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
              $record = $this->User->find('first', array( 'conditions' => array('User.code' => $data['code'])));
              if (empty($record)) {
                  $this->promtMessage = array('status'=>'failed', 'message'=>'Whoops, you entered an invalid code');
              } else {
                  unset($record['User']['modified']);
                  if (!$record['User']['activation_status']) {
                      $record['User']['activation_status'] = 1;
                      $this->User->id = $record['User']['id'];
                      if ($this->User->save($record)) { 
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
                  if ($this->checkPassword($data['password'],$record['User']['password'])) {
                      $this->promtMessage = array('status'=>'success', 'message'=>'Login success, Welcome!');
                  } else {
                      $this->promtMessage = array('status'=>'failed', 'message'=>'Whoops, login failed');
                  }
                 
              }
          }
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($this->promtMessage));
      return $this->response->send();
    }
  }
?>