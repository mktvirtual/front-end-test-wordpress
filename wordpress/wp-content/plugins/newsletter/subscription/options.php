<?php
if (!defined('ABSPATH')) exit;

@include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();
$module = NewsletterSubscription::instance();

// TODO: Remove and use the $module->options.
$options = get_option('newsletter', array());

if ($controls->is_action()) {
    if ($controls->is_action('save')) {

        $defaults = $module->get_default_options();

        if (empty($controls->data['profile_text'])) {
            $controls->data['profile_text'] = $defaults['profile_text'];
        }

        // Without the last curly bracket since there can be a form number apended
        if (empty($controls->data['subscription_text'])) {
            $controls->data['subscription_text'] = $defaults['subscription_text'];
        }

        if (empty($controls->data['confirmation_text'])) {
            $controls->data['confirmation_text'] = $defaults['confirmation_text'];
        }

        if (empty($controls->data['confirmation_subject'])) {
            $controls->data['confirmation_subject'] = $defaults['confirmation_subject'];
        }

        if (empty($controls->data['confirmation_message'])) {
            $controls->data['confirmation_message'] = $defaults['confirmation_message'];
        }

        if (empty($controls->data['confirmed_text'])) {
            $controls->data['confirmed_text'] = $defaults['confirmed_text'];
        }

        if (empty($controls->data['confirmed_subject'])) {
            $controls->data['confirmed_subject'] = $defaults['confirmed_subject'];
        }

        if (empty($controls->data['confirmed_message'])) {
            $controls->data['confirmed_message'] = $defaults['confirmed_message'];
        }

        $controls->data['confirmed_message'] = NewsletterModule::clean_url_tags($controls->data['confirmed_message']);
        $controls->data['confirmed_text'] = NewsletterModule::clean_url_tags($controls->data['confirmed_text']);
        $controls->data['confirmation_text'] = NewsletterModule::clean_url_tags($controls->data['confirmation_text']);
        $controls->data['confirmation_message'] = NewsletterModule::clean_url_tags($controls->data['confirmation_message']);

        $controls->data['confirmed_url'] = trim($controls->data['confirmed_url']);
        $controls->data['confirmation_url'] = trim($controls->data['confirmation_url']);
        
        if (!empty($controls->data['page'])) {
            $controls->data['url'] = ''; // do not unset
        }

        $module->merge_options($controls->data);
        $controls->add_message_saved();
    }

    if ($controls->is_action('create')) {
        $page = array();
        $page['post_title'] = 'Newsletter';
        $page['post_content'] = '[newsletter]';
        $page['post_status'] = 'publish';
        $page['post_type'] = 'page';
        $page['comment_status'] = 'closed';
        $page['ping_status'] = 'closed';
        $page['post_category'] = array(1);

        // Insert the post into the database
        $page_id = wp_insert_post($page);

        $controls->data['page'] = $page_id;
        $module->merge_options($controls->data);
    }

    if ($controls->is_action('reset')) {
        $controls->data = $module->reset_options();
    }

    if ($controls->is_action('test-confirmation')) {

        $users = NewsletterUsers::instance()->get_test_users();
        if (count($users) == 0) {
            $controls->errors = 'There are no test subscribers. Read more about test subscribers <a href="https://www.thenewsletterplugin.com/plugins/newsletter/subscribers-module#test" target="_blank">here</a>.';
        } else {
            $addresses = array();
            foreach ($users as &$user) {
                $addresses[] = $user->email;
                $res = $module->mail($user->email, $newsletter->replace($module->options['confirmation_subject']), $newsletter->replace($module->options['confirmation_message'], $user));
                if (!$res) {
                    $controls->errors = 'The email address ' . $user->email . ' failed.';
                    break;
                }
            }
            $controls->messages .= 'Test emails sent to ' . count($users) . ' test subscribers: ' .
                    implode(', ', $addresses) . '. Read more about test subscribers <a href="https://www.thenewsletterplugin.com/plugins/newsletter/subscribers-module#test" target="_blank">here</a>.';
            $controls->messages .= '<br>If the message is not received, try to change the message text it could trigger some antispam filters.';
        }
    }

    if ($controls->is_action('test-confirmed')) {

        $users = NewsletterUsers::instance()->get_test_users();
        if (count($users) == 0) {
            $controls->errors = 'There are no test subscribers. Read more about test subscribers <a href="https://www.thenewsletterplugin.com/plugins/newsletter/subscribers-module#test" target="_blank">here</a>.';
        } else {
            $addresses = array();
            foreach ($users as &$user) {
                $addresses[] = $user->email;
                $res = $module->mail($user->email, $newsletter->replace($module->options['confirmed_subject']), $newsletter->replace($module->options['confirmed_message'], $user));
                if (!$res) {
                    $controls->errors = 'The email address ' . $user->email . ' failed.';
                    break;
                }
            }
            $controls->messages .= 'Test emails sent to ' . count($users) . ' test subscribers: ' .
                    implode(', ', $addresses) . '. Read more about test subscribers <a href="https://www.thenewsletterplugin.com/plugins/newsletter/subscribers-module#test" target="_blank">here</a>.';
            $controls->messages .= '<br>If the message is not received, try to change the message text it could trigger some antispam filters.';
        }
    }
} else {
    $controls->data = get_option('newsletter', array());
}

