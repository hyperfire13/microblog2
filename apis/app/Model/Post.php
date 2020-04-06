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
      'Retweet' => array (
        'className' => 'Post',
        'fields' => array('Retweet.post,Retweet.user_id,Retweet.id,Retweet.created'),
        'foreignKey' => 'post_id',
        'dependent' => true 
      ),
      'RetweetOwner' => array (
        'className' => 'User',
        'fields' => array('RetweetOwner.first_name','RetweetOwner.last_name', 'RetweetOwner.image'),
        'foreignKey' => false,
        'conditions' => " RetweetOwner.id = Retweet.user_id",
        'dependent' => true
      )
    );
    public $hasMany = array(
      'Like' => array(
        'className' => 'Like',
        'foreignKey' => 'post_id',
        'conditions' => array('Like.deleted' => '1'),
        'dependent' => true
      
      ),
      'Comment' => array(
        'className' => 'Comment',
        'foreignKey' => 'post_id',
        'conditions' => array('Comment.deleted' => '1'),
        'dependent' => true
      )
  ) ;
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