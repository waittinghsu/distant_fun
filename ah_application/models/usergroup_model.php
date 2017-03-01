<?php
class Usergroup_model extends CI_Model {
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
     function query_userqroup($page,$limit=20,$where_array,$orderby='',$sort_by="desc"){        
        $result=array();
        $this->db->start_cache();
        foreach ($where_array as $key => $value) {
            $this->db->where($key,$value);
        }
        $this->db->join('group', 'usergroup.groupId = group.Id');
        $this->db->join('userinfo', 'usergroup.userId = userinfo.Id');
        $this->db->join('userlogins', 'usergroup.userId = userlogins.userId');
        $this->db->stop_cache();
        
        $result['data']=$this->db->get('usergroup')->result();         
        $result['rownum']=  $this->db->count_all_results('usergroup');
        $this->db->flush_cache();
//        $result['sql']=  $this->db->last_query();
        return $result;  
    }
    function query_userqroup_cards($page,$limit=20,$where_array,$orderby='',$sort_by="desc"){        
        $result=array();
        $this->db->start_cache();
        foreach ($where_array as $key => $value) {
            $this->db->where($key,$value);
        }
        $this->db->stop_cache();

        $result['data']=$this->db->get('usergroup')->result();
        $this->db->flush_cache();
        $result['rownum']=  $this->db->count_all_results('usergroup');
//        $result['sql']=  $this->db->last_query();
        return $result;  
    }
    function query_usergroup_by_UGid($where_array){
        foreach ($where_array as $key => $value){
             $this->db->where($key, $value);
        }    
    	$result =$this->db->get("usergroup")->result();
    	if (!empty($result)){
    		return $result[0];
    	}else{
    		return array();
    	}
    }
    function query_usergroup_card_by_UGid($where_array){
        foreach ($where_array as $key => $value){
             $this->db->where($key, $value);
        }    
    	$result =$this->db->get("usergroup_cards")->result();
    	if (!empty($result)){
    		return $result[0];
    	}else{
    		return array();
    	}
    }
    function query_usergroup_card_member_byGID($where_array,$orderby="",$sort_by="desc"){
        $this->db->start_cache();
        foreach ($where_array as $key => $value){
             $this->db->where($key, $value);
        }  
        
        $this->db->join('usergroup','usergroup.Id = usergroup_cards.UserGroupId');
        $this->db->where('usergroup.usergroup_check ','Y');
         
        $this->db->stop_cache();   
        if($orderby != ""){
        $this->db->order_by($orderby,$sort_by);        
        }
    	$result['data'] =$this->db->get('usergroup_cards')->result();          
        $result['rownum']=  $this->db->count_all_results('usergroup_cards');
        $this->db->flush_cache();
       
//        $result['ss']=  $this->db->last_query();     
        return $result ;
    }
    function add_usergroup($data){
        $this->db->insert('usergroup', $data);
        return $this->db->insert_id();
    }
    function add_usergroup_cards($data){
        $this->db->insert('usergroup_cards', $data);
        return $this->db->insert_id();
    }
    function update_usergroup_cards($where_array = array(),$update_array=array()){
         foreach ($where_array as $key => $value){
            $this->db->where($key, $value);
        }
    	$this->db->update('usergroup_cards', $update_array);       
    }
    function GetRandCard($groupId,$userId){
        $query['data'] = $this->db->query("SELECT * 
            FROM (
             `usergroup_cards`
            )
            JOIN  `usergroup` ON  `usergroup`.`Id` =  `usergroup_cards`.`UserGroupId` 
            LEFT JOIN (
            SELECT  `usergroup_cards`.`PickUserId` AS  `passId` 
            FROM  `usergroup_cards` 
            WHERE  `usergroup_cards`.`PickUserId` IS NOT NULL
            ) AS  `passtable` ON  `passtable`.`passId` =  `usergroup`.`userId` 
            WHERE  `usergroup`.`groupId` =".$groupId.
            " AND  `passtable`.`passId` IS NULL 
            AND  `usergroup`.`userId` !=".$userId.
            " AND  `usergroup`.`usergroup_check` =  'Y'
            ORDER BY RAND() ")->result();      
        return $query;
    }
    
    

}
?>
