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
 * Custom field ID cache class.
 */
class CRM_IdCache_Cache_CustomField extends CRM_IdCache_Cache {
  /**
   * Returns the ID of a CiviCRM custom field.
   *
   * @param string $customGroupName Name of the custom field set
   * @param string $name Name of the custom field
   * @return int
   */
   public static function getFieldId($customGroupName, $name) {
    return self::getId('CustomField', $name, $customGroupName);
  }

  /**
   * Returns the 'API name' of a CiviCRM custom field.
   *
   * @param string $customGroupName Name of the custom field set
   * @param string $name Name of the custom field
   * @return string
   */
  public static function getApiField($customGroupName, $name) {
    return "custom_" . self::getFieldId($customGroupName, $name);
  }

  /**
   * @return array of entity type names that this class supports.
   */
  public static function acceptedEntityTypes()
  {
    return ['CustomField'];
  }

  /**
   * Returns API params for the entity defined by $entityType, $name and $extra.
   *
   * @param string $name name of the CiviCRM entity
   * @param string $extra name of the custom field set
   * @return array
   */
  protected static function getApiParams($name, $extra)
  {
    return [
      'name' => $name,
      'custom_group_id' => $extra,
    ];
  }
}
