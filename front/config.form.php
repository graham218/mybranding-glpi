<?php
include('../../../inc/includes.php');

Session::checkRight('config', UPDATE);

if (!empty($_POST['update'])) {
   $config = new PluginMybrandingConfig();
   $config->update($_POST);
   Html::back();
}

Html::redirect($CFG_GLPI['root_doc'] . '/front/config.form.php?forcetab=PluginMybrandingConfig$1');