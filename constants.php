<?php
define('BASE_URL', 'http://' . $_SERVER['SERVER_NAME']);

// themes/plugins/upload/ckeditor paths
define('THEMES_PATH', ROOT_PATH . '/public/themes/');
define('THEMES_DEFAULT_PATH', THEMES_PATH . 'default/');
define('PLUGINS_PATH', ROOT_PATH . '/public/plugins/');
define('CKEDITOR_PATH', ROOT_PATH . '/public/ckeditor/');

define('THEMES_URL', BASE_URL . '/public/themes/');
define('THEMES_DEFAULT_URL', THEMES_URL . 'default/');
define('PLUGINS_URL', BASE_URL . '/public/plugins/');
define('CKEDITOR_URL', BASE_URL . '/public/ckeditor/');

// table prefix
define('TABLE_PREFIX', 'na_');
