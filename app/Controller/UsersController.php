<?php 
  // app/Controller/UsersController.php
  App::uses('AppController', 'Controller');

  class UsersController extends AppController {
    public function add() {
      $this->layout = false;
      if ($this->request->is('post')) {
          $data = $this->request->input('json_decode', true);
          echo json_encode($data);
          if (empty($data)) {
              $data = $this->request->data;
          }
          $response = array('status'=>'failed', 'message'=>'Please provide form data');
          if (!empty($data)) {
              if ($this->User->save($data)) {
                  $this->Flash->success(__('The user has been saved'));
                  $response = array('status'=>'success','message'=>'Product successfully created');
                  //return $this->redirect(array('action' => 'add'));
              } else {
                  $response = array('status'=>'failed', 'message'=>$this->User->validationErrors);
              }
              // $this->Flash->error(
              //   __('The user could not be saved. Please, try again.')
              // );
          }
      } else {
          $response = array('status'=>'failed', 'message'=>'HTTP method not allowed');
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($response));
      return $this->response->send();
    }
  }
?>