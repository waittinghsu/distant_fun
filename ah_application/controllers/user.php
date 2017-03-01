<?php
ini_set("display_errors", 1);
class User extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		//設定時區+8h
		date_default_timezone_set( "Asia/Taipei" );
		//載入helper
		$this->load->helper('url');
                //載入自訂公用類別
                $this->load->library("ah_util");
				
		$fb_config=array("facebook_app_id"=>FBAPP_ID,"facebook_secret"=>FBAPP_SECRET,"fileUpload"=>False);
		$this->load->library("fb",$fb_config);
		//載入library
		$this->load->library('image_lib');//處理縮圖與裁圖
                $this->load->library("curl");
                $this->load->library("connect_security");//登入驗證
		//載入model
                $this->load->model('user_model','',FALSE);
                $this->load->model('group_model','',FALSE);
                $this->load->model('usergroup_model','',FALSE);
                
		if ($this->input->cookie('utm_source')==""){
			setcookie("utm_source", strip_tags($this->input->get("utm_source")), time()+3600);  /* expire in 1 hour */
			setcookie("utm_medium", strip_tags($this->input->get("utm_medium")), time()+3600);  /* expire in 1 hour */
			setcookie("utm_campaign", strip_tags($this->input->get("utm_campaign")), time()+3600);  /* expire in 1 hour */
		}
	}
    function index(){			
	$data=array();                
        $data["pop"]=$this->load->view("pop",$data,true);//活動辦法  FB輸入框  黑影       
        $data["menu"]=$this->load->view("menu",$data,true);                
        $this->load->view("index",$data);		
    }  
    function login(){
        $this->connect_security->login_redirect_check(site_url('group'));//判斷是否已經登入-重導頁面
        $data=array();                
        $data["pop"]=$this->load->view("pop",$data,true);//活動辦法  FB輸入框  黑影       
	$data["menu"]=$this->load->view("menu",$data,true);     
        $data["sakura"]=$this->load->view("sakura",$data,true);        
        $this->load->view("user/login",$data);	
     }
     function do_login(){        
        $access_token=$this->input->post("access_token");          
      if ($access_token==""){
                $json_result['status']='parms error{FB_token}';
    		echo json_encode($json_result);
    		exit;
    	}    
        $json_result['access_token']=$access_token;
        $this->fb->set_access_token($access_token);
        $me=$this->fb->get_me_from_fb();
        $login_querys=$this->user_model->query_login_by_Providerkey($me['id']);       
        if(empty($login_querys['data'])){
            $add_data_array=array('LoginProvider'=>'Facebook','Providerkey'=>$me['id']);
            $newID=  $this->user_model->add_login_Front($add_data_array);
            $birth=  explode('/',$me['birthday']);
            $add_userinfo_array=array('Id'=>$newID,
                'user_email'=>$me['email'],  
                'user_name'=>$me['first_name'],
                'user_nickname'=>$me['first_name'],
                'user_birthday'=>$birth[2].'-'.$birth[0].'-'.$birth[1],
                'user_gender'=>$me['gender'],
                'user_register_time'=>date('Y-m-d H:i:s'),
                'user_modify_time'=>date('Y-m-d H:i:s')
                );
            $this->user_model->add_userinfo_Front($add_userinfo_array);
            //add_userinfo_Front            
            $json_result['href']=  site_url('/user/profile')."?uid=".$newID;
        }else{ 
            $newID=$login_querys['data'][0]->userId;
            $json_result['href']= site_url('group');
        }
            $json_result['status']='done';
            
        $this->connect_security->login_session_save($newID);        
        echo json_encode($json_result);         
     }
     function logout(){
        $this->connect_security->login_session_destory();    
    	header("Location: ".site_url("user/login"));
    	return;
     }
     function profile(){
        $data=array();
        $get_msg =  $this->input->get('msg');
        switch ($get_msg){
            case 'SUCCESS':
                $data['msg_type']='success';
                $data['msg']='修改完成';
                break;
            default :
                $data['msg_type']='block';
                $data['msg']='修改您的資本資料';
                break;
        }
        $data['login_id']=$this->connect_security->login_check(site_url('user/login')); 
        $userinfo_querys= $this->user_model->query_userinfoby_id($data['login_id']);  
        if(empty($userinfo_querys['data'])){
                header('Location:'.  site_url('user/logout'));
                return;
        }     
        foreach ($userinfo_querys['data'] as $key => $value) { 
            $cphone_array=(!empty($value->user_contact_phone))? explode('-', $value->user_contact_phone):array(NULL,NULL); 
            $value->user_contact_phone_Zone=$cphone_array[0];
            $value->user_contact_phone_Num=$cphone_array[1]; 
            $userinfo_query=$value;
        }
        $data['userinfos']=$userinfo_query;
        $data['row']=$userinfo_querys['rownum'];  
        $data["menu_tag"]='profile';
        $data["menu"]=$this->load->view("sky/front_menu",$data,true);   
        $this->load->view("user/profile",$data);         
     }     
     function profile_update(){         
         $cp1=trim($this->input->post('user_contact_phone'));
         $cp2=trim($this->input->post('user_contact_phone2'));
         $updata_array=array('user_name'=>$this->input->post('user_name'),
                'user_nickname'=>$this->input->post('user_nickname'),
                'user_mobile_phone'=>$this->input->post('user_mobile_phone'),
                'user_contact_phone'=>(trim($cp1) == '' ||  trim($cp2) == '')?NULL:$cp1.'-'.$cp2,
                'user_address'=>$this->input->post('user_address'),
                'user_address_memo'=>$this->input->post('user_address_memo')
//                'user_email'=>$this->input->post('user_email')
             );
         $login_id=$this->connect_security->login_check(site_url('user/login'));
         $this->user_model->update_db('userinfo',array('Id'=>$login_id),$updata_array);
         header('location:' .  site_url('user/profile').'?msg=SUCCESS');  
     }
     function usergroup_cards(){    
         
        $data=array();
        $groupId= $this->input->get_post('groupId'); 
        $login_id=$this->connect_security->login_id_get();         
//        $login_id=1;
        if(empty($groupId) || empty($login_id)){
            header('location:' .  site_url('group'));  
        }        
        $where_array=array('usergroup.groupId'=> $groupId,'usergroup.userId'=> $login_id);
        $group_card_querys=$this->usergroup_model->query_usergroup_card_member_byGID($where_array);
        if(empty($group_card_querys['data'])){
             header('location:' .  site_url('group'));  
        }
        //抓面前使用者資訊，並對照抽重的對象
        $PickUser = array();
        if(!empty($group_card_querys['data'][0]->PickUserId)){
            $userinfo_querys = $this->user_model->query_userinfoby_id($group_card_querys['data'][0]->PickUserId);
            $PickUser = $userinfo_querys['data'][0];
        }
        $where_array=array('usergroup.groupId'=> $groupId,'usergroup.userId !='=> $login_id);
        $group_card_querys=$this->usergroup_model->query_usergroup_card_member_byGID($where_array,'usergroup_cards.cardId','random');
//        Omega($group_card_querys);
        foreach ($group_card_querys['data'] as $key =>$value){   
                $PicNumEncode = $this->ah_util->ah_pic_encode($value->cardId);            
                $value->piccode =  $this->ah_util->ah_pic_encode($value->userId);
                $value->picname =  $PicNumEncode.'.jpg';                
                $group_cards_data[]=$value;
        }
        $data['PickUser']=(!empty($PickUser))?$userinfo_querys['data'][0]:array();
        $data['groupId'] = $groupId;
        $data["group_cards_data"] = $group_cards_data;
        $data["menu_tag"] ='mygroup';
        $data["menu"] = $this->load->view("sky/front_menu",$data,true);   
        $this->load->view("user/usergroup_cards",$data);    
     }
     function ajax_getcard(){
        $data=array();
        $groupId= $this->input->get_post('groupId'); 
        $login_id=$this->connect_security->login_id_get();    
//        $groupId = 1;
//        $login_id= 1;
        if(empty($groupId) || empty($login_id)){
           $result['status']='nologin';
           $result['msg']='您沒有此權限';
           $result['href']=  site_url('group');
           echo json_encode($result);
           return ;
        } 
        $where_array=array('usergroup.groupId'=> $groupId,'usergroup.userId'=> $login_id);
        $UserCardQuerys=$this->usergroup_model->query_usergroup_card_member_byGID($where_array);
        if(empty($UserCardQuerys['data'])){
           $result['status']='nojoin';
           $result['msg']='您沒有此權限';
           $result['href']=  site_url('group/mygroup');
           echo json_encode($result);
           return ;
        }
        $PickUser = array();
        if(!empty($UserCardQuerys['data'][0]->PickUserId)){
           $result['status']='noting';
           $result['msg']='你已經抽過了';
//           $result['href']=  site_url('user/usergroup_cards').'?groupId='.$groupId;
           echo json_encode($result);
           return ;
        }        
       
        $where_array=array('usergroup.groupId'=> $groupId,'usergroup.userId !='=> $login_id,"usergroup_cards.PickUserId" => NULL);
        $RandCardInfo=$this->usergroup_model->GetRandCard($groupId,$login_id);
        if(!empty($RandCardInfo)){
            $WhereArray = array('UserGroupId' => $UserCardQuerys['data'][0]->UserGroupId);
            $UpdateArray = array('PickUserId' => $RandCardInfo['data'][0]->userId);
            $this->usergroup_model->update_usergroup_cards($WhereArray,$UpdateArray);
            $result['status']='done';
            $result['msg']='你抽到了'.$RandCardInfo['data'][0]->cardId.'號';
            $result['href']=  site_url('user/usergroup_cards').'?groupId='.$groupId;
            echo json_encode($result);
        }

        
     }
     
     function ajax_usergroup_card(){
        $groupId= $this->input->post('group');    
        $login_id=$this->connect_security->login_id_get();           
        if(empty($login_id) || empty($groupId)){//確認帳號
           $result['msg']='您未登入帳號';
           $result['href']=  site_url('user/login');
           echo json_encode($result);
           return ;
        }
        $query_array=array('groupId'=>$groupId,'userId'=>$login_id);
        $usergroup_query=  $this->usergroup_model->query_usergroup_by_UGid($query_array);
        if(empty($usergroup_query)){
           $result['msg'] = '請先加入群組';
           $result['href'] =  site_url('group/group_info').'?gid='.$groupId;       
           echo json_encode($result);
           return ; 
        }    
        if($usergroup_query->usergroup_check == 'N'){
           $result['msg'] = '等待管理員審核你的加入';
           $result['href'] =  site_url('group/mygroup');       
           echo json_encode($result);
           return ; 
        }
        //檢此UG有無登記  卡片
        $usergroup_card_query=  $this->usergroup_model->query_usergroup_card_by_UGid(array('UserGroupId'=>$usergroup_query->Id));      
        if(empty($usergroup_card_query)){//add  
            $where_array=array('usergroup.groupId'=> $groupId);
            $group_card_querys=$this->usergroup_model->query_usergroup_card_member_byGID($where_array);
            $card_array=array(0);
            foreach ($group_card_querys['data'] as $key => $value) {
                $card_array[]=$value->cardId;               
            }
                $rand_num=mt_rand(1,44);
            while (in_array($rand_num, $card_array)) {
                $rand_num=mt_rand(1,44);                 
            }
            $add_array=array('UserGroupId '=>$usergroup_query->Id,'cardId '=>$rand_num);
            $UG_card_NUM=  $this->usergroup_model->add_usergroup_cards($add_array);            
            $result['msg']='您的號碼牌~~'.$rand_num;
            $result['href']=  site_url('group/mygroup');
        }else{//X                   
            $result['msg']='您的號碼牌~~'.$usergroup_card_query->cardId;            
            $result['href']=  site_url('group/mygroup');
        }
        if(date('Y-m-d') >= '2014-12-12'){
            $result['href']=  site_url('user/usergroup_cards').'?groupId='.$groupId;
         }
        $result['status']='done';
        echo json_encode($result);

     }
   
	
}
?>