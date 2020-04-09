<?php
  App::uses('AppModel', 'Model');

  class Follower extends AppModel {
    public $belongsTo  = array(
      'MyFollower' => array (
        'className' => 'User',
        'fields' => array('MyFollower.first_name','MyFollower.last_name'),
        'foreignKey' => 'user_id',
        'dependent' => true
      ),
      'MyFollowing' => array (
        'className' => 'User',
        'fields' => array('MyFollowing.first_name','MyFollowing.last_name'),
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