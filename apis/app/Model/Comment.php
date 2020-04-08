<?php
  App::uses('AppModel', 'Model');
  App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

  class Comment extends AppModel {
    public $belongsTo  = array(
      'User' => array (
        'className' => 'User',
        'fields' => array('User.first_name','User.last_name','User.image'),
        'foreignKey' => 'user_id',
        'dependent' => true
      )
    );
    public $validate = array (
      'user_id' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'biginteger',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'user ID'
        )
      ),
      'post_id' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'biginteger',
          'allowEmpty' => false,
          'required' => false,
          'message' => 'post id'
        )
      ),
      'comment' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'string',
          'allowEmpty' => false,
          'required' => false,
          'message' => 'comment'
        )
      ),
      'deleted' => array(
        'required' => array(
          'type' => 'tinyint',
          'allowEmpty' => true,
          'message' => 'deleted status',
          'required' => false
        )
      )
    );
  }
?>