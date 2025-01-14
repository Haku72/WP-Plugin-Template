<div class="wrap">
    <h1><?= esc_html(get_admin_page_title()) ?></h1>
    <div class="my-5">
        <p>Plugin description</p>
    </div>
    <form method="post" action="options.php">
        <?php
        settings_fields('{PREFIX}_SETTINGS_GROUP');
        do_settings_sections('{PREFIX}_MENU_SLUG');
        submit_button();
        ?>
    </form>
</div>
