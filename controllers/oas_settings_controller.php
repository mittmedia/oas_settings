<?php

namespace OasSettings
{
  class OasSettingsController extends \WpMvc\BaseController
  {
    public function index()
    {
      global $site;

      $site = \WpMvc\Site::find( 1 );

      if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
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
