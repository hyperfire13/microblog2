<?php
  App::uses('AppModel', 'Model');
  App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

  class Post extends AppModel {
    public $belongsTo  = array(
      'User' => array (
        'className' => 'User',
        'fields' => array('User.id','User.first_name','User.last_name','User.image'),
        'foreignKey' => 'user_id',
        'dependent' => true
      ),
      'Retweet' => array (
        'className' => 'Post',
        'fields' => array('Retweet.post,Retweet.user_id,Retweet.id,Retweet.created,Retweet.modified,Retweet.images,Retweet.image_captions,Retweet.deleted'),
        'conditions' => "Retweet.deleted = 1",
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
      ),
      'Share' => array(
        'className' => 'Post',
        'foreignKey' => 'post_id',
        'conditions' => array('Share.deleted' => 1),
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
          'rule' => array('maxLength', 150),
          'type' => 'text',
          'allowEmpty' => false,
          'required' => true,
          'message' => 'Blog/Retweet caption must not be blank or not more than 150 characters long'
        )
      ),
      'images' => array(
        'required' => array(
          'rule' => 'notBlank',
          'type' => 'text',
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
      if (isset($this->data[$this->alias]['post'])) {
          $this->data[$this->alias]['post'] = $this->clean_string($this->data[$this->alias]['post']);
      }
      return true;
    }
    public function afterFind($results, $primary = false) {
      foreach ($results as $key => $val) {
          if (isset($val['Post']['images'])) {
              $results[$key]['Post']['images'] = $this->decodeImages(
                  $val['Post']['images']
              );
          }
      }
      //echo json_encode($results);
      for ($i=0; $i < sizeof($results); $i++) {
        if (isset($results[$i]['Retweet']['images'])) {
          $results[$i]['Retweet']['images'] = $this->decodeImages(
            is_string($results[$i]['Retweet']['images']) ? $results[$i]['Retweet']['images'] : json_encode($results[$i]['Retweet']['images'])
          );
        }
        if (isset($results[$i]['Post']['image_captions'])) {
            $results[$i]['Post']['image_captions'] = $this->decodeImages($results[$i]['Post']['image_captions']);
        }
        if (isset($results[$i]['Retweet']['image_captions'])) {
            $results[$i]['Retweet']['image_captions'] = $this->decodeImages(
              is_string($results[$i]['Retweet']['image_captions']) ? $results[$i]['Retweet']['image_captions'] : json_encode($results[$i]['Retweet']['image_captions'])
            );
        }
      }
      return $results;
    }
    protected function _encode($data){
      return json_encode($data);
    }
    protected function decodeImages($data){
      //echo $data;
      if (is_string($data)) {
        $decode = json_decode($data,true);
        //print_r($decode);
        return $decode;
      }
      // $decode = json_decode($data,true);
      // return is_object($decode) ? (array)$decode : $decode;
    }
  }
?>