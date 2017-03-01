<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Connect_security {
	var $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
		//載入model
		//$this->CI->load->model("user_model","",false);

		//載入自訂公用類別
		$this->CI->load->library('session');
		
				
	}
        function login_check($redirect_path=""){  //有登入情況下就重導網頁
		$user_id=$this->CI->session->userdata("user_id");
		if ($user_id != ""){
			return $user_id;
		}		
		$redirect_path=($redirect_path == "")?WEBROOT:$redirect_path;		
		header("Location: ".$redirect_path);		
	}
	function login_redirect_check($redirect_path=""){  //有登入情況下就重導網頁
		$user_id=$this->CI->session->userdata("user_id");

		if ($user_id==""){
			return;
		}
		if ($redirect_path==""){  //預設導至首頁
			$redirect_path=WEBROOT;
		}
		header("Location: ".$redirect_path);		
	}
	function login_session_save($user_id){
		$data["user_id"]=$user_id;
		$this->CI->session->set_userdata($data);
	}
	function login_id_get(){
		$user_id=$this->CI->session->userdata("user_id");
		return $user_id; 
	}
	function login_session_destory(){
		$this->CI->session->sess_destroy();
	}
/*	
    function login_check($redirect_path=""){
    	//檢查cookie有沒有access_token
    	$access_token=$this->CI->input->cookie('access_token');
    	if (!empty($access_token)){
    		//檢查是否已經過期
    		//已無此檔案
    		if (file_exists(ACCESS_TOKEN."/".$access_token.".txt")!=true){
    			self::auto_login();
    			return;
    		}
    		$content=file_get_contents(ACCESS_TOKEN."/".$access_token.".txt");
    		//檢查是否逾時,或IP不同
    		$data= explode(",", $content);
    		if ($content[0]!=$_SERVER['REMOTE_ADDR'] || (strtotime(date("Y-m-d H:i:s"))-strtotime($content[1])>30*60)){
    			self::auto_login();
    			return;
    		}
    		if ($redirect==""){  //預設導至個人首頁
    			$redirect=site_url("user/index");
    		}
    		header("Location: ".$redirect);
    		
    	}
    }
    
    
    private function auto_login(){  //自動重新登入
    	//檢查cookie有沒有login_id 與password
    	$login_id=$this->CI->input->cookie('login_id');
    	$password=$this->CI->input->cookie('password');  //cookie是已 md5的
    	if ($login_id=="" || $password==""){
    		//導至登入頁
    		header("Location: ".site_url("user/login"));
    		return;
    	}
    	//帳密 允許使用字母、數字、底線和一個點 ,且開頭必須為英文字
    	if (preg_match("^[a-zA-Z]\w{5,17}")!=true){
    		//導至登入頁
    		header("Location: ".site_url("user/login"));
    		return;
    	}
    	
    	//從資料庫驗證
    	$user=$this->user_model->select_by_login_id_n_password($login_id,$password);
    	if (empty($user)){
    		header("Location: ".site_url("user/index")."?msg=data_not_found");
    		return;
    	}
    	switch ($user->status){
    		case "A":
    			 
    			//寫入cookie
    			self::save_login_cookie($user->login_id,$password);
    			break;
    	}
    }
	function save_login_cookie($login_id,$password,$expire="-1"){
		//重新寫access_token
		$access_token=md5($login_id.date("YmdHis"));
		$filename=$access_token.".txt";
		$data=$_SERVER['REMOTE_ADDR'].",".date("Y-m-d H:i:s");
		file_put_contents(ACCESS_TOKEN."/".$filename,$data);
		
		//寫入cookie
		$cookie = array(
				'name'   => 'access_token',
				'value'  => $access_token,
				'expire' => $expire,  
				'domain' => DOMAIN,
				'path'   => '/mapit',
				'prefix' => 'mapit_',
				'secure' => TRUE
		);
		$this->CI->input->set_cookie($cookie);
		
		$cookie = array(
				'name'   => 'login_id',
				'value'  => $login_id,
				'expire' => $expire,  
				'domain' => DOMAIN,
				'path'   => '/mapit',
				'prefix' => 'mapit_',
				'secure' => TRUE
		);
		$this->CI->input->set_cookie($cookie);
		$cookie = array(
				'name'   => 'passwrod',
				'value'  => $password,
				'expire' => $expire,  
				'domain' => DOMAIN,
				'path'   => '/mapit',
				'prefix' => 'mapit_',
				'secure' => TRUE
		);
		 
		$this->CI->input->set_cookie($cookie);		
	}
*/	
}