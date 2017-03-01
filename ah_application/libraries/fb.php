<?php
//include_once(dirname(__FILE__)."FBconfig.php");
include_once 'facebook.php';

class Fb {
    private /*facebook obj*/ $facebook;
    private /*string*/$facebook_app_id;
    private /*string*/$facebook_secret;
    private /*string*/$access_token;
    
    private /*array*/ $friends;
    private /*array*/ $me;
        
    public function __construct($config){
        $this->facebook_app_id = $config["facebook_app_id"];
        $this->facebook_secret = $config["facebook_secret"];
        
     //   $this->fb_connect = $config["fb_connect"]; 
        if ($this->facebook_app_id!="" && $this->facebook_secret!=""){
            $this->facebook = new Facebook(array(
  			    	'appId'  => $this->facebook_app_id,
  					'secret' => $this->facebook_secret,
  					'cookie' => true,
            		'fileUpload' => $config["fileUpload"]
            ));
        }             
    }
	
	public /*bool*/ function get_access_token_from_fb($config){  //config包括  req_perms,redirect_uri,next,cancel_url
	    if (empty($this->facebook_app_id)){
	        return false;
	    }
	    if (empty($this->facebook_secret)){
	        return false;
	    }	    
        $session = $this->facebook->getSession();

        if (!$session ) {
            $url=$this->facebook->getLoginUrl($config);
            echo "<script type='text/javascript'>top.location.href = '".$url."';</script>";
            return false;
        }else{
            $this->access_token=$session['access_token'];
            
        }
        return true;
    }
   	public /*bool*/ function get_access_token(){
   	    return $this->access_token;
   	}	
	public /*string,friends*/ function get_friends_from_fb(){ //抓好友
        $error="";
        if (empty($this->access_token)){
            return "error:no access_token";
        }
        $attachment =  array('access_token' => $this->access_token);        
        try {     
            $this->friends = $this->facebook->api('/me/friends','GET',$attachment);
            return $this->friends;
        } catch (FacebookApiException $e) {     
            return "error:".$e;
        }
        return $error;  	    
    }
	
	public /*string,me*/ function get_me_from_fb(){ //抓從fb自己資料
        if (empty($this->access_token)){
            return "error:no access_token";
        }
        //取得該使用者的id
        $attachment =  array('access_token' => $this->access_token);
        try {     
            $this->me = $this->facebook->api('/me','GET',$attachment);
            return $this->me;
        }catch (FacebookApiException $e) {
   	        return "error:".$e;
       }   	
    }
    
	public /*me*/ function get_me(){ 
	    return $this->me;
	}
	
	public /*img*/ function get_avatar($fb_id,$type="large",$width=100,$height=100){  //抓任一人的大頭照(大張)
	    switch ($type){
	        case "large":
            case "small":
	            return file_get_contents("https://graph.facebook.com/".$fb_id."/picture?type=".$type);
	            break;
            case "define":    //自定size
            	return file_get_contents("https://graph.facebook.com/".$fb_id."/picture?width=".$width."&height=".$height);
            	break;
	        default:
	            return file_get_contents("https://graph.facebook.com/".$fb_id."/picture?type=large");
	            break;
	    }
	}
	
	public /*string*/ function check_is_fans($fans_id){ //判斷有無加入粉絲團(按下讚) 

        if (!isset($this->me["id"]) || empty($this->me["id"])){
            return "error:no me";
        } 
        try {
            $likeID = $this->facebook->api( array( "method" => "fql.query", "query" => "SELECT uid, page_id FROM page_fan WHERE  uid=".$this->me["id"]." AND page_id=".$fans_id ));
            

            if (empty($likeID) ) {
    	        $islikes=false;
            }
            else{
    	        $islikes=true;
            }
        }catch (FacebookApiException $e) {
   	        return "error:".$e;
        }   	
		return $islikes;
    }
    public /*string*/ function check_is_fans_2($fans_id){ //判斷有無加入粉絲團(按下讚) 第二種query方式
    
    	if (!isset($this->me["id"]) || empty($this->me["id"])){
    		return "error:no me";
    	}
    	try {
    		$likeID = $this->facebook->api( array( "method" => "fql.query", "query" => "SELECT uid, page_id FROM page_fan WHERE  uid=".$this->me["id"]." AND page_id=".$fans_id ));
    
    		if (empty($likeID) ) {
    			$islikes=false;
    		}
    		else{
    			$islikes=true;
    		}
    	}catch (FacebookApiException $e) {
    		return "error:".$e;
    	}
    	return $islikes;
    }
    
