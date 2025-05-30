<?php

namespace controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Events\Dispatcher;

class ViewController
{
    private static $viewFactory;
    private static $viewPaths = [];
    private static $namespaceRegister = [];
    private static $viewFinder;

    public static function init($cachePath)
    {
        self::initBladeEngine($cachePath, self::$viewPaths);
        self::enqueue();
    }

    public static function render($view, $data = [], $return = false)
    {
        if (!self::$viewFactory) {
            throw new \Exception("Blade is not initialized. Please call initBladeEngine() first.");
        }
        $str = self::$viewFactory->make($view, $data)->render();
        if ($return) {
            return $str;
        }
        echo $str;
    }

    public static function registerPath($view_path, $namespace = '')
    {
        self::$viewPaths[] = $view_path;

        if (!$namespace) return;

        if (isset(self::$viewFinder)) {
            self::$viewFinder->addNamespace($namespace, $view_path);
        } else { //FileViewFinder doesn't exist yet, so store namespace addition as a callback closure for future consumption
            self::$namespaceRegister[] = static function () use ($view_path, $namespace) {
                self::$viewFinder->addNamespace($namespace, $view_path);
            };
        }
    }

    private static function initBladeEngine($cachePath, $viewsPath)
    {
        if (!is_array($viewsPath)) {
            dd("ERROR: views path directory is not an array!", "given: $viewsPath", __FILE__); //FIXME: use internal logging instead
        }
        if (empty($viewsPath)) {
            dd("Error: views path directory is empty!", __FILE__); //FIXME: use internal logging instead
        }

        $filesystem = new Filesystem();
        $compiler = new BladeCompiler($filesystem, $cachePath);
        $resolver = new EngineResolver();

        $resolver->register('blade', function () use ($compiler) {
            return new CompilerEngine($compiler);
        });

        self::$viewFinder = new FileViewFinder($filesystem, $viewsPath);

        self::$viewFactory = new Factory($resolver, self::$viewFinder, new Dispatcher());
        self::$viewFactory->addExtension('blade.php', 'blade');

        self::resolveRegister();
    }

    private static function resolveRegister()
    {
        foreach (self::$namespaceRegister as $cb) {
            $cb();
        }
    }

    private static function enqueue()
    {
        add_action('admin_enqueue_scripts', static function ($hook) {
            if ($hook !== 'settings_page_' . {PREFIX}_MENU_SLUG) {
                return;
            }

            $manifest_path = DCAC_PLUGIN_PATH . 'public/build/manifest.json';
            $manifest = json_decode(file_get_contents($manifest_path), true);

            foreach ($manifest as $file => $entries) {
                self::enqueueStyles($file, $entries);
                self::enqueueScripts($file, $entries);
            }
        }, 10, 1);
    }

    private static function enqueueStyles($file, $entries)
    {
        if (strpos($file, 'resources/styles/') === 0) {
            foreach ((array) $entries as $styles) {
                $url = {PREFIX}_PLUGIN_URL . 'public/build/' . $styles;
                $path = {PREFIX}_PLUGIN_PATH . 'public/build/' . $styles;

                wp_enqueue_style(
                    '{PREFIX}-' . sanitize_title($file), // Unique handle per script
                    $url,
                    [],
                    file_exists($path) ? filemtime($path) : false,
                    false
                );
            }
        }
    }

    private static function enqueueScripts($file, $entries)
    {
        if (strpos($file, 'resources/scripts/') === 0 || strpos($file, 'system/subsystems/') === 0) {
            $url = {PREFIX}_PLUGIN_URL . 'public/build/' . $entries['file'];
            $path = {PREFIX}_PLUGIN_PATH . 'public/build/' . $entries['file'];

            wp_enqueue_script(
                '{PREFIX}-' . sanitize_title($file), // Unique handle per script
                $url,
                [],
                file_exists($path) ? filemtime($path) : false,
                true
            );
        }
    }
}
