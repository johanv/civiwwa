<?php
/*
  be.chiro.civi.idcache - cache for ID's of custom CiviCRM entities.
  Copyright (C) 2017  Chirojeugd-Vlaanderen vzw

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
 * Option value ID cache class.
 */
class CRM_IdCache_Cache_CustomSearch extends CRM_IdCache_Cache_OptionValue {
 /**
   * @return array of entity type names that this class supports.
   */
  public static function acceptedEntityTypes() {
    return ['OptionValue'];
  }

  /**
   * Returns the *value* (not the ID) of a CiviCRM option value.
   *
   * This is very similar to Cache::getId.
   *
   * @param $name name of the option value
   * @return string
   */
  public static function getSearchId($name) {
    // Use a custom cache key, because the 'ordinary' cache key might be
    // used to cache the ID, and not the value.
    $cacheKey = self::getCacheKey('CustomSearch', $name, null) . '_value';
    $result = Civi::cache()->get($cacheKey);
    if (empty($result)) {
      $params = static::getApiParams($name);
      // If the entity is not found, the line below will throw an exception.
      $entity = civicrm_api3('OptionValue', 'getsingle', $params);
      $result = $entity['value'];
      Civi::cache()->set($cacheKey, $result);
    }
    return $result;
  }

  /**
   * Returns API params for retrieving an option value.
   *
   * @param $name Name of the option value.
   * @param $extra unused
   * @return array
   * @throws \Exception
   */
  protected static function getApiParams($name, $extra = NULL) {
    return [
      'name' => $name,
      'option_group_id' => 'custom_search',
    ];
  }
}
