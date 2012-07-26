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
  add_submenu_page( 'settings.php', 'OAS settings Settings', 'OAS settings', 'manage_network', 'oas_settings_settings', 'oas_settings_page');
}

function oas_settings_page()
{
  global $oas_settings_app;

  $oas_settings_app->oas_settings_controller->index();
}

add_action('plugin_oas_statistics', 'oas_settings_show_oas_statistics');
function oas_settings_show_oas_statistics()
{
  $site = \WpMvc\Site::find( 1 );

  $oas_active       = $site->sitemeta->oas_active->meta_value;

  if (!isset($site->sitemeta->oas_active) || $oas_active != 'true')
    return;

  $oas_server       = $site->sitemeta->oas_server->meta_value;
  $oas_script_url   = $site->sitemeta->oas_script_url->meta_value;
  $oas_sitepage     = $site->sitemeta->oas_sitepage->meta_value;
  $oas_site         = $site->sitemeta->oas_site->meta_value;
  $oas_position     = $site->sitemeta->oas_position->meta_value;
  $oas_noscript_url = $site->sitemeta->oas_noscript_url->meta_value;
  $oas_html_block   = $site->sitemeta->oas_html_block->meta_value;

  if (isset($site->sitemeta->oas_html_block) && trim($oas_html_block) != '') {
    echo stripslashes($oas_html_block);
    return;
  }

  if (
    !isset($site->sitemeta->oas_active) || trim($oas_active) == ''
    || !isset($site->sitemeta->oas_server) || trim($oas_server) == ''
    || !isset($site->sitemeta->oas_script_url) || trim($oas_script_url) == ''
    || !isset($site->sitemeta->oas_sitepage) || trim($oas_sitepage) == ''
    || !isset($site->sitemeta->oas_site) || trim($oas_site) == ''
    || !isset($site->sitemeta->oas_position) || trim($oas_position) == ''
    || !isset($site->sitemeta->oas_noscript_url) || trim($oas_noscript_url) == ''
  )
    return;

  $randomNumber = rand(10000,99999);

  $department = 'WordPress Blogg';

  global $current_blog;

  $blog = \WpMvc\Blog::find($current_blog->blog_id);

  if(isset($blog->option->i_write_about) && trim($blog->option->i_write_about->option_value) != '') {
    $department = $blog->option->i_write_about->option_value;
  }

  $blog_name    = get_bloginfo('name');
  $oas_page     = strlen($_SERVER['REQUEST_URI']) > 1 ? urlencode('http://' . DOMAIN_CURRENT_SITE . $_SERVER['REQUEST_URI']) : urlencode('Bloggens startsida');

  $oas_section      = 'Blogg';
  $oas_subsection1  = urlencode($department);
  $oas_subsection2  = urlencode($blog_name);

  if ($oas_subsection2[sizeof($oas_subsection2) - 1] == '0') { $oas_subsection2 = substr($oas_subsection2, 0, -1); }

  $group2 = '';

  if (DOMAIN_CURRENT_SITE == 'blogg.st.nu') {
    $group2 = '&Grupp2=ST_Dgbl-natverket';

    if (preg_match('/look/i', $blog->option->current_theme->option_value)) {
      $oas_section = 'LOOK';
      $oas_subsection1 = urlencode($blog_name);
    }
  }

  $stats  = '';
  $stats .= "\n".'<!-- begin oas 6 analytics -->'."\n";
  $stats .= '<script type="text/javascript" src="'.$oas_script_url.'"></script>'."\n";
  $stats .= '<script type="text/javascript"> <!--'."\n";
  $stats .= "\t_version=11;\n";
  $stats .= "\tif (navigator.userAgent.indexOf('mozilla/3') != -1){\n";
  $stats .= "\t\t_version=10;\n";
  $stats .= "\t}\n";

  $stats .= "\tvar server = '".$oas_server."';\n";
  $stats .= "\tvar sitepage = '".$oas_sitepage."';\n";
  $stats .= "\tvar position = '".$oas_position."';\n";
  $stats .= "\tvar oas_site = '".$oas_site."';\n";
  $stats .= "\tvar oas_section = '".$oas_section."';\n";
  $stats .= "\tvar oas_subsection1 = '".$oas_subsection1."';\n";
  $stats .= "\tvar oas_subsection2 = '".$oas_subsection2."';\n";
  $stats .= "\tvar oas_page = '".$oas_page."';\n";

  $stats .= "\tif (! (RN)) {\n";
  $stats .= "\t\tvar RN = new String (Math.random());\n";
  $stats .= "\t\tvar RNS = RN.substring (2, 11);\n";
  $stats .= "\t}\n";
  $stats .= "\tvar oas = server;\n";
  $stats .= "\tvar oaspage = sitepage + '/1' + RNS + '@' + position;\n";
  $stats .= "\toaspage+='?XE'; //Don't touch.\n";
  $stats .= "\toaspage+='&Sajt='+oas_site+'&Sektion='+oas_section+'&Undersektion1='+oas_subsection1+'&Undersektion2='+oas_subsection2+'&Sida='+oas_page+'";
  $stats .= $group2."&Grupp4=nv';";
  $stats .= " //Add Taxonomy here.\n";
  $stats .= "\t".'oaspage+=OAS_rdl + "&if_nt_CookieAccept=" + OAS_CA + \'&XE\'; //Don\'t touch.'."\n";
  $stats .= "\tif (_version < 11) {\n";
  $stats .= "\t\tdocument.write('<a href=\"'+oas+'/1c/'+oaspage+'\" TARGET=\"_top\" ><img src=\"'+oas+'/1/'+oaspage+'\" border=0 width=1 height=1 alt=\" \"></a>');\n";
  $stats .= "\t} else {\n";
  $stats .= "\t\tdocument.write ('<scr'+'ipt type=\"text/javascript\" src=\"' + oas + '/3/' + oaspage + '\">\<\/script\>');\n";
  $stats .= "\t}\n";
  $stats .= "// -->\n";
  $stats .= "</script>\n";

  $stats .= '<noscript>'."\n";
  $stats .= '<img src="'.str_replace('12345',$randomNumber,$oas_noscript_url);
  $stats .= '&Sajt='.$oas_sitepage;
  $stats .= '&Sektion='.$oas_section;
  $stats .= '&Undersektion1='.$oas_subsection1;
  $stats .= '&Undersektion2='.$oas_subsection2;
  $stats .= '&Sida='+$oas_page;
  $stats .= '&Grupp1=tidningsnatet';
  $stats .= $group2;
  $stats .= '&Grupp4=nv';
  $stats .= '&XE';
  $stats .= '" border="0">'."\n";
  $stats .= '</noscript>'."\n";

  $stats .= "<!-- Start natverkstagg Tidningsnatet -->\n";
  $stats .= '<img src="http://sifomedia.tidningsnatet.se/1/tidningsnatet/';
  $stats .= $randomNumber.'@'.$oas_position;
  $stats .= '?XE&Sajt='.$oas_sitepage.'&Sektion=startsida&';
  $stats .= 'Grupp1=tidningsnatet';
  $stats .= $group2;
  $stats .= '&Grupp4=nv';
  $stats .= '&XE" border="0" alt="" />'."\n";
  $stats .= "<!-- Slut natverkstagg -->\n";
  $stats .= '<!-- end oas 6 analytics -->'."\n";

  echo $stats;
}