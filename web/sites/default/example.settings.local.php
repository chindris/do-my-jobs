<?php
/**
 * @file
 * AmazeeIO Drupal 8 example settings.local.php file
 *
 * This file will not be included and is just an example file.
 * If you would like to use this file, copy it to the name 'settings.local.php' (this file will be excluded from Git)
 */
 
// Disable render caches, necessary for twig files to be newly loaded all the time
$settings['cache']['bins']['render'] = 'cache.backend.null';
$settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';

$config['system.logging']['error_level'] = 'verbose';
