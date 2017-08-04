<?php

// This file is used only on first installation!

$options = array();
$options['enabled'] = 0;
$options['template'] = @file_get_contents(dirname(__FILE__) . '/../email.html');
