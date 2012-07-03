<?php
/*
Plugin Name: OAS settings
Plugin URI: https://github.com/mittmedia/oas_settings
Description: Setup statistic tags for OAS
Version: 1.0.0
Author: Fredrik Sundström
Author URI: https://github.com/fredriksundstrom
License: MIT
*/

/*
Copyright (c) 2012 Fredrik Sundström

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
*/

require_once( 'wp_mvc/init.php' );

$oas_settings_app = new \WpMvc\Application();

$oas_settings_app->init( 'OasSettings', WP_PLUGIN_DIR . '/oas_settings' );

// WP: Add pages
add_action( "network_admin_menu", "oas_settings" );
function oas_settings()
{
  add_submenu_page( 'settings.php', 'OAS settings Settings', 'OAS settings', 'Super Admin', 'oas_settings_settings', 'oas_settings_page');
}

function oas_settings_page()
{
  global $oas_settings_app;

  $oas_settings_app->oas_settings_controller->index();
}