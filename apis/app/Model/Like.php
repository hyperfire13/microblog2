<?php
  App::uses('AppModel', 'Model');
  App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

  class Like extends AppModel {
    public $belongsTo  = array(
      'Post' => array (
        'className' => 'Post',
        'foreignKey' => 'post_id',
        'dependent' => true
      )
    );
  }
?>