<?php 
  App::uses('AppController', 'Controller');
  App::uses('CakeEmail', 'Network/Email');

  class LikesController extends AppController {
    public function likePost () {
      $this->layout = false;
      $data = $this->request->input('json_decode', true);
      if ($this->CheckRequest('post')) { 
          if ($this->CheckSession('User.token')) { 
              $this->promtMessage = array('status'=>'failed', 'message'=>'records not found');
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              $data['user_id'] = $this->idDecryption($data['user_id']);
              if ($data['token'] === $baseToken && $baseId === $data['user_id']) { 
                  if (empty($data)) {
                      $data = $this->request->data;
                  } elseif (!empty($data)) { 
                      $duplicateCount = $this->Like->find('count', array(
                        'conditions' => array('Like.user_id' => $data['user_id'],'Like.post_id' => $data['post_id'],'Like.deleted' => 1)
                      ));
                      if ($duplicateCount < 1) {
                          if ($this->Like->save($data)) {
                              $this->promtMessage = array('status'=>'success','message'=>'You like this post');
                          } else {
                              $errorList = ['Notice :'];
                              $errors = $this->Like->validationErrors;
                              foreach ($errors as $value) {
                              array_push($errorList," ".$value[0]);
                              } 
                              $this->promtMessage = array('status'=>'failed', 'message'=> $errorList);
                          }
                      } else {
                          $likeId = $this->Like->find('first',array('conditions' => array('Like.user_id' => $data['user_id'],'Like.post_id' => $data['post_id'],'Like.deleted' => 1),'fields' => array('id')));
                          $this->Like->id = $likeId['Like']['id'];
                          $data['date_deleted'] = date("Y-m-d H:i:s");
                          $data['deleted'] = false;
                          if ($this->Like->save($data,true,['date_deleted','deleted'])) {
                              $this->promtMessage = array('status'=>'unlike','message'=>'You unlike this post');
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

