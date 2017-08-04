<?php

/**
 * This file is used for creating dbHelper class.
 *
 * @author Tech Banker
 * @package google-maps-bank
 * @version 2.0.0
 */
if (!defined("ABSPATH")) {
    exit;
} // Exit if accessed directly
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
        /*
          Class Name: dbHelper_google_maps
          Parameter: No
          Description: This class is user for insert,update and delete operations.
          Created On: 7-11-2016 18:11
          Created By: Tech Banker Team
         */

        class dbHelper_google_maps {
            /*
              Function Name: insertCommand
              Parameter: Yes($table_name,$data)
              Description: This function is used to insert data in database.
              Created On: 28-01-2017 13:23
              Created By: Tech Banker Team
             */

            function insertCommand($table_name, $data) {
                global $wpdb;
                $wpdb->insert($table_name, $data);
                return $wpdb->insert_id;
            }

            /*
              Function Name: updateCommand
              Parameter: Yes($table_name,$data,$where)
              Description: This function is used to update data in database.
              Created On: 28-01-2017 13:23
              Created By: Tech Banker Team
             */

            function updateCommand($table_name, $data, $where) {
                global $wpdb;
                $wpdb->update($table_name, $data, $where);
            }

            /*
              Function Name: deleteCommand
              Parameter: Yes($table_name,$where)
              Description: This function is used to delete data from database.
              Created On: 28-01-2017 13:23
              Created By: Tech Banker Team
             */

            function deleteCommand($table_name, $where) {
                global $wpdb;
                $wpdb->delete($table_name, $where);
            }

            /*
              Function Name: bulk_deleteCommand
              Parameter: Yes($table_name,$where,$data)
              Description: This function is used to delete multiple data from database.
              Created On: 28-01-2017 13:23
              Created By: Tech Banker Team
             */

            function bulk_deleteCommand($table_name, $where, $data) {
                global $wpdb;
                $wpdb->query
                        (
                        "DELETE FROM $table_name WHERE $where IN ($data)"
                );
            }

            /*
              Function Name: file_reader
              Parameters: No
              Decription: This function is used to file read.
              Created On: 28-01-2017 13:23
              Created By: Tech Banker Team
             */

            public static function file_reader($filePath) {
                $reader = "";
                if (file_exists($filePath)) {
                    $reader = file_get_contents($filePath);
                }
                return $reader;
            }

        }

        /*
          Class Name: plugin_info_google_maps_bank
          Parameters: No
          Description: This Class is used to get the the information about plugins.
          Created On: 05-04-2017 18:06
          Created By: Tech Banker Team
         */

        class plugin_info_google_maps_bank {
            /*
              Function Name: get_plugin_info_google_maps_bank
              Parameters: No
              Decription: This function is used to return the information about plugins.
              Created On: 05-04-2017 18:06
              Created By: Tech Banker Team
             */

            function get_plugin_info_google_maps_bank() {
                $active_plugins = (array) get_option("active_plugins", array());
                if (is_multisite())
                    $active_plugins = array_merge($active_plugins, get_site_option("active_sitewide_plugins", array()));
                $plugins = array();
                if (count($active_plugins) > 0) {
                    $get_plugins = array();
                    foreach ($active_plugins as $plugin) {
                        $plugin_data = @get_plugin_data(WP_PLUGIN_DIR . "/" . $plugin);

                        $get_plugins["plugin_name"] = strip_tags($plugin_data["Name"]);
                        $get_plugins["plugin_author"] = strip_tags($plugin_data["Author"]);
                        $get_plugins["plugin_version"] = strip_tags($plugin_data["Version"]);
                        array_push($plugins, $get_plugins);
                    }
                    return $plugins;
                }
            }

        }

    }
}