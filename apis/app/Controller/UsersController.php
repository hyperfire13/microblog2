<?php 
  // app/Controller/UsersController.php
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
          $data['code'] = 'MB-'. $this->createCode();
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
              // $duplicateCount = $this->User->find('count', array(
              //     'conditions' => array('User.username' => $data['username'])
              // ));
              $record = $this->User->find('first', array( 'conditions' => array('User.username' => $data['username'])));
              if (empty($record)) {
                  $this->promtMessage = array('status'=>'success', 'message'=>'Email not found');
              } else {
                  echo $record['User']['email'];
              }
              
              
          }
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($this->promtMessage));
      return $this->response->send();
    }
  }
?>