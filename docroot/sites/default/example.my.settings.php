<?php

// Enter details here for users you want to create. Create arbitrary
// passwords. Your users will be able to log on with facebook.

$conf['civiwwa_users'] = [
  'a_user_name' => [
    'name' => 'a_user_name',
    'mail' => 'users_email_address',
    'pass' => 'some_random_password',
    'status' => 1,
    'init' => 'users_email_address',
    'roles' => [3 => 'CivIWWA power user'],
  ],
  'another_user_name' => [
    'name' => 'another_user_name',
    'mail' => 'this_users_email_address',
    'pass' => 'another_random_password',
    'status' => 1,
    'init' => 'this_users_email_address',
    'roles' => [3 => 'CivIWWA power user'],
  ],
  'websiteapi' => [
    'name' => 'websiteapi',
    'mail' => 'some_email_address',
    'pass' => 'yet_another_random_password',
    'status' => 1,
    'init' => 'some_email_address',
    'roles' => [4 => 'Website API user'],
    'api_key' => 'the_civcrm_api_key_for_the_api_user',
  ],
];

$conf['fboauth_apiversion'] = 'v2.5';
$conf['fboauth_id'] = 'ID_FOR_YOUR_FACEBOOK_APP';
$conf['fboauth_secret'] = 'SECRET_FOR_YOUR_FACEBOOK_APP';