    public function get_checkins($uid="me()",$limit=1){
    	if (empty($this->access_token)){
    		return "error:no access_token";
    	}   
    	try { 	
    		$checkins= $this->facebook->api( array( "method" => "fql.query", "query" => "SELECT coords, tagged_uids, page_id,timestamp FROM checkin WHERE author_uid=".$uid."  order by timestamp desc limit 0,".$limit , "access_token" => $this->access_token ));
    		
   		}catch (FacebookApiException $e) {
   			return "error:".$e;
   		}
   		return $checkins;    	    	
    }
	public /*string*/ function check_publish_auth(){//先判斷有沒有發佈到塗鴨牆的權限
        if (empty($this->access_token)){
            return "error:no access_token";
        }
	    
	    $perms="publish_stream";
	    try {
    	    $permission = $this->facebook->api( array( 'method' => 'users.hasapppermission', 'ext_perm' => $perms ,'access_token' => $this->access_token) );
    	    return $permission;
        }catch (FacebookApiException $e) {
   	        return "error:".$e;
        }   	
    }
	
	public function set_access_token($access_token){  //設定access_token 避免每次都要去跟facebook重要一次
	    $this->access_token=$access_token;
    }
	
	public function add_publish_auth(){  //導到加入發佈到塗鴨牆的權限頁
           
	    $perms="publish_stream";            
	    $url = $this->facebook->getLoginUrl(array('req_perms' => $perms));
	
    	echo "<script type='text/javascript'>self.location.href = '$url';</script>";	
    }
    
	public function publish($fb_id,$publish_parameters){  
		/*$publish_parameters=array(
		 'message' => 'message default',
				'name' => '【時尚搶包】下載APP，機票、Prada包送給你！',
				'caption' => 'caption',
				'link' => 'http://www.fashionguide.com.tw',
				'description' => '經濟不景氣，但…又想出國、買名牌包嗎?“快下載APP”玩「時尚搶包」活動，就有機會抽中 香港來回機票、Prada名牌包、美妝保養品、時尚隨行杯等，超多好康獎品哦！',
				'picture' => 'http://events.fashionguide.com.tw/FB/action/'.$folder.'/i/fb-s.jpg',
    			'place' => '182873855081177',
    			'tags'=>array("100000914494824"),				
				'actions'=>array(array('name' => '時尚搶包',
						'link' => 'http://event.fashionguide.com.tw'))
		);
		*/
		
        if (empty($this->access_token)){
            return "error:no access_token";
        }
        $attachment = $publish_parameters;
        $attachment["access_token"]=$this->access_token;

        try {                                
            $result = $this->facebook->api('/'.$fb_id.'/feed/',
					'post', 
                                    $attachment);
        }catch (FacebookApiException $e) {
   	        return "error:".$e;
        } 
    }
    
