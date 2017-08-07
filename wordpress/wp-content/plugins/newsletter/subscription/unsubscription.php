<?php
if (!defined('ABSPATH')) exit;

@include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();
$module = NewsletterSubscription::instance();
$defaults = $module->get_default_options();

if (!$controls->is_action()) {
    $controls->data = $module->get_options();
} else {
    if ($controls->is_action('save')) {
        $controls->data['unsubscription_text'] = NewsletterModule::clean_url_tags($controls->data['unsubscription_text']);
        $controls->data['unsubscribed_text'] = NewsletterModule::clean_url_tags($controls->data['unsubscribed_text']);
        $controls->data['unsubscribed_message'] = NewsletterModule::clean_url_tags($controls->data['unsubscribed_message']);

        if (empty($controls->data['unsubscription_text'])) {
            $controls->data['unsubscription_text'] = $defaults['unsubscription_text'];
        }
        if (empty($controls->data['unsubscribed_text'])) {
            $controls->data['unsubscribed_text'] = $defaults['unsubscribed_text'];
        }
        if (empty($controls->data['unsubscribed_message'])) {
            $controls->data['unsubscribed_message'] = $defaults['unsubscribed_message'];
        }
        if (empty($controls->data['unsubscribed_subject'])) {
            $controls->data['unsubscribed_subject'] = $defaults['unsubscribed_subject'];
        }
        if (empty($controls->data['unsubscription_error_text'])) {
            $controls->data['unsubscription_error_text'] = $defaults['unsubscription_error_text'];
        }

        $module->merge_options($controls->data);
        $controls->data = $module->get_options();
        $controls->add_message_saved();
    }

    if ($controls->is_action('reset')) {
        $controls->data['unsubscription_text'] = $defaults['unsubscription_text'];
        $controls->data['unsubscribed_text'] = $defaults['unsubscribed_text'];
        $controls->data['unsubscribed_subject'] = $defaults['unsubscribed_subject'];
        $controls->data['unsubscribed_message'] = $defaults['unsubscribed_message'];
        $controls->data['unsubscription_error_text'] = $defaults['unsubscription_error_text'];
        $module->merge_options($controls->data);
        $controls->data = $module->get_options();
    }
}
?>

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_DIR . '/tnp-header.php'; ?>

    <div id="tnp-heading">

        <h2>Unsubscription</h2>

        <p>
            A user starts the cancellation process clicking the unsubscription link in
            a newsletter. This link contains the email to unsubscribe and some unique information
            to avoid hacking. The user are required to confirm the unsubscription: this is the last
            step where YOU can communicate with your almost missed user.
        </p>
        <p>
            To create immediate cancellation, you can use the <strong>{unsubscription_confirm_url}</strong>
            in your newsletters and upon click on that link goodbye message and email are used directly
            skipping the confirm request.
        </p>

    </div>

    <div id="tnp-body"> 

        <form method="post" action="">
            <?php $controls->init(); ?>

            <table class="form-table">
                <tr valign="top">
                    <th><?php _e('Unsubscription message', 'newsletter') ?></th>
                    <td>
                        <?php $controls->wp_editor('unsubscription_text'); ?>
                        <p class="description">
                            This text is show to users who click on a "unsubscription link" in a newsletter
                            email. You <strong>must</strong> insert a link in the text that user can follow to confirm the
                            unsubscription request using the tag <strong>{unsubscription_confirm_url}</strong>.
                        </p>
                    </td>
                </tr>

                <tr valign="top">
                    <th><?php _e('Goodbye message', 'newsletter') ?></th>
                    <td>
                        <?php $controls->wp_editor('unsubscribed_text'); ?>
                        <p class="description">
                            Shown to users after the cancellation has been completed.
                        </p>
                    </td>
                </tr>

                <tr valign="top">
                    <th><?php _e('Goodbye email', 'newsletter') ?></th>
                    <td>
                        <?php $controls->email('unsubscribed', 'wordpress', true); ?>
                        <p class="description">
                            Sent after a cancellation, is the last message you send to the user before his removal
                            from your newsletter subscribers.
                        </p>
                    </td>
                </tr>
                <tr>
                    <th>Unsubscription error</th>
                    <td>
                        <?php $controls->wp_editor('unsubscription_error_text'); ?>
                        <p class="description">
                            When the unsubscription cannot be completed, for example because the
                            subscriber has already been removed.
                        </p>
                    </td>
                </tr>                       
            </table>

            <p>
                <?php $controls->button_save() ?>
                <?php $controls->button_reset() ?>
            </p>
        </form>
    </div>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

</div>