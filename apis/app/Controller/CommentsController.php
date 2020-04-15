<?php 
  App::uses('AppController', 'Controller');
  App::uses('CakeEmail', 'Network/Email');

  class CommentsController extends AppController { 
    public function viewComments () {
      $this->layout = false;
      $userId = $this->cleanNumber($this->request->query('id'));
      $postId = $this->cleanNumber($this->request->query('postId'));
      $token = $this->cleanString($this->request->query('token'));
      if ($this->CheckRequest('get')) {
          if ($this->CheckSession('User.token')) {
              $this->promtMessage = array('status'=>'failed', 'message'=>'records not found');
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              if ($token === $baseToken && $baseId === $userId) {
                  
                  $comments =  $this->Comment->find('all',array(
                    'conditions'=>array('Comment.post_id'=>$postId,'Comment.deleted'=>1),
                    'order'=> array('Comment.created ASC'),
                  ));
                  if (!empty($comments)) {
                      $this->promtMessage = array('status'=>'success','record'=>$comments);
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
    public function saveComment () {
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
                      if ($this->Comment->save($data)) { 
                          $this->promtMessage = array('status'=>'success','message'=>'comment saved');
                      } else {
                          $errorList = ['Notice :'];
                          $errors = $this->Comment->validationErrors;
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

