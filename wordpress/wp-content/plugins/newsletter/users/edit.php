<?php
if (!defined('ABSPATH'))
    exit;

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();
$module = NewsletterUsers::instance();

$id = (int) $_GET['id'];

if ($controls->is_action('save')) {

    $email = $module->normalize_email($controls->data['email']);
    if ($email == null) {
        $controls->errors = 'The email address is not valid';
    }

    if (empty($controls->errors)) {
        $user = $module->get_user($controls->data['email']);
        if ($user && $user->id != $id) {
            $controls->errors = 'The email address is already taken by another subscriber';
        }
    }

    if (empty($controls->errors)) {
        // For unselected preferences, force the zero value
        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            if (!isset($controls->data['list_' . $i])) {
                $controls->data['list_' . $i] = 0;
            }
        }

        $controls->data['id'] = $id;
        $r = $module->save_user($controls->data);
        if ($r === false) {
            $controls->errors = 'Unable to update, may be the email (if changed) is duplicated.';
        } else {
            $controls->messages = 'Updated.';
            $controls->data = $module->get_user($id, ARRAY_A);
        }
    }
}

if ($controls->is_action('delete')) {
    $module->delete_user($id);
    $controls->js_redirect($module->get_admin_page_url('index'));
    return;
}

if (!$controls->is_action()) {
    $controls->data = $module->get_user($id, ARRAY_A);
}

$options_profile = get_option('newsletter_profile');

$panels = Newsletter::instance()->panels;

//$wpdb->query($wpdb->prepare("insert ignore into " . $wpdb->prefix . "newsletter_sent (user_id, email_id, time) select user_id, email_id, UNIX_TIMESTAMP(created) from " . NEWSLETTER_STATS_TABLE . " where user_id=%d", $id));

function percent($value, $total) {
    if ($total == 0)
        return '-';
    return sprintf("%.2f", $value / $total * 100) . '%';
}

