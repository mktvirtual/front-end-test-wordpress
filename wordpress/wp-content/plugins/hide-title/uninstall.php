<?php

global $wpdb;

$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->postmeta . ' WHERE meta_key="dojodigital_toggle_title"' ) );