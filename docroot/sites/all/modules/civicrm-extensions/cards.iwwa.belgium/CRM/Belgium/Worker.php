<?php

/**
 * Created by PhpStorm.
 * User: johanv
 * Date: 4/12/17
 * Time: 10:00 PM
 */
class CRM_Belgium_Worker {
  /**
   * Updates state_province_id if the address with given id is a Belgian address.
   *
   * @param int $addressId
   */
  public function guessProvince($addressId) {
    // TODO
  }

  /**
   * If the contact of the address has no preferred language, guess.
   *
   * @param $addressId
   */
  public function updatePreferredLanguage($addressId) {
    // TODO
  }
}