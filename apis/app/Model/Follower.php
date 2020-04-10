<?php
  App::uses('AppModel', 'Model');

  class Follower extends AppModel {
    public $belongsTo  = array(
      'MyFollower' => array (
        'className' => 'User',
        'fields' => array('MyFollower.id','MyFollower.first_name','MyFollower.last_name','MyFollower.image'),
        'foreignKey' => 'user_id',
        'conditions' => array('MyFollower.deleted' => '1'),
        'dependent' => true
      ),
      'MyFollowing' => array (
        'className' => 'User',
        'fields' => array('MyFollowing.id','MyFollowing.first_name','MyFollowing.last_name','MyFollowing.image'),
        'foreignKey' => 'following_id',
        'conditions' => array('MyFollowing.deleted' => '1'),
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
      'following_id' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'biginteger',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'following ID'
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