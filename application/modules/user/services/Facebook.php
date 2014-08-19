<?php

/**
 * Service
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class User_Service_Facebook extends MF_Service_ServiceAbstract {
    
    protected $facebook;
    protected $userId;
    
    public function init() {
        require_once('php-sdk/facebook.php');
        
          $config = array(
            'appId' => '1498520680377806',
            'secret' => 'e25175e33663ee5a05f2d2d111907297',
              
            'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
          );
            $this->userId = "307849886046563";
            $this->facebook = new Facebook($config);

    }
    
    public function publishNews($name,$message, $url,$photo) {
        $access_token = "CAAVS5YjXrc4BAO8ZAfiqJ4wPYXijAH6ewi4tvnvJNOhN3WjdjLWOKTnEk23JaY0Q1dM5g9lRKZAfGGsfqwBBZCEiIBeqbyvzZA0PlZB4AagXZAyF9uUDewYe3tzZAuAJDA5seULrIuwT0K92wr7MP9dMGlHfmAFZA6COCQEsGjVSdMmjKXUs6gIFThHCuDjXp2PlqnwJsJenIQZDZD";
      
      
      $token = $this->facebook->getExtendedAccessToken($access_token);
      $appsecret_proof= hash_hmac('sha256', $token, "e25175e33663ee5a05f2d2d111907297");
      $ret_obj = $this->facebook->api('/'.$this->userId.'/feed', 'POST',
      array(
          "access_token" => $token,
          "appsecret_proof" => $appsecret_proof,
          'link' => $url,
          'name' => $name,
          'message' => $message,
          'picture' => $photo
     ));
    }
    
}

