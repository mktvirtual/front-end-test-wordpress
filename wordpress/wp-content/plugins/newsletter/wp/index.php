<?php
if (!defined('ABSPATH'))
    exit;

@include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();
$module = NewsletterWp::instance();

if (!$controls->is_action()) {
    $controls->data = $module->options;
} else {
    if ($controls->is_action('save')) {
        //$module->merge_options($controls->data);
        unset($controls->data['align_wp_users_status']);
        $module->save_options($controls->data);
        $controls->add_message_saved();
    }

    if ($controls->is_action('align_wp_users')) {
        ignore_user_abort(true);
        set_time_limit(0);

        // TODO: check if the user is already there
        $wp_users = $wpdb->get_results("select id, user_email, user_login from $wpdb->users");
        $count = 0;
        foreach ($wp_users as &$wp_user) {

            // A subscriber is already there with the same wp_user_id? Do Nothing.
            $nl_user = $module->get_user_by_wp_user_id($wp_user->id);
            if (!empty($nl_user)) {
                continue;
            }

            // A subscriber has the same email? Align them if not already associated to another wordpress user
            $nl_user = $module->get_user($module->normalize_email($wp_user->user_email));
            if (!empty($nl_user)) {
                if (empty($nl_user->wp_user_id)) {
                    //$module->logger->info('Linked');
                    $module->set_user_wp_user_id($nl_user->id, $wp_user->id);
                    continue;
                }
            }

            // Create a new subscriber
            $nl_user = array();
            $nl_user['email'] = $module->normalize_email($wp_user->user_email);
            $nl_user['name'] = $wp_user->first_name;
            if (empty($nl_user['name'])) {
                $nl_user['name'] = $wp_user->user_login;
            }
            $nl_user['surname'] = $wp_user->last_name;
            $nl_user['status'] = $controls->data['align_wp_users_status'];
            $nl_user['wp_user_id'] = $wp_user->id;
            $nl_user['referrer'] = 'wordpress';

            // Adds the force subscription preferences
            $preferences = NewsletterSubscription::instance()->options['preferences'];
            if (is_array($preferences)) {
                foreach ($preferences as $p) {
                    $nl_user['list_' . $p] = 1;
                }
            }

            $module->save_user($nl_user);
            $count++;
        }
        $controls->messages = count($wp_users) . ' ' . __('WordPress users processed', 'newsletter') . '. ';
        $controls->messages .= $count . ' ' . __('subscriptions added', 'newsletter') . '.';
    }
}
?>
<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_DIR . '/tnp-header.php'; ?>

    <div id="tnp-heading">

        <h2><?php _e('WordPress Registration Integration', 'newsletter') ?></h2>

        <p>Configure if and how a regular WordPress user registration can be connected to a Newsletter subscription.</p>
        <p>
            Important! This type of subscription does not require confirmation, it's automatic on first login.
            <a href="https://www.thenewsletterplugin.com/plugins/newsletter/subscription-module#registration" target="_blank">Read more on documentation page</a>.
        </p>

    </div>

    <div id="tnp-body">

        <form method="post" action="">

            <?php $controls->init(); ?>

            <table class="form-table">
                <tr valign="top">
                    <th>Subscription on registration</th>
                    <td>
                        <?php $controls->select('subscribe', array(0 => 'No', 1 => 'Yes, force subscription', 2 => 'Yes, show the option', 3 => 'Yes, show the option already checked')); ?>
                        <p class="description">
                            Adds a newsletter subscription option on registration. 
                            <a href="https://www.thenewsletterplugin.com/plugins/newsletter/subscription-module#registration" target="_blank">Read more</a>
                        </p>
                    </td>
                </tr>
                <tr valign="top">
                    <th><?php _e('Check box label', 'newsletter') ?></th>
                    <td>
                        <?php $controls->text('subscribe_label', 30); ?>
                    </td>
                </tr>
            </table>

            <h3><?php _e('Confirmation', 'newsletter') ?></h3>
            <p>
                Subscribers will be automatically confirmed on first log-in (because it demonstrates they received the WP email with
                their password. Hence no confirmation email is sent. Anyway you can change that behavior here and ask anyway for confirmation.
            </p>
            <table class="form-table"> 

                <tr valign="top">
                    <th>Send the confirmation email</th>
                    <td>
                        <?php $controls->yesno('confirmation'); ?>
                    </td>
                </tr>  
                <tr valign="top">
                    <th><?php _e('Send welcome email to registered users', 'newsletter') ?></th>
                    <td>
                        <?php $controls->yesno('welcome'); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th><?php _e('Subscription delete', 'newsletter') ?></th>
                    <td>
                        <?php $controls->yesno('delete'); ?>
                        <p class="description">Delete the subscription connected to a WordPress user when that user is deleted</p>
                    </td>
                </tr>
            </table>

            
            <h3><?php _e('Import already registered users', 'newsletter') ?>
            <table class="form-table">   
                <tr>
                    <th><?php _e('Import with status', 'newsletter') ?></th>
                    <td>
                        <?php $controls->select('align_wp_users_status', array('C' => __('Confirmed', 'newsletter'), 'S' => __('Not confirmed', 'newsletter'))); ?>
                        <?php $controls->button_confirm('align_wp_users', __('Import', 'newsletter'), __('Proceed?', 'newsletter')); ?>
                        <p class="description">
                            <a href="https://www.thenewsletterplugin.com/plugins/newsletter/subscribers-module#import-wp-users" target="_blank">
                                <?php _e('Please, carefully read the documentation before taking this action!', 'newsletter') ?>
                            </a>
                        </p>
                    </td>
                </tr>
            </table>
            <p>
                <?php $controls->button_save(); ?>
            </p>
        </form>
    </div>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

</div>
