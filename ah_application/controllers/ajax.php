<?php
ini_set("display_errors", 1);

class Ajax extends CI_Controller {

	
	function __construct()
    {

        // Call the Model constructor
        parent::__construct();
        
        //設定時區+8h
		date_default_timezone_set( "Asia/Taipei" );
		
		//載入helper
		$this->load->helper('url');
		//載入自訂公用類別
		$this->load->library("ah_util");
				
		$fb_config=array("facebook_app_id"=>FBAPP_ID,"facebook_secret"=>FBAPP_SECRET,"fileUpload"=>False);
		$this->load->library("fb",$fb_config);
		
		//載入model
		$this->load->model("user_model","",false);
		
    }
     function publish_get(){
         Omega($this->input->post());
     }
    function publish(){
    	
    	$access_token=$this->input->get_post("access_token");
    	$message=trim($this->input->get_post("message"));
    	$pic=trim($this->input->get_post("blogger_pic"));
    	
    	$url=str_replace("!!!","&",trim($this->input->get_post("blogger_url")));

    	if ($access_token=="" || $message=="" || $pic=="" || $url==""){
    		echo "parms error";
    		exit;
    	}
    	$this->fb->set_access_token($access_token);
    	
    	$me=$this->fb->get_me_from_fb();

    	//FB發佈時設定內文和標題
   		$publish_parameters=array(
    			 
   			'message' =>$message,
   			'name' => 'FB title',
   			'caption' => WEBROOT,
   			'description' =>'description！',
   			'link' => $url,
   			'picture' => WEB_I."/common/".$pic,
    			 
    
   		);
                    //測試網址是否為我要的FB發文
                   //Omega($publish_parameters);    
    	echo $this->fb->publish($me["id"],$publish_parameters);
 
    	//留資料  用get_post 是因為跨網域的jsonp式用get傳值
    	$user_name=trim($this->input->get_post("user_name",true));
    	$phone=trim($this->input->get_post("phone",true));
    	$email=trim($this->input->get_post("email",true));
    	$address=trim($this->input->get_post("address",true));
    	
        

    	//if ($user_name==""  ||  $email=="" || $phone=="" || $address==""){
    	if ($email=="" || $phone=="" || $address==""){
    		echo "parms error";
    		exit;
    	}
        
        
        $add_share_msg_data = array('fb_id' => $me["id"],'fb_name' => $me["name"],'user_phone' => $phone,
            'user_address' => $address,'share_message' => $message,'fb_email' => $me["email"],
            'email' => $email,'gender' => $me["gender"],'create_time' => date("Y-m-d H:i:s"),
            'create_ip' => $_SERVER['REMOTE_ADDR']);
        //add sharer message
        $this->user_model->add_user_message($add_share_msg_data);

               
    	$user=$this->user_model->select_by_fb_id('',$me["id"]);    	 
    	if (empty($user)){  //新增
                //開啟不了user_birthday繞道
    		if(!empty($me["birthday"])){
                $birth = explode("/", $me["birthday"]);
                $birthday = $birth[2] . "-" . $birth[0] . "-" . $birth[1];              
            }else{
                $birthday="1970-1-1";//$birthday="1970-1-1";               
            }     
    		$add_user_data = array('fb_id' => $me["id"], 'fb_name' => $me["name"], 'fb_email' => $me["email"],
                'email' => $email, 'gender' => $me["gender"], 'user_name' => $user_name, 'phone' => $phone,
                'address' => $address, 'birthday' => $birthday, 'utm_source' => $this->input->cookie('utm_source'),
                'utm_medium' => $this->input->cookie('utm_medium'), 'utm_campaign' => $this->input->cookie('utm_campaign'),
                'publish_times' => 1, 'create_time' => date("Y-m-d H:i:s"), 'create_ip' => $_SERVER['REMOTE_ADDR']);
            $this->user_model->add_user( 'fb_publish_user',$add_user_data);
    	}else{  //更新
    		$update_user_data = array('user_name' => $user_name, 'phone' => $phone, 'email' => $email, 'address' => $address, 'publish_times' => $user->publish_times + 1,);
            $this->user_model->update_user_basic_data('',$me["id"], $update_user_data);  
    	}
    	echo "done";
//        $jsons->ans='parms error01';
//        echo 'remoteANS(' . json_encode($jsons) . ')';
    }
	function user_data(){
		$access_token=$this->input->post("access_token");
		
		if ($access_token==""){
			echo "parms error";
			exit;
		}
		$this->fb->set_access_token($access_token);
		$me=$this->fb->get_me_from_fb();
		$user=$this->user_model->select_by_fb_id('',$me["id"]);//透過user_model 來像資料庫要使用者資料 
		
                
                $user_return["user_name"]=isset($user->user_name)?$user->user_name:$me['name'];
		$user_return["phone"]=isset($user->phone)?$user->phone:'';          
		$user_return["address"]=isset($user->address)?$user->address:'';
		$user_return["email"]=isset($user->email)?$user->email:$me['email'];
		echo json_encode($user_return);
	}    
}


?>