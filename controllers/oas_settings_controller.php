<?php

namespace OasSettings
{
  class OasSettingsController extends \WpMvc\BaseController
  {
    public function index()
    {
      global $site;

      $site = \WpMvc\Site::find( 1 );
      $this->create_attribute_if_not_exists( $site, 'oas_active' );
      $this->create_attribute_if_not_exists( $site, 'oas_server' );
      $this->create_attribute_if_not_exists( $site, 'oas_script_url' );
      $this->create_attribute_if_not_exists( $site, 'oas_sitepage' );
      $this->create_attribute_if_not_exists( $site, 'oas_site' );
      $this->create_attribute_if_not_exists( $site, 'oas_position' );
      $this->create_attribute_if_not_exists( $site, 'oas_noscript_url' );
      $this->create_attribute_if_not_exists( $site, 'oas_html_block' );

      if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_GET['page'] ) && $_GET['page'] == 'oas_settings_settings' ) {
        $site->takes_post( $_POST['site'] );

        $site->save();
      }

      $this->render( $this, "index" );
    }

    private function create_attribute_if_not_exists( &$site, $attribute )
    {
      if ( ! isset( $site->sitemeta->{$attribute} ) ) {
        $site->sitemeta->{$attribute} = \WpMvc\SiteMeta::virgin();
        $site->sitemeta->{$attribute}->site_id = $site->id;
        $site->sitemeta->{$attribute}->meta_key = "$attribute";
        $site->sitemeta->{$attribute}->meta_value = "";
        $site->sitemeta->{$attribute}->save();
      }
    }
  }
}
