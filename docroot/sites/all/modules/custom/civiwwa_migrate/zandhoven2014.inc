<?php
/*
  civiwwa_migrate - Migrations for CivIWWA.
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

class zandhoven2014Migration extends CiviMigration {
  protected $entity = 'participant';
  protected $debug = 1;

  public function __construct($arguments) {
    parent::__construct($arguments);
    $this->description = t('Import participants Zandhoven 2014');

    $columns = [
      // I suspect this to be a duplicate from 'preferred language'.
      ['n', t('n')],
      ['last_name', t('Last Name')],
      ['first_name', t('First Name')],
      ['street_address', t('Street Address')],
      ['postal_code', t('Postal Code')],
      ['city', t('City')],
      ['preferred_language', t('Preferred Language')],
      ['full_name', t('Full Name')],
    ];

    $this->source = new MigrateSourceCSV(
      DRUPAL_ROOT . '/' . drupal_get_path('module', 'civiwwa_migrate') . '/data_sources/zandhoven2014.csv',
      $columns);

    // Mapping source and destination.
    $this->map = new MigrateSQLMap($this->machineName,
      // Source keys (unique identification of participant)
      [
        'last_name' => [ 'type' => 'varchar', 'length' => 255, 'not null' => FALSE ],
        'first_name' => [ 'type' => 'varchar', 'length' => 255, 'not null' => FALSE ],
      ]
      // Corresponding destination keys
      , MigrateDestinationCivicrmApi::getKeySchema()
    );

    $this->addFieldMapping('contact_id', 'constructed_key')->sourceMigration('people');
    $this->addFieldMapping('event_id')->defaultValue('2');
    // Deelgenomen
    $this->addFieldMapping('participant_status_id')->defaultValue('2');
    // Deelnemer
    $this->addFieldMapping('participant_role_id')->defaultValue('1');
  }

  public function prepareRow($row) {
    if (parent::prepareRow($row) === FALSE) {
      return FALSE;
    }
    // Some participants have first name and last name in the name field.
    // Workaround.
    if (empty($row->first_name)) {
      $words = explode(' ', $row->last_name);
      $row->first_name = $words[0];
      array_shift($words);
      $row->last_name = implode(' ', $words);
    }
    $row->constructed_key = [[$row->last_name, $row->first_name]];
    return TRUE;
  }
}