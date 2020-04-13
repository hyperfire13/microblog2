<?php
  /**
   * Application level Controller
   *
   * This file is application-wide controller file. You can put all
   * application-wide controller-related methods here.
   *
   * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
   * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
   *
   * Licensed under The MIT License
   * For full copyright and license information, please see the LICENSE.txt
   * Redistributions of files must retain the above copyright notice.
   *
   * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
   * @link          https://cakephp.org CakePHP(tm) Project
   * @package       app.Controller
   * @since         CakePHP(tm) v 0.2.9
   * @license       https://opensource.org/licenses/mit-license.php MIT License
   */

  App::uses('Controller', 'Controller');
  App::uses('CakeEmail', 'Network/Email');
  App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
  App::uses('CakeTime', 'Utility');
  /**
   * Application Controller
   *
   * Add your application-wide methods in the class below, your controllers
   * will inherit them.
   *
   * @package		app.Controller
   * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
   */
  class AppController extends Controller {
    // check method variables
    private $requestMethod;
    private $session;
    public $promtMessage;
    // email sender variables
    public $link;
    public $name;
    public $token;
    public $email;
    // code for validation
    private $code;

    public function sendValidationLink ($token,$name,$email) {
      try {
          $this->link = '/activate-user.php';
          $this->name = $name;
          $this->token = $token;
          $this->email = $email;
          $Email = new CakeEmail();
          $Email->config('gmail');
          $Email->from(array('microblog.yns@gmail.com' => 'Microblog Team'));
          $Email->to($this->email);
          $Email->subject('About');
          $Email->template('default', 'default');
          $Email->emailFormat('html');
          $Email->viewVars(array('link' => $this->link,'name' => $this->name,'token' => $this->token ));
          $Email->send();
      } catch (Exception $e) {
          $this->promtMessage = array('status'=>'emailProblem', 'message'=>'There is a problem sending verification code to email');
      }
    }

    public function CheckRequest ($method) {
      $this->requestMethod = $method;
      if ($this->request->is($this->requestMethod)) {
          return true;
      } else {
          $this->promtMessage = array('status'=>'failed', 'message'=>'wrong request method');
          return false;
      }
    }

    public function CheckSession ($session) {
      $this->session = $session;
      if ($this->Session->check($this->session)) { 
          return true;
      } else {
          $this->promtMessage = array('status'=>'failed', 'message'=>'unauthorized');
          return false;
      }
    }
    
    public function createCode () {
      $this->code = rand(1000, 999999); 
      return $this->code;
    }

    public function capitalizeFirstLetter ($word) {
      $formattedWord = ucwords($word);
      return $formattedWord;
    }

    public function checkPassword ($pw,$basePw) {
      $passwordHasher = new BlowfishPasswordHasher();
      $pw = $passwordHasher->check($pw,$basePw);
      return $pw;
    }

    public function createToken ($username) {
      $passwordHasher = new BlowfishPasswordHasher();
      $token = $passwordHasher->hash($username);
      return $token;
    }

    public function cleanString($value) {

      // Removes leading and trailing spaces
      $data = trim($value);
  
      // Removes Unwanted Characters
      $data = filter_var($data, FILTER_SANITIZE_STRING);
  
      // Sanitizes HTML Characters
      $data = htmlspecialchars_decode($data, ENT_QUOTES);
  
      return $data;
    }

    public function cleanNumber($value) {

      // Removes leading and trailing spaces
      $data = trim($value);

      // Removes Unwanted Characters
      $data = filter_var($data, FILTER_SANITIZE_NUMBER_INT);

      // Sanitizes HTML Characters
      $data = htmlspecialchars_decode($data, ENT_QUOTES);

      return $data;
    }
  }
