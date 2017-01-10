<?php
/*
  apiaccess - CivIWWA api access.
  Copyright (C) 2016  Johan Vervloet

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU Affero General Public License as
  published by the Free Software Foundation, either version 3 of the
  License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Affero General Public License for more details.

  You should have received a copy of the GNU Affero General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


/**
 * ApiAccess.Reconfigure API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_api_access_Reconfigure_spec(&$spec) {
}

/**
 * ApiAccess.Reconfigure API
 *
 * This applies CiviCRM API keys given in the civiwwa_users drupal variable
 * to the appropriate users.
 *
 * This is useful if you have different environments (dev, staging, live)
 * with different keys.
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_api_access_Reconfigure($params) {
  $values = [];
  $isError = FALSE;
  foreach (variable_get('civiwwa_users') as $user) {
    if (!empty($user['api_key'])) {
      $existing = user_load_by_name($user['name']);
      $apiResult = civicrm_api3(
        'UFMatch', 'getsingle', [
          'uf_id' => $existing->uid,
          'api.Contact.getsingle' => [
            'id' => '$value.contact_id',
            'api.Contact.create' => [
              'id' => '$value.id',
              'api_key' => $user['api_key'],
            ],
          ],
      ]);
      $values[] = $apiResult;
      $isError |= $apiResult['is_error'];
    }
  }
  if (!$isError) {
    return civicrm_api3_create_success($values, $params, 'ApiAccess', 'reconfigure');
  }
  else {
    return civicrm_api3_create_error('Error assigning API keys', $values);
  }
}

