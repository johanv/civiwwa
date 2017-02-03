<?php
/**
 * @file
 * civiwwa_dev.features.user_permission.inc
 */

/**
 * Implements hook_user_default_permissions().
 */
function civiwwa_dev_user_default_permissions() {
  $permissions = array();

  // Exported permission: 'access environment indicator'.
  $permissions['access environment indicator'] = array(
    'name' => 'access environment indicator',
    'roles' => array(
      'anonymous user' => 'anonymous user',
      'authenticated user' => 'authenticated user',
    ),
    'module' => 'environment_indicator',
  );

  return $permissions;
}
