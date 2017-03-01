<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ah_util {

    var $CI;

    function __construct() {
        //CI初始化
        $this->CI = & get_instance();
        //載入library
        $this->CI->load->library('image_lib'); //處理縮圖與裁圖  
    }

    //判斷字串的日期格式
    function is_date($str) {
        $stamp = strtotime($str);

        if (!is_numeric($stamp)) {
            return FALSE;
        }
        $month = date('m', $stamp);
        $day = date('d', $stamp);
        $year = date('Y', $stamp);
        if (checkdate($month, $day, $year)) {
            return TRUE;
        }
        return FALSE;
    }

    //產生random字串,如:5NSBH5
    function make_hash($length = 6, $list = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz") {
        mt_srand((double) microtime() * 1000000);
        $newstring = "";
        if ($length > 0) {
            while (strlen($newstring) < $length) {
                $newstring.=$list[mt_rand(0, strlen($list) - 1)];
            }
        }
        return $newstring;
    }

    function page_style() {
        return array(
            //首頁
            "first_tag_open" => "<div style='float:left'>",
            "first_link" => "<img src='" . WEB_I . "/manage/table/paging_far_left.gif' width='24' height='24' border='0' />",
            "first_tag_close" => "</div>",
            //末頁
            "last_tag_open" => "<div style='float:left'>",
            "last_link" => "<img src='" . WEB_I . "/manage/table/paging_far_right.gif' width='24' height='24' border='0' />",
            "last_tag_close" => "</div>",
            //下一頁
            "next_tag_open" => "<div style='float:left'>",
            "next_link" => "<img src='" . WEB_I . "/manage/table/paging_right.gif' width='24' height='24' border='0' />",
            "next_tag_close" => "</div>",
            //上一頁
            "prev_tag_open" => "<div style='float:left'>",
            "prev_link" => "<img src='" . WEB_I . "/manage/table/paging_left.gif' width='24' height='24' border='0' />",
            "prev_tag_close" => "</div>",
            //自訂分頁數字連結
            "num_tag_open" => "<div style='float:left;margin:5px 5px'>",
            "num_tag_close" => "</div>",
            //自訂"目前頁面"連結名稱
            "cur_tag_open" => "<div style='float:left;margin:5px 5px;font-weight:bold;'>",
            "cur_tag_close" => "</div>"
        );
    }

    function create_folder($number, $layer = 4) {  //預設切4層
        $zero = '';
        for ($i = 1; $i <= $layer; $i++) {
            $zero.="0";
        }
        $number = $zero . $number;

        $return_str = '';
        for ($i = $layer; $i >= 1; $i--) {
            $return_str.=substr($number, $i * -1, 1) . "/";
        }

        $return_str = substr($return_str, 0, strlen($return_str) - 1);
        return $return_str;
    }

    function create_folder_entity($parent_dir, $number, $layer = 4) { //預設切4層
        $zero = '';
        for ($i = 1; $i <= $layer; $i++) {
            $zero.="0";
        }
        $number = $zero . $number;

        $folder = "";
        for ($i = 0; $i < $layer; $i++) {
            $folder.=substr($number, $i - $layer, 1);
            if (!is_dir($parent_dir . "\\" . $folder)) {
                mkdir($parent_dir . "\\" . $folder);
            }
            $folder.="\\";
        }

        return substr($folder, 0, strlen($folder) - 1);
    }

    function filechk($filename = '') {
        $upload_file_error = 'done';
        switch ($_FILES[$filename]['type']) {
            case "image/jpeg":
            case "image/pjpeg":
                $header_file_type = "jpg";
                break;
            case "image/png":
                $header_file_type = "png";
                break;
            default:
                $upload_file_error = "upload_type_error";
                break;
        }
        if ($_FILES[$filename]["error"] != 0) {
            $upload_file_error = "upload_error";
        }
        //判斷size是否正確(2M)
        if ($_FILES[$filename]["size"] > 1024 * 1024 * 2) {
            $upload_file_error = "over_size";
        }
        if ($upload_file_error != "") {
            $upload_file_error;
        }

        return $upload_file_error;
    }

    function img_resize($source, $target, $width, $height, $crop = true) {
        list($w, $h) = getimagesize($source);
        if ($w / $width > $h / $height) {
            $this->img['width'] = $w * ($height / $h);
            $this->img['height'] = $height;
            $this->img['x_axis'] = ($this->img['width'] - $width) / 2;
            $this->img['y_axis'] = 0;
        } else {

            $this->img['width'] = $width;
            $this->img['height'] = $h * ($width / $w);
            $this->img['x_axis'] = 0;
            $this->img['y_axis'] = ($this->img['height'] - $height) / 2;
        }
        $this->img['source_image'] = $source;
        $this->img['new_image'] = $target;
        $this->CI->image_lib->initialize($this->img);
        if (!$this->CI->image_lib->resize()) {
            echo "編輯失敗,檔案發生錯誤:" . $this->CI->image_lib->display_errors();
            die();
        }
        if ($crop == true) {
            $this->img['maintain_ratio'] = FALSE;   //不要讓長寬自動縮放                
            $this->img['source_image'] = $target;
            $this->img['width'] = $width;
            $this->img['height'] = $height;
            $this->CI->image_lib->initialize($this->img);
            if (!$this->CI->image_lib->crop()) {
                echo "編輯失敗,檔案發生錯誤:" . $this->CI->image_lib->display_errors();
                die();
            }
        }
    }
    
    function text_combined($config=array()) {        
        //image1  add text          
//        $config = array();
//        $config['source_image'] = $source;
//        $config['wm_text'] = $word;
//        $config['wm_type'] = 'text';
//        //load ttf word type
//        $config['wm_font_path'] = DOCROOT . "\\resource\c\\font\msjh.ttf";
//        $config['wm_font_size'] = $wm_font_size;
//        $config['wm_font_color'] = $word_color; //'FF0000'
//        $config['wm_vrt_alignment'] = 'top';
//        $config['wm_hor_alignment'] = 'left';
//        $config['wm_hor_x_axis'] = $wm_hor_x_axis;
//        $config['wm_vrt_y_axis'] = $wm_vrt_y_axis;
//        $config['wm_padding'] = '20';
//        $config['new_image'] = $target;
        $this->CI->image_lib->initialize($config);
        if (!$this->CI->image_lib->watermark()) {
            echo "編輯失敗,檔案發生錯誤:" . $this->CI->image_lib->display_errors();
            die();
        }
        $this->CI->image_lib->clear();
    }
    function img_combined($config = array()) {
//        $config = array();
//        $config['source_image'] = $source;
//        $config['wm_overlay_path'] = $src_child;
//        $config['wm_vrt_alignment'] = 'top';
//        $config['wm_hor_alignment'] = 'left';
//        $config['wm_hor_x_axis'] = $wm_hor_x_axis;
//        $config['wm_vrt_y_axis'] = $wm_vrt_y_axis;
//        $config['wm_opacity'] = 100; //圖片透明度
//        $config['wm_type'] = 'overlay';
//        $config['new_image'] =$target;
        $this->CI->image_lib->initialize($config);
        if (!$this->CI->image_lib->watermark()) {
            echo "編輯失敗,檔案發生錯誤:" . $this->CI->image_lib->display_errors();
            die();
        }
        $this->CI->image_lib->clear();
    }
    function ah_city_town(){
        $this->CI->load->model("ah_model"); 
        $city_query=$this->CI->ah_model->query_cities(0,10000,array("A"));
        $town_query=$this->CI->ah_model->query_towns(0,10000,array("A"));
        $ah_city_town['city']=$city_query['data'];

        foreach($town_query['data'] as $key=>$value){        
            $ah_city_town['town'][$value->city_id][]=array('town_name'=>$value->town_name,'zipcode'=>$value->zipcode);
        }        
        return $ah_city_town;
    }
    function ah_pic_encode($value){
        return substr(md5($value), 0,6).str_rot13(str_replace("=","",base64_encode($value)));
    }
    function ah_pic_decode($value){
        return base64_decode(str_rot13(substr($value,6)));
    }
    

}
