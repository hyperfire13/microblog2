<?php
  App::uses('AppModel', 'Model');
  App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

  class User extends AppModel {

    public $validate = array(
      'username' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'message' => 'Username is required'
        )
      ),
      'password' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'message' => 'password is required'
        )
      ),
      'email' => array(
        'required' => array(
          'rule' => 'email',
          'type' => 'string',
          'message' => 'Enter a valid email'
        )
      ),
      'first_name' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'message' => 'Firstname is required'
        )
      ),
      'middle_name' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'message' => 'Middlename is required'
        )
      ),
      'last_name' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'message' => 'Lastname is required'
        )
      ),
      'date_of_birth' => array(
        'required' => array(
          'rule' => 'date',
          'type' => 'string',
          'message' => 'Date of Birth is required'
        )
      ),
      '	deleted_date' => array(
        'required' => array(
          'rule' => 'date',
          'type' => 'timestamp',
          'message' => 'Date of Birth is required'
        )
      )
    );
    public function beforeSave($options = array()) {
      if (isset($this->data[$this->alias]['password'])) {
          $passwordHasher = new BlowfishPasswordHasher();
          $this->data[$this->alias]['password'] = $passwordHasher->hash(
              $this->data[$this->alias]['password']
          );
      }
      return true;
    }
  }
?>