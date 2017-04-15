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

class membershipsMigration extends Civimigration {
  protected $entity = 'relationship';

  public function __construct($arguments) {
    parent::__construct($arguments);
    $this->description = t('Import membership relations');

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
      ['event_id', t('Event ID')],
    ];

    $this->source = new MigrateSourceCSV(
      DRUPAL_ROOT . '/' . drupal_get_path('module', 'civiwwa_migrate') . '/data_sources/import.csv',
      $columns);

    // Mapping source and destination.
    $this->map = new MigrateSQLMap($this->machineName,
      // Source keys
      [
        'last_name' => [ 'type' => 'varchar', 'length' => 255, 'not null' => FALSE ],
        'first_name' => [ 'type' => 'varchar', 'length' => 255, 'not null' => FALSE ],
        'club' => [ 'type' => 'varchar', 'length' => 255, 'not null' => FALSE ],
      ]
      // Corresponding destination keys
      , MigrateDestinationCivicrmApi::getKeySchema()
    );

    $this->addFieldMapping('contact_id_a', 'constructed_key')->sourceMigration('people');
    $this->addFieldMapping('contact_id_b', 'club')->sourceMigration('clubs');
    // I think I cannot use IdCache here.
    $this->addFieldMapping('relationship_type_id')->defaultValue(11);
    $this->addFieldMapping('is_active')->defaultValue(TRUE);
  }

  public function prepareRow($row) {
    if (parent::prepareRow($row) === FALSE) {
      return FALSE;
    }
    $row->constructed_key = [[$row->last_name, $row->first_name]];
    return TRUE;
  }
}