<div id="alswh-import-plugin" class="wrap">
    <h1><?= esc_html(get_admin_page_title()) ?></h1>
    <!--    --><?php //var_dump(get_option(Settings::get_options_name())) ?>
    <div class="my-5">
        <p>This plugin will connect to the ALSWH database and create Wordpress posts from retrieved publications. Any
            pre-existing posts will be updated instead.</p>
    </div>
    <?php include(MUB_PLUGIN_PATH . 'views/partials/form-options.php') ?>

    <div id="plugin-status" class="mt-5 mb-2">
        <h3>Status: <span>Ready</span></h3>
    </div>

    <?php include(MUB_PLUGIN_PATH . 'views/partials/form-run.php') ?>

    <?php $pub_data = PublicationImport::get_data() ?>
</div>
