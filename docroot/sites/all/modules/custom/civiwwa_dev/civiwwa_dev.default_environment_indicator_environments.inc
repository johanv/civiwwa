<?php
/**
 * @file
 * civiwwa_dev.default_environment_indicator_environments.inc
 */

/**
 * Implements hook_default_environment_indicator_environment().
 */
function civiwwa_dev_default_environment_indicator_environment() {
  $export = array();

  $environment = new stdClass();
  $environment->disabled = FALSE; /* Edit this to true to make a default environment disabled initially */
  $environment->api_version = 1;
  $environment->machine = 'dev_environment';
  $environment->name = 'Dev-omgeving';
  $environment->regexurl = 'localhost';
  $environment->settings = array(
    'color' => '#aa3333',
    'text_color' => '#ffffff',
    'weight' => '99',
    'position' => 'top',
    'fixed' => 0,
  );
  $export['dev_environment'] = $environment;

  $environment = new stdClass();
  $environment->disabled = FALSE; /* Edit this to true to make a default environment disabled initially */
  $environment->api_version = 1;
  $environment->machine = 'testomgeving';
  $environment->name = 'Testomgeving';
  $environment->regexurl = 'iwwatest.johanv.org';
  $environment->settings = array(
    'color' => '#1a6d44',
    'text_color' => '#ffffff',
    'weight' => '',
    'position' => 'top',
    'fixed' => 0,
  );
  $export['testomgeving'] = $environment;

  return $export;
}
