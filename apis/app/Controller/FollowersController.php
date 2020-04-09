<?php 
  App::uses('AppController', 'Controller');
  App::uses('CakeEmail', 'Network/Email');

  class FollowersController extends AppController { 
    public function viewFollowing () {
      $this->layout = false;
      $userId = $this->cleanNumber($this->request->query('id'));
      $token = $this->cleanString($this->request->query('token'));
      if ($this->CheckRequest('get')) {
          if ($this->CheckSession('User.token')) {
              $this->promtMessage = array('status'=>'failed', 'message'=>'records not found');
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              if ($token === $baseToken && $baseId === $userId) {
                  $followers =  $this->Follower->find('all',array(
                    'conditions'=>array('Follower.user_id'=>$userId,'Follower.deleted'=>1),
                    'order'=> array('Follower.created ASC'),
                  ));
                  if (!empty($followers)) {
                      $this->promtMessage = array('status'=>'success','record'=>$followers);
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
    public function viewFollowers () {
      $this->layout = false;
      $userId = $this->cleanNumber($this->request->query('id'));
      $token = $this->cleanString($this->request->query('token'));
      if ($this->CheckRequest('get')) {
          if ($this->CheckSession('User.token')) {
              $this->promtMessage = array('status'=>'failed', 'message'=>'records not found');
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              if ($token === $baseToken && $baseId === $userId) {
                  $followers =  $this->Follower->find('all',array(
                    'conditions'=>array('Follower.following_id'=>$userId,'Follower.deleted'=>1),
                    'order'=> array('Follower.created ASC'),
                  ));
                  if (!empty($followers)) {
                      $this->promtMessage = array('status'=>'success','record'=>$followers);
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

