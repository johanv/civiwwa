<?php
/*
  civiwwa_newsletter - Sets up the CiviCRM newsletter.
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
 * ID's of groups.
 */
class CRM_Newsletter_Groups {
  public static function NEWSLETTER() {
    return CRM_IdCache_Cache_Generic::getId('Group', 'newsletter');
  }
}