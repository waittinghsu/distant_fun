<?php
ini_set("display_errors", 1);
class Group extends CI_Controller {
        private $pagintion;
        private $user_page_size=20; 
	function __construct()
	{
		parent::__construct();
		//設定時區+8h
		date_default_timezone_set( "Asia/Taipei" );
		//載入helper
		$this->load->helper('url');
                //載入自訂公用類別
                $this->load->library("ah_util");			
		
		//載入library
             
                $this->load->library("connect_security");//登入驗證
		//載入model
                $this->load->model('group_model','',FALSE);
                $this->load->model('user_model','',FALSE);
                $this->load->model('usergroup_model','',FALSE);
                
		if ($this->input->cookie('utm_source')==""){
			setcookie("utm_source", strip_tags($this->input->get("utm_source")), time()+3600);  /* expire in 1 hour */
			setcookie("utm_medium", strip_tags($this->input->get("utm_medium")), time()+3600);  /* expire in 1 hour */
			setcookie("utm_campaign", strip_tags($this->input->get("utm_campaign")), time()+3600);  /* expire in 1 hour */
		}
                
                //分頁基本設定
		$this->load->library('pagination');
		$this->pagintion['num_links'] = 5;
		$this->pagintion['use_page_numbers'] = TRUE;
		$this->pagintion['page_query_string'] = TRUE;
		$this->pagintion = array_merge($this->pagintion, $this->ah_util->page_style());
                
	}
    function index(){			
	$data=array(); 
        //分頁
        $per_page=floor($this->input->get("per_page"));
    	if ($per_page=="" || !is_numeric($per_page) || $per_page<1){
    		$per_page=1;
    	}
        $data["per_page"]=$per_page;
        
        
        $group_querys=$this->group_model->query_group($per_page-1,$this->user_page_size,array(),'Id','ASC');

        $data['group_infos']=$group_querys['data'];
        
        //分頁設定
    	$this->pagintion['base_url'] = site_url("group")."?v=1";
    	$this->pagintion['per_page'] = $this->user_page_size;
    	$this->pagintion['total_rows'] = $group_querys["rownum"];
    	$this->pagination->initialize($this->pagintion);
    	$data["pagination"]=$this->pagination->create_links(); 

    	$data["total_row"]=$group_querys["rownum"];
        //end
        
        $data["menu_tag"]='group';
        $data["menu"]=$this->load->view("sky/front_menu",$data,true);                
        $this->load->view("group/group",$data);		
    } 
  
    function group_info(){
        $data=array();  
        $group_id=$this->input->get('gid',TRUE);
        //確認群組存在
        $check_qroup= $this->group_model->query_group_by_id($group_id);
        if(empty($check_qroup)){
            header('Location:'.  site_url('group'));
        }
        //query群組資訊
        $qroup_info_querys=$this->usergroup_model->query_userqroup(0,20,array('`group`.`Id`'=>$group_id));
//        Omega($check_qroup);
        $fb_pic=array();
        foreach ($qroup_info_querys['data'] as $key => $value) {
            if($value->LoginProvider == 'Facebook' && $value->usergroup_check == 'Y'){
                $fb_pic[]='<img src="https://graph.facebook.com/'.$value->Providerkey.'/picture?type=" width="50px" height="50px">';
            }
            $group_about_userID[]=$value->userId;
        }             
        $login_id=$this->connect_security->login_id_get();    
        
        $usergroup_querys=$this->usergroup_model->query_usergroup_by_UGid(array('groupId'=>$group_id,'userId'=>$login_id));
        $join_check =(!empty($login_id) && !empty($usergroup_querys))?$usergroup_querys:'N';
//        Omega($join_check);
        $data['join_check']=$join_check;
        $data['qroup_info_query']=$check_qroup;

        $data['group_id']=$group_id;        
        $data['group_pic']=  WEB_I.'/group/group'.$group_id.$check_qroup->group_img_ext;
       
        $data['fb_pic']=$fb_pic;
        $data["menu_tag"]='group';
        $data["loading_pop"]=$this->load->view("loading_pop",$data,true);   
        $data["menu"]=$this->load->view("sky/front_menu",$data,true);   
        $this->load->view("group/group_info",$data);	         
    }
    function mygroup(){
        $data=array();     
        $login_id=$this->connect_security->login_check(site_url('user/login'));
        $where_array=array('usergroup.userId'=>$login_id);
        $mygroup_querys=$this->usergroup_model->query_userqroup(0,20,$where_array);

        
         //分頁設定
    	$this->pagintion['base_url'] = site_url("group")."?v=1";
    	$this->pagintion['per_page'] = $this->user_page_size;
    	$this->pagintion['total_rows'] = $mygroup_querys["rownum"];
    	$this->pagination->initialize($this->pagintion);
    	$data["pagination"]=$this->pagination->create_links(); 
    	$data["total_row"]=$mygroup_querys["rownum"];
        //end
        
        
        $data['group_infos']=$mygroup_querys['data'];
        $data["menu_tag"]='mygroup';
        $data["menu"]=$this->load->view("sky/front_menu",$data,true);   
        $this->load->view("group/mygroup",$data);	         
     }
     function ajax_join_group(){
        $groupId= $this->input->post('group');    
        $login_id=$this->connect_security->login_id_get();   
        
        if(empty($login_id)){//確認帳號
           $result['msg']='您未登入帳號';
           $result['href']=  site_url('user/login');
           echo json_encode($result);
           return ;
        }
        $query_array=array('groupId'=>$groupId,'userId'=>$login_id);
        $usergroup_query_by_id=  $this->usergroup_model->query_usergroup_by_UGid($query_array);
        if(empty($usergroup_query_by_id)){
           $add_array=array('userId'=>$login_id,'groupId'=>$groupId,'roleId'=>3,'usergroup_check'=>'Y');
           $UG_NUM = $this->usergroup_model->add_usergroup($add_array);
           $result['test'] = $UG_NUM; 
           $result['msg'] = ($UG_NUM)?'註冊成功等候!管理員確認':'發生錯誤了請聯絡工程人員';
           $result['href'] =  site_url('group/mygroup');
           echo json_encode($result);
           return ;
        }       
        $result['msg']='你已經註冊過搂~~';
        $result['href']=  site_url('group/mygroup');
        $result['status']='done';
        echo json_encode($result);
     }
	
}
?>