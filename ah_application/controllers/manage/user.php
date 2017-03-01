<?php
ini_set("display_errors", 1);

class User extends CI_controller {
	private $pagintion;
	private $user_page_size=20;  //參與者列表每頁數量
	
	
	function __construct()
    {
        
        // Call the Model constructor
        parent::__construct();
        
        
        //設定時區+8h
		date_default_timezone_set( "Asia/Taipei" );
		
		//開啟Session
		session_start();
		
		//載入helper
		$this->load->helper('url');

		//載入自訂公用類別
		$this->load->library("ah_util");
		$this->load->library("excel");
		$this->load->library("lunar");
						
		//載入model
		$this->load->model("user_model","",false);
		
		//分頁基本設定
		$this->load->library('pagination');
		$this->pagintion['num_links'] = 5;
		$this->pagintion['use_page_numbers'] = TRUE;
		$this->pagintion['page_query_string'] = TRUE;
		$this->pagintion = array_merge($this->pagintion, $this->ah_util->page_style());
		
		
    }
    function index(){
		header("Location: ".site_url("manage/user/user_list"));
    }
        
    

    
    /*參與者列表*/
    function user_list(){
    	
    	//檢查有無登入
    	self::check_session();
    
    	$data["menu1"]="user";
    	$data["menu2"]="user_list";
    
    	$data["msg"]=$this->input->get("msg");  //alert 操作動作訊息用
    
    	$per_page=floor($this->input->get("per_page"));
    	if ($per_page=="" || !is_numeric($per_page) || $per_page<1){
    		$per_page=1;
    	}
    	 
    	 
    	$data["per_page"]=$per_page;
    	
    
    	$users=$this->user_model->query_users('',$per_page-1,$this->user_page_size,array("D"),"create_time");
            
    	$lunar_birthday=array();
    	foreach ($users["data"] as $user){
    		$lunar_birthday[$user->fb_id]=date("Y-m-d",$this->lunar->S2L($user->birthday));
                //omega 20140624 need datetime discrete go model
                //$user->create_date_day= date_format(date_create($user->create_time),"Y-m-d");
                //$user->create_times=date_format(date_create($user->create_time),"H:i:s");       
    	}
        
    	$data["users"]=$users["data"];
    	$data["lunar_birthday"]=$lunar_birthday;
    	 
    	//分頁設定
    	$this->pagintion['base_url'] = site_url("manage/user/user_list")."?v=1";
    	$this->pagintion['per_page'] = $this->user_page_size;
    	$this->pagintion['total_rows'] = $users["rownum"];
    	$this->pagination->initialize($this->pagintion);
    	$data["pagination"]=$this->pagination->create_links();
    
    	$data["total_row"]=$users["rownum"];
    	$view["content"]=$this->load->view("manage/user_list",$data,true);
         
          // Omega($data);
    	$this->load->view("manage/frame",$view);
    
    } 
    
    /*參與者文章列表*/
    function user_share_message(){    	
    	//檢查有無登入
    	self::check_session();    
    	$data["menu1"]="user";
    	$data["menu2"]="user_share_message";    
    	$data["msg"]=$this->input->get("msg");  //alert 操作動作訊息用    
    	$per_page=floor($this->input->get("per_page"));
    	if ($per_page=="" || !is_numeric($per_page) || $per_page<1){
    		$per_page=1;
    	} 
    	$data["per_page"]=$per_page;   	
    
    	$users=$this->user_model->query_share_message($per_page-1,$this->user_page_size,array("D"),"fb_id`,`create_time");
 
        $data["users"]=$users["data"];
    
    	 
    	//分頁設定
    	$this->pagintion['base_url'] = site_url("manage/user/user_list")."?v=1";
    	$this->pagintion['per_page'] = $this->user_page_size;
    	$this->pagintion['total_rows'] = $users["rownum"];
    	$this->pagination->initialize($this->pagintion);
    	$data["pagination"]=$this->pagination->create_links();    
    	$data["total_row"]=$users["rownum"];
    	$view["content"]=$this->load->view("manage/user_share_message",$data,true);
         
    	$this->load->view("manage/frame",$view);   
    }  
        

    
    function user_list_save_to_XLS(){
    	$header = array("fb id","暱稱","姓名","性別","生日","FB Email","Email","聯絡電話","聯絡地址","發佈次數","utm_source","utm_medium","utm_campaign","資料建立日期","資料建立時間","IP");
    	$this->excel->filename = 'user_list';  
        
    	$users=$this->user_model->query_users('',0,1000000,array("D"),"create_time");
    	$datas=array();  
        
    	foreach ($users["data"] as $user){
    		$data =array($user->fb_id,$user->fb_name,$user->user_name,$user->gender,$user->birthday,trim($user->fb_email),
    				trim($user->email),trim($user->phone),$user->address,$user->publish_times,$user->utm_source,$user->utm_medium,$user->utm_campaign,
    				$user->create_date_day,$user->create_time,$user->create_ip);
    		$datas[]=$data;
    	}    	 
    	$this->excel->make_from_array($header,$datas);    
    }    
    
    function share_message_save_to_XLS(){
    	$header = array("fb id","姓名","性別","FB Email","Email","聯絡電話","聯絡地址","資料建立時日期","資料建立時間","IP");
    	$this->excel->filename = 'user_list';  
        
    	$users=$this->user_model->query_share_message(0,1000000,array("D"),"fb_id`,`create_time");
    	$datas=array();  
        
    	foreach ($users["data"] as $user){
    		$data =array($user->fb_id,$user->fb_name,$user->gender,trim($user->fb_email),
    				trim($user->email),trim($user->user_phone),$user->user_address,$user->create_date_day,
    				$user->create_time,$user->create_ip);    		
                $datas[]=$data;
    	}    	 
    	$this->excel->make_from_array($header,$datas);    
    } 
    
   	/*內部使用function*/
	private function check_session(){
		if (!isset($_SESSION[SESSION_PRE."manager_id"]) || $_SESSION[SESSION_PRE."manager_id"]==""){
			//未登入
			header("Location: ".site_url("manage/manager/login"));
			exit;
		}
	}
}

?>