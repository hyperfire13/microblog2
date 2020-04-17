<?php
  App::uses('AppModel', 'Model');
  App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

  class User extends AppModel {

    public $validate = array(
      'username' => array(
        'required' => array(
          'rule' => array('minLength', 8),
          'type' => 'string',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'username must not be blank and more than 8 characters'
        )
      ),
      'password' => array(
        'required' => array(
          'rule' => array('minLength', 6),
          'type' => 'string',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'password must be more than 6 characters'
        )
      ),
      'email' => array(
        'required' => array(
          'rule' => 'email',
          'type' => 'string',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'email provided is either taken / invalid'
        )
      ),
      'first_name' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'allowEmpty' => false,
          'message' => 'invalid firstname',
          'required' => true
        )
      ),
      'middle_name' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'invalid middlename'
        )
      ),
      'last_name' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'invalid lastname'
        )
      ),
      'date_of_birth' => array(
        'required' => array(
          'rule' => 'checkDOB',
          'type' => 'date',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'birthday is invalid,'
        )
      ),'activation_status' => array(
        'required' => array(
          'rule' => 'numeric',
          'type' => 'tinyinteger',
          'allowEmpty' => false,
          'required' => false,
          'message' => 'invalid activation status'
        )
        ),
      'code' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'validation code'
        )
      )
    );
    public function checkDOB($check) {
      return $check['date_of_birth'] < date("Y-m-d");
    }
    public function beforeSave($options = array()) {
      if (isset($this->data[$this->alias]['password'])) {
          $passwordHasher = new BlowfishPasswordHasher();
          $this->data[$this->alias]['password'] = $passwordHasher->hash(
              $this->data[$this->alias]['password']
          );
      }
      if (isset($this->data[$this->alias]['first_name'])) {
          $this->data[$this->alias]['first_name'] = trim($this->clean_string($this->data[$this->alias]['first_name']),'"');
      }
      if (isset($this->data[$this->alias]['middle_name'])) {
          $this->data[$this->alias]['middle_name'] = trim($this->clean_string($this->data[$this->alias]['middle_name']),'"');
      }
      if (isset($this->data[$this->alias]['last_name'])) {
          $this->data[$this->alias]['last_name'] = trim($this->clean_string($this->data[$this->alias]['last_name']),'"');
      }
      if (isset($this->data[$this->alias]['username'])) {
          $this->data[$this->alias]['username'] = $this->clean_string($this->data[$this->alias]['username']);
      }
      return true;
    }
    // public function afterFind($results, $primary = false) {
    //   //echo json_encode($results);
    //   for ($i=0; $i < sizeof($results); $i++) {
    //     if (isset($results[$i]['User']['id'])) {
    //         $results[$i]['User']['id'] = $this->idEncryption($results[$i]['User']['id']);
    //     }
    //   }
    //   return $results;
    // }
  }
?>