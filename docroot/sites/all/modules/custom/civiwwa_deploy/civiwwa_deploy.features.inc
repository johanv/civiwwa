<?php
/**
 * @file
 * civiwwa_deploy.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function civiwwa_deploy_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
}
