<?php

/**
 * Class CRM_Settingsform_Form_Settings
 *
 * Copied this from
 * https://github.com/eileenmcnaughton/nz.co.fuzion.civixero/blob/master/CRM/Civixero/Form/XeroSettings.php
 */
class CRM_Settingsform_Form_Settings extends CRM_Core_Form
{
  // Dummy setting. In most of the cases, you will change 'dummy' to the name of your settings group.
  private $_settingFilter = array('group' => 'dummy');
  private $_settings = array();
  function buildQuickForm() {
    $settings = $this->getFormSettings();
    foreach ($settings as $name => $setting) {
      if (isset($setting['quick_form_type'])) {
        $add = 'add' . $setting['quick_form_type'];
        if ($add == 'addElement') {
          $this->$add($setting['html_type'], $name, ts($setting['title']), CRM_Utils_Array::value('html_attributes', $setting, array ()));
        }
        elseif ($setting['html_type'] == 'Select') {
          $optionValues = array();
          if (!empty($setting['pseudoconstant']) && !empty($setting['pseudoconstant']['optionGroupName'])) {
            $optionValues = CRM_Core_OptionGroup::values($setting['pseudoconstant']['optionGroupName'], FALSE, FALSE, FALSE, NULL, 'name');
          }
          $this->add('select', $setting['name'], $setting['title'], $optionValues, FALSE, $setting['html_attributes']);
        }
        else {
          $this->$add($name, ts($setting['title']));
        }
        $this->assign("{$setting['description']}_description", ts('description'));
      }
    }

    $this->addButtons(array(
      array (
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      )
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }
  function postProcess() {
    $this->_submittedValues = $this->exportValues();
    $this->saveSettings();
    parent::postProcess();
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons". These
    // items don't have labels. We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

  /**
   * Get the settings we are going to allow to be set on this form.
   *
   * @return array
   */
  function getFormSettings() {
    if (empty($this->_settings)) {
      $settings = civicrm_api3('setting', 'getfields', array('filters' => $this->_settingFilter));
    }
    $extraSettings = civicrm_api3('setting', 'getfields', array('filters' => array('group' => 'accountsync')));
    $settings = $settings['values'] + $extraSettings['values'];
    return $settings;
  }

  /**
   * Get the settings we are going to allow to be set on this form.
   *
   * @return array
   */
  function saveSettings() {
    $settings = $this->getFormSettings();
    $values = array_intersect_key($this->_submittedValues, $settings);
    civicrm_api3('setting', 'create', $values);
  }

  /**
   * Set defaults for form.
   *
   * @see CRM_Core_Form::setDefaultValues()
   */
  function setDefaultValues() {
    $existing = civicrm_api3('setting', 'get', array('return' => array_keys($this->getFormSettings())));
    $defaults = array();
    $domainID = CRM_Core_Config::domainID();
    foreach ($existing['values'][$domainID] as $name => $value) {
      $defaults[$name] = $value;
    }
    return $defaults;
  }

  /**
   * @param array $settingFilter
   */
  protected function setSettingFilter($settingFilter)
  {
    $this->_settingFilter = $settingFilter;
  }
}

