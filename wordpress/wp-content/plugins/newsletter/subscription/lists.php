<?php
if (!defined('ABSPATH')) exit;

@include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();
$module = NewsletterSubscription::instance();

if (!$controls->is_action()) {
    $controls->data = $module->get_options('profile');
} else {
    if ($controls->is_action('save')) {
        $module->merge_options($controls->data, 'profile');
        // In the near future
        $module->save_options($controls->data, 'lists');
        $controls->add_message_saved();
    }
}
$status = array(0 => 'Disabled/Private use', 1 => 'Only on profile page', 2 => 'Even on subscription forms', '3' => 'Hidden');
?>

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_DIR . '/tnp-header.php'; ?>

    <div id="tnp-heading">

        <h2><?php _e('Lists', 'newsletter') ?></h2>

    </div>

    <div id="tnp-body">

        <form method="post" action="">
            <?php $controls->init(); ?>

            <table class="widefat">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Name/Label</th>
                        <th>On subscription</th>
                        <th>Initially...</th>
                    </tr>
                </thead>
                <?php for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) { ?>
                    <tr>
                        <td>List <?php echo $i; ?></td>
                        <td><?php $controls->text('list_' . $i); ?></td>
                        <td><?php $controls->select('list_' . $i . '_status', $status); ?></td>
                        <td><?php $controls->select('list_' . $i . '_checked', array(0 => 'Unchecked', 1 => 'Checked')); ?></td>
                    </tr>
                <?php } ?>
            </table>

            <p>
                <?php $controls->button_save(); ?>
            </p>
        </form>
    </div>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

</div>