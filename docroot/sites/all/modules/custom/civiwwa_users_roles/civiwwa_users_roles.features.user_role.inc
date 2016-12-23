<?php
/**
 * @file
 * civiwwa_users_roles.features.user_role.inc
 */

/**
 * Implements hook_user_default_roles().
 */
function civiwwa_users_roles_user_default_roles() {
  $roles = array();

  // Exported role: CivIWWA power user.
  $roles['CivIWWA power user'] = array(
    'name' => 'CivIWWA power user',
    'weight' => 2,
  );

  return $roles;
}