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
              if ($data['token'] === $baseToken && $baseId === $data['user_id']) {  
                  if (empty($data)) {
                      $data = $this->request->data;
                  } elseif (!empty($data)) { 
                      if (!empty($_FILES['file'])) { 
                          $totalPosts = $this->Post->find('count', array(
                            'conditions' => array('Post.user_id' => $data['user_id'])
                        )) + 1;
                          $no_files = count($_FILES["file"]['name']);
                          for ($i=0; $i < $no_files; $i++) { 
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
                          $data['images'] = json_encode($postImages);
                      }
                      if ($this->Post->save($data)) {
                          $this->promtMessage = array('status'=>'success', 'message'=>'Your blog was uploaded');
                      } else {
                          $errorList = ['Missing :'];
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
    public function viewAllBlogs () {
      $this->layout = false;
      $userId = $this->cleanNumber($this->request->query('id'));
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
      $userId = $this->cleanNumber($this->request->query('id'));
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
                              $errorList = ['Missing :'];
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
              if ($data['token'] === $baseToken && $baseId === $data['user_id']) {  
                  if (empty($data)) {
                      $data = $this->request->data;
                  } elseif (!empty($data)) { 
                      $checkOwner = $this->Post->find('count', array(
                        'conditions' => array('Post.id' => $data['post_id'],'Post.user_id' => $data['user_id'])
                      ));
                      if ($checkOwner === 1) {
                          if (!empty($_FILES['file'])) { 
                              $totalPosts = $this->Post->find('count', array('conditions' => array('Post.user_id' => $data['user_id'])
                                )) + 1;
                                $no_files = count($_FILES["file"]['name']);
                              for ($i=0; $i < $no_files; $i++) { 
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
                              $data['images'] = json_encode($data['existing_pics']);
                          } else {
                              $data['images'] = json_encode($data['existing_pics']);
                          }
                          $this->Post->id = $data['post_id'];
                          unset($data['post_id']);
                          if ($this->Post->save($data)) {
                              $this->promtMessage = array('status'=>'success', 'message'=>'Your blog was edited');
                          } else {
                              $errorList = ['Missing :'];
                              $errors = $this->Post->validationErrors;
                              foreach ($errors as $value) {
                              array_push($errorList," ".$value[0]);
                              } 
                              $this->promtMessage = array('status'=>'failed', 'message'=> $errorList);
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
                if ($data['token'] === $baseToken && $baseId === $data['user_id']) { 
                    if (empty($data)) {
                        $data = $this->request->data;
                    } elseif (!empty($data)) { 
                        if ($this->Post->save($data,true,['user_id','post_id'])) { 
                            $this->promtMessage = array('status'=>'success','message'=>'You shared this post');
                        } else {
                            $errorList = ['Missing :'];
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
  }
?>