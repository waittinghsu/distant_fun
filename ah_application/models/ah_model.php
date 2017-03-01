<?php
class Ah_model extends CI_Model {
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
    function select_by_city_id($id){
    	$this->db->where('id', $id);
    	$this->db->where('status <> ', "D");
    	$result =$this->db->get("city")->result();
    	if (!empty($result)){
    		return $result[0];
    	}else{
    		return array();
    	}    
    }
    
    function select_by_city_name($city_name){
    	$this->db->where('city_name', $city_name);
    	$this->db->where('status <> ', "D");
    	$result =$this->db->get("city")->result();
    	if (!empty($result)){
    		return $result[0];
    	}else{
    		return array();
    	}    
    }
    
    function get_cities_num(){
    	$this->db->where("status <>","D");
    	return $this->db->count_all_results("city");
    }   
    function query_cities($page,$limit=20,$status=array()){
    	
    	$this->db->start_cache();
        if (!empty($status)){
    		$this->db->where_in("city.status",$status);
    	}
    	$this->db->stop_cache();
    	 	 
		$result["rownum"]=$this->db->count_all_results("city");
		
		$this->db->order_by("city.sort");
		$this->db->limit($limit,$page*$limit);
		$result["data"]=$this->db->get("city")->result();		
		$this->db->flush_cache();
		return $result;    	
    }
    function select_by_town_id($id){
    	$this->db->where('id', $id);
    	$this->db->where('status <> ', "D");
    	$result =$this->db->get("town")->result();
    	if (!empty($result)){
    		return $result[0];
    	}else{
    		return array();
    	}    
    }    
    function select_by_town_name($town_name){
    	$this->db->where('town_name', $town_name);
    	$this->db->where('status <> ', "D");
    	$result =$this->db->get("town")->result();
    	if (!empty($result)){
    		return $result[0];
    	}else{
    		return array();
    	}    
    }    
    function get_towns_num(){
    	$this->db->where("status <>","D");
    	return $this->db->count_all_results("town");
    }   
    function query_towns($page,$limit=20,$status=array(),$city_id=""){
    	
    	$this->db->start_cache();
        if (!empty($status)){
    		$this->db->where_in("town.status",$status);
    	}
    	if (!empty($city_id)){
    		$this->db->where("city_id",$city_id);
    	}
    	$this->db->stop_cache();    	 	 
		$result["rownum"]=$this->db->count_all_results("town");
		$this->db->order_by("town.zipcode");
		$this->db->limit($limit,$page*$limit);
		$result["data"]=$this->db->get("town")->result();		
		$this->db->flush_cache();
		return $result;    	
    }
}
?>
