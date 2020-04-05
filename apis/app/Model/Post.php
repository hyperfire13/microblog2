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
      ),
      'Reweet' => array (
        'className' => 'Post',
        'fields' => array('post'),
        'foreignKey' => 'post_id',
        'dependent' => true
      )
      ,
      'ReweetOwner' => array (
        'className' => 'User',
        'fields' => array('first_name','last_name'),
        'foreignKey' => 'user_id',
        // 'conditions' => array('ReweetOwner.id' => 219),
        'dependent' => true
      )
    );
    // public $hasMany = array(
    //   'Reweet' => array(
    //     'className' => 'Post',
    //     'foreignKey' => 'post_id',
    //     'fields' => array('post'),

    //   )
    // );
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