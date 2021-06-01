<?php
/**
 * dashboard-main view.
 * WordPress MVC view.
 *
 * @author Ivan Zabroda <zabr91.github.io>
 * @package transport-calc-cdek
 * @version 1.0.0
 */
?>

<div class="wrap">
    <h2><?php echo get_admin_page_title() ?></h2>

    <form action="options.php" method="POST">
        <?php
        settings_fields( 'transportcalccdek' );
        do_settings_sections( 'transportcalccdek-settings' );
        submit_button();
        ?>
    </form>
</div>