<?php
/*
  cards.iwwa.iwwamembership CivIWWA membership configuration.
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
 * IwwaMembership.Createbasicmemberships API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_iwwa_membership_Createbasicmemberships_spec(&$spec) {
}

/**
 * IwwaMembership.Createbasicmemberships API
 *
 * Create basic memberships for every participant. Ever.
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_iwwa_membership_Createbasicmemberships($params) {
  // Freddy decided that the start date of the 'basic' membership is the
  // date of the first event the contact attended.
  $sql = "SELECT c.id, MIN(e.start_date) AS start_date, MAX(m.id) AS membership_id
    FROM civicrm_contact c 
    JOIN civicrm_participant p ON c.id = p.contact_id
    JOIN civicrm_event e ON e.id = p.event_id AND e.start_date < now()
    LEFT OUTER JOIN civicrm_membership m ON c.id = m.contact_id AND m.membership_type_id = %1
    WHERE c.is_deleted = 0
    GROUP BY c.id
    HAVING membership_id IS NULL
    ";
  $params = [1 => [CRM_IwwaMembership_Type::BASIC_MEMBER(), 'Integer']];
  $dao = CRM_Core_DAO::executeQuery($sql, $params);
  $count = 0;
  while ($dao->fetch()) {
    civicrm_api3('Membership', 'create', [
      'contact_id' => $dao->id,
      'membership_type_id' => CRM_IwwaMembership_Type::BASIC_MEMBER(),
      'start_date' => $dao->start_date,
      'join_date' => $dao->start_date,
    ]);
    ++$count;
  }
  return civicrm_api3_create_success($count, $params, 'NewEntity', 'NewAction');
}

