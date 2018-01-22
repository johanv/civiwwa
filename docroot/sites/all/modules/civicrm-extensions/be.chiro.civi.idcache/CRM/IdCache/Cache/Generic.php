<?php
/*
  be.chiro.civi.idcache - cache for ID's of custom CiviCRM entities.
  Copyright (C) 2016  Chirojeugd-Vlaanderen vzw

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
 * Generic ID cache class.
 *
 * This will work for entities that can be identified by their names.
 */
class CRM_IdCache_Cache_Generic extends CRM_IdCache_Cache {

  /**
   * @return array of entity type names that this class supports.
   */
  public static function acceptedEntityTypes() {
    return [
      'CaseType',
      'ContactType',
      'CustomGroup',
      'CustomSearch',
      'FinancialAccount',
      'FinancialType',
      'Group',
      'LocationType',
      'MembershipType',
      'OptionGroup',
      'ParticipantStatusType',
      'Tag',
    ];
  }

  /**
   * Returns API params for the entity defined by $entityType, $name and $extra.
   *
   * @param string $name name of the CiviCRM entity
   * @param string $extra (optional) extra information to determine entity
   * @return array
   */
  protected static function getApiParams($name, $extra)
  {
    return ['name' => $name];
  }
}
