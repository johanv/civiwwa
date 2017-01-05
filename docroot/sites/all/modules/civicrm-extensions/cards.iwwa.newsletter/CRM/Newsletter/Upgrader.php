<?php
/*
  civiwwa_newsletter - Sets up the CiviCRM newsletter.
  Copyright (C) 2017  Johan Vervloet

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
 * Collection of upgrade steps.
 */
class CRM_Newsletter_Upgrader extends CRM_Newsletter_Upgrader_Base {
  /**
   * Install the extension
   *
   * @return bool
   */
  public function install() {
    $result = civicrm_api3('Job', 'get', array(
      'api_entity' => 'Mailchimp',
      'api_action' => 'pushsync',
      'api.Job.create' => array(
        'id' => '$value.id',
        'is_active' => 1,
      ),
    ));
    return !$result['is_error'] && $result['count'] == 1;
  }

  /**
   * Enable the extension.
   *
   * @return bool
   */
  public function enable() {
    $configResult = civicrm_api3('Civiconfig', 'load_json', [
      // there should be a better way to do this.
      'path' => realpath(__DIR__ . '/../../') . '/resources/'
    ]);

    $result = civicrm_api3('Group', 'create', [
      'id' => CRM_Newsletter_Groups::NEWSLETTER(),
      CRM_Newsletter_Fields::MC_LIST_ID() => CRM_Core_BAO_Setting::getItem('iwwa_newsletter', 'list_id'),
      'is_active' => TRUE,
    ]);
    return (!$configResult['is_error'] && !$result['is_error']);
  }

  public function disable() {
    $result = civicrm_api3('Group', 'create', [
      'id' => CRM_Newsletter_Groups::NEWSLETTER(),
      CRM_Newsletter_Fields::MC_LIST_ID() => NULL,
      'is_active' => FALSE,
    ]);
    return (!$result['is_error']);
  }
}
