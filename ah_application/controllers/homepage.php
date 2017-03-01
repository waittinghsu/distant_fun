<?php
ini_set("display_errors", 1);
class Homepage extends CI_Controller {


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
                $data["pop"]=$this->load->view("pop",$data,true);//活動辦法  FB輸入框  黑影
                $data["menuchild_alt"]='menu_index';
		$data["menu"]=$this->load->view("menu",$data,true);        
                $data["sakura"]=$this->load->view("sakura",$data,true);        
		$this->load->view("index",$data);		
	}
        
	function blogger($page_url_parameter=Null){
                $data=array();
                $result=array();
                $Network_Model=array('natalie','doris','nancy','stella','fifi','anju','tyra');
                $Network_Models=array(
                    'natalie'=>array('model_num'=>1,
                                'model_name'=>'Natalie',
                                'model_description'=>'女人阿！就應該要像個永不凋零的花，越開越美麗阿～平常就一定要擁有戀愛般的好氣色，老公才不會亂看別人，知道嗎! 現在新流行戀愛妝感，就是要有粉嫩嫩的感覺 像花一樣這罐"Za裸妝心機輕潤粉底液"不會讓妳很慘白，用了會有自然透紅 粉嫩裸妝的好氣色喔！就像我不放棄追求美麗，"Za裸妝心機輕潤粉底液"能維持整天自然透紅粧效然後再上點腮紅，化個眉毛，就是我平常的妝囉'),
                    'doris'=>array('model_num'=>2,
                        'model_name'=>'Doris',
                                'model_description'=>'稿哩?'),
                    'nancy'=>array('model_num'=>3,
                        'model_name'=>'Nancy',
                                'model_description'=>'稿?'),
                    'stella'=>array('model_num'=>4,
                        'model_name'=>'Stella',
                                'model_description'=>'而這也是今夏最夯的「熱戀妝」，就是要讓大家都洋溢戀愛粉紅感不用太多的眼妝勾勒，把重點放在完美無瑕有光澤的底妝與嫩嫩好氣色!!Za的裸粧心機清潤粉底液服貼又自然，就算沒有在熱戀中，也可以讓別人看起來有熱戀fu，小鹿亂撞XDD'),
                    'fifi'=>array('model_num'=>5,
                        'model_name'=>'Fifi',
                                'model_description'=>'很多女孩都會問我約會妝容，我覺得除了電人的眼睛，清透無暇的底妝也是非常重要的呢!Za裸粧心機清潤粉底液是我最近在用的底妝，水感基底配方，很輕薄、輕透，不會讓人感到很厚重呢!!他自然透紅的粧感，再加上粉粉的腮紅跟淺色色的唇膏，搭起來就是百分百的約會戀愛妝容啦!!就算沒談戀愛沒有老公，也要隨時讓自已保持戀愛粉嫩好氣色有了另一伴，更加要讓自已維持在好的狀態，化上戀愛妝容像熱戀期那樣的幸福感唷!戀愛妝當然不能讓人以為油膩膩的，脫妝絕對是大NG的事情呀~ 選用戀愛妝的底妝就很重要囉!Za這瓶讓我在夏日出外也不輕易脫妝，而且妝感自然呈現出好氣色~ 又是開架的平價商品非常好入手的價位，推薦給大家!!
                    '),
                    'anju'=>array('model_num'=>6,
                        'model_name'=>'Anju',
                                'model_description'=>'覺得戀情要保持新鮮，平常還是要在對方面前呈現有打扮的感覺~妝容也很重要♡尤其底妝更是靈魂~覺得戀情要保持新鮮，平常還是要在對方面前呈現有打扮的感覺~妝容也很重要♡尤其底妝更是靈魂~今年夏天特別喜歡透亮底就算沒有另一半～上起妝來還是有戀愛中的粉嫩好氣色也有種“好像最近戀愛了”那種感覺～戀愛中的人更有熱戀期的感覺～女孩都要試看看自然粉嫩的底妝,搭配放淡的眼妝還有害羞腮紅,這可是今夏流行的戀愛妝感喲！照片是使用OC00Za裸粧心機輕潤粉底液！自然透紅真的好粉嫩！是不是感覺好有種戀愛中小女人的FU呢？'),
                    'tyra'=>array('model_num'=>7,
                        'model_name'=>'Tyra',
                                'model_description'=>'我喜歡的當然戀愛妝 一定是乾淨清新 細細的內眼線+刷上自然的睫毛膏不需要多餘的眼影來點綴  整體妝容要粉嫩粉嫩的粉紅感 唇色也是要粉嫩氣質可愛的顏色~~~讓你的妝容白裡透紅 所以底妝很重要!!! ::Za裸粧心機清潤粉底液:: 以水為基底配方 所以很薄透也讓肌膚自然透紅重點是持粧效果超讚的！整天不出油不脫粧唷！炎熱的夏天 熱戀中的你可不想臉上油膩膩泛油光~~~歐先生也喜歡我這種粉嫩自然透紅的粉紅感戀愛熱戀妝<3' ) 
                    ); 
                //判斷是否有參數以及有無在規定清單內  來設定page數值
                $page=((!isset($page_url_parameter)) || (!in_array($page_url_parameter,$Network_Model)))?"natalie":$page_url_parameter;
                $result['model_num']=$Network_Models[$page]['model_num'];
                $result['model_description']=$Network_Models[$page]['model_description'];
                $result['model_name']=$Network_Models[$page]['model_name'];
              
                $data=$result;        
                $data["pop"]=$this->load->view("pop",$data,true);//活動辦法  FB輸入框  黑影              
                $data["menu"]=$this->load->view("menu",$data,true); //主要選單 以及logo                   
                $this->load->view("blogger",$data);
	}
    function ppls100(){//20140630 加入百人推薦頁面  DB sharer                
		$data=array();                
                $data["pop"]=$this->load->view("pop",$data,true);//活動辦法  FB輸入框  黑影        
                $data["menu"]=$this->load->view("menu",$data,true);                
                //20140630 omega取得  百名網友分享
                $this->load->model("ppls100_model");
                $data["content"]=$this->ppls100_model->query_sharers(2,$limit=20);   
                $this->load->view("ppls100",$data);
	}	
	function index_test(){
		$data=array();
        $ah_city_town_query=$this->ah_util->ah_city_town();
        self::img_add_TextandImg();  
		$page=$this->input->get("page");
		$data["utm_source"]=$this->input->get("utm_source");
		$data["utm_medium"]=$this->input->get("utm_medium");
		$data["utm_campaign"]=$this->input->get("utm_campaign");
		switch ($page){
			case "index":
			default:
				$data["title"]="-";
				$data["description"]="，！， 。，！";
				$data["image"]="picShareIndex.jpg";  //resource/i
				break;
			case "blogger":
				$data["title"]="  ";
				$data["description"]=" ，！，！";
				$data["image"]="picShareBlogger.jpg";
				break;			
		}	
        $data['city']=  ($ah_city_town_query['city']);
        $data['town']= json_encode( $ah_city_town_query['town']);
		$this->load->view("index_test",$data);
	}
    private function img_add_TextandImg(){  
      
             /* --------------階段一:取得FB的大頭貼--------------- */
            $fbimg_url = "https://graph.facebook.com/" . '100004391437677' . "/picture?type=large";
            $target = 'resource/i/fb_img_make//' . 'FB100004391437677' . '.png';
            $this->curl->curl_imgdownload($fbimg_url, $target);  
//           $URL_to_image = file_get_contents("https://graph.facebook.com/".'100004391437677'."/picture?type=large");    
//           $creat_image = imagecreatefromstring($URL_to_image);
//           imagepng($creat_image,'resource/i/fb_img_make/'.'FB100004391437677'.'.png');         
            /* -----------------------END-------------------- */        
            /* --------------階段二:圖片resize--------------- */
            $source = FBIMG_DOC . '\\' . 'FB100004391437677' . '.png';
            $target = '';
            $this->ah_util->img_resize($source, $target, 110, 113, TRUE);
            /* -----------------------END--------------------- */
            $phototype_img='fb-1.jpg';
            $pic_name='100004391437677';
            /* --------------階段三:文字嵌入基本圖--------------- */        
            $config = array();
            $config['source_image'] = FBIMG_DOC . '\\'.$phototype_img;
            $config['new_image'] = FBIMG_DOC . '\\' . $pic_name . '.png';
            $config['wm_text'] = date('m') . ' 月' . date('d') . ' 日';
            $config['wm_type'] = 'text';
            //load ttf word type
            $config['wm_font_path'] = DOCROOT . "\\resource\c\\font\msjh.ttf";
            $config['wm_font_size'] = 10;
            $config['wm_font_color'] = 'b5b5b5'; //'FF0000'
            $config['wm_vrt_alignment'] = 'top';
            $config['wm_hor_alignment'] = 'left';
            $config['wm_hor_x_axis'] = 170;
            $config['wm_vrt_y_axis'] = 21;
            $config['wm_padding'] = '20';
            $this->ah_util->text_combined($config); 
            /* -----------------------END--------------------- */
            
             /* --------------階段三:文字嵌入基本圖--------------- */  
            $config = array();
            $config['source_image'] = FBIMG_DOC . '\\' . $pic_name . '.png';
    //        $config['new_image'] = FBIMG_DOC . '\\' . $pic_name . '.png';
            $config['wm_text'] = 17;
            $config['wm_type'] = 'text';
            //load ttf word type
            $config['wm_font_path'] = DOCROOT . "\\resource\c\\font\msjh.ttf";
            $config['wm_font_size'] = 10;
            $config['wm_font_color'] = 'FF3799'; //'FF0000'
            $config['wm_vrt_alignment'] = 'top';
            $config['wm_hor_alignment'] = 'left';
            $config['wm_hor_x_axis'] = 205;//184 205
            $config['wm_vrt_y_axis'] = 38;
            $config['wm_padding'] = '20';
            $this->ah_util->text_combined($config);   
            /* -----------------------END--------------------- */

            /* --------------階段四:將FB圖片嵌入基本圖------------ */  
            $config = array();
            $config['source_image'] = FBIMG_DOC . '\\' . $pic_name . '.png';
            $config['wm_overlay_path'] = FBIMG_DOC . "\\" . 'FB100004391437677' . '.png';
    //         $config['new_image'] = ;
            $config['wm_vrt_alignment'] = 'top';
            $config['wm_hor_alignment'] = 'left';
            $config['wm_hor_x_axis'] = 48;
            $config['wm_vrt_y_axis'] = 90;
            $config['wm_opacity'] = 100; //圖片透明度
            $config['wm_type'] = 'overlay';  
            $this->ah_util->img_combined($config);
            /* -----------------------END--------------------- */       
    }
}
?>