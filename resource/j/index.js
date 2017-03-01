$(function(){
	$(".mbtn").bind("click",function(){
		//save_analysis('首頁','點擊','免費送新品');
		window.location=WEBROOT+'/index.php/homepage/blogger';
	});
	
        
 
	 //20140923 Omega 取消行動版配置 
//	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
//		if ($(window).width()<1024){
//			window.location=WEBROOT+"/index.php/mobile";
//		}
//	}
});