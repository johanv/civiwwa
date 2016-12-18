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
  protected $debug = 1;

  public function __construct($arguments) {
    parent::__construct($arguments);
    $this->description = t('Import contacts');

    $columns = [
      ['last_name', t('Last Name')],
      ['first_name', t('First Name')],
      ['street_address', t('Street Address')],
      ['postal_code', t('Postal Code')],
      ['preferred_language', t('Preferred Language')],
      ['city', t('City')],
      ['phone', t('Phone')],
      ['email', t('Email')],
      ['birth_date', t('Birth Date')],
      ['club', t('Club')],
    ];

    $this->source = new MigrateSourceCSV(
      DRUPAL_ROOT . '/' . drupal_get_path('module', 'civiwwa_migrate') . '/data_sources/iedereen.csv',
      $columns);

    $this->map = new MigrateSQLMap($this->machineName, [
      'last_name' => [ 'type' => 'varchar', 'length' => 255, 'not null' => FALSE ],
      'first_name' => [ 'type' => 'varchar', 'length' => 255, 'not null' => FALSE ],
    ], MigrateDestinationCivicrmApi::getKeySchema());

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
    if ($row->preferred_language == 'F') {
      $row->preferred_language = 'fr_FR';
    }
    else {
      $row->preferred_language = 'nl_NL';
    }
    if (!empty($row->birth_date)) {
      $row->birth_date = date('Y-m-d', strtotime($row->birth_date));
    }
  }

  public function complete($entity, stdClass $row) {
    if (!empty($row->city)) {
      return;
    }
    civicrm_api3('Address', 'create', [
      'contact_id' => $entity['contact_id'],
      'street_address' => $row->street_address,
      'postal_code' => $row->postal_code,
      'city' => $row->city,
    ]);
  }
}
