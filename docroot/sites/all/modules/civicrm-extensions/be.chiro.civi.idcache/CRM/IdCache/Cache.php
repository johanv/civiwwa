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
 * Abstract ID cache class.
 */
abstract class CRM_IdCache_Cache {
  /**
   * @return array of entity type names that this class supports.
   */
  public abstract static function acceptedEntityTypes();

  /**
   * Returns the ID of a CiviCRM entity.
   *
   * @param string $entityType name of the CiviCRM entity type
   * @param string $name name of the CiviCRM entity
   * @param string $extra (optional) extra information to determine entity
   * @throws Exception
   * @return int
   */
  public static function getId($entityType, $name, $extra = NULL) {
    if (!in_array($entityType, static::acceptedEntityTypes())) {
      throw new Exception("Entity type ${entityType} not supported by this cache.");
    }
    $cacheKey = self::getCacheKey($entityType, $name, $extra);
    $result = Civi::cache()->get($cacheKey);
    if (empty($result)) {
      $params = static::getApiParams($name, $extra);
      // This will throw an exception if the entity is not found.
      $entity = civicrm_api3($entityType, 'getsingle', $params);
      $result = $entity['id'];
      Civi::cache()->set($cacheKey, $result);
    }
    return $result;
  }

  /**
   * Determines the cache key for a CiviCRM entity ID.
   *
   * @param string $entityType name of the CiviCRM entity type
   * @param string $name name of the CiviCRM entity
   * @param string $extra (optional) extra information to determine entity
   * @return string the cache key
   */
  protected static function getCacheKey($entityType, $name, $extra) {
    $cacheKey = "CiviConfig_${entityType}_${name}";
    if (!empty($extra)) {
      $cacheKey .= "_${extra}";
    }
    return $cacheKey;
  }

  /**
   * Returns API params for the entity defined by $entityType, $name and $extra.
   *
   * @param string $name name of the CiviCRM entity
   * @param string $extra (optional) extra information to determine entity
   * @return array
   */
  protected static abstract function getApiParams($name, $extra);
}