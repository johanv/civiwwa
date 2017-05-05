<?php
/*
    cards.iwwa.tournament - IWWA Tournaments extension.
    Based on VervolgCursusSearch,
    Copyright (C) 2015, 2016  Chirojeugd-Vlaanderen vzw
    Modifications for IWWA Copyright (C) 2017  Johan Vervloet

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
 * A custom contact search
 *
 * TODO: Cleanup ugly copied code from old search.
 */
class CRM_Tournament_Form_Search_EventsInclExclSearch extends CRM_Contact_Form_Search_Custom_Base implements CRM_Contact_Form_Search_Interface {
  private $_events;

  function __construct(&$formValues) {
    parent::__construct($formValues);

    $this->_events = civicrm_api3('Event', 'get', array(
      'is_template' => 0,
      'options' => array('limit' => 0, 'sort' => "start_date DESC"),
      'return' => array("id", "title"),
    ));
  }

  /**
   * Prepare a set of search fields
   *
   * @param CRM_Core_Form $form modifiable
   * @return void
   */
  function buildForm(&$form) {
    CRM_Utils_System::setTitle(ts('Deelnemers wel/niet op tournooi'));

    $form->addRadio('aanw_op', ts('Aanwezig op '), array(
      'AND' => 'al deze ',
      'OR' => 'sommige van deze ',
    ));

    $eventOptions = [];

    foreach ($this->_events['values'] as $option) {
      $eventOptions[$option['id']] = $option['title'];
    }

    $form->add('select', 'cursus_wel', ts('Events'), $eventOptions, FALSE, array('class' => 'crm-select2 huge', 'multiple' => TRUE));
    $form->add('select', 'cursus_niet', ts('Aanwezig op geen van '), $eventOptions, FALSE, array('class' => 'crm-select2 huge', 'multiple' => TRUE));

    // Optionally define default search values
    $form->setDefaults(array(
      'aanw_op' => 'OR',
    ));

    /**
     * if you are using the standard template, this array tells the template what elements
     * are part of the search criteria
     */
    $form->assign('elements', array(
      'aanw_op',
      'cursus_wel',
      'cursus_niet',
    ));
  }

  /**
   * Get a list of summary data points
   *
   * @return mixed; NULL or array with keys:
   *  - summary: string
   *  - total: numeric
   */
  function summary() {
    return NULL;
    // return array(
    //   'summary' => 'This is a summary',
    //   'total' => 50.0,
    // );
  }

  /**
   * Get a list of displayable columns
   *
   * @return array, keys are printable column headers and values are SQL column names
   */
  function &columns() {
    // return by reference
    $columns = array(
      ts('Sort Name') => 'sort_name',
      ts('Birth Date') => 'birth_date',
      ts('Email') => 'email',
      ts('Phone') => 'phone',
      ts('Address') => 'street_address',
      ts('Postal') => 'postal_code',
      ts('City') => 'city',
      ts('Country') => 'country',
      ts('Last Name') => 'last_name',
      ts('First Name') => 'first_name',
      ts('External Identifier') => 'external_identifier',
    );
    return $columns;
  }

  /**
   * Construct a full SQL query which returns one page worth of results
   *
   * @param int $offset
   * @param int $rowcount
   * @param null $sort
   * @param bool $includeContactIDs
   * @param bool $justIDs
   * @return string, sql
   */
  function all($offset = 0, $rowcount = 0, $sort = NULL, $includeContactIDs = FALSE, $justIDs = FALSE) {
    // delegate to $this->sql(), $this->select(), $this->from(), $this->where(), etc.
    $sql = $this->sql($this->select(), $offset, $rowcount, $sort, $includeContactIDs, NULL);
    return $sql;
  }

  /**
   * Construct a SQL SELECT clause
   *
   * @return string, sql fragment with SELECT arguments
   */
  function select() {
    $select = "distinct contact_a.id as contact_id, "
      . "contact_a.sort_name, "
      . "contact_a.last_name, "
      . "contact_a.first_name, "
      . "contact_a.external_identifier, "
      . "a.street_address as street_address, "
      . "a.city as city, "
      . "a.postal_code as postal_code, "
      . "ctr.id as country_id, "
      . "ctr.name as country, "
      . "p.phone as phone, "
      . "m.email as email, "
      . "contact_a.birth_date as birth_date ";
    return $select;
  }

