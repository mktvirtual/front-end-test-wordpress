<?php
if (!defined('ABSPATH')) exit;

@include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$module = Newsletter::instance();
$controls = new NewsletterControls();

if (!$controls->is_action()) {
    $controls->data = get_option('newsletter_main');
} else {

    if ($controls->is_action('save')) {
        $module->merge_options($controls->data);
        $controls->messages .= 'Saved.';
    }
}
?>

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_DIR . '/tnp-header.php'; ?>

    <div id="tnp-heading">
    
        <h2><?php _e('Company Info', 'newsletter') ?></h2>
        <p>
            These informations are used by Newsletter themes to automatically generate some sections of regular newsletters,
            <a href="https://www.thenewsletterplugin.com/feed-by-mail-extension?utm_source=plugin&utm_medium=link&utm_campaign=newsletter-feed" target="_blank">
                auto messages
            </a> and 
            <a href="https://www.thenewsletterplugin.com/plugins/newsletter/follow-up-module?utm_source=plugin&utm_medium=link&utm_campaign=newsletter-followup" target="_blank">
                follow-up mails
            </a>. 
            Themes may not use all these fields and/or have specific alternate configurations. All fields are <strong>optional</strong>.
        </p>
        
    </div>
    <div id="tnp-body">

    <form method="post" action="">
        <?php $controls->init(); ?>

        <div id="tabs">

            <ul>
                <li><a href="#tabs-general"><?php _e('General', 'newsletter') ?></a></li>
                <li><a href="#tabs-social"><?php _e('Social', 'newsletter') ?></a></li>
            </ul>

            <div id="tabs-general">
                <h3>Header Settings</h3>

                <table class="form-table">
                    <tr valign="top">
                        <th>
                            Logo
                    <div class="tnp-tip">
                        <span class="tip-button">Tip</span>
                        <span class="tip-content">
                            Keep the file lightweight and ideally smaller than 500px in width and 200px in height.
                            Remember that .png images provide best performances with text and shapes logos.
                        </span>
                    </div>
                    </th>
                    <td>
                        <?php $controls->media('header_logo', 'medium'); ?>
                        <p class="description">
                            Click to change. This should be your logo in .png or .jpg format.
                        </p>
                    </td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>
                            <?php $controls->text('header_title', 40); ?>
                            <p class="description">Appears only when no logo has been uploaded or when it's blocked by email clients.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Subtitle</th>
                        <td>
                            <?php $controls->text('header_sub', 40); ?>
                            <p class="description">Appears only if present.</p>
                        </td>
                    </tr>
                </table>

                <h3>Footer Settings</h3>

                <table class="form-table">
                    <tr valign="top">
                        <th>Blog or company name</th>
                        <td>
                            <?php $controls->text('footer_title', 40); ?>
                            <p class="description">
                                User or corporation name to be displayed on the newsletter footer.
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th>Address</th>
                        <td>
                            <?php $controls->text('footer_contact', 40); ?>
                            <p class="description">
                                Your real address, if available. The CAN-SPAM Act requires it.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th>Copyright, privacy or legal text</th>
                        <td>
                            <?php $controls->text('footer_legal', 40); ?>
                            <p class="description">
                                Any copyright, privacy or legal text you want on the newsletter footer.
                            </p>
                        </td>
                    </tr>
                </table>                
            </div>
            <div id="tabs-social">
                <h3>Social Settings</h3>

                <p>Social icons will be added automatically to your newsletter only for set URLs.</p>

                <table class="form-table">
                    <tr valign="top">
                        <th>Facebook</th>
                        <td>
                            <?php $controls->text('facebook_url', 40); ?>
                            <p class="description">
                                Your Facebook url (e.g. https://www.facebook.com/thenewsletterplugin)
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th>Google+</th>
                        <td>
                            <?php $controls->text('googleplus_url', 40); ?>
                            <p class="description">
                                Your Google+ url (e.g. https://plus.google.com/...)
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th>Twitter</th>
                        <td>
                            <?php $controls->text('twitter_url', 40); ?>
                            <p class="description">
                                Your Twitter url (e.g. https://twitter.com/...)
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th>Linkedin</th>
                        <td>
                            <?php $controls->text('linkedin_url', 40); ?>
                            <p class="description">
                                Your Linkedin url (e.g. https://www.linkedin.com/in/...)
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th>YouTube</th>
                        <td>
                            <?php $controls->text('youtube_url', 40); ?>
                            <p class="description">
                                Your YouTube url (e.g. https://www.youtube.com/channel/...)
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th>Vimeo</th>
                        <td>
                            <?php $controls->text('vimeo_url', 40); ?>
                            <p class="description">
                                Your Vimeo url (e.g. http://vimeo.com/...)
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th>Instagram</th>
                        <td>
                            <?php $controls->text('instagram_url', 40); ?>
                            <p class="description">
                                Your Vimeo url (e.g. http://instagram.com/...)
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <p>
            <?php $controls->button('save', 'Save'); ?>
        </p>

    </form>
</div>
    
    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>
    
</div>
