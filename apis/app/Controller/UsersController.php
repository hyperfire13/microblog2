<?php 
  // app/Controller/UsersController.php
  App::uses('AppController', 'Controller');
  App::uses('CakeEmail', 'Network/Email');

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
              $duplicateCount = $this->User->find('count', array(
                  'conditions' => array('User.username' => $data['username'])
              ));
              // check if username is existing
              if ($duplicateCount === 0) {
                  // saving user
                  if ($this->User->save($data)) {
                      $this->Flash->success(__('The user has been saved'));
                      $response = array('status'=>'success','message'=>'User successfully signed up!');
                      $Email = new CakeEmail();
                      $Email->config('gmail');
                      $Email->from(array('microblog.yns@gmail.com' => 'Microblog Account'));
                      $Email->to('kennethybanez.yns@gmail.com');
                      $Email->subject('About');
                      $Email->send('Clck the link below to verify your email');
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