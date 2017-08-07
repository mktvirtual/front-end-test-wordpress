<?php
if (!defined('ABSPATH'))
    exit;

/* READ THE BLOCKS */
$blocks_dir = NEWSLETTER_DIR . '/emails/tnp-composer/blocks/';
$files = glob($blocks_dir . '*.block.php');
foreach ($files as $file) {
    $path_parts = pathinfo($file);
    $filename = $path_parts['filename'];
    $section = substr($filename, 0, strpos($filename, '-'));
    $index = substr($filename, strpos($filename, '-') + 1, 2);
    $blocks[$section][$index]['name'] = substr($filename, strrpos($filename, '-') + 1);
    $blocks[$section][$index]['filename'] = $filename;
}

$dirs = apply_filters('newsletter_blocks_dir', array());

foreach ($dirs as $dir) {
    $dir = str_replace('\\', '/', $dir);

    $list = NewsletterEmails::instance()->scan_blocks_dir($dir);

    foreach ($list as $key => $data) {
        $blocks[$data['section']][$key]['name'] = $data['name'];
        $blocks[$data['section']][$key]['filename'] = $key;
        $blocks[$data['section']][$key]['icon'] = $data['icon'];
    }
}

// order the sections
$blocks = array_merge(array_flip(array('header', 'content', 'footer')), $blocks);

// prepare the options for the default blocks
$block_options = get_option('newsletter_main');
?>
<style>
    .placeholder {
        border: 1px dotted #bbb!important;
        border-style: dotted!important;
        border-color: #bbb!important;
        border-width: 1px!important;
        background-color: #fff!important;
        height: 50px;
        margin: 15px 0;
        width: 100%;
        box-sizing: border-box!important;
    }
    #newsletter-builder-area-center-frame-content {
        min-height: 300px!important;
    }
</style>

<div id="newsletter-preloaded-export" style="display: none;"></div>

<div id="newsletter-builder">  

    <div id="newsletter-builder-sidebar">

        <?php foreach ($blocks as $k => $section) { ?>
            <div class="newsletter-sidebar-add-buttons" id="sidebar-add-<?php echo $k ?>">
                <h4><span><?php echo ucfirst($k) ?></span></h4>
                <?php foreach ($section AS $key => $block) { ?>
                    <div class="newsletter-sidebar-buttons-content-tab" data-id="<?php echo $k . '-' . $key ?>" data-file="<?php echo $block['filename'] ?>">
                        <?php if (isset($block['icon'])) { ?>
                            <img src="<?php echo $block['icon'] ?>" title="<?php echo esc_attr($block['name']) ?>">
                        <?php } else if (file_exists(NEWSLETTER_DIR . '/emails/tnp-composer/blocks/' . $block['filename'] . '.png')) { ?>
                            <img src="<?php echo plugins_url('newsletter'); ?>/emails/tnp-composer/blocks/<?php echo $block['filename'] ?>.png" title="Drag&Drop">
                        <?php } else { ?>
                            <img src="http://placehold.it/200x100?text=<?php echo $block['name'] ?>" title="Drag&Drop">
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

    </div>

    <div id="newsletter-builder-area">

        <div id="newsletter-builder-area-center-frame-content">

            <?php
            if (isset($email)) {
                echo NewsletterModule::extract_body($body);
            } else {
                include $blocks_dir . 'header-01-header.block.php';
                include $blocks_dir . 'content-01-hero.block.php';
                include $blocks_dir . 'footer-01-footer.block.php';
                include $blocks_dir . 'footer-02-canspam.block.php';
            }
            ?>

        </div>
    </div>

    <div id="newsletter-mobile-preview-area">
        <iframe id="tnp-mobile-preview"></iframe>
    </div>

</div>

<div id="tnp-body"> 
    <?php include NEWSLETTER_DIR . '/emails/tnp-composer/edit.php'; ?>
</div>

<script type="text/javascript">
    TNP_PLUGIN_URL = "<?php echo NEWSLETTER_URL ?>";
    TNP_HOME_URL = "<?php echo home_url('/', is_ssl()?'https':'http') ?>";
</script>
<script type="text/javascript" src="<?php echo plugins_url('newsletter'); ?>/emails/tnp-composer/_scripts/newsletter-builder.js?ver=<?php echo time() ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.3/tinymce.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>
<script>
    jQuery(function () {
        //jQuery("#tnp-mobile-preview").niceScroll();
        tnp_mobile_preview();
    });
</script>