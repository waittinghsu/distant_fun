<?php
ini_set("display_errors", 1);

class Manager extends CI_controller {
	private $pagintion;
	private $manager_page_size=20;  //管理員列表每頁數量
	
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
				
		//載入model
		$this->load->model("manager_model","",false);
		
		//分頁基本設定
		$this->load->library('pagination');
		$this->pagintion['num_links'] = 5;
		$this->pagintion['use_page_numbers'] = TRUE;
		$this->pagintion['page_query_string'] = TRUE;
		$this->pagintion = array_merge($this->pagintion, $this->ah_util->page_style());
		
		
    }
    function index(){
    	//檢查有無登入
		self::check_session();
		if ($this->input->get("msg")==""){
			header("Location: ".site_url("manage/user/user_list")); 
			exit;
		}else{
			$data["msg"]=$this->input->get("msg");  //alert 操作動作訊息用
		
 			$view["content"]=$this->load->view("manage/index",$data,true);
 			$this->load->view("manage/frame",$view);
		}
    }
    
    
    /*管理員*/
    function manager_list(){
    	//檢查有無登入
		self::check_session();
		
		if ($_SESSION[SESSION_PRE."sys_auth"]>1){
			header("Location: ".site_url("manage/manager/index")."?msg=auth_error"); //權限不足警告
			exit;
		}
		
		$data["menu1"]="manager";
		$data["menu2"]="manager_list";
		
		$data["msg"]=$this->input->get("msg");  //alert 操作動作訊息用
		
		
		$per_page=floor($this->input->get("per_page"));
		if ($per_page=="" || !is_numeric($per_page) || $per_page<1){
			$per_page=1;
		}
		
		$data["per_page"]=$per_page;
		 
		$managers=$this->manager_model->query_managers($per_page-1,$this->manager_page_size);
		$data["managers"]=$managers["data"];
		//分頁設定
		$this->pagintion['base_url'] = site_url("manage/manager/manager_list")."?v=1";
		$this->pagintion['per_page'] = $this->manager_page_size;
		$this->pagintion['total_rows'] = $managers["rownum"];
		$this->pagination->initialize($this->pagintion);
		$data["pagination"]=$this->pagination->create_links();
		 
		$data["total_row"]=$managers["rownum"];
		$view["content"]=$this->load->view("manage/manager_list",$data,true);
		$this->load->view("manage/frame",$view);    	    	 

    }
    function manager_add(){ //新增管理者
    	//檢查有無登入
		self::check_session();
    	if ($_SESSION[SESSION_PRE."sys_auth"]>1){
    		header("Location: ".site_url("manage/manager/index")."?msg=auth_error"); //權限不足警告
    		exit;
    	}
    	 
    	$data["act"]="add";
    	$data["action"]=site_url("manage/manager/manager_add");
    	$data["menu1"]="manager";
    	$data["menu2"]="manager_list";		
    	$data["per_page"]="1";
    	
    	if ($this->input->post("id")==""){
    		$data["msg"]=$this->input->get("msg");
    		$data["id"]="";
    		$data["password"]="";
    		$data["manager_name"]="";
    		$data["sys_auth"]="2";
    		$data["status"]="A";
    		$data["memo"]="";    		
    		
    		$view["content"]=$this->load->view("manage/manager_edit",$data,true);
    		$this->load->view("manage/frame",$view);
    		
    	}else{  //進資料庫
    		if ($this->input->post("password")==""
    				||$this->input->post("manager_name")==""
    				||($this->input->post("sys_auth")!="1" && $this->input->post("sys_auth")!="2")
    				||($this->input->post("status")!="A" && $this->input->post("status")!="C" && $this->input->post("status")!="D")
    		){
				header("Location: ".site_url("manage/manager/manager_add")."?msg=parms_error");
    			exit;
    		}
    		//id exists
    		$manager=$this->manager_model->select_manager_by_id($this->input->post("id"));
    		if (!empty($manager)){
    			
    			$data["msg"]="id_exits";
    			$data["id"]=$this->input->post("id");
    			$data["password"]=$this->input->post("password");
    			$data["manager_name"]=$this->input->post("manager_name");
    			$data["sys_auth"]=$this->input->post("sys_auth");
    			$data["status"]=$this->input->post("status");
    			$data["memo"]=$this->input->post("memo");
    			$view["content"]=$this->load->view("manage/manager_edit",$data,true);
    			echo $this->load->view("manage/frame",$view,true);
    			exit;
    		}
    		 
    		$this->manager_model->add_manager($this->input->post("id"),
    				md5($this->input->post("password")),
    				$this->input->post("manager_name"),
    				$this->input->post("sys_auth"),
    				$this->input->post("status"),
    				$this->input->post("memo"));
    		header("Location: ".site_url("manage/manager/manager_list")."?msg=add_fin&per_page=".(floor($this->manager_model->get_managers_num()/$this->manager_page_size)+1));

    	}
    	 
    }
    function manager_edit(){
    	//檢查有無登入
		self::check_session();
    	
    	
    	$data["per_page"]=$this->input->get_post("per_page");
    	if (!is_numeric($data["per_page"])){
    		header("Location: ".site_url("manage/manager/index")."?msg=parms_error"); //參數錯誤
    		exit;
    	}
    	if ($_SESSION[SESSION_PRE."sys_auth"]>1){
    		header("Location: ".site_url("manage/manager/index")."?msg=auth_error"); //權限不足警告
    		exit;
    	}
    	
    	$data["act"]="edit";
    	$data["action"]=site_url("manage/manager/manager_edit");
    	$data["menu1"]="manager";
    	$data["menu2"]="manager_list";    	
    	
   		if ($this->input->post("id")==""){  //顯示
   			$id=$this->input->get("id");
   			$manager=$this->manager_model->select_manager_by_id($id);
   			if (empty($manager)){
   				header("Location: ".site_url("manage/manager/manager_list")."?msg=id_not_exists&per_page=".$data["per_page"]); //id不存在錯誤
   				exit;
   			}
			
 			$data["id"]=$id;
   			$data["password"]=md5($manager->password);
   			$data["manager_name"]=$manager->manager_name;
   			$data["sys_auth"]=$manager->sys_auth;
   			$data["status"]=$manager->status;
   			$data["memo"]=$manager->memo;
   				
   			$view["content"]=$this->load->view("manage/manager_edit",$data,true);
   			$this->load->view("manage/frame",$view);

   		}else{  //更新
   			if ($this->input->post("password")==""
				||$this->input->post("manager_name")==""
   				||($this->input->post("sys_auth")!="0" && $this->input->post("sys_auth")!="1" && $this->input->post("sys_auth")!="2")
    			||($this->input->post("status")!="A" && $this->input->post("status")!="C" && $this->input->post("status")!="D"
    			||$this->input->post("per_page")=="")
    		   ){
   				header("Location: ".site_url("manage/manager/manager_edit")."?msg=parms_error&id=".$this->input->post("id")."&per_page=1"); //參數錯誤
    			exit;
    		}    			
    		$this->manager_model->update_manager($this->input->post("id"),
    											 $this->input->post("password"),
    											 $this->input->post("manager_name"),
    											 $this->input->post("sys_auth"),
    											 $this->input->post("status"),
    											 $this->input->post("memo"));
    		header("Location: ".site_url("manage/manager/manager_list")."?msg=edit_fin&per_page=".$data["per_page"]);
								
    		
    	}
    }
    
    

        
    /*login,logout*/
    function login(){
    	if ($this->input->post("id")=="" || $this->input->post("password")==""){    		
    		$this->load->view("manage/login");
    	}else{
    		//檢查帳密
    		$manager=$this->manager_model->select_manager_login($this->input->post("id"),md5($this->input->post("password")),'A');
    		if (empty($manager)){
    			//帳密錯誤
    			echo "<script>alert('id or password error');</script>";
    			echo "<script>window.location='".site_url("manage/manager/login")."'</script>"; 
    			exit;
    		}else{
    			$_SESSION[SESSION_PRE."manager_id"]=$this->input->post("id");
    			$_SESSION[SESSION_PRE."sys_auth"]=$manager->sys_auth;
    			$_SESSION[SESSION_PRE."manager_name"]=$manager->manager_name;
    			$this->manager_model->update_login_time($this->input->post("id"));
    			header("Location: ".site_url("manage/manager/index"));
    			exit;
    		}
    	}
    }
    function logout(){
    	$_SESSION[SESSION_PRE."manager_id"]="";
    	$this->load->view("manage/login");
    }
    
   	/*內部使用function*/
	private function check_session(){
		if (!isset($_SESSION[SESSION_PRE."manager_id"]) || $_SESSION[SESSION_PRE."manager_id"]==""){
			//未登入
			header("Location: ".site_url("manage/manager/login"));
			exit;
		}
		
		//有登入的新增選單及天地
		
		
	}

}


?>