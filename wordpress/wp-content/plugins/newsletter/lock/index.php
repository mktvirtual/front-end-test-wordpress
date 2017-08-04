<?php
if (!defined('ABSPATH')) exit;

@include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();
$module = NewsletterLock::instance();

if (!$controls->is_action()) {
    $controls->data = $module->get_options();
} else {
    if ($controls->is_action('save')) {
        $module->save_options($controls->data);
        $controls->data = $module->get_options();
    }
     if ($controls->is_action('reset')) {
         $module->reset_options();
         $controls->data = $module->get_options();
     }
}
?>

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_DIR . '/tnp-header.php'; ?>

    <div id="tnp-heading">

        <h2><?php _e('Locked Content', 'newsletter') ?></h2>
        <p>
            Please, <a href="https://www.thenewsletterplugin.com/plugins/newsletter/newsletter-locked-content" target="_blank">read more here how to use and configure</a>,
            since it can incredibly increase your subscription rate.
        </p>

    </div>

    <div id="tnp-body">

        <form method="post" action="">
            <?php $controls->init(); ?>
            <table class="form-table">
                <tr valign="top">
                    <th><?php _e('Enabled', 'newsletter') ?></th>
                    <td>
                        <?php $controls->yesno('enabled'); ?>
                        <p class="description">
                            If you don't plan to use this feature, keep it disable save blog resources!
                        </p>
                    </td>
                </tr>
                <tr valign="top">
                    <th><?php _e('Tags or categories to block', 'newsletter') ?></th>
                    <td>
                        <?php $controls->text('ids', 70); ?> (<?php _e('comma separated', 'newsletter') ?>)
                        <p class="description">
                            <?php _e('Use tag or category slugs or id for which lock the posts content', 'newsletter') ?>
                        </p>
                    </td>
                </tr>

                <tr valign="top">
                    <th><?php _e('Unlock destination URL', 'newsletter') ?></th>
                    <td>
                        <?php $controls->text('url', 70); ?>
                        <p class="description">
                            <?php _e('URL where redirect subscribers when they click on unlocking URL ({unlock_url}) inserted in newsletters and welcome message.', 'newsletter') ?>
                            <br>
                            Newsletters with tracking active can link directly the pages with locked content since the URLs will 
                            unlock the content as well.
                        </p>
                    </td>
                </tr>
                <tr valign="top">
                    <th><?php _e('Denied content message', 'newsletter') ?></th>
                    <td>
                        <?php $controls->wp_editor('message'); ?>

                        <p class="description">
                            This message is shown in place of protected post or page content which is surrounded with
                            [newsletter_lock] and [/newsletter_lock] shortcodes or in place of the full content if they are
                            in categories or have tags as specified above.<br>
                            You can use shortcodes like [newsletter_form] to display a subscription form or any other Newsletter shortcode.
                            <strong>Remember to add the {unlock_url} on the welcome email so the user can unlock the content.</strong>
                        </p>
                    </td>
                </tr>
            </table>
            <p>
                <?php $controls->button_save(); ?>
                <?php $controls->button_reset(); ?>
            </p>
        </form>
    </div>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

</div>