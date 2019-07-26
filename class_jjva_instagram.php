<?php 
require 'vendor/autoload.php';
class jjva_instagram {
    private $endpoint = "https://www.instagram.com/thecraze_/?__a=1";
    private $thumbnail_width  = '150px';
    private $thumbnail_height = '150px';
    function __construct() {
		add_shortcode('jjva_instagram', array($this, 'printShortcode'));         
    }
    function printShortcode() {
        return "<div class='container'>
        <div class='col-md-12'>
            <div class='card profile-card-2'>
                <div class='card-img-block'>
                    <img class='img-fluid' src='".plugins_url('assets/images/craze.jpg', __FILE__ ) ."' alt='Card image cap'>
                </div>
                <div class='card-body pt-5'>
                    <img src=" .  $this->getUserProfilePic() ." alt='profile-image' class='profile'/>
                        <div class='row'>
                        <div class='col-md-6'>
                            <h5 class='card-title'>". $this->getUserProfileName() ."</h5>
                            <span>
                              <b>".  $this->getUserFollowers()."</b> seguidores</span> |
                              <b>".  $this->getUserfollows()."</b> seguidos
                        </div>
                        <div class='col-md-6 '>
                        <div class='float-right'>
                        <a href='https://www.instagram.com/thecraze_/' target='_blank' style='background-color:#af1f4b !important ; color: #FFFFFF !important' class='btn'>Seguir</a>
                        </div>
                            
                        </div>
                        </div>
                        <hr>
                        <div class='row masonry-grid'>
                            ".  $this->getImages() ."
                        </div>
                        <hr>
                 </div>
            </div>
         </div>
    </div>";
    }
    function connect($endpoint) {
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->endpoint);
        $statusCode = $res->getStatusCode();
        return $statusCode;
    }
    function getData() {
 
        $status =  $this ->connect($this->endpoint);
        switch($status) {
            case "200":
               $client = new GuzzleHttp\Client();
               $res = $client->request('GET', $this->endpoint);
               $data=json_decode($res->getBody(),true);//converts in array
                return $data;
            break;
            case "500":
                return "Error de conexion";
            break;
        } 

        
    }

    function getImages() {
      $query =  $this ->connect($this->endpoint);
      switch($query) {
        case "200":
            $dat   =  $this->getData();
            $arrayD = $dat['graphql']['user']['edge_owner_to_timeline_media']['edges'];
            $images = '';
            foreach($arrayD as $key=>$val){// this can be ommited if only 0 index is there after 
                 $images.=  $this->parseArray($val['node']);
            }
            return $images;
        break;
        case "500":

        break;
      }
    }
    function getUserProfileName() {
        $query =  $this ->connect($this->endpoint);
      switch($query) {
        case "200":
            $dat   =  $this->getData();
            $arrayD = $dat['graphql']['user'];
                return $arrayD['full_name'];
         break;
        case "500":

        break;
      }
    }
    function getUserProfilePic() {
        $query =  $this ->connect($this->endpoint);
      switch($query) {
        case "200":
            $dat   =  $this->getData();
            $arrayD = $dat['graphql']['user'];
                return $arrayD['profile_pic_url'];
         break;
        case "500":

        break;
      }
    }
    function getUserFollowers() {
        $query =  $this ->connect($this->endpoint);
      switch($query) {
        case "200":
            $dat   =  $this->getData();
            $arrayD = $dat['graphql']['user']['edge_followed_by'];
                return $arrayD['count'];
         break;
        case "500":

        break;
      }
    }
    function getUserFollows() {
        $query =  $this ->connect($this->endpoint);
      switch($query) {
        case "200":
            $dat   =  $this->getData();
            $arrayD = $dat['graphql']['user']['edge_follow'];
               return $arrayD['count'];
         break;
        case "500":

        break;
      }
    }
    function parseArray($array) { 
        if (is_array($array)) {
            $array_images = [];
            $tmp_images = [];
            // $tmp_images = array_push($array_images, $array['thumbnail_src']);
            $element =  $array['thumbnail_src'] ;
            $tmp_images = array_push($array_images, $element); 
            $images = '';    
            for($i = 0 ; $i < count($array_images); $i++) {
               $images.=  " <div class='masonry-column col-md-3 col-6 col-xs-4 col-sm-4 '>    <a href='". $array_images[$i] . "' data-rel='lightcase'>
               <img style='padding-bottom:5px;border-radius:25px;' class='img-thumbnail img-fluid' width='".$thumbnail_width."' height='". $thumbnail_height. "' src='". $array_images[$i] . "'>
              <span style='display:block;font-size:10px; text-align:center'><i style='color:red;font-size:10px;' class='fas fa-heart'></i> &nbsp;".$array['edge_liked_by']['count']."</span></a></div>";
            }  
            return $images;
        }
    }
 
} // END CLASS
$jjva_instagram = new jjva_instagram();

?>