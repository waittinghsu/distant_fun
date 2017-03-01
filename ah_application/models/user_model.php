<?php
class User_model extends CI_Model {
	private $db;
	function __construct()
    {
        // 呼叫模型(Model)的建構函數
        parent::__construct();
        $this->db = $this->load->database(DB_NAME,TRUE);        
        //載入自訂公用類別       
    }
    function __destruct()
    {
        $this->db->close();        
    }
    /*-----------前台------------*/
    function query_login_by_Providerkey($Providerkey){
        $result=array();
        $table='userlogins';
        $this->db->start_cache();
        $this->db->where('Providerkey',$Providerkey);        
        $this->db->stop_cache();
        $result['row'] = $this->db->count_all();
        $result['data']= $this->db->get($table)->result();    
//        $result['sql']=  $this->db->last_query();
        $this->db->flush_cache();
        return $result;
    }
    function add_login_Front($data_array){
        $this->db->insert('userlogins',$data_array);
        return $this->db->insert_id();
    }
    function add_userinfo_Front($data_array){
        $this->db->insert('userinfo',$data_array);       
    }
    function  query_userinfoby_id($id){
        $result=array();
        $this->db->start_cache();
        $this->db->where('Id', $id);
        $this->db->join('userlogins','userinfo.Id = userlogins.userId');
        $this->db->stop_cache();
    	$result['data'] =$this->db->get("userinfo")->result();
        $result['rownum'] =$this->db->count_all_results('userinfo');
        
        $this->db->flush_cache();
        return $result;        
    }     
    
    function update_db($dbrable,$where_array=array(),$update_array=array()){  
        foreach ($where_array as $key => $value){
            $this->db->where($key, $value);
        }
    	$this->db->update($dbrable, $update_array);
    }


    /*---------後台---------*/
    function add_user($dbtable_N = 'fb_publish_user',$data){  
        $dbtable_N= empty($dbtable_N)?"fb_publish_user":$dbtable_N;       
    	$this->db->insert($dbtable_N, $data);
    }
    function select_by_fb_id($dbtable_N = 'fb_publish_user',$fb_id){
        $dbtable_N= empty($dbtable_N)?"fb_publish_user":$dbtable_N;
    	$this->db->where('fb_id', $fb_id);
    	$result =$this->db->get("fb_publish_user")->result();
    	if (!empty($result)){
    		return $result[0];
    	}else{
    		return array();
    	}
    }
    function query_users($dbtable_N = 'fb_publish_user',$page,$limit=20,$status_exception=array(),$orderby="",$sort_by="desc"){  
        $dbtable_N= empty($dbtable_N)?"fb_publish_user":$dbtable_N;
    	$result["rownum"]= $this->db->count_all("fb_publish_user");
    	$this->db->order_by($orderby,$sort_by);
    	$this->db->limit($limit,$page*$limit);
        
    	$result["data"]=$this->db->get("fb_publish_user")->result();
        foreach ($result["data"] as $user){
    		//$lunar_birthday[$user->fb_id]=date("Y-m-d",$this->lunar->S2L($user->birthday));
                //omega 20140624 need datetime discrete
                $user->create_date_day= date_format(date_create($user->create_time),"Y-m-d");
                $user->create_time=date_format(date_create($user->create_time),"H:i:s");      
    	} 
    	return $result;
    }
    function update_user_basic_data($dbtable_N = 'fb_publish_user',$fb_id,$data){   
        $dbtable_N= empty($dbtable_N)?"fb_publish_user":$dbtable_N;
    	$this->db->where('fb_id', $fb_id);
    	$this->db->update('fb_publish_user', $data);
    }    
    function add_user_message($data){    	
    	$this->db->insert('user_message', $data);
    }    
    function query_share_message($page,$limit=20,$status_exception=array(),$orderby="",$sort_by="desc"){   		    		 
    	$result["rownum"]= $this->db->count_all("user_message");
    	$this->db->order_by($orderby,$sort_by);
    	$this->db->limit($limit,$page*$limit);    	
    	$result["data"]=$this->db->get("user_message")->result();
        foreach ($result["data"] as $user){    	
                $user->create_date_day= date_format(date_create($user->create_time),"Y-m-d");
                $user->create_time=date_format(date_create($user->create_time),"H:i:s");      
    	}
    	return $result;
    }
}
?>
