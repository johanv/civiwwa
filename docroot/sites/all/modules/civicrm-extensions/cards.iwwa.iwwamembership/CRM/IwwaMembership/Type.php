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
 * Class CRM_IwwaMembership_Type
 */
class CRM_IwwaMembership_Type {
  public static function BASIC_MEMBER() {
    // The original membership type 'basic member' is disabled. The membership
    // with name 'lid' replaces it.
    return CRM_IdCache_Cache_Generic::getId('MembershipType', 'lid');
  }
}