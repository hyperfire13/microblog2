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
              $duplicateCount = $this->User->find('count', array(
                  'conditions' => array('User.username' => $data['username'])
              ));
              // check if username is existing
              if ($duplicateCount === 0) {
                  // saving user
                  if ($this->User->save($data)) {
                      $this->Flash->success(__('The user has been saved'));
                      $this->promtMessage = array('status'=>'success','message'=>'Yehey! You are now registered!');
                      $this->sendValidationLink($code,$name,$email);
                  } else {
                      $errorList = [];
                      $errors = $this->User->validationErrors;
                      foreach ($errors as $value) {
                        array_push($errorList," ".$value[0]);
                      }
                      $this->promtMessage = array('status'=>'failed', 'message'=> $errorList);
                  }
              } else {
                    // response if email/username is existing
                    $this->promtMessage = array('status'=>'failed','message'=>'Username already taken');
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
              $data = array_map('trim', $data) ;
              $record = $this->User->find('first', array( 'conditions' => array('User.code' => $data['code'])));
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
              $record = $this->User->find('first', array( 'conditions' => array('User.username' => $data['username'])));
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
                      $path = $path.strtolower($userId."-profilepic.".$extension);
                      $imgNewName = strtolower($userId."-profilepic.".$extension);
                      $this->User->id = $userId;
                      if ($this->User->saveField('image',$imgNewName)) { 
                          if (move_uploaded_file($tmp,$path)) {
                              $this->promtMessage = array('status'=>'success', 'message'=>"Image uploaded to server and database");
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
  }
?>