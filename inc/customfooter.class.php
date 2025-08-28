<?php
class PluginMybrandingCustomfooter extends CommonGLPI {
   static function getTypeName($nb = 0) {
      return __('Custom Footer', 'mybranding');
   }

   static function showFooter() {
      echo "<footer style='text-align: center; padding: 10px; background: #f8f9fa;'>
               &copy; " . date('Y') . " Your Company Name. All rights reserved.
            </footer>";
      PluginMybrandingLogger::log('Custom footer displayed');
   }
}