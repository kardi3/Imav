<?php

/**
 * Service
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class User_Service_GooglePlus extends MF_Service_ServiceAbstract {
    
    protected $google;
    protected $userId;
    
    public function init() {
        require_once 'Google/Client.php';
        require_once 'Google/Service/Books.php';
        $client = new Google_Client();
        $client->setApplicationName("Client_Library_Examples");
        $client->setDeveloperKey("YOUR_APP_KEY");
        $service = new Google_Service_Books($client);
        $optParams = array('filter' => 'free-ebooks');
        $results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);

        foreach ($results as $item) {
            echo $item['volumeInfo']['title'], "<br /> \n";
        }

    }
    
    public function publishNews($name,$message, $url,$photo) {
        $access_token = "CAAVS5YjXrc4BAO8ZAfiqJ4wPYXijAH6ewi4tvnvJNOhN3WjdjLWOKTnEk23JaY0Q1dM5g9lRKZAfGGsfqwBBZCEiIBeqbyvzZA0PlZB4AagXZAyF9uUDewYe3tzZAuAJDA5seULrIuwT0K92wr7MP9dMGlHfmAFZA6COCQEsGjVSdMmjKXUs6gIFThHCuDjXp2PlqnwJsJenIQZDZD";
      
      
      $token = $this->google->getExtendedAccessToken($access_token);
      $appsecret_proof= hash_hmac('sha256', $token, "e25175e33663ee5a05f2d2d111907297");
      $ret_obj = $this->google->api('/'.$this->userId.'/feed', 'POST',
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

