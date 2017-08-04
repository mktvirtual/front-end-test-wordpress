<?php
include NEWSLETTER_INCLUDES_DIR . '/helper.php';

$filters = array();
$filters['showposts'] = isset($_POST['num']) ? intval($_POST['num']) : 3;
if (!empty($_POST['categories'])) {
    $filters['category__in'] = $_POST['categories'];
}
if (!empty($_POST['tags'])) {
    $filters['tag'] = $_POST['tags'];
}
$posts = get_posts($filters);

$bgcolor = isset($_POST['bgcolor']) ? $_POST['bgcolor'] : '#E6E9ED';

?>

<!-- COMPACT ARTICLE SECTION -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tnpc-row tnpc-row-posts" data-id="content-06" data-block="content-06-posts">
    <tr>
        <td bgcolor="<?php echo $bgcolor ?>" align="center" style="padding: 70px 15px 70px 15px;" class="section-padding edit-block">
            
            <table border="0" cellpadding="0" cellspacing="0" width="500" style="padding:0 0 20px 0;" class="responsive-table">
                <!-- TITLE -->
                <tr>
                    <td align="center" style="padding: 0 0 10px 0; font-size: 25px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #333333;" class="padding-copy tnpc-row-edit" data-type="title" colspan="2">From Our Blog</td>
                </tr>

<?php foreach ($posts AS $post) { ?>

                    <tr>
                        <td valign="top" style="padding: 40px 0 0 0;" class="mobile-hide tnpc-row-edit" data-type="image">
                            <a href="<?php echo tnp_post_permalink($post) ?>" target="_blank">
                                <img src="<?php echo tnp_post_thumbnail_src($post) ?>" width="105" height="105" border="0" style="display: block; font-family: Arial; color: #666666; font-size: 14px; width: 105px!important; height: 105px!important;">
                            </a>
                        </td>
                        <td style="padding: 40px 0 0 0;" class="no-padding">
                            <!-- ARTICLE -->
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                    <td align="left" style="padding: 0 0 5px 25px; font-size: 13px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #aaaaaa;" class="padding-meta">
                                        <?php echo tnp_post_date($post) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding: 0 0 5px 25px; font-size: 22px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #333333;" class="padding-copy tnpc-row-edit" data-type="title">
                                        <?php echo tnp_post_title($post) ?>
                                    </td>  
                                </tr>
                                <tr>
                                    <td align="left" style="padding: 10px 0 15px 25px; font-size: 16px; line-height: 24px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy tnpc-row-edit" data-type="text">
                                        <?php echo tnp_post_excerpt($post) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 0 45px 25px;" align="left" class="padding">
                                        <table border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                                            <tr>
                                                <td align="center">
                                                    <!-- BULLETPROOF BUTTON -->
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                                                        <tr>
                                                            <td align="center" style="padding: 0;" class="padding-copy">
                                                                <table border="0" cellspacing="0" cellpadding="0" class="responsive-table">
                                                                    <tr>
                                                                        <td align="center">
                                                                            <a href="<?php echo tnp_post_permalink($post) ?>" target="_blank" style="font-size: 15px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #256F9C; border-top: 10px solid #256F9C; border-bottom: 10px solid #256F9C; border-left: 20px solid #256F9C; border-right: 20px solid #256F9C; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;" class="mobile-button tnpc-row-edit" data-type="link">Go To Article &rarr;</a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

<?php } ?>

            </table>
        </td>
    </tr>
</table>
