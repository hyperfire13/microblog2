<?php
  App::uses('AppModel', 'Model');
  App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

  class User extends AppModel {

    public $validate = array(
      'username' => array(
        'required' => array(
          'rule' => 'notBlank',
          'message' => 'A username is required'
        )
      ),
      'password' => array(
        'required' => array(
          'rule' => 'notBlank',
          'message' => 'A password is required'
        )
      )
    );

  }



?>