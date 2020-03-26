<?php
  App::uses('AppModel', 'Model');
  App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

  class User extends AppModel {

    public $validate = array(
      'username' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'username'
        )
      ),
      'password' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'password'
        )
      ),
      'email' => array(
        'required' => array(
          'rule' => 'email',
          'type' => 'string',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'email'
        )
      ),
      'first_name' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'allowEmpty' => false,
          'message' => 'firstname',
          'required' => true
        )
      ),
      'middle_name' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'middlename'
        )
      ),
      'last_name' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'lastname'
        )
      ),
      'date_of_birth' => array(
        'required' => array(
          'rule' => 'date',
          'type' => 'string',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'birthday'
        )
      ),
      'deleted_date' => array(
        'required' => array(
          'rule' => 'date',
          'type' => 'timestamp',
          'message' => 'delete date is required'
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