  /**
   * Construct a SQL FROM clause
   *
   * @return string, sql fragment with FROM and JOIN clauses
   */
  function from() {
    // eigenlijk zitten hier ook wheres in de subquery. Staat hier dus
    // eigenlijk niet op zijn plaats, maar toch ook weer wel. Hmmm.

    $events_niet = CRM_Utils_Array::value('cursus_niet', $this->_formValues);
    $ids_niet = implode(', ', validate_ints($events_niet));

    $from = "from civicrm_contact contact_a
      left outer join civicrm_address a on a.contact_id = contact_a.id and a.is_primary = 1
      left outer join civicrm_phone p on p.contact_id = contact_a.id and p.is_primary = 1
      left outer join civicrm_email m on m.contact_id = contact_a.id and m.is_primary = 1
      left outer join civicrm_country ctr on a.country_id = ctr.id
      ";

    // Stel de join samen voor de wel-aanwezig-dingen.
    // We moeten minstens 1 cursus vinden.
    $from .= "
      JOIN civicrm_participant p1 ON contact_a.id = p1.contact_id
      JOIN civicrm_event e1 ON p1.event_id = e1.id
    ";

    $aanw_op = CRM_Utils_Array::value('aanw_op', $this->_formValues);
    if ($aanw_op == "AND") {
      // In dit geval moeten we ze allemaal vinden.
      $aantal_wel = count(CRM_Utils_Array::value('cursus_wel', $this->_formValues));
      for ($i = 2; $i <= $aantal_wel; ++$i) {
        $from .= "
          JOIN civicrm_participant p{$i} ON contact_a.id = p{$i}.contact_id
          JOIN civicrm_event e{$i} ON p{$i}.event_id = e{$i}.id
        ";
      }
    }

    if (!empty($events_niet)) {
      $from .= "
        left outer join (
        select contact_id
        from civicrm_participant p
        join civicrm_event e on p.event_id = e.id
        where e.id in ($ids_niet)
        and p.status_id = 2 and p.role_id = 1
        ) pNiet on p1.contact_id = pNiet.contact_id
        ";
    }

    return $from;
  }

  /**
   * Construct a SQL WHERE clause
   *
   * @param bool $includeContactIDs
   * @return string, sql fragment with conditional expressions
   */
  function where($includeContactIDs = FALSE) {
    $clauses = array();
    $params = array();

    // beperk tot individuals
    $clauses[] = "contact_a.contact_type = 'Individual'";
    // aanwezig op evenement
    $clauses[] = "p1.status_id = 2";
    // deelnemer event wel
    $clauses[] = "p1.role_id = 1";

    if (!empty(CRM_Utils_Array::value('cursus_niet', $this->_formValues))) {
      // geen deelnemer event niet
      $clauses[] = "pNiet.contact_id IS NULL";
    }

    // Het where stuk voor 'evenementen wel':
    $event_ids = CRM_Utils_Array::value('cursus_wel', $this->_formValues);
    if (!empty($event_ids)) {
      $aanw_op = CRM_Utils_Array::value('aanw_op', $this->_formValues);

      // It's magic :-)
      if ($aanw_op == 'AND') {
        $i = 1;
        foreach ($event_ids as $event_id) {
          $clauses[] = "e${i}.id = %${i}";
          $params[$i] = array($event_id, 'Integer');
          ++$i;
        }
      }
      else {
        $wel_ids = implode(', ', validate_ints($event_ids));
        $clauses[] = "e1.id IN ($wel_ids)";
      }
    }
    $where = implode(' AND ', $clauses);

    return $this->whereClause($where, $params);
  }

  /**
   * Determine the Smarty template for the search screen
   *
   * @return string, template path (findable through Smarty template path)
   */
  function templateFile() {
    return 'CRM/Contact/Form/Search/Custom.tpl';
  }

  /**
   * Modify the content of each row
   *
   * @param array $row modifiable SQL result row
   * @return void
   */
  function alterRow(&$row) {
    //$row['sort_name'] .= ' ( altered )';
  }
}
