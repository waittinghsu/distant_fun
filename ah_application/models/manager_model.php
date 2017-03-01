<?php
class Manager_model extends CI_Model {
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
    function select_manager_login($id,$password,$status=""){
    	$this->db->where('id', $id);
    	$this->db->where('password', $password);
    	if ($status!=""){
    		$this->db->where('status', $status);
    	}
    	$result =$this->db->get("manager")->result();
    	if (empty($result)){
    		return array();
    	}else{
    		return $result[0];
    	}
    	 
    }
    function select_manager_by_id($id){
    	$this->db->where("id",$id);
    	$result =$this->db->get("manager")->result();
    	if (empty($result)){
    		return array();
    	}else{
    		return $result[0];
    	}    	
    }
    function get_managers_num(){
    	$this->db->where("status <>","D");
    	return $this->db->count_all_results("manager");
    }    
    function query_managers($page,$limit=20){
    	$this->db->where("status <>","D");
		$result["rownum"]=$this->db->count_all_results("manager");
		$this->db->where("status <>","D");
		$this->db->order_by("status");
		$this->db->limit($limit,$page*$limit);
		$result["data"]=$this->db->get("manager")->result();
		return $result;    	
    }
    function add_manager($id,$password,$manage_name,$sys_auth,$status,$memo){
    	$data["id"]=$id;
    	$data["password"]=$password;
    	$data["manager_name"]=$manage_name;
    	$data["sys_auth"]=$sys_auth;
		$data["status"]=$status;
		$data["memo"]=$memo;
		
		$this->db->insert('manager', $data);		

    }
    function update_manager($id,$password,$manage_name,$sys_auth,$status,$memo){
    	$data["password"]=$password;
    	$data["manager_name"]=$manage_name;
    	$data["sys_auth"]=$sys_auth;
    	$data["status"]=$status;
    	$data["memo"]=$memo;
    	$this->db->where("id",$id);
    	$this->db->update('manager', $data);
    }
    
    function update_login_time($id){
    	$data["last_login_time"]=date("Y-m-d H:i:s");
    	$this->db->where('id', $id);
    	$this->db->update('manager', $data);
    }

}
?>