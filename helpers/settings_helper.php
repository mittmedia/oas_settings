<?php

namespace OasSettings
{
  class SettingsHelper
  {
    public static function activation_option_to_text( $code )
    {
      switch ( $code ) {
        case 'true':
          return 'Ja';
        case 'false':
          return 'Nej';
      }
    }

    public static function activation_option_to_code( $text )
    {
      switch ( $code ) {
        case 'Ja':
          return 'true';
        case 'Nej':
          return 'false';
      }
    }
  }
}