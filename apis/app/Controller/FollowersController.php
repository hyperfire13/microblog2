<?php 
  App::uses('AppController', 'Controller');
  App::uses('CakeEmail', 'Network/Email');
  App::uses('User', 'Model');
  class FollowersController extends AppController {
    public function viewPeople () {
      $this->layout = false;
      $userId = $this->request->query('id');
      $userId = $this->cleanNumber($this->idDecryption($userId));
      $token = $this->cleanString($this->request->query('token'));
      $page = $this->cleanNumber($this->request->query('page'));
      $size = $this->cleanNumber($this->request->query('size'));
      $followersFollowedByMe = [];
      $followingThatFollowedBack = [];
      if ($this->CheckRequest('get')) {
          if ($this->CheckSession('User.token')) {
              $this->promtMessage = array('status'=>'failed', 'message'=>'records not found');
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              if ($token === $baseToken && $baseId === $userId) {
                  $offset = ($page - 1) * $size;
                  $totalFollowers = $this->Follower->find('count', array(
                    'conditions' => array('Follower.following_id' => $userId,'Follower.deleted'=>1)
                  ));
                  $totalFollowings = $this->Follower->find('count', array(
                    'conditions' => array('Follower.user_id' => $userId,'Follower.deleted'=>1)
                  ));
                  $followers =  $this->Follower->find('all',array(
                    'conditions'=>array('Follower.following_id'=>$userId,'Follower.deleted'=>1),
                    'order'=> array('Follower.created ASC'),
                    'limit'=>$size,
                    'offset'=>$offset
                  ));
                  $followings =  $this->Follower->find('all',array(
                    'conditions'=>array('Follower.user_id'=>$userId,'Follower.deleted'=>1),
                    'order'=> array('Follower.created ASC'),
                    'limit'=>$size,
                    'offset'=>$offset
                  ));
                  if (!empty($followers) || !empty($followings)) {
                      for ($followingCount=0; $followingCount < sizeof($followings); $followingCount++) { 
                        for ($followerCount=0; $followerCount < sizeof($followers); $followerCount++) { 
                          if ($followers[$followerCount]['MyFollower']['id'] === $followings[$followingCount]['MyFollowing']['id']) {
                              array_push($followersFollowedByMe,$followerCount);
                              array_push($followingThatFollowedBack,$followingCount);
                          } 
                        }
                      }
                      for ($i=0; $i < sizeof($followersFollowedByMe); $i++) { 
                        $followers[$followersFollowedByMe[$i]]['MyFollower']['followed'] = true;
                      }
                      for ($i=0; $i < sizeof($followingThatFollowedBack); $i++) { 
                        $followings[$followingThatFollowedBack[$i]]['MyFollowing']['followedBack'] = true;
                      }
                      for ($i=0; $i < sizeof($followers) ; $i++) { 
                        $followers[$i]['MyFollower']['id'] = $this->idEncryption($followers[$i]['MyFollower']['id']);
                      }
                      for ($i=0; $i < sizeof($followings) ; $i++) { 
                        $followings[$i]['MyFollowing']['id'] = $this->idEncryption($followings[$i]['MyFollowing']['id']);
                      }
                      $this->promtMessage = array('status'=>'success','totalFollowers' => $totalFollowers,'totalFollowings' => $totalFollowings, 'followerTotalPages'=>(ceil($totalFollowers/$size)),'followingTotalPages'=>(ceil($totalFollowings/$size)),'followers'=>$followers,'followings'=> $followings);
                  } else {
                      $followers = [];
                      $followings = [];
                      $this->promtMessage = array('status'=>'success', 'followers'=>$followers,'followings'=> $followings);
                  }
                } else {
                    $this->promtMessage = array('status'=>'failed', 'message'=>'unauthorized');
                }
          }
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($this->promtMessage));
      return $this->response->send();
    }
    public function follow () {
      $this->layout = false;
      $data = $this->request->input('json_decode', true);
      if ($this->CheckRequest('post')) { 
          if ($this->CheckSession('User.token')) { 
              $this->promtMessage = array('status'=>'failed', 'message'=>'records not found');
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              $data['user_id'] = $this->idDecryption($data['user_id']);
              if ($data['token'] === $baseToken && $baseId === $data['user_id']) {  
                  if (empty($data)) {
                    $data = $this->request->data;
                  } elseif (!empty($data)) { 
                      $duplicateCount = $this->Follower->find('count', array(
                        'conditions' => array('Follower.user_id' => $data['user_id'],'Follower.following_id' => $data['following_id'],'Follower.deleted' => 1)
                      ));
                      if ($duplicateCount < 1) {
                          if ($this->Follower->save($data)) { 
                              $this->promtMessage = array('status'=>'success','message'=>'follow successful');
                          } else {
                              $errorList = ['Notice :'];
                              $errors = $this->Like->validationErrors;
                              foreach ($errors as $value) {
                              array_push($errorList," ".$value[0]);
                              } 
                              $this->promtMessage = array('status'=>'failed', 'message'=> $errorList);
                          }  
                      }
                  }
              } else {
                  $this->promtMessage = array('status'=>'failed', 'message'=>'unauthorized');
            }
          }
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($this->promtMessage));
      return $this->response->send();
    }
    public function unfollow () {
      $this->layout = false;
      $data = $this->request->input('json_decode', true);
      if ($this->CheckRequest('post')) { 
          if ($this->CheckSession('User.token')) { 
              $this->promtMessage = array('status'=>'failed', 'message'=>'records not found');
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              $data['user_id'] = $this->idDecryption($data['user_id']);
              if ($data['token'] === $baseToken && $baseId === $data['user_id']) {  
                  if (empty($data)) {
                      $data = $this->request->data;
                  } elseif (!empty($data)) { 
                      $this->Follower->id = $data['id'];
                      if ($this->Follower->saveField('deleted',0)) { 
                          $this->promtMessage = array('status'=>'success','message'=>'unfollow successful');
                      } else {
                          $errorList = ['Notice :'];
                          $errors = $this->Like->validationErrors;
                          foreach ($errors as $value) {
                          array_push($errorList," ".$value[0]);
                          } 
                          $this->promtMessage = array('status'=>'failed', 'message'=> $errorList);
                      }  
                   
                  }
              } else {
                  $this->promtMessage = array('status'=>'failed', 'message'=>'unauthorized');
            }
          }
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($this->promtMessage));
      return $this->response->send();
    }
    public function searchPeople () {
      $this->layout = false;
      $userId = $this->request->query('id');
      $userId = $this->cleanNumber($this->idDecryption($userId));
      $token = $this->cleanString($this->request->query('token'));
      $page = $this->cleanNumber($this->request->query('page'));
      $size = $this->cleanNumber($this->request->query('size'));
      $search = '%'.(empty($this->cleanString($this->request->query('search'))) ? 'blank' : $this->cleanString($this->request->query('search'))).'%';
      $followers = [];
      $followings = [];
      $people = [];
      $peopleIds = [];
      if ($this->CheckRequest('get')) {
          if ($this->CheckSession('User.token')) { 
              $this->promtMessage = array('status'=>'failed', 'message'=>'records not found');
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              if ($token === $baseToken && $baseId === $userId) { 
                  $userModel = new User();
                  $offset = ($page - 1) * $size;
                  $peopleName = $userModel->find('all',array(
                    'conditions'=>array(array("OR" => array(
                      "User.first_name LIKE" => $search,
                      "User.middle_name LIKE" => $search,
                      "User.last_name LIKE" => $search
                    )),'User.deleted'=>1,'User.activation_status'=>1,'User.id <>' => $userId),
                    'fields' => array('id','first_name','middle_name','last_name','image'),
                    'limit'=>$size,
                    'offset'=>$offset,
                    'order'=> array('User.created ASC'),
                     ));
                  if (!empty($peopleName)) {
                      for ($i=0; $i < sizeof($peopleName) ; $i++) { 
                        array_push($peopleIds,$peopleName[$i]['User']['id']);
                        $myFollower =  $this->Follower->find('count',array(
                          'conditions'=>array('Follower.user_id'=>$peopleName[$i]['User']['id'],'Follower.following_id'=>$userId,'Follower.deleted'=>1),
                          'order'=> array('Follower.created ASC'),
                          'limit'=>$size,
                          'offset'=>$offset
                        ));
                        $myFollowing =  $this->Follower->find('all',array(
                          'conditions'=>array('Follower.user_id'=>$userId,'Follower.following_id'=>$peopleName[$i]['User']['id'],'Follower.deleted'=>1),
                          'order'=> array('Follower.created ASC'),
                          'fields' => array('id'),
                          'limit'=>$size,
                          'offset'=>$offset
                        ));
                        if ($myFollower === 1) {
                            $peopleName[$i]['User']['myFollower'] = true;
                        }
                        if (sizeof($myFollowing) === 1) {
                            $peopleName[$i]['User']['myFollowing'] = true;
                            $peopleName[$i]['User']['myFollowingId'] = $myFollowing[0]['Follower']['id'];
                        }
                      }
                      $total = $userModel->find('count',array(
                        'conditions'=>array(array("OR" => array(
                          "User.first_name LIKE" => $search,
                          "User.middle_name LIKE" => $search,
                          "User.last_name LIKE" => $search
                        )),'User.deleted'=>1,'User.activation_status'=>1)
                         ));
                      for ($i=0; $i < sizeof($peopleName); $i++) { 
                        $peopleName[$i]['User']['id'] = $this->idEncryption($peopleName[$i]['User']['id']);
                      }
                      $this->promtMessage = array('status'=>'success', 'people'=>$peopleName,'total'=>$total,'totalPages'=>(ceil($total/$size)));
                  } else {
                      $people = [];
                      $this->promtMessage = array('status'=>'success', 'people'=>$peopleName);
                  }
              } else {
                  $this->promtMessage = array('status'=>'failed', 'message'=>'unauthorized');
              }
          }
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($this->promtMessage));
      return $this->response->send();
    }
  }
?>