if (empty($controls->data['page'])) {
    $controls->messages .= '<p>You should set a dedicated page for Newsletter which used to interact with your subscribers.</p>';
} else {
    $post = get_post($controls->data['page']);
    
    if (!$post || $post->post_status != 'publish') {
        $controls->errors .= '<p>The dedicated page selected below does not exist anymore or has been unpublished. Please, select a different one.</p>';
    } else {
        if (strpos($post->post_content, '[newsletter') === false) {
            $controls->errors .= '<p>The dedicated page selected DOES NOT contain the [newsletter] shortcode. Please fix it. It should contain ONLY the [newsletter] shortcode.</p>';
        }
    }
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/codemirror.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/addon/hint/show-hint.css">
<style>
    .CodeMirror {
        border: 1px solid #ddd;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/codemirror.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/mode/css/css.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/addon/hint/show-hint.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/addon/hint/css-hint.js"></script>
<script>
    jQuery(function () {
        var editor = CodeMirror.fromTextArea(document.getElementById("options-css"), {
            lineNumbers: true,
            mode: 'css',
            extraKeys: {"Ctrl-Space": "autocomplete"}
        });
    });
</script>

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_DIR . '/tnp-header.php'; ?>

    <div id="tnp-heading">

        <h2><?php _e('Subscription, Profile Page Configuration', 'newsletter') ?></h2>

        <p>
            In this panel you can configure the subscription, set up every message, the single or double opt in and
            even a customized subscription form.
        </p>
        <p>
            Page layout where messages are shown is managed by subscription/page.php file which contains instruction on how to
            customize it OR use a WordPress page for messages as described on subscription configuration.
        </p>

    </div>

    <div id="tnp-body">

        <form method="post" action="">
            <?php $controls->init(); ?>
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-general">General</a></li>
                    <li><a href="#tabs-2">Subscription</a></li>
                    <li><a href="#tabs-3">Confirmation</a></li>
                    <li><a href="#tabs-4">Welcome</a></li>
                    <li><a href="#tabs-9">Profile</a></li>
                    <li><a href="#tabs-7">Docs</a></li>
                </ul>

                <div id="tabs-general">
                    <table class="form-table">
                        <tr valign="top">
                            <th>Opt In</th>
                            <td>
                                <?php $controls->select('noconfirmation', array(0 => 'Double Opt In', 1 => 'Single Opt In')); ?>
                                <p class="description">
                                    <strong>Double Opt In</strong> means subscribers need to confirm their email address by an activation link sent them on a activation email message.<br />
                                    <strong>Single Opt In</strong> means subscribers do not need to confirm their email address.<br />
                                </p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Newsletter dedicated page</th>
                            <td>
                                <?php $controls->page('page', 'The Newsletter standard unstyled page'); ?>
                                <?php
                                if (empty($controls->data['url']) && empty($controls->data['page'])) {
                                    $controls->button('create', 'Create a page for me');
                                }
                                ?>
                                <?php if (!empty($controls->data['url'])) { ?>
                                <p class="description">
                                    <strong>
                                        You're currently using the URL <code><?php echo esc_html($controls->data['url'])?></code>
                                        as dedicated page. Please select the corrisponding page above (new as version 4.6.5+).
                                    </strong>
                                </p>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Notifications</th>
                            <td>
                                <?php $controls->yesno('notify'); ?>
                                to: <?php $controls->text_email('notify_email'); ?> (email address, leave empty for the WordPress administration email <?php echo get_option('admin_email'); ?>)
                                <p class="description">
                                    Notifications are sent on confirmed subscriptions and cancellations.
                                </p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th><?php _e('Custom styles', 'newsletter')?></th>
                            <td>
                                <?php if (apply_filters('newsletter_enqueue_style', true) === false) { ?>
                                <p><strong>Warning: Newsletter styles and custom styles are disable by your theme or a plugin.</strong></p>
                                <?php } ?>
                                <?php $controls->textarea('css'); ?>
                            </td>
                        </tr>
                    </table>
                </div>


                <div id="tabs-2">

                    <table class="form-table">
                        <tr valign="top">
                            <th>Subscription page</th>
                            <td>
                                <?php $controls->wp_editor('subscription_text'); ?>
                                <p class="description">
                                    Use <strong>{subscription_form}</strong> to insert the subscription form where you prefer in the text or
                                    <strong>{subscription_form_N}</strong> (with N from 1 to 10) to insert one of the custom forms.
                                </p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th><?php _e('Forced lists', 'newsletter')?></th>
                            <td>
                                <?php $controls->preferences(); ?>
                                <p class="description">
                                    Add to new subscribers these lists by default.
                                </p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Disable antibot/antispam?</th>
                            <td>
                                <?php $controls->yesno('antibot_disable'); ?>
                                <p class="description">
                                    Required for ajax form subsmissions.
                                </p>
                            </td>
                        </tr>
                    </table>

                    <h3>Special cases</h3>

                    <table class="form-table">
                        <!--
                        <tr valign="top">
                            <th>Already subscribed page content</th>
                            <td>
                        <?php //$controls->wp_editor('already_confirmed_text'); ?><br>
                        <?php //$controls->checkbox('resend_welcome_email_disabled', 'Do not resend the welcome email'); ?>
                                <p class="description">
                                    Shown when the email is already subscribed and confirmed. The welcome email, if not disabled, will
                                    be sent. Find out more on this topic on its
                                    <a href="https://www.thenewsletterplugin.com/plugins/newsletter/subscription-module#repeated" target="_blank">documentation page</a>.
                                </p>
                            </td>
                        </tr>
                        -->
                        <tr valign="top">
                            <th>Error page content</th>
                            <td>
                                <?php $controls->wp_editor('error_text'); ?>
                                <p class="description">
                                    Message shown when the email is bounced or other errors occurred.
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>


                <div id="tabs-3">

                    <p>This configuration applies only when you sent the double opt-in mode.</p>

                    <table class="form-table">
                        <tr valign="top">
                            <th>Confirmation required message</th>
                            <td>
                                <?php $controls->wp_editor('confirmation_text'); ?>
                                <p class="description">
                                    This message is shown to just subscribed users which require to confirm the subscription
                                    following the instructions sent them with the following email. Invite them to check the mailbox and to
                                    give a look to the spam folder if no messages are received within 10 minutes.
                                </p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th>Alternative custom confirmation required page</th>
                            <td>
                                <?php $controls->text('confirmation_url', 70); ?>
                                <p class="description">
                                    A full page address (http://yourblog.com/confirm) to be used instead of message above.
                                    If left empty the message above is used.
                                </p>
                            </td>
                        </tr>


                        <!-- CONFIRMATION EMAIL -->
                        <tr valign="top">
                            <th>Confirmation email</th>
                            <td>
                                <?php $controls->email('confirmation', 'wordpress'); ?>
                                <?php $controls->button('test-confirmation', 'Send a test'); ?>
                                <p class="description">
                                    Message sent by email to new subscribers with instructions to confirm their subscription
                                    (for double opt-in process). Do not forget to add the <strong>{subscription_confirm_url}</strong>
                                    that users must click to activate their subscription.<br />
                                    Sometime can be useful to add a <strong>{unsubscription_url}</strong> to let users to
                                    cancel if they wrongly subscribed to your newsletter.
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>


                <div id="tabs-4">
                    <table class="form-table">
                        <tr valign="top">
                            <th>Welcome message</th>
                            <td>
                                <?php $controls->wp_editor('confirmed_text'); ?>
                                <p class="description">
                                    Showed when the user follow the confirmation URL sent to him with previous email
                                    settings or if signed up directly with no double opt-in process. You can use the <strong>{profile_form}</strong> tag to let the user to
                                    complete it's profile.
                                </p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th>Alternative custom welcome page</th>
                            <td>
                                <?php $controls->text('confirmed_url', 70); ?>
                                <p class="description">
                                    A full page address (http://yourblog.com/welcome) to be used instead of message above. If empty the message is
                                    used.
                                </p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th>Conversion tracking code<br/><small>ADVANCED</small></th>
                            <td>
                                <?php $controls->textarea('confirmed_tracking'); ?>
                                <p class="description">
                                    The code is injected AS-IS in welcome page and can be used to track conversion
                                    (you can use PHP if needed). It does not work with a custom welcome page.
                                    Conversion code is usually supply by tracking services,
                                    like Google AdWords, Google Analytics and so on.
                                </p>
                            </td>
                        </tr>

                        <!-- WELCOME/CONFIRMED EMAIL -->
                        <tr valign="top">
                            <th>
                                Welcome email<br /><small>The right place where to put bonus content link</small>
                            </th>
                            <td>
                                <?php $controls->email('confirmed', 'wordpress', true); ?>
                                <?php $controls->button('test-confirmed', 'Send a test'); ?>
                                <p class="description">
                                    Email sent to the user to confirm his subscription, the successful confirmation
                                    page, the welcome email. This is the right message where to put a <strong>{unlock_url}</strong> link to remember to the
                                    user where is the premium content (if any, main configuration panel).<br />
                                    It's a good idea to add the <strong>{unsubscription_url}</strong> too and the <strong>{profile_url}</strong>
                                    letting users to cancel or manage/complete their profile.
                                </p>
                            </td>
                        </tr>

                    </table>
                </div>

                <!-- PROFILE -->
                <div id="tabs-9">

                    <p>
                        The page shown when the subscriber wants to edit his profile following the link
                        {profile_url} you added to a newsletter pr the welcome email.
                    </p>


                    <table class="form-table">
                        <tr valign="top">
                            <th>Customized profile page</th>
                            <td>
                                <?php $controls->text('profile_url', 70); ?>
                                <p class="description">
                                    A full page address (e.g. http://yourblog.com/profile) to be used to show and edit the subscriber profile.
                                    Leave empty to use an auto generated page or the main Newsletter page with the message below.
                                    <br>
                                    The custom page must contain the [newsletter_profile] shortcode.
                                </p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Profile page</th>
                            <td>
                                <?php $controls->wp_editor('profile_text'); ?>
                                <p class="description">
                                    This is the page where subscribers can edit their data and it must contain the {profile_form} tag. <a href="'https://www.thenewsletterplugin.com/plugins/newsletter/subscription-module#profile" target="_blank">Read more</a>.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Other messages</th>
                            <td>
                                confirmation after profile save<br>
                                <?php $controls->text('profile_saved', 80); ?><br><br>
                                email changed notice<br>
                                <?php $controls->text('profile_email_changed', 80); ?>
                                <p class="description">when a subscriber changes his email, he will be unconfirmed and a new confirmation email is sent</p>
                                <br><br>
                                generic error<br>
                                <?php $controls->text('profile_error', 80); ?>
                                <p class="description">when the email is not valid or already used by another subscriber</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="tabs-7">

                    <h4>User's data</h4>
                    <p>
                        <strong>{name}</strong>
                        The user name<br />
                        <strong>{surname}</strong>
                        The user surname<br />
                        <strong>{email}</strong>
                        The user email<br />
                        <strong>{ip}</strong>
                        The IP address from where the subscription started<br />
                        <strong>{id}</strong>
                        The user id<br />
                        <strong>{token}</strong>
                        The user secret token<br />
                        <strong>{profile_N}</strong>
                        The user profile field number N (from 1 to 19)<br />
                    </p>

                    <h4>Action URLs and forms</h4>
                    <p>
                        <strong>{subscription_confirm_url}</strong>
                        URL to build a link to confirmation of subscription when double opt-in is used. To be used on confirmation email.<br />
                        <strong>{unsubscription_url}</strong>
                        URL to build a link to start the cancellation process. To be used on every newsletter to let the user to cancel.<br />
                        <strong>{unsubscription_confirm_url}</strong>
                        URL to build a link to an immediate cancellation action. Can be used on newsletters if you want an immediate cancellation or
                        on cancellation page (displayed on {unsubscription_url}) to ask a cancellation confirmation.<br />
                        <strong>{profile_url}</strong>
                        URL to build a link to user's profile page (see the User Profile panel)<br />
                        <strong>{unlock_url}</strong>
                        Special URL to build a link that on click unlocks protected contents. See Main Configuration panel.<br />
                        <strong>{profile_form}</strong>
                        Insert the profile form with user's data. Usually it make sense only on welcome page.<br />
                    </p>
                </div>
            </div>

            <p>
                <?php $controls->button_save(); ?>
                <?php $controls->button_confirm('reset', 'Reset all', 'Are you sure you want to reset all?'); ?>
            </p>

        </form>
    </div>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

</div>