function percentValue($value, $total) {
    if ($total == 0)
        return 0;
    return round($value / $total * 100);
}
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart', 'geomap']});
</script>

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_DIR . '/tnp-header.php'; ?>

    <div id="tnp-heading">

        <h2><?php _e('Editing', 'newsletter') ?> <?php echo esc_html($controls->data['email']) ?></h2>

    </div>

    <div id="tnp-body" class="tnp-users tnp-users-edit">

        <form method="post" action="">
            <p>
                <?php $controls->button_back('?page=newsletter_users_index'); ?>
                <?php $controls->button_save(); ?>
            </p>
            <?php $controls->init(); ?>

            <div id="tabs">

                <ul>
                    <li><a href="#tabs-general">General</a></li>
                    <li><a href="#tabs-preferences">Lists</a></li>
                    <li><a href="#tabs-profile">Profile</a></li>
                    <li><a href="#tabs-other">Other</a></li>
                    <li><a href="#tabs-newsletters">Newsletters</a></li>

                </ul>

                <div id="tabs-general">

                    <?php do_action('newsletter_users_edit_general', $id, $controls) ?>

                    <table class="form-table">

                        <tr valign="top">
                            <th>Email address</th>
                            <td>
                                <?php $controls->text('email', 60); ?>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>First name</th>
                            <td>
                                <?php $controls->text('name', 50); ?>
                                <p class="description">
                                    If you collect only the name of the subscriber without distinction of first and last name this field is used.
                                </p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Last name</th>
                            <td>
                                <?php $controls->text('surname', 50); ?>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Gender</th>
                            <td>
                                <?php $controls->select('sex', array('n' => 'Not specified', 'f' => 'female', 'm' => 'male')); ?>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Status</th>
                            <td>
                                <?php $controls->select('status', array('C' => 'Confirmed', 'S' => 'Not confirmed', 'U' => 'Unsubscribed', 'B' => 'Bounced')); ?>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Test subscriber?</th>
                            <td>
                                <?php $controls->yesno('test'); ?>
                                <p class="description">
                                    A test subscriber is a regular subscriber that is even used as recipint when sending test newsletter are sent
                                    (for example to check the layout).
                                </p>
                            </td>
                        </tr>

                        <?php do_action('newsletter_user_edit_extra', $controls); ?>

                        <tr valign="top">
                            <th>Feed by mail</th>
                            <td>
                                <?php $controls->yesno('feed'); ?>
                                <p class="description">
                                    "Yes" when this subscriber has the feed by mail service active. The 
                                    <a href="https://www.thenewsletterplugin.com/feed-by-mail-extension?utm_source=plugin&utm_medium=link&utm_campaign=newsletter-feed" target="_blank">feed by mail is an extension of this plugin</a>.
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="tabs-preferences">
                    <div class="tab-preamble">
                        <p>
                            The subscriber's preferences are a set of "on/off" fields that can be used while sending newsletter to
                            select a subset of subscribes. 
                        </p>
                    </div>
                    <table class="form-table">
                        <tr>
                            <th>Preferences</th>
                            <td>
                                <?php $controls->preferences('list'); ?>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="tabs-profile">
                    <div class="tab-preamble">
                        <p>
                            The user's profile is a set of optional and textual fields you can collect along with the subscription process
                            or when the user's editing his profile. Those fields can be configured in the "Subscription Form" panel.
                        </p>
                    </div>
                    <table class="widefat">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Name</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 1; $i <= NEWSLETTER_PROFILE_MAX; $i++) {
                                echo '<tr><td>(' . $i . ') ';
                                echo '</td><td>';
                                echo esc_html($options_profile['profile_' . $i]);
                                echo '</td><td>';
                                $controls->text('profile_' . $i, 70);
                                echo '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div id="tabs-other">
                    <div class="tab-preamble">
                        <p>
                            Other user's data collected or generated along the subscription process.
                        </p>
                    </div>
                    <table class="form-table">
                        <tr valign="top">
                            <th>ID</th>
                            <td>
                                <?php $controls->value('id'); ?>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th><?php _e('Created', 'newsletter')?></th>
                            <td>
                                <?php $controls->value('created'); ?>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th><?php _e('WP user ID', 'newsletter')?></th>
                            <td>
                                <?php $controls->text('wp_user_id'); ?>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>From IP address</th>
                            <td>
                                <?php $controls->value('ip'); ?>
                                <p class="description">
                                    Internet address from which the subscription started. Required by many providers.
                                </p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Secret token</th>
                            <td>
                                <?php $controls->text('token', 50); ?>
                                <p class="description">
                                    This secret token is used to access the profile page and edit profile data, to confirm and cancel the subscription.
                                </p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Profile URL</th>
                            <td>
                                <?php echo esc_html(home_url('/') . '?na=pe&nk=' . $id . '-' . $controls->data['token']) ?>
                                <p class="description">
                                    The URL which lands on the user profile editing page. It can be added on newsletters using the {profile_url} tag.
                                </p>
                            </td>
                        </tr>

                    </table>
                </div>
                <div id="tabs-newsletters">
                    <p>Newsletter sent to this subscriber.</p>
                    <?php if (!has_action('newsletter_user_newsletters_tab') && !has_action('newsletter_users_edit_newsletters')) { ?>
                        <div class="tnp-tab-notice">
                            This panel requires the <a href="https://www.thenewsletterplugin.com/plugins/newsletter/reports-module" target="_blank">Reports Extension 4+</a>.
                        </div>
                        <?php
                    } else {
                        do_action('newsletter_user_newsletters_tab', $id);
                        do_action('newsletter_users_edit_newsletters', $id);
                    }
                    ?>
                </div>

                <?php
                if (isset($panels['user_edit'])) {
                    foreach ($panels['user_edit'] as $panel) {
                        call_user_func($panel['callback'], $id, $controls);
                    }
                }
                ?>

            </div>

            <p class="submit">
                <?php $controls->button_save(); ?>
                <?php $controls->button('delete', 'Delete'); ?>
            </p>

        </form>
    </div>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

</div>
