<?php 
  // app/Controller/UsersController.php
  App::uses('AppController', 'Controller');
  App::uses('CakeEmail', 'Network/Email');

  class EmailValidation {
    private $link;
    private $name;
    
    public function sendValidationLink ($token,$name) {
      $this->link = 'http://192.168.254.168/microblog-2/signup.php?token=' . $token;
      $this->name = $name;
      $Email = new CakeEmail();
      $Email->config('gmail');
      $Email->from(array('microblog.yns@gmail.com' => 'Microblog Account'));
      $Email->to('kennethybanez.yns@gmail.com');
      $Email->subject('About');
      $Email->template('default', 'default');
      $Email->emailFormat('html');
      $Email->viewVars(array('link' => $this->link,'name' => $this->name ));
      $Email->send();
    }
  }
  
  class UsersController extends AppController {
    public function add() {
      $this->layout = false;
      // default error response
      $response = array('status'=>'failed', 'message'=>'Please complete the fields');
      if ($this->request->is('post')) {
          $data = $this->request->input('json_decode', true);
          //echo json_encode($data);
          if (empty($data)) {
              $data = $this->request->data;
          }
          // check if data in not empty
          if (!empty($data)) {
              $name = $data['first_name'];
              $duplicateCount = $this->User->find('count', array(
                  'conditions' => array('User.username' => $data['username'])
              ));
              // check if username is existing
              if ($duplicateCount === 0) {
                  // saving user
                  if ($this->User->save($data)) {
                      $this->Flash->success(__('The user has been saved'));
                      $response = array('status'=>'success','message'=>'User successfully signed up!');
                      $emailSender = new EmailValidation();
                      $emailSender->sendValidationLink('token12345',$name);
                  } else {
                      $errorList = [];
                      $errors = $this->User->validationErrors;
                      foreach ($errors as $value) {
                        array_push($errorList," ".$value[0]);
                      }
                      $response = array('status'=>'failed', 'message'=> $errorList);
                  }
              } else {
                  // response if email/username is existing
                  $response = array('status'=>'failed','message'=>'Username already taken');
              }
          }
      } else {
          // response if email/username is existing
          $response = array('status'=>'failed', 'message'=>'HTTP method not allowed');
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($response));
      return $this->response->send();
    }
  }
?>