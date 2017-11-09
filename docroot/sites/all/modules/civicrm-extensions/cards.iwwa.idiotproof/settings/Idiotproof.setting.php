<?php

//    This file is part of cards.iwwa.idiotproof.
//    
//    cards.iwwa.idiotproof tries to add some easy shortcuts to CiviCRM.
//    Copyright (C) 2017 Johan Vervloet <johanv@johanv.org>
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU Affero General Public License as
//    published by the Free Software Foundation, either version 3 of the
//    License, or (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU Affero General Public License for more details.
//
//    You should have received a copy of the GNU Affero General Public License
//    along with this program.  If not, see <https://www.gnu.org/licenses/>.

/*
 * Settings metadata file
 */
return array(
  'idiotproof_general_members_group_name' => array(
    'group_name' => 'Idiotproof Preferences',
    'group' => 'idiotproof',
    'name' => 'idiotproof_general_members_group_name',
    // TODO: Can't I have a drop down with available groups?
    'type' => 'String',
    'default' => '',
    'add' => '4.7',
    'is_domain' => 0,
    'is_contact' => 0,
    'description' => 'Name of CiviCRM group that defines the "general members"',
    'title' => 'General members group',
    'help_text' => 'Name of a CiviCRM group. The idiotproof extension provides general functionality like "show me all the members"; Contacts in the CiviCRM group with this name are considered to be "the members".',
    'html_type' => 'Text',
    'quick_form_type' => 'Element',
  )
);
