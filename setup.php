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

function plugin_mybranding_install() {
   global $DB;

   // Create configuration table if it doesn't exist
   $table = 'glpi_plugin_mybranding_configs';
   if (!$DB->tableExists($table)) {
      $query = "CREATE TABLE `$table` (
         `id` INT NOT NULL AUTO_INCREMENT,
         `enable_branding` TINYINT NOT NULL DEFAULT '1',
         `sidebar_color` VARCHAR(7) NOT NULL DEFAULT '#1a73e8',
         PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
      
      if (!$DB->query($query)) {
         PluginMybrandingLogger::log('Failed to create table: ' . $DB->error());
         return false;
      }

      // Insert default configuration
      $query = "INSERT INTO `$table` (`id`, `enable_branding`, `sidebar_color`)
                VALUES (1, 1, '#1a73e8')";
      if (!$DB->query($query)) {
         PluginMybrandingLogger::log('Failed to insert default config: ' . $DB->error());
         return false;
      }
   }

   PluginMybrandingLogger::log('Plugin MyBranding installed successfully');
   return true;
}

function plugin_mybranding_uninstall() {
   global $DB;

   // Drop configuration table
   $table = 'glpi_plugin_mybranding_configs';
   if ($DB->tableExists($table)) {
      $query = "DROP TABLE `$table`";
      if (!$DB->query($query)) {
         PluginMybrandingLogger::log('Failed to drop table: ' . $DB->error());
         return false;
      }
   }

   PluginMybrandingLogger::log('Plugin MyBranding uninstalled successfully');
   return true;
}