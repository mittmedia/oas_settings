<?php global $site; ?>

<div class="wrap">
  <div id="icon-options-general" class="icon32"><br></div>
  <h2><?php _e( 'OAS Settings', 'oas-settings' ); ?></h2>
  <?php

  $content = array(
    array(
      'title' => 'Använd OAS',
      'name' => $site->sitemeta->oas_active->meta_key,
      'type' => 'select',
      'options' => array(
        'true' => 'Ja',
        'false' => 'Nej',
      ),
      'object' => $site->sitemeta->oas_active,
      'default_value' => \OasSettings\SettingsHelper::activation_option_to_text( $site->sitemeta->oas_active->meta_value ),
      'key' => 'meta_value'
    ),
    array(
      'title' => 'HTML',
      'name' => $site->sitemeta->oas_html_block->meta_key,
      'type' => 'textarea',
      'object' => $site->sitemeta->oas_html_block,
      'default_value' => $site->sitemeta->oas_html_block->meta_value,
      'key' => 'meta_value',
      'description' => 'Om det finns kod skrivet här används den istället för nedanstående OAS-inställningar.'
    ),
    array(
      'title' => 'Server',
      'name' => $site->sitemeta->oas_server->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->oas_server,
      'default_value' => $site->sitemeta->oas_server->meta_value,
      'key' => 'meta_value',
      'description' => 'Tidningens subdomän hos SIFO, Exempel: http://sifomedia.allehanda.se'
    ),
    array(
      'title' => 'Script URL',
      'name' => $site->sitemeta->oas_script_url->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->oas_script_url,
      'default_value' => $site->sitemeta->oas_script_url->meta_value,
      'key' => 'meta_value',
      'description' => 'Undersök Page Source på tidningens hemsida om ni är osäkra, det brukar vara t.ex. http://sifomedia.allehanda.se/Scripts/oas_analytics.js'
    ),
    array(
      'title' => 'Sitepage',
      'name' => $site->sitemeta->oas_sitepage->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->oas_sitepage,
      'default_value' => $site->sitemeta->oas_sitepage->meta_value,
      'key' => 'meta_value',
      'description' => 'Sajtens alias hos SIFO, Exempel: allehanda och st'
    ),
    array(
      'title' => 'Site',
      'name' => $site->sitemeta->oas_site->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->oas_site,
      'default_value' => $site->sitemeta->oas_site->meta_value,
      'key' => 'meta_value',
      'description' => 'Parametern "site" så att statistiken reggas rätt hos SIFO, Exempel: allehanda och st'
    ),
    array(
      'title' => 'Position',
      'name' => $site->sitemeta->oas_position->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->oas_position,
      'default_value' => $site->sitemeta->oas_position->meta_value,
      'key' => 'meta_value',
      'description' => 'Fråga SIFO om ni är osäkra, det brukar vara http://sifomedia.allehanda.se/1/allehanda/12345@TopRight?XE&JSFLAG=noscript'
    ),
    array(
      'title' => 'NoScript URL',
      'name' => $site->sitemeta->oas_noscript_url->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->oas_noscript_url,
      'default_value' => $site->sitemeta->oas_noscript_url->meta_value,
      'key' => 'meta_value'
    ),
  );

  \WpMvc\FormHelper::render_form( $site, $content );

  ?>
</div>