<?php
if (!defined('ABSPATH'))
    exit;

@include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();
$module = NewsletterSubscription::instance();

if (!$controls->is_action()) {
    $controls->data = $module->get_options('template');
} else {
    if ($controls->is_action('save')) {
        $module->save_options($controls->data, 'template');

        if (strpos($controls->data['template'], '{message}') === false) {
            $controls->errors = __('The tag {message} is missing in your template', 'newsletter');
        }

        $controls->add_message_saved();
    }
    if ($controls->is_action('reset')) {
        $controls->data['template'] = file_get_contents(dirname(__FILE__) . '/email.html');
        $controls->add_message_done();
    }

    if ($controls->is_action('test')) {

        $users = NewsletterUsers::instance()->get_test_users();
        if (count($users) == 0) {
            $controls->errors = __('No test subscribers found.', 'newsletter') . ' <a href="https://www.thenewsletterplugin.com/plugins/newsletter/subscribers-module#test" target="_blank"><i class="fa fa-info-circle"></i></a>';
        } else {
            $template = $controls->data['template'];
            if (strpos($template, '{message}') === false) {
                $template .= '{message}';
            }
            $message = '<p>This is a generic example of message embedded inside the template.</p>';
            $message .= '<p>Subscriber data can be referenced by messages with tags. See the <a href="https://www.thenewsletterplugin.com">plugin documentation</a>.</p>';
            $message .= '<p>First name: {name}</p>';
            $message .= '<p>Last name: {surname}</p>';
            $message .= '<p>Email: {email}</p>';

            $message = str_replace('{message}', $message, $template);
            $addresses = array();
            foreach ($users as &$user) {
                $addresses[] = $user->email;
                Newsletter::instance()->mail($user->email, 'Newsletter Messages Template Test', $newsletter->replace($message, $user));
            }
            $controls->messages .= 'Test emails sent to ' . count($users) . ' test subscribers: ' .
                    implode(', ', $addresses) . '.' . ' <a href="https://www.thenewsletterplugin.com/plugins/newsletter/subscribers-module#test" target="_blank"><i class="fa fa-info-circle"></i></a>';
        }
    }
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/codemirror.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/addon/hint/show-hint.css">
<style>    
.CodeMirror {
            height: 100%;
        }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/codemirror.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/mode/xml/xml.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/mode/css/css.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/mode/javascript/javascript.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/mode/htmlmixed/htmlmixed.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/addon/hint/show-hint.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/addon/hint/xml-hint.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/addon/hint/html-hint.js"></script>
<script>
    jQuery(function () {
        templateEditor = CodeMirror.fromTextArea(document.getElementById("options-template"), {
            lineNumbers: true,
            mode: 'htmlmixed',
            extraKeys: {"Ctrl-Space": "autocomplete"}
        });
    });
</script>

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_DIR . '/tnp-header.php'; ?>

    <div id="tnp-heading">

        <h2><?php _e('Messages template', 'newsletter') ?></h2>
        <p>
            Edit the default template of confirmation, welcome and cancellation emails. Add the {message} tag where you
            want the specific message text to be included.
        </p>

    </div>

    <div id="tnp-body">

        <form method="post" action="">
            <?php $controls->init(); ?>
            <p>
                <?php $controls->button_save(); ?>
            </p>
            <table class="form-table">
                <tr valign="top">
                    <th>Enabled?</th>
                    <td>
                        <?php $controls->yesno('enabled'); ?>
                        <p class="description">
                            When not enabled, the old templating system is used (see the file
                            wp-content/plugins/newsletter/subscription/email.php).
                        </p>
                    </td>
                </tr>
                </table>
            
                <h3><?php _e('Template', 'newsletter')?></h3>
                
                        <?php $controls->textarea_preview('template', '100%', '700px'); ?>
                        <br><br>
                        <?php $controls->button_reset(); ?>
                        <?php $controls->button('test', 'Send a test'); ?>
                
            <p>
                <?php $controls->button_save(); ?>
            </p>
        </form>
    </div>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

</div>