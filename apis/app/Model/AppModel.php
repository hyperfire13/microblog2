<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

  public function clean_string($value) {

    // Removes leading and trailing spaces
    $data = trim($value);

    // Removes Unwanted Characters
    $data = filter_var($data, FILTER_SANITIZE_STRING);

    // Sanitizes HTML Characters
    $data = htmlspecialchars_decode($data, ENT_QUOTES);

    return $data;
  }
  public function idEncryption($id) {
    $data = openssl_encrypt($id, "AES-128-ECB", $this->idEncryptor);
    //AyYEF91D0AisI0CHxk2+0w==
    return $data;
  }
  public function idDecryption($id) {
    $data = openssl_decrypt($id, "AES-128-ECB", $this->idEncryptor);
    //AyYEF91D0AisI0CHxk2+0w==
    return $data;
  }
}
