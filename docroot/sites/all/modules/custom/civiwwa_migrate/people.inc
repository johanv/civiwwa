<?php
/*
  civiwwa_migrate - Migrations for CivIWWA.
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

class peopleMigration extends Civimigration {
  protected $entity = 'contact';

  public function __construct($arguments) {
    parent::__construct($arguments);
    $this->description = t('Import contacts');

    $columns = [
      ['row_number', t('Row Number')],
      ['registration_date', t('Registration Date')],
      ['last_name', t('Last Name')],
      ['first_name', t('First Name')],
      ['email', t('Email')],
      ['state_province', t('State/Province')],
      ['postal_code', t('Postal Code')],
      ['city', t('City')],
      ['country', t('Country')],
      ['birth_date', t('Birth Date')],
      ['gender', t('Gender')],
      ['color', t('Color')],
      ['club', t('Club')],
    ];

    // I'm not sure what will happen if we re-use the same migration on a
    // different Excel file. Fingers crossed.
    $this->source = new MigrateSourceCSV(
      DRUPAL_ROOT . '/' . drupal_get_path('module', 'civiwwa_migrate') . '/data_sources/import.csv',
      $columns);

    // Mapping source and destination.
    $this->map = new MigrateSQLMap($this->machineName,
      // Source keys
      [
        'last_name' => [ 'type' => 'varchar', 'length' => 255, 'not null' => FALSE ],
        'first_name' => [ 'type' => 'varchar', 'length' => 255, 'not null' => FALSE ],
      ]
      // Corresponding destination keys
      , MigrateDestinationCivicrmApi::getKeySchema()
    );

    $this->addFieldMapping('first_name', 'first_name');
    $this->addFieldMapping('last_name', 'last_name');
    $this->addFieldMapping('preferred_language', 'preferred_language');

    // Migrating the address like this does not seem to work:
    // $this->addFieldMapping('street_address', 'street_address');
    // $this->addFieldMapping('postal_code', 'postal_code');
    // $this->addFieldMapping('city', 'city');
    $this->addFieldMapping('phone', 'phone');
    $this->addFieldMapping('email', 'email');
    $this->addFieldMapping('birth_date', 'birth_date');
    $this->addFieldMapping('contact_type')->defaultValue('Individual');
    $this->addFieldMapping('country')->defaultValue('BE');
  }

  public function prepareRow($row) {
    if (!parent::prepareRow($row)) {
      return FALSE;
    }
    if ($row->first_name == 'Voornaam') {
      // Let's assume this is the header row.
      return FALSE;
    }
    if ($row->preferred_language == 'F') {
      $row->preferred_language = 'fr_FR';
    }
    else {
      $row->preferred_language = 'nl_NL';
    }
    if (!empty($row->birth_date)) {
      $row->birth_date = date('Y-m-d', strtotime($row->birth_date));
    }
    return TRUE;
  }

  public function complete($entity, stdClass $row) {
    // Initially everybody is subscribed to the newsletter.
    $result = civicrm_api3('GroupContact', 'create', [
      'contact_id' => $entity['id'],
      'group_id' => CRM_Newsletter_Groups::NEWSLETTER(),
      'status' => 'Added',
    ]);

    if (empty($row->postal_code)) {
      return;
    }

    // Delete existing address first.
    civicrm_api3('Address', 'get', [
      'contact_id' => $entity['id'],
      'api.Address.delete' => ['id' => '$value.id'],
    ]);
    civicrm_api3('Address', 'create', [
      'contact_id' => $entity['id'],
      'street_address' => $row->street_address,
      'postal_code' => $row->postal_code,
      'state_province_id' => CRM_Belgium_Logic::guessProvince($row->postal_code),
      'city' => $row->city,
      'location_type_id' => 1,
    ]);
  }
}
