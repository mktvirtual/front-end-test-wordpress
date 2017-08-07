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

<!-- TWO COLUMN SECTION -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tnpc-row tnpc-row-posts" data-id="content-07" data-block="content-07-twocols">
    <tr>
        <td bgcolor="<?php echo $bgcolor ?>" align="center" style="padding: 70px 15px 70px 15px;" class="section-padding edit-block">
            <table border="0" cellpadding="0" cellspacing="0" width="500" class="responsive-table">
                <tr>
                    <td>
                        <!-- TITLE SECTION AND COPY -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333;" class="padding-copy tnpc-row-edit" data-type="title">Great News!</td>
                            </tr>
                            <tr>
                                <td align="center" style="padding: 20px 0 20px 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy tnpc-row-edit" data-type="text">The twelve jurors were all writing very busily on slates.</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <!-- TWO COLUMNS -->
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <?php foreach (array_chunk($posts, 2) AS $row) { ?>        
                                    <tr>
                                        <td valign="top" style="padding: 0;" class="mobile-wrapper">
                                    
                                    <!-- LEFT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" align="left" class="responsive-table">
                                        <tr>
                                            <td style="padding: 20px 0 40px 0;">
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    <tr>
                                                        <td align="center" bgcolor="#F5F7FA" valign="middle" class="tnpc-row-edit" data-type="image">
                                                            <a href="<?php echo tnp_post_permalink($row[0]) ?>" target="_blank">
                                                                <img src="<?php echo tnp_post_thumbnail_src($row[0], array(240, 160)) ?>" width="240" height="160" style="display: block; color: #666666; font-family: Helvetica, arial, sans-serif; font-size: 13px; width: 240px; height: 160px;" border="0" class="img-max">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" style="padding: 15px 0 0 0; font-family: Arial, sans-serif; color: #333333; font-size: 20px;" bgcolor="#F5F7FA" class="tnpc-row-edit" data-type="title"><?php echo tnp_post_title($row[0]) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" style="padding: 5px 0 0 0; font-family: Arial, sans-serif; color: #666666; font-size: 14px; line-height: 20px;" bgcolor="#F5F7FA" class="tnpc-row-edit" data-type="text"><?php echo tnp_post_excerpt($row[0]) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" style="padding: 5px 0 0 0; font-family: Arial, sans-serif; color: #666666; font-size: 14px; line-height: 20px;" bgcolor="#F5F7FA"><a href="<?php echo tnp_post_permalink($row[0]) ?>" style="color: #256F9C; text-decoration: none;" class="tnpc-row-edit" data-type="link">Go To Article &rarr;</a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <?php if (!empty($row[1])) { ?>
                                    <!-- RIGHT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" align="right" class="responsive-table">
                                        <tr>
                                            <td style="padding: 20px 0 40px 0;">
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    <tr>
                                                        <td align="center" bgcolor="#F5F7FA" valign="middle" class="tnpc-row-edit" data-type="image">
                                                            <a href="<?php echo tnp_post_permalink($row[1]) ?>" target="_blank">
                                                                <img src="<?php echo tnp_post_thumbnail_src($row[1], array(240, 160)) ?>" width="240" height="160" style="display: block; color: #666666; font-family: Helvetica, arial, sans-serif; font-size: 13px; width: 240px; height: 160px;" border="0" class="img-max">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" style="padding: 15px 0 0 0; font-family: Arial, sans-serif; color: #333333; font-size: 20px;" bgcolor="#F5F7FA" class="tnpc-row-edit" data-type="title"><?php echo tnp_post_title($row[1]) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" style="padding: 5px 0 0 0; font-family: Arial, sans-serif; color: #666666; font-size: 14px; line-height: 20px;" bgcolor="#F5F7FA" class="tnpc-row-edit" data-type="text"><?php echo tnp_post_excerpt($row[1]) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" style="padding: 5px 0 0 0; font-family: Arial, sans-serif; color: #666666; font-size: 14px; line-height: 20px;" bgcolor="#F5F7FA"><a href="<?php echo tnp_post_permalink($row[1]) ?>" style="color: #256F9C; text-decoration: none;" class="tnpc-row-edit" data-type="link">Go To Article &rarr;</a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php } ?>
                                    
                                </td>
                            </tr>
                            
                                    <?php } ?>
                            
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
