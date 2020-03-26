<?php 
  // app/Controller/UsersController.php
  App::uses('AppController', 'Controller');
  App::uses('CakeEmail', 'Network/Email');

  class CodeGenerator {
    private $code;
    public function createCode () {
      $this->code = rand(1000, 9999); 
      return $this->code;
    }
  }
  class EmailValidation {
    private $link;
    private $name;
    private $token;
    
    public function sendValidationLink ($token,$name) {
      $this->link = 'http://192.168.254.168/microblog-2/signup.php?token=' . $token;
      $this->name = $name;
      $this->token = $token;
      $Email = new CakeEmail();
      $Email->config('gmail');
      $Email->from(array('microblog.yns@gmail.com' => 'Microblog Account'));
      $Email->to('kennethybanez.yns@gmail.com');
      $Email->subject('About');
      $Email->template('default', 'default');
      $Email->emailFormat('html');
      $Email->viewVars(array('link' => $this->link,'name' => $this->name,'token' => $this->token ));
      $Email->send();
    }
  }
  
  class UsersController extends AppController {
    public function add() {
      $this->layout = false;
      $emailSender = new EmailValidation();
      $codeGenerator = new CodeGenerator();
      // default error response
      if ($this->CheckRequest('post')) {
          $this->promtMessage = array('status'=>'failed', 'message'=>'Please complete the fields');
          $data = $this->request->input('json_decode', true);
          $data['code'] = 'MB-'. $codeGenerator->createCode();
          echo json_encode($data);
          if (empty($data)) {
              $data = $this->request->data;
          }
          // check if data in not empty
          if (!empty($data)) {
              $name = $data['first_name'];
              $code = $data['code'];
              $duplicateCount = $this->User->find('count', array(
                  'conditions' => array('User.username' => $data['username'])
              ));
              // check if username is existing
              if ($duplicateCount === 0) {
                  // saving user
                  if ($this->User->save($data)) {
                      $this->Flash->success(__('The user has been saved'));
                      $this->promtMessage = array('status'=>'success','message'=>'User successfully signed up!');
                      $emailSender->sendValidationLink($code,$name);
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
  }
?>