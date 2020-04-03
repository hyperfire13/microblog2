<?php 
  App::uses('AppController', 'Controller');
  App::uses('CakeEmail', 'Network/Email');

  class PostsController extends AppController { 
    
    public function viewMyBlogs () {
      $this->layout = false;
      $userId = $this->request->query('id');
      $token = $this->request->query('token');
      $page = $this->request->query('page');
      $size = $this->request->query('size');
       
      if ($this->CheckRequest('get')) {
          if ($this->CheckSession('User.token')) {
              $this->promtMessage = array('status'=>'failed', 'message'=>'records not found');
              $baseToken = $this->Session->read('User.token');
              $baseId = $this->Session->read('User.id');
              if ($token === $baseToken && $baseId === $userId) {
                  $offset = ($page - 1) * $size;
                  $blogs =  $this->Post->find('all',array(
                    'conditions'=>array('Post.user_id'=>$userId,'Post.deleted'=>1),
                    'limit'=>$size,
                    'order'=> array('Post.created DESC'),
                    'offset'=>$offset
                  ));
                  if (!empty($blogs)) {
                      $this->promtMessage = array('status'=>'success','total'=>sizeof($blogs) ,'record'=>$blogs);
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