    public function get_page_name($page_id){ //取得頁面名稱(或打卡地點名稱)
    	if (empty($this->access_token)){
    		return "error:no access_token";
    	}   	
   		try {
	   		$page= $this->facebook->api( array( "method" => "fql.query", "query" => "SELECT name, fan_count FROM page WHERE page_id = ".$page_id , "access_token" => $this->access_token ));
   	
   		}catch (FacebookApiException $e) {
   			return "error:".$e;
   		}	
		
   		return $page[0]["name"];
   	
    }
    public function query_albums(){
    	if (empty($this->access_token)){
    		return "error:no access_token";
    	}
    	try {
    		//不抓Timeline Photos
    		$albums= $this->facebook->api( array( "method" => "fql.query", "query" => "SELECT object_id,name,cover_object_id FROM album WHERE owner=me() and name<>'Timeline Photos'" , "access_token" => $this->access_token ));

    	}catch (FacebookApiException $e) {
    		return "error:".$e;
    	}
    	if (empty($albums)){
    		return array();
    	}else{
    		$cover_object_ids="";
    		$new_albums=array();
    		
    		if (isset($albums["error_code"])){
    			return "error_code:".$albums["error_code"];
    		}
    		
    		foreach ($albums as $album){
    			$new_albums[$album["object_id"]]["name"]=$album["name"];
    			$cover_object_ids .=$album["cover_object_id"].",";
    		}
    		$cover_object_ids =substr($cover_object_ids ,0,strlen($cover_object_ids)-1);
    		$photos= $this->facebook->api( array( "method" => "fql.query", "query" => "select album_object_id,src,src_big from photo where object_id in(".$cover_object_ids .")" , "access_token" => $this->access_token ));
    		foreach ($photos as $photo){
    			$new_albums[$photo["album_object_id"]]["src"]=$photo["src"];
    			$new_albums[$photo["album_object_id"]]["src_big"]=$photo["src_big"];
    		}
    		return $new_albums;
    	}
    	 
    }
    public function query_friend_albums($friend_id){
    	if (empty($this->access_token)){
    		return "error:no access_token";
    	}
    	try {
    		//不抓Timeline Photos
    		$albums= $this->facebook->api( array( "method" => "fql.query", "query" => "SELECT object_id,name,cover_object_id FROM album WHERE owner=".$friend_id." and name<>'Timeline Photos'" , "access_token" => $this->access_token ));
    
    	}catch (FacebookApiException $e) {
    		return "error:".$e;
    	}
    	if (empty($albums)){
    		return array();
    	}else{
    		$cover_object_ids="";
    		$new_albums=array();
    		foreach ($albums as $album){
    			$new_albums[$album["object_id"]]["name"]=$album["name"];
    			$cover_object_ids .=$album["cover_object_id"].",";
    		}
    		$cover_object_ids =substr($cover_object_ids ,0,strlen($cover_object_ids)-1);
    		$photos= $this->facebook->api( array( "method" => "fql.query", "query" => "select album_object_id,src,src_big from photo where object_id in(".$cover_object_ids .")" , "access_token" => $this->access_token ));
    		foreach ($photos as $photo){
    			$new_albums[$photo["album_object_id"]]["src"]=$photo["src"];
    			$new_albums[$photo["album_object_id"]]["src_big"]=$photo["src_big"];
    		}
    		return $new_albums;
    	}
    
    }
    
