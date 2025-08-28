<?php
define('PLUGIN_MYBRANDING_VERSION', '1.0.0');
define('PLUGIN_MYBRANDING_MIN_GLPI', '10.0.0');
define('PLUGIN_MYBRANDING_MAX_GLPI', '11.0.0');

function plugin_init_mybranding() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['mybranding'] = true;

   // Add custom CSS
   $PLUGIN_HOOKS['add_css']['mybranding'] = 'css/mybranding.css';

   // Add custom favicon
   $PLUGIN_HOOKS['add_favicon']['mybranding'] = 'front/favicon.php';

   // Customize footer
   $PLUGIN_HOOKS['footer']['mybranding'] = ['PluginMybrandingCustomfooter', 'showFooter'];

   // Add configuration menu for admins
   if (Session::haveRight('config', UPDATE)) {
      $PLUGIN_HOOKS['config_page']['mybranding'] = 'front/config.form.php';
      $PLUGIN_HOOKS['menu_toadd']['mybranding'] = [
         'config' => 'PluginMybrandingConfig'
      ];
   }

   // Log plugin initialization
   PluginMybrandingLogger::log('Plugin MyBranding initialized');
}

function plugin_version_mybranding() {
   return [
      'name'           => __('My Branding', 'mybranding'),
      'version'        => PLUGIN_MYBRANDING_VERSION,
      'author'         => 'Your Company Name',
      'license'        => 'GPLv2+',
      'homepage'       => 'https://yourwebsite.com',
      'requirements'   => [
         'glpi' => [
            'min' => PLUGIN_MYBRANDING_MIN_GLPI,
            'max' => PLUGIN_MYBRANDING_MAX_GLPI
         ]
      ]
   ];
}

function plugin_check_prerequisites() {
   if (version_compare(GLPI_VERSION, PLUGIN_MYBRANDING_MIN_GLPI, '<')) {
      echo "This plugin requires GLPI >= " . PLUGIN_MYBRANDING_MIN_GLPI;
      return false;
   }
   return true;
}

function plugin_check_config() {
   return true;
}