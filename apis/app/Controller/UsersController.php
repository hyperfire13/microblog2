<?php 
  
  App::uses('AppController', 'Controller');
  App::uses('CakeEmail', 'Network/Email');

  class UsersController extends AppController {
    public function add() {
      $this->layout = false;
      // check request method
      if ($this->CheckRequest('post')) {
          $this->promtMessage = array('status'=>'failed', 'message'=>'Please complete the fields');
          $data = $this->request->input('json_decode', true);
          // generate verification code
          $lastDigits = $this->User->find('count') +1;
          $data['code'] = 'MB-'. $this->createCode().$lastDigits;
          if (empty($data)) {
              $data = $this->request->data;
          }
          // check if data in not empty
          if (!empty($data)) {
              $name = $this->capitalizeFirstLetter($data['first_name']);
              $code = $data['code'];
              $email = $data['email'];
              $data['first_name'] = $this->capitalizeFirstLetter($data['first_name']);
              $data['middle_name'] = $this->capitalizeFirstLetter($data['middle_name']);
              $data['last_name'] = $this->capitalizeFirstLetter($data['last_name']);
              $duplicateCount = $this->User->find('count', array(
                  'conditions' => array('User.username' => $data['username'])
              ));
              $duplicateEmail = $this->User->find('count', array(
                'conditions' => array('User.email' => $data['email'])
              ));
              // check if username is existing
              if ($duplicateCount === 0 && $duplicateEmail === 0) {
                  // saving user
                  if ($this->User->save($data)) {
                      $this->Flash->success(__('The user has been saved'));
                      $this->promtMessage = array('status'=>'success','message'=>'Yehey! You are now registered!');
                      $this->sendValidationLink($code,$name,$email);
                  } else {
                      $errorList = [];
                      $errors = $this->User->validationErrors;
                      foreach ($errors as $key => $value) {
                        array_push($errorList,array($key => $value[0]));
                      }
                      $this->promtMessage = array('status'=>'failed', 'message'=> $errorList);
                  }
              } else {
                  if ($duplicateCount > 0 ) { 
                      // response if email/username is existing
                      $this->promtMessage = array('status'=>'failed','message'=>'Username already taken');
                      $errorList = [];
                      array_push($errorList,array('username'=>'Username already taken'));
                      $this->promtMessage = array('status'=>'failed','message'=>$errorList);
                  }
                  if ($duplicateEmail > 0 ) { 
                      $errorList = [];
                      array_push($errorList,array('email'=>'Email already taken'));
                      $this->promtMessage = array('status'=>'failed','message'=>$errorList);
                  }
              }
          }
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($this->promtMessage));
      return $this->response->send();
    }
    public function activate () { 
      $this->layout = false;
      $data = $this->request->input('json_decode', true);
      if ($this->CheckRequest('post')) { 
          $this->promtMessage = array('status'=>'failed', 'message'=>'Please complete the fields');
          if (empty($data)) {
             $data = $this->request->data;
          } elseif (!empty($data)) {
              $data = array_map('trim', $data);
              $data['code'] = $this->cleanString($data['code']); 
              $record = $this->User->find('first', array( 'conditions' => array('BINARY User.code = '.'\''.$data['code'].'\'')));
              if (empty($record)) {
                  $this->promtMessage = array('status'=>'failed', 'message'=>'Whoops, you entered an invalid code');
              } else {
                  unset($record['User']['modified']);
                  if (!$record['User']['activation_status']) {
                      $record['User']['activation_status'] = 1;
                      $this->User->id = $record['User']['id'];
                      if ($this->User->saveField('activation_status',1)) { 
                          $this->promtMessage = array('status'=>'success','message'=>'Yehey! Your account was activated');
                      } else {
                          $this->promtMessage = array('status'=>'failed','message'=>$this->User->validationErrors);
                      } 
                  } else {
                      $this->promtMessage = array('status'=>'success','message'=>'Your account was already activated');  
                  }
              }
          }
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($this->promtMessage));
      return $this->response->send();
    }
    public function resendCode () {
      $this->layout = false;
      $data = $this->request->input('json_decode', true);
      if ($this->CheckRequest('post')) { 
          $this->promtMessage = array('status'=>'failed', 'message'=>'Please complete the fields');
          if (empty($data)) {
              $data = $this->request->data;
          } elseif (!empty($data)) {
              // $duplicateCount = $this->User->find('count', array(
              //     'conditions' => array('User.username' => $data['username'])
              // ));
              $record = $this->User->find('first', array( 'conditions' => array('User.username' => $data['username'])));
              if (empty($record)) {
                  $this->promtMessage = array('status'=>'failed', 'message'=>'Email not found');
              } else {
                  $resendEmail = $record['User']['email'];
                  $resendCode = $record['User']['code'];
                  $resendName =  $this->capitalizeFirstLetter($record['User']['first_name']);
                  $this->sendValidationLink($resendCode,$resendName,$resendEmail);
                  $this->promtMessage = array('status'=>'success','message'=>'Yehey! Validation code resent! Check you email.');
              }
          }
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($this->promtMessage));
      return $this->response->send();
    }
    public function login () {
      $this->layout = false;
      $data = $this->request->input('json_decode', true);
      if ($this->CheckRequest('post')) { 
          $this->promtMessage = array('status'=>'failed', 'message'=>'Please complete the fields');
          if (empty($data)) {
              $data = $this->request->data;
          } elseif (!empty($data)) {
              $data['username'] = $this->cleanString($data['username']);
              $data['password'] = $this->cleanString($data['password']);
              $record = $this->User->find('first', array( 'conditions' => array('BINARY User.username = '.'\''. $data['username'].'\'')));
              if (empty($record)) {
                  $this->promtMessage = array('status'=>'failed', 'message'=>'Whoops, login failed');
              } else {
                  if ($record['User']['activation_status']) {
                      if ($this->checkPassword($data['password'],$record['User']['password'])) {
                          $token = $this->createToken($data['username']);
                          $this->Session->write('User.token',$token );
                          $this->Session->write('User.id',$record['User']['id']);
                          $this->promtMessage = array('status'=>'success', 'message'=>'Login success, Welcome!','token'=>$token);
                      } else {
                          $this->promtMessage = array('status'=>'failed', 'message'=>'Whoops, login failed');
                      }
                  } else {
                      $this->promtMessage = array('status'=>'failed', 'message'=>'The account you are using is not activated yet');
                  }
              }
          }
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($this->promtMessage));
      return $this->response->send();
    }
    public function authenticate () {
      $this->layout = false;
      $data = $this->request->input('json_decode', true);
      if ($this->CheckRequest('post')) {
          $this->promtMessage = array('status'=>'failed', 'message'=>'Please complete the fields');
          if (empty($data)) {
              $data = $this->request->data;
          } elseif (!empty($data)) {
              if ($this->Session->check('User.token')) {
                  $baseToken = $this->Session->read('User.token');
                  if ($data['token'] === $baseToken) {
                      $this->promtMessage = array('status'=>'success', 'message'=>'Login success, Welcome!');
                  }
              }
          }
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($this->promtMessage));
      return $this->response->send();
    }
    public  function logout () {
      $this->layout = false;
      $data = $this->request->input('json_decode', true);
      if ($this->CheckRequest('post')) { 
        if($this->Session->destroy()) {
            //$this->promtMessage = array('status'=>'success', 'message'=>$data['token']);
        };
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($this->promtMessage));
      return $this->response->send();
    }
    public  function getProfile () {
      $this->layout = false;
      $data = $this->request->input('json_decode', true);
      if ($this->CheckRequest('post')) { 
          if (empty($data)) {
              $this->promtMessage = array('status'=>'failed', 'message'=>'Please complete the fields');
          } elseif (!empty($data)) { 
              $this->promtMessage = array('status'=>'failed', 'message'=>'Please relogin');
              if ($this->Session->check('User.token')) {
                  $baseToken = $this->Session->read('User.token');
                  if ($data['token'] === $baseToken) {
                      $id = $this->Session->read('User.id');
                      $record = $this->User->find('first', array( 'conditions' => array('User.id' => $id)));
                      $record['User']['date_of_birth'] = date("M d, Y", strtotime($record['User']['date_of_birth']));
                      $record['User']['first_name'] = $this->capitalizeFirstLetter($record['User']['first_name']);
                      $record['User']['last_name'] = $this->capitalizeFirstLetter($record['User']['last_name']);
                      $record['User']['id'] = $this->idEncryption($record['User']['id']);
                      $this->promtMessage = array('status'=>'success', 'record'=>$record);
                  }
              }
          }
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($this->promtMessage));
      return $this->response->send();
    }
    public function profilePic () {
      $this->layout = false;
      if ($this->CheckRequest('post')) { 
          if ($this->CheckSession('User.token')) {
              $data = $this->request->data; 
              $baseToken = $this->Session->read('User.token');
              if ($data['token'] === $baseToken) {
                  $this->promtMessage = array('status'=>'failed', 'message'=>'Please complete the fields');
                  if (empty($_FILES['file'])) {
                      $this->promtMessage = array('status'=>'failed', 'message'=>'No photo was sent');
                  } else {
                      $userId = $this->Session->read('User.id');
                      $img = $_FILES['file']['name'][0];
                      $tmp = $_FILES['file']['tmp_name'][0];
                      $path = '../../../pic-profiles/';
                      $extension = pathinfo($img, PATHINFO_EXTENSION);
                      $imgNewName = strtolower($userId.$this->createCode()."-profilepic.".$extension);
                      $path = $path. $imgNewName;
                      $this->User->id = $userId;
                      if ($_FILES['file']['size'][0] <= 2000000) {
                          if ($this->User->saveField('image',$imgNewName)) {
                              if (move_uploaded_file($tmp,$path)) {
                                  $this->promtMessage = array('status'=>'success', 'message'=>"Image uploaded to server and database");
                              }
                          } 
                      } else {
                          $this->promtMessage = array('status'=>'failed', 'message'=>'Image should not be more than 2mb in size');
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
    public function editProfile () {
      $this->layout = false;
      if ($this->CheckRequest('post')) {
          if ($this->CheckSession('User.token')) {
              $this->promtMessage = array('status'=>'failed', 'message'=>'record not found');
              $data = $this->request->input('json_decode', true);
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              $data['id'] = $this->idDecryption($data['id']);
              if ($data['token'] === $baseToken && $baseId === $data['id']) {  
                  if (empty($data)) {
                      $data = $this->request->data;
                  } elseif (!empty($data)) {
                      $record = $this->User->find('first', array( 'conditions' => array('User.id' => $data['id'])));
                      if (!empty($record)) {
                          if ($this->checkPassword($data['old_password'],$record['User']['password'])) {
                              $this->User->id = $data['id'];
                              unset($data['old_password']);
                              if ($this->User->save($data,true,['username','password','email','first_name','middle_name','last_name','date_of_birth'])) { 
                                  $this->promtMessage = array('status'=>'success', 'message'=>'Profile successfuilly updated!');
                              } else {
                                  $errorList = ['Notice :'];
                                  $errors = $this->User->validationErrors;
                                  foreach ($errors as $value) {
                                  array_push($errorList," ".$value[0]);
                                }
                                $this->promtMessage = array('status'=>'failed', 'message'=> $errorList);
                              }
                          } else {
                              $this->promtMessage = array('status'=>'failed', 'message'=>'Wrong old password');
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
    public  function showProfile () {
      $this->layout = false;
      $userId = $this->request->query('user_id');
      $userId = $this->cleanNumber($this->idDecryption($userId));
      $searchId = $this->request->query('search_id');
      $searchId = $this->cleanNumber($this->idDecryption($searchId));
      $token = $this->cleanString($this->request->query('token'));
      if ($this->CheckRequest('get')) {
          $this->promtMessage = array('status'=>'failed', 'message'=>'User not found');
          if ($this->CheckSession('User.token')) {
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              if ($token === $baseToken && $baseId === $userId) {
                  $record = $this->User->find('first', array( 'conditions' => array('User.id' => $searchId),'fields' => array('id','first_name','middle_name','last_name','date_of_birth','username','image')));
                  if (!empty($record)) {
                      $record['User']['date_of_birth'] = date("M d, Y", strtotime($record['User']['date_of_birth']));
                      $record['User']['first_name'] = $this->capitalizeFirstLetter($record['User']['first_name']);
                      $record['User']['last_name'] = $this->capitalizeFirstLetter($record['User']['last_name']);
                      $this->promtMessage = array('status'=>'success', 'record'=>$record);
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