    public function query_albums_by_name($album_name){
    	if (empty($this->access_token)){
    		return "error:no access_token";
    	}
    	 
    	//確定同名稱是否已存在
    	try {
    		$albums= $this->facebook->api( array( "method" => "fql.query", "query" => "SELECT object_id,type FROM album WHERE owner=me() AND name='".$album_name."'" , "access_token" => $this->access_token ));
    		 
    	}catch (FacebookApiException $e) {
    		
    		return "error:".$e;
    	}
    	
    	if (empty($albums)){
    		return array();
    	}else{
    		return $albums;
    	}    		
    	 
    }
    public function create_album($album_name,$album_description){ //製作新相簿
    	if (empty($this->access_token)){
    		return "error:no access_token";
    	}
    	
    	
    	
    	
   		// Create a new album
   		$graph_url = "https://graph.facebook.com/me/albums?"
    				."access_token=". $this->access_token;
    		
    	$postdata = http_build_query(
   					array('name' => $album_name,
   						  'message' => $album_description,
   						 )
   					);
   		$opts = array('http' =>
   				array('method'=> 'POST',
   					  'header'=>
   					  'Content-type: application/x-www-form-urlencoded',
   					  'content' => $postdata
   			    	 )
   				);
   		$context  = stream_context_create($opts);
   		$result = json_decode(file_get_contents($graph_url, false,$context));
   		return $result->id;  //回傳創建相簿id

		
  	}
  	function query_photos($album_id){ 
    	if (empty($this->access_token)){
    		return "error:no access_token";
    	}
    	//先抓相簿內相片總數
    	
    	$albums= $this->facebook->api( array( "method" => "fql.query", "query" => "SELECT photo_count FROM album WHERE object_id =".$album_id , "access_token" => $this->access_token ));
    	if (empty($albums)){
    		return "error:no this album";
    	}    	
    	if (isset($albums["error_code"])){
    		return "error_code:".$albums["error_code"];
    	}    	
    	$return_photos=array();
    	for ($i=0;$i<floor($albums[0]["photo_count"]/100)+1;$i++){  //fb只能一次抓100筆的照片資訊
    		try {
    			$photos= $this->facebook->api( array( "method" => "fql.query", "query" => "select object_id,src,src_big from photo WHERE album_object_id =".$album_id." limit 100 OFFSET ".$i*100 , "access_token" => $this->access_token ));
    			$return_photos=array_merge($return_photos,$photos);
	    	}catch (FacebookApiException $e) {
    			return "error:".$e;
	    	}
    	}
    	
    	

    	if (empty($return_photos)){
    		return array();
    	}else{
    		return $return_photos;
    	}
	  			
	}
  	  
  	
  	function upload_pic($album_object_id,$file_doc_path,$pic_desc,$message="",$tags=array()){
  		if (empty($this->access_token)){
  			return "error:no access_token";
  		}
  		  		
  		$this->facebook->setFileUploadSupport(true);
  		
    	$args = array(
       		'name' => $pic_desc,
        	'source' => '@' .$file_doc_path,
//    		'picture'=> '@' .$file_doc_path,
      		'access_token' => $this->access_token,
    		'message' =>$message,
   			'tags' => $tags
    	);
    
  		
  		
      // actual post
      $res = $this->facebook->api($album_object_id."/photos",'POST',$args);
      //print_r($res);
      return $res["id"];
     
  		
  	}
  	function tag_pic($pic_id,$uid,$text,$x,$y){
  		if (empty($this->access_token)){
  			return "error:no access_token";
  		}
  		
  		$tags = array (
  				0 => array (
  						'tag_uid' => $uid,
  						'x' => $x,
  						'y' => $y
  				)
  		);
  		foreach ( $tags as $t ) {
  			$t = array($t);
  			$t = json_encode ($t );
  			$args = array (
  					'tags' => $t,
  					'access_token' => $this->access_token
  			);
  			$datatag = $this->facebook->api('/' . $pic_id . '/tags', 'post', $args);
  		}  		
/*  		
  		$tags= array(
  				//'tag_text' => $text,
  				'tag_uid' => $uid,
  				'x' => $x,
  				'y' => $y
  		);  			
  		$args['tags']= array(0=>json_encode($tags));
		$args['access_token']=$this->access_token;

  		

  		$datatag = $this->facebook->api('/' . $pic_id . '/tags', 'post', $args);
*/  		
  	}
  	function get_signed_request(){  //抓取頁面資訊 
  		$signed_request = $this->facebook->getSignedRequest();
  		return $signed_request;
  		 
  	}
  	function search_place($lat,$lng,$distance=100){  //座標 距離(m)   找尋座標附近打卡地點, FB一次只會抓25筆 所以不要設太大範圍,不然要改寫 ,且要注意 不是100%完全抓的到= =
  		
 		try{
  			$place = $this->facebook->api('/search?type=place&center='.$lat.','.$lng.'&distance='.$distance);
  			
  		}catch(Exception $e){
  			echo "loc:".$lat.",".$lng."<br/>";
  			var_dump($e);
  			return array();
  		}
  		foreach ($place["data"] as $p){
  			$data["id"]=$p["id"];
  			$data["name"]=$p["name"];
  			$return_data[]=$data;
  		}
  		return $return_data;
  	}
  	function checkin($place,$message="",$lat,$lng,$tags=""){  //打卡   tag是 可以好友array
  		
  		$this->facebook->api('/me/checkins', 'POST', 
  				array(
  				'access_token' => $this->access_token,
				'place' =>  $place,
  						
  				'message' =>$message,
  				'coordinates' => json_encode(array(
  					'latitude'  => $lat,
  					'longitude' => $lng,
  					'tags' => $tags)
					)
  				)
  		);  		
  	}
  	function share($link,$message){   //分享連結
  		$this->facebook->api('/me/links', 'POST', array(
  				'link' => $link,
  				'message' => $message,
  				'access_token' => $this->access_token
  		));
  	
  	}
  	 
  	
}	
?>