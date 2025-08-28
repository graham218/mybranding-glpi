<?php
class PluginMybrandingLogger {
   static function log($message) {
      global $CFG_GLPI;
      $log_file = GLPI_LOG_DIR . '/mybranding.log';
      $timestamp = date('Y-m-d H:i:s');
      file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND);
   }
}