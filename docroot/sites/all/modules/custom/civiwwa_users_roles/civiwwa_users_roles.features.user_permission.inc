<?php
/**
 * @file
 * civiwwa_users_roles.features.user_permission.inc
 */

/**
 * Implements hook_user_default_permissions().
 */
function civiwwa_users_roles_user_default_permissions() {
  $permissions = array();

  // Exported permission: 'access CiviCRM'.
  $permissions['access CiviCRM'] = array(
    'name' => 'access CiviCRM',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'access CiviContribute'.
  $permissions['access CiviContribute'] = array(
    'name' => 'access CiviContribute',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'access CiviEvent'.
  $permissions['access CiviEvent'] = array(
    'name' => 'access CiviEvent',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'access CiviMember'.
  $permissions['access CiviMember'] = array(
    'name' => 'access CiviMember',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'access Contact Dashboard'.
  $permissions['access Contact Dashboard'] = array(
    'name' => 'access Contact Dashboard',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'access all custom data'.
  $permissions['access all custom data'] = array(
    'name' => 'access all custom data',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'access contact reference fields'.
  $permissions['access contact reference fields'] = array(
    'name' => 'access contact reference fields',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'access content'.
  $permissions['access content'] = array(
    'name' => 'access content',
    'roles' => array(
      'anonymous user' => 'anonymous user',
      'authenticated user' => 'authenticated user',
    ),
    'module' => 'node',
  );

  // Exported permission: 'access content overview'.
  $permissions['access content overview'] = array(
    'name' => 'access content overview',
    'roles' => array(),
    'module' => 'node',
  );

  // Exported permission: 'access uploaded files'.
  $permissions['access uploaded files'] = array(
    'name' => 'access uploaded files',
    'roles' => array(),
    'module' => 'civicrm',
  );

  // Exported permission: 'add contacts'.
  $permissions['add contacts'] = array(
    'name' => 'add contacts',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'administer Tagsets'.
  $permissions['administer Tagsets'] = array(
    'name' => 'administer Tagsets',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'administer nodes'.
  $permissions['administer nodes'] = array(
    'name' => 'administer nodes',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'node',
  );

  // Exported permission: 'administer themes'.
  $permissions['administer themes'] = array(
    'name' => 'administer themes',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'system',
  );

  // Exported permission: 'delete activities'.
  $permissions['delete activities'] = array(
    'name' => 'delete activities',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'delete contacts'.
  $permissions['delete contacts'] = array(
    'name' => 'delete contacts',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'delete in CiviContribute'.
  $permissions['delete in CiviContribute'] = array(
    'name' => 'delete in CiviContribute',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'delete in CiviEvent'.
  $permissions['delete in CiviEvent'] = array(
    'name' => 'delete in CiviEvent',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'delete in CiviMember'.
  $permissions['delete in CiviMember'] = array(
    'name' => 'delete in CiviMember',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'edit all contacts'.
  $permissions['edit all contacts'] = array(
    'name' => 'edit all contacts',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'edit all events'.
  $permissions['edit all events'] = array(
    'name' => 'edit all events',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'edit contributions'.
  $permissions['edit contributions'] = array(
    'name' => 'edit contributions',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'edit event participants'.
  $permissions['edit event participants'] = array(
    'name' => 'edit event participants',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'edit groups'.
  $permissions['edit groups'] = array(
    'name' => 'edit groups',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'edit memberships'.
  $permissions['edit memberships'] = array(
    'name' => 'edit memberships',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'edit message templates'.
  $permissions['edit message templates'] = array(
    'name' => 'edit message templates',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'edit my contact'.
  $permissions['edit my contact'] = array(
    'name' => 'edit my contact',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'import contacts'.
  $permissions['import contacts'] = array(
    'name' => 'import contacts',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'make online contributions'.
  $permissions['make online contributions'] = array(
    'name' => 'make online contributions',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'manage event profiles'.
  $permissions['manage event profiles'] = array(
    'name' => 'manage event profiles',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'manage tags'.
  $permissions['manage tags'] = array(
    'name' => 'manage tags',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'merge duplicate contacts'.
  $permissions['merge duplicate contacts'] = array(
    'name' => 'merge duplicate contacts',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'profile create'.
  $permissions['profile create'] = array(
    'name' => 'profile create',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'profile edit'.
  $permissions['profile edit'] = array(
    'name' => 'profile edit',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'profile listings'.
  $permissions['profile listings'] = array(
    'name' => 'profile listings',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'profile listings and forms'.
  $permissions['profile listings and forms'] = array(
    'name' => 'profile listings and forms',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'profile view'.
  $permissions['profile view'] = array(
    'name' => 'profile view',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'register for events'.
  $permissions['register for events'] = array(
    'name' => 'register for events',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'view all activities'.
  $permissions['view all activities'] = array(
    'name' => 'view all activities',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'view all contacts'.
  $permissions['view all contacts'] = array(
    'name' => 'view all contacts',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'view all notes'.
  $permissions['view all notes'] = array(
    'name' => 'view all notes',
    'roles' => array(),
    'module' => 'civicrm',
  );

  // Exported permission: 'view event info'.
  $permissions['view event info'] = array(
    'name' => 'view event info',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'view event participants'.
  $permissions['view event participants'] = array(
    'name' => 'view event participants',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'view my contact'.
  $permissions['view my contact'] = array(
    'name' => 'view my contact',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'view my invoices'.
  $permissions['view my invoices'] = array(
    'name' => 'view my invoices',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'civicrm',
  );

  // Exported permission: 'view own unpublished content'.
  $permissions['view own unpublished content'] = array(
    'name' => 'view own unpublished content',
    'roles' => array(
      'CivIWWA power user' => 'CivIWWA power user',
    ),
    'module' => 'node',
  );

  return $permissions;
}
