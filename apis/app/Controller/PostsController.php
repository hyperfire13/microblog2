<?php 
  App::uses('AppController', 'Controller');
  App::uses('CakeEmail', 'Network/Email');
  App::uses('Follower', 'Model');

  class PostsController extends AppController { 
    public function addPost () {
      $this->layout = false;
      if ($this->CheckRequest('post')) {
          if ($this->CheckSession('User.token')) {
              $this->promtMessage = array('status'=>'failed', 'message'=>'record not found');
              $data = $this->request->data; 
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              $postImages = [];
              $data['user_id'] = $this->idDecryption($data['user_id']);
              if ($data['token'] === $baseToken && $baseId === $data['user_id']) {  
                  if (empty($data)) {
                      $data = $this->request->data;
                  } elseif (!empty($data)) { 
                      $go = true;
                      if (!empty($_FILES['file'])) { 
                          $totalPosts = $this->Post->find('count', array(
                            'conditions' => array('Post.user_id' => $data['user_id'])
                        )) + 1;
                          $no_files = count($_FILES["file"]['name']);
                          for ($i=0; $i < $no_files; $i++) {
                            
                            if ($_FILES['file']['size'][$i] > 2000000) {
                                $this->promtMessage = array('status'=>'failed', 'message'=>('Image number '.($i+1).' should not exceed size of 2mb'));
                                $go = false;
                            } else {
                                $img = $_FILES['file']['name'][$i];
                                $tmp = $_FILES['file']['tmp_name'][$i];
                                $path = '../../../pic-posts/';
                                $extension = pathinfo($img, PATHINFO_EXTENSION);
                                $path = $path.strtolower($totalPosts.$data['user_id'].$i."-postpic.".$extension);
                                $imgNewName = strtolower($totalPosts.$data['user_id'].$i."-postpic.".$extension);
                                array_push($postImages,$imgNewName);
                                if (!move_uploaded_file($tmp,$path)) {
                                    $this->promtMessage = array('status'=>'failed', 'message'=>"Image not uploaded to server and database");
                                }  
                            }
                          }
                          $data['images'] = json_encode($postImages);
                      }
                      if ($go) {
                          if ($this->Post->save($data)) {
                              $this->promtMessage = array('status'=>'success', 'message'=>'Your blog was uploaded');
                          } else {
                              $errorList = ['Notice :'];
                              $errors = $this->Post->validationErrors;
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
    public function viewAllBlogs () {
      $this->layout = false;
      $userId = $this->request->query('id');
      $userId = $this->cleanNumber($this->idDecryption($userId));
      $token = $this->cleanString($this->request->query('token'));
      $page = $this->cleanNumber($this->request->query('page'));
      $size = $this->cleanNumber($this->request->query('size'));
      if ($this->CheckRequest('get')) {
          if ($this->CheckSession('User.token')) {
              $this->promtMessage = array('status'=>'failed', 'message'=>'records not found');
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              if ($token === $baseToken && $baseId === $userId) {
                  $followingModel = new Follower();
                  $offset = ($page - 1) * $size;
                  $followingIds = [];
                  $followings =  $followingModel->find('all',array(
                    'conditions'=>array('Follower.user_id'=>$userId,'Follower.deleted'=>1),
                    'order'=> array('Follower.created ASC'),
                  ));
                  for ($followingCount=0; $followingCount < sizeof($followings); $followingCount++) { 
                      array_push($followingIds,$followings[$followingCount]['MyFollowing']['id']);
                  }
                  array_push($followingIds,$userId);
                  $total = $this->Post->find('count', array(
                    'conditions' => array('Post.user_id' => $followingIds,'Post.deleted'=>1)
                  ));
                  $blogs =  $this->Post->find('all',array(
                    'conditions'=>array('Post.user_id'=>$followingIds,'Post.deleted'=>1),
                    'limit'=>$size,
                    'order'=> array('Post.created DESC'),
                    'offset'=>$offset
                  ));
                  for ($i=0; $i < sizeof($blogs); $i++) {
                    if (isset($blogs[$i]['Post']['user_id'])) {
                      $blogs[$i]['Post']['user_id'] = $this->idEncryption($blogs[$i]['Post']['user_id']);
                    }
                    if (isset($blogs[$i]['User']['id'])) {
                      $blogs[$i]['User']['id'] = $this->idEncryption($blogs[$i]['User']['id']);
                    }
                  }
                  if (!empty($blogs)) {
                      $this->promtMessage = array('status'=>'success','total'=>$total,'totalPages'=>(ceil($total/$size)),'record'=>$blogs);
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
    public function viewMyBlogs () {
      $this->layout = false;
      $userId = $this->request->query('id');
      $userId = $this->cleanNumber($this->idDecryption($userId));
      $token = $this->cleanString($this->request->query('token'));
      $page = $this->cleanNumber($this->request->query('page'));
      $size = $this->cleanNumber($this->request->query('size'));
      if ($this->CheckRequest('get')) {
          if ($this->CheckSession('User.token')) {
              $this->promtMessage = array('status'=>'failed', 'message'=>'records not found');
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              if ($token === $baseToken && $baseId === $userId) {
                  $offset = ($page - 1) * $size;
                  $total = $this->Post->find('count', array(
                    'conditions' => array('Post.user_id' => $userId,'Post.deleted'=>1)
                  ));
                  $blogs =  $this->Post->find('all',array(
                    'conditions'=>array('Post.user_id'=>$userId,'Post.deleted'=>1),
                    'limit'=>$size,
                    'order'=> array('Post.created DESC'),
                    'offset'=>$offset
                  ));
                  if (!empty($blogs)) {
                      $this->promtMessage = array('status'=>'success','total'=>$total,'totalPages'=>(ceil($total/$size)),'record'=>$blogs);
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
    public function deletePost () {
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
                      $checkOwner = $this->Post->find('count', array(
                          'conditions' => array('Post.id' => $data['post_id'],'Post.user_id' => $data['user_id'])
                      ));
                      if ($checkOwner === 1) {
                          $data['deleted_date'] = date("Y-m-d H:i:s");
                          $data['deleted'] = false;
                          $this->Post->id = $data['post_id'];
                          if ($this->Post->save($data,true,['deleted_date','deleted'])) { 
                              $this->promtMessage = array('status'=>'success','message'=>'Your post was deleted');
                          } else {
                              $errorList = ['Notice :'];
                              $errors = $this->Post->validationErrors;
                              foreach ($errors as $value) {
                              array_push($errorList," ".$value[0]);
                              } 
                              $this->promtMessage = array('status'=>'failed', 'message'=> $errorList);
                          }
                      } else {
                        $this->promtMessage = array('status'=>'failed', 'message'=>'unauthorized to delete this');
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
    public function editPost () {
      $this->layout = false;
      if ($this->CheckRequest('post')) { 
          if ($this->CheckSession('User.token')) {
              $this->promtMessage = array('status'=>'failed', 'message'=>'record not found');
              $data = $this->request->data; 
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              $postImages = [];
              $data['existing_pics'] = json_decode($data['existing_pics'],true);
              $data['user_id'] = $this->idDecryption($data['user_id']);
              if ($data['token'] === $baseToken && $baseId === $data['user_id']) {
                  if (empty($data)) {
                      $data = $this->request->data;
                  } elseif (!empty($data)) { 
                      $checkOwner = $this->Post->find('count', array(
                        'conditions' => array('Post.id' => $data['post_id'],'Post.user_id' => $data['user_id'])
                      ));
                      if ($checkOwner === 1) { 
                          $go = true;
                          if (!empty($_FILES['file'])) { 
                              $totalPosts = $this->Post->find('count', array('conditions' => array('Post.user_id' => $data['user_id'])
                                )) + 1;
                                $no_files = count($_FILES["file"]['name']);
                               
                              for ($i=0; $i < $no_files; $i++) {
                                if ($_FILES['file']['size'][$i] > 2000000) {
                                    $this->promtMessage = array('status'=>'failed', 'message'=>('Some of your images exceeds the size of 2mb, select another image with lower size'));
                                    $go = false;
                                } else {
                                    $img = $_FILES['file']['name'][$i];
                                    $tmp = $_FILES['file']['tmp_name'][$i];
                                    $path = '../../../pic-posts/';
                                    $extension = pathinfo($img, PATHINFO_EXTENSION);
                                    $path = $path.strtolower($totalPosts.$data['user_id'].$i."-postpic.".$extension);
                                    $imgNewName = strtolower($totalPosts.$data['user_id'].$i."-postpic.".$extension);
                                    array_push($data['existing_pics'],$imgNewName);
                                    if (!move_uploaded_file($tmp,$path)) {
                                        $this->promtMessage = array('status'=>'failed', 'message'=>"Image not uploaded to server and database");
                                    }
                                }
                              }
                              $data['images'] = json_encode($data['existing_pics']);
                          } else {
                              $data['images'] = json_encode($data['existing_pics']);
                          }
                          $this->Post->id = $data['post_id'];
                          unset($data['post_id']);
                          if ($go) {
                              if ($this->Post->save($data)) {
                                  $this->promtMessage = array('status'=>'success', 'message'=>'Your blog was edited');
                              } else {
                                  $errorList = ['Notice :'];
                                  $errors = $this->Post->validationErrors;
                                  foreach ($errors as $value) {
                                  array_push($errorList," ".$value[0]);
                                  } 
                                  $this->promtMessage = array('status'=>'failed', 'message'=> $errorList);
                              }
                          }
                      } else {
                        $this->promtMessage = array('status'=>'failed', 'message'=>'unauthorized to edit this');
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
    public function sharePost () {
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
                      $rule = (empty($data['post']) ? false : true);
                      if ($this->Post->save($data,$rule,['user_id','post_id','post'])) {
                          $this->promtMessage = array('status'=>'success','message'=>'You shared this post');
                      } else {
                          $errorList = ['Notice :'];
                          $errors = $this->Post->validationErrors;
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
    public function searchAllBlogs () {
      $this->layout = false;
      $userId = $this->request->query('id');
      $userId = $this->cleanNumber($this->idDecryption($userId));
      $token = $this->cleanString($this->request->query('token'));
      $page = $this->cleanNumber($this->request->query('page'));
      $size = $this->cleanNumber($this->request->query('size'));
      $search = '%'.(empty($this->cleanString($this->request->query('search'))) ? 'blank' : $this->cleanString($this->request->query('search'))).'%';
      if ($this->CheckRequest('get')) {
          if ($this->CheckSession('User.token')) {
              $this->promtMessage = array('status'=>'failed', 'message'=>'records not found');
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              if ($token === $baseToken && $baseId === $userId) {
                  $followingModel = new Follower();
                  $offset = ($page - 1) * $size;
                  $followingIds = [];
                  $followings =  $followingModel->find('all',array(
                    'conditions'=>array('Follower.user_id'=>$userId,'Follower.deleted'=>1),
                    'order'=> array('Follower.created ASC'),
                  ));
                  for ($followingCount=0; $followingCount < sizeof($followings); $followingCount++) { 
                      array_push($followingIds,$followings[$followingCount]['MyFollowing']['id']);
                  }
                  array_push($followingIds,$userId);
                  $total = $this->Post->find('count', array(
                    'conditions' => array('Post.user_id' => $followingIds,'Post.post LIKE' => $search,'Post.deleted'=>1)
                  ));
                  $blogs =  $this->Post->find('all',array(
                    'conditions'=>array('Post.user_id'=>$followingIds,'Post.post LIKE' => $search,'Post.deleted'=>1),
                    'limit'=>$size,
                    'order'=> array('Post.created DESC'),
                    'offset'=>$offset
                  ));
                  if (!empty($blogs)) {
                      $this->promtMessage = array('status'=>'success','total'=>$total,'totalPages'=>(ceil($total/$size)),'record'=>$blogs);
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