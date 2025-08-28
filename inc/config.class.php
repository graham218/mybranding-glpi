<?php
class PluginMybrandingConfig extends CommonDBTM {
   static function getTypeName($nb = 0) {
      return __('My Branding Configuration', 'mybranding');
   }

   function getTabNameForItem(CommonGLPI $item, $withtemplate = 0) {
      if ($item->getType() == 'Config') {
         return self::getTypeName();
      }
      return '';
   }

   static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0) {
      if ($item->getType() == 'Config') {
         self::showConfigForm();
      }
      return true;
   }

   static function showConfigForm() {
      global $CFG_GLPI;

      $config = new self();
      $config->getFromDB(1);
      if (!$config->fields) {
         $config->fields = [
            'id' => 1,
            'enable_branding' => 1,
            'sidebar_color' => '#1a73e8'
         ];
      }

      echo "<form method='post' action='" . Toolbox::getItemTypeFormURL(__CLASS__) . "'>";
      echo "<table class='tab_cadre_fixe'>";
      echo "<tr><th colspan='2'>" . __('My Branding Settings', 'mybranding') . "</th></tr>";
      echo "<tr><td>" . __('Enable Branding', 'mybranding') . "</td><td>";
      Html::showCheckbox([
         'name' => 'enable_branding',
         'checked' => $config->fields['enable_branding']
      ]);
      echo "</td></tr>";
      echo "<tr><td>" . __('Sidebar Color', 'mybranding') . "</td><td>";
      Html::showColorField('sidebar_color', ['value' => $config->fields['sidebar_color']]);
      echo "</td></tr>";
      echo "<tr><td colspan='2'>";
      echo Html::submit(__('Save'), ['name' => 'update']);
      echo "</td></tr>";
      echo "</table>";
      Html::closeForm();

      PluginMybrandingLogger::log('Configuration form displayed');
   }

   function update($input) {
      $this->check($input['id'], UPDATE);
      PluginMybrandingLogger::log('Configuration updated: ' . json_encode($input));
      return parent::update($input);
   }
}