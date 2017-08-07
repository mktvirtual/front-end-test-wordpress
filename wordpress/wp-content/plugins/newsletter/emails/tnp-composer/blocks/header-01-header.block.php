<!-- HEADER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" data-id="header-01" class="tnpc-row" data-id="header-01">
    <tr>
        <td bgcolor="#333333" class="edit-block">
            <div align="center" style="padding: 0px 15px 0px 15px;">
                <table border="0" cellpadding="0" cellspacing="0" width="500" class="wrapper">
                    <!-- LOGO/PREHEADER TEXT -->
                    <tr>
                        <td style="padding: 20px 0px 30px 0px;" class="logo">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="100" align="left" class="tnpc-row-edit" data-type="image">
                                        <a href="#" target="_blank">
                                            <?php if (!empty($block_options['header_logo']['url'])) { ?>
                                                <img alt="<?php echo esc_attr($block_options['header_title']) ?>" src="<?php echo $block_options['header_logo']['url'] ?>" style="display: block; width: 180px;" border="0">
                                            <?php } else { ?>
                                                <img alt="<?php echo esc_attr($block_options['header_title']) ?>" src="http://placehold.it/180x100&text=<?php echo esc_attr($block_options['header_title']) ?>" style="display: block; width: 180px;" border="0">
                                            <?php } ?>
                                        </a>
                                    </td>
                                    <td width="400" align="right" class="mobile-hide">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="right" style="padding: 0 0 5px 0; font-size: 14px; font-family: Arial, sans-serif; color: #666666; text-decoration: none;" class="tnpc-row-edit" data-type="text">
                                                    <span style="color: #666666; text-decoration: none;" ><?php echo !empty($block_options['header_sub']) ? $block_options['header_sub'] : 'A little text up top can be nice.<br>Maybe a link to tweet?' ?></span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>