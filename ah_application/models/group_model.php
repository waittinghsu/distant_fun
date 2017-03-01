<?php
class Group_model extends CI_Model {
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
    function query_group($page,$limit=20,$status_exception=array(),$orderby="",$sort_by="desc"){  
        $this->db->start_cache();
        $this->db->order_by($orderby,$sort_by);
    	$result["rownum"]= $this->db->count_all("group");
            foreach ($status_exception as $key => $value){
                $this->db->where($key,$value);
            }        
    	
    	$this->db->limit($limit,$page*$limit);
        $this->db->stop_cache();
    	$result["data"]=$this->db->get("group")->result();      
        $this->db->flush_cache();
    	return $result;
    }
    function query_group_by_id($id){
        $this->db->where('Id', $id);
    	$result =$this->db->get("group")->result();
    	if (!empty($result)){
    		return $result[0];
    	}else{
    		return array();
    	}
    }
  

}
?>
