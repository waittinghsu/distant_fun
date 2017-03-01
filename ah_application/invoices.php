<?php
ini_set("display_errors", 1);
class Invoices extends CI_Controller {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		//設定時區+8h
		date_default_timezone_set( "Asia/Taipei" );
		//載入helper
		$this->load->helper('url');
        //載入自訂公用類別
        $this->load->library("ah_util");
		//載入library
		$this->load->library('image_lib');//處理縮圖與裁圖
        $this->load->library("curl"); 		
		//載入model
		if ($this->input->cookie('utm_source')==""){
			setcookie("utm_source", strip_tags($this->input->get("utm_source")), time()+3600);  /* expire in 1 hour */
			setcookie("utm_medium", strip_tags($this->input->get("utm_medium")), time()+3600);  /* expire in 1 hour */
			setcookie("utm_campaign", strip_tags($this->input->get("utm_campaign")), time()+3600);  /* expire in 1 hour */
		}
	}
	function index(){			
		$data=array();
        $date_now=date("Y-m-d H:i:s");        
        $data['date_now']=($date_now > '2015-1-09 23:59:59')?'F':'T';           
       
        $data['meta']=array('keywords'=>'永信藥品、HAC、抽iPhone6、登錄發票、agenil、健康、晶亮葉黃膠囊、納麴Q10膠囊、活力五味子錠、蝶萃保濕系列',
            'title'=>'登錄發票-登錄購買HAC系列商品發票(折扣後滿699元)',
            'og-title'=>'登錄發票-登錄購買HAC系列商品發票(折扣後滿699元)',
            'description'=>'永信藥品HAC7週年感恩回饋，週週抽iPhone6,凡2014/11/01~12/31活動期間，於全省指定通路購買活動指定產品單筆消費折扣後滿699元，即可憑發票至活動網站參加週週抽iPhone6活動!(每張發票限登錄乙次)，越早登錄機會越多喔~',
            'og-description'=>'永信藥品HAC7週年感恩回饋，週週抽iPhone6,凡2014/11/01~12/31活動期間，於全省指定通路購買活動指定產品單筆消費折扣後滿699元，即可憑發票至活動網站參加週週抽iPhone6活動!(每張發票限登錄乙次)，越早登錄機會越多喔~');
		$data["content"]=$this->load->view("/content/invoices",$data,true);                
		$this->load->view("frame",$data);		
	}        
}
?>