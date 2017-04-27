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

return array (
  0 =>
    array (
      'name' => 'Create memberships for participants',
      'entity' => 'Job',
      'params' =>
        array (
          'version' => 3,
          'name' => 'Create memberships for participants',
          'description' => "Create memberships for participants that don't have
            a membership yet. The membership starts at the earliest event
            registration.",
          'api_entity' => 'IwwaMembership',
          'api_action' => 'Createbasicmemberships',
          'run_frequency' => 'Daily',
          'is_active' => 1,
        ),
    ),
);
