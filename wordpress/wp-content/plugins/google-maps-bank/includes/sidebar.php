<?php
/**
 * This file is used for displaying sidebar menus.
 *
 * @author  Tech Banker
 * @package google-maps-bank/includes
 * @version 2.0.0
 */
if (!defined("ABSPATH")) {
    exit;
}// Exit if accessed directly
if (!is_user_logged_in()) {
    return;
} else {
    $access_granted = false;
    foreach ($user_role_permission as $permission) {
        if (current_user_can($permission)) {
            $access_granted = true;
            break;
        }
    }
    if (!$access_granted) {
        return;
    } else {
        ?>
        <div class="page-sidebar-wrapper-tech-banker">
            <div class="page-sidebar-tech-banker navbar-collapse collapse">
                <div class="sidebar-menu-tech-banker">
                    <ul class="page-sidebar-menu-tech-banker" data-slide-speed="200">
                        <div class="sidebar-search-wrapper" style="padding:20px;text-align:center">
                            <a class="plugin-logo" href="<?php echo tech_banker_beta_url; ?>" target="_blank">
                                <img src="<?php echo plugins_url("assets/global/img/google-maps-logo.png", dirname(__FILE__)); ?>" alt="Google Maps Bank">
                            </a>
                        </div>
                        <li id="ux_li_google_map">
                            <a href="javascript:;">
                                <i class="icon-custom-globe-alt"></i>
                                <span>
                                    <?php echo $gm_google_maps; ?>
                                </span>
                            </a>
                            <ul class="sub-menu">
                                <li id="ux_li_manage_map">
                                    <a href="admin.php?page=gmb_google_maps">
                                        <i class=icon-custom-grid ></i>
                                        <span>
                                            <?php echo $gm_manage_map; ?>
                                        </span>
                                    </a>
                                </li>
                                <li id="ux_li_add_map">
                                    <a href="admin.php?page=gmb_add_map">
                                        <i class="icon-custom-plus "></i>
                                        <span>
                                            <?php echo $gm_add_map; ?>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="ux_li_google_map_overlay">
                            <a href="javascript:;">
                                <i class="icon-custom-map "></i>
                                <span>
                                    <?php echo $gm_overlays; ?>
                                </span>
                            </a>
                            <ul class="sub-menu">
                                <li id="ux_li_manage_overlay">
                                    <a href="admin.php?page=gmb_manage_overlays">
                                        <i class=icon-custom-book-open></i>
                                        <span>
                                            <?php echo $gm_manage_overlays; ?>
                                        </span>
                                    </a>
                                </li>
                                <li id="ux_li_add_overlay">
                                    <a href="admin.php?page=gmb_add_overlays">
                                        <i class="icon-custom-basket"></i>
                                        <span>
                                            <?php echo $gm_add_overlays; ?>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="ux_li_google_map_layers">
                            <a href="admin.php?page=gmb_layers">
                                <i class="icon-custom-layers"></i>
                                <span>
                                    <?php echo $gm_layers; ?>
                                </span>
                                <span class="badge">Pro</span>
                            </a>
                        </li>
                        <li id="ux_li_google_map_store_locator">
                            <a href="javascript:;">
                                <i class="icon-custom-pointer"></i>
                                <span>
                                    <?php echo $gm_store_locator; ?>
                                </span>
                                <span class="badge">Pro</span>
                            </a>
                            <ul class="sub-menu">
                                <li id="ux_li_manage_store">
                                    <a href="admin.php?page=gmb_manage_store">
                                        <i class=icon-custom-energy></i>
                                        <span>
                                            <?php echo $gm_manage_store; ?>
                                        </span>
                                    </a>
                                </li>
                                <li id="ux_li_add_store">
                                    <a href="admin.php?page=gmb_add_store">
                                        <i class="icon-custom-plus"></i>
                                        <span>
                                            <?php echo $gm_add_store; ?>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="ux_li_layout_settings">
                            <a href="javascript:;">
                                <i class="icon-custom-paper-clip"></i>
                                <span>
                                    <?php echo $gm_layout_settings; ?>
                                </span>
                            </a>
                            <ul class="sub-menu">
                                <li id="ux_li_info_window">
                                    <a href="admin.php?page=gmb_info_window">
                                        <i class="icon-custom-picture"></i>
                                        <span>
                                            <?php echo $gm_info_window; ?>
                                        </span>
                                    </a>
                                </li>
                                <li id="ux_li_directions">
                                    <a href="admin.php?page=gmb_directions">
                                        <i class="icon-custom-directions"></i>
                                        <span>
                                            <?php echo $gm_directions; ?>
                                        </span>
                                        <span class="badge">Pro</span>
                                    </a>
                                </li>
                                <li id="ux_li_store_locator">
                                    <a href="admin.php?page=gmb_store_locator">
                                        <i class="icon-custom-tag"></i>
                                        <span>
                                            <?php echo $gm_store_locator; ?>
                                        </span>
                                        <span class="badge">Pro</span>
                                    </a>
                                </li>
                                <li id="ux_li_map_customization">
                                    <a href="admin.php?page=gmb_map_customization">
                                        <i class="icon-custom-paper-plane"></i>
                                        <span>
                                            <?php echo $gm_map_customization; ?>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="ux_li_custom_css">
                            <a href="admin.php?page=gmb_custom_css">
                                <i class="icon-custom-pencil"></i>
                                <span>
                                    <?php echo $gm_custom_css; ?>
                                </span>
                                <span class="badge">Pro</span>
                            </a>
                        </li>
                        <li id="ux_li_shortcodes">
                            <a href="admin.php?page=gmb_shortcode">
                                <i class="icon-custom-rocket"></i>
                                <span>
                                    <?php echo $gm_shortcode; ?>
                                </span>
                            </a>
                        </li>
                        <li id="ux_li_other_settings">
                            <a href="admin.php?page=gmb_other_settings">
                                <i class="icon-custom-wrench"></i>
                                <span>
                                    <?php echo $gm_other_settings; ?>
                                </span>
                            </a>
                        </li>
                        <li id="ux_li_roles_and_capabilities">
                            <a href="admin.php?page=gmb_roles_and_capabilities">
                                <i class="icon-custom-user"></i>
                                <span>
                                    <?php echo $gm_roles_and_capabilities; ?>
                                </span>
                                <span class="badge">Pro</span>
                            </a>
                        </li>
                        <li id="ux_li_feature_requests">
                            <a href="admin.php?page=gmb_feature_requests">
                                <i class="icon-custom-call-out"></i>
                                <span>
                                    <?php echo $gm_feature_requests; ?>
                                </span>
                            </a>
                        </li>
                        <li id="ux_li_system_information">
                            <a href="admin.php?page=gmb_system_information">
                                <i class="icon-custom-screen-desktop"></i>
                                <span>
                                    <?php echo $gm_system_information; ?>
                                </span>
                            </a>
                        </li>
                        <li id="ux_li_upgrade">
                            <a href="admin.php?page=gm_upgrade">
                                <i class="icon-custom-briefcase"></i>
                                <span>
                                    <?php echo $gm_upgrade; ?>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-content-wrapper">
            <div class="page-content">
                <div style="margin-bottom:12px">
                    <a href="http://beta.tech-banker.com/products/google-maps-bank/" target="_blank">
                        <img src="<?php echo plugins_url("assets/global/img/google-maps-bank-banner.png", dirname(__FILE__)); ?>" title="Google Maps Bank" style="width: 100%;">
                    </a>
                </div>
                <div class="container-fluid page-header-container">
                    <div class="row">
                        <div class="col-md-3 page-header-column">
                            <h4>Get Started</h4>
                            <a class="btn" href="#" target="_blank">Watch Video!</a>
                            <p>or <a href="http://beta.tech-banker.com/products/google-maps-bank/user-guide/" target="_blank">read documentation here</a></p>
                        </div>
                        <div class="col-md-3 page-header-column">
                            <h4>Go Premium</h4>
                            <ul>
                                <li><a href="http://beta.tech-banker.com/products/google-maps-bank/" target="_blank">Features</a></li>
                                <li><a href="http://beta.tech-banker.com/products/google-maps-bank/demos/" target="_blank">Online Demos</a></li>
                                <li><a href="http://beta.tech-banker.com/products/google-maps-bank/pricing/" target="_blank">Pricing Plans</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3 page-header-column">
                            <h4>User Guide</h4>
                            <ul>
                                <li><a href="http://beta.tech-banker.com/products/google-maps-bank/user-guide/" target="_blank">Documentation</a></li>
                                <li><a href="https://wordpress.org/support/plugin/google-maps-bank" target="_blank">Support Question!</a></li>
                                <li><a href="http://beta.tech-banker.com/contact-us/" target="_blank">Contact Us</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3 page-header-column">
                            <h4>More Actions</h4>
                            <ul>
                                <li><a href="https://wordpress.org/support/plugin/google-maps-bank/reviews/?filter=5" target="_blank">Rate Us!</a></li>
                                <li><a href="http://beta.tech-banker.com/products/" target="_blank">Our Other Products</a></li>
                                <li><a href="http://beta.tech-banker.com/services/" target="_blank">Our Other Services</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
            }
        }