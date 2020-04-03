<?php
  App::uses('AppModel', 'Model');
  App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

  class Post extends AppModel {
    public $belongsTo  = array(
      'User' => array (
        'className' => 'User',
        'fields' => array('User.first_name','User.last_name'),
        'foreignKey' => 'user_id',
        'dependent' => true
      )
    );
    public $validate = array(
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
          'allowEmpty' => true,
          'required' => false,
          'message' => 'reblog id'
        )
      ),
      'post' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'text',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'blog'
        )
      ),
      'images' => array(
        'required' => array(
          'type' => 'string',
          'allowEmpty' => true,
          'message' => 'images',
          'required' => false
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
    public function beforeSave($options = array()) {
      
      return true;
    }
  }
?>