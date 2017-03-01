var fullHeight;
var Loop_2Sec;
var Loop_1Sec;
var Loop_3Sec;
var indexInitial;
//===============DOM readied execute==================================================
//首頁
indexInitial = function(){}

/*********************************************global picture slide function**************************************/        
        
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~global picture slide function-  END~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
       //關閉 POP 視窗
         function close_message(){
                //滾到從右邊算起的-100%位置
                
                $(".des").stop(true,false).animate({right:"-100%"},1000,"easeOutExpo",function() {
                    $(".des").css('display',"none");
                    $(".popblock").css('display',"none");  
                    $(".publish").css("display","none");
                });                   
                $(".publish").stop(true,false).animate({right:"-100%"},1000,"easeOutExpo",function() {
                    $(".des").css('display',"none");
                    $(".popblock").css('display',"none");  
                    $(".publish").css("display","none");
                });    
        };
        //END
        
        
fullHeight = function(){
	
	var Hcont = $(window).innerHeight();
	var Wcont = $(window).innerWidth();  
	$(".container, .blo .main, .blo .net, .pro .net , .hun .net").css({height:Hcont, width:Wcont});
	$(".index .container, .index .main, .index .net, .index .main .bloggers").css({height:Hcont, width:Wcont});
	$(" .index .main .bloggersFrame").css({height:Hcont, width:Wcont*7});
	$(".pro .main .alltop").css({height:Hcont*0.7});
	$(".hun .main").css({height:Hcont, width:Wcont-360});

	//video 預設寬高
	var init_w=1920;
	var init_h=1080;
	var vr=init_w/init_h;

	if (Wcont/Hcont<vr){
		$(".bgLay1").css("height",Hcont);
		$(".bgLay1").css("width",init_w*(Hcont/init_h));
		$(".bgLay1").css("margin-left",((init_w*(Hcont/init_h))/2)*-1);
		$(".bgLay1").css("margin-top",Hcont/2*-1);

	}else{
		$(".bgLay1").css("width",Wcont);
		$(".bgLay1").css("height",init_h*(Wcont/init_w));
		$(".bgLay1").css("margin-top",((init_h*(Wcont/init_w))/2)*-1);
		$(".bgLay1").css("margin-left",Wcont/2*-1);
	}
  var indexTitleH = $(".index .mainText").innerHeight();
  $(".index .mainText .goBtn").css({height:indexTitleH, width:indexTitleH, marginRight:indexTitleH/2*-1});
  $(".blo .cons p").css({height:Hcont-166-107});
  var desBlackH = $(".des .black").innerHeight();
  $(".des .bgbgbg").css({height:desBlackH});
  $(".des .text").css({height:desBlackH-70});
}

//DOM ready then go.
$(document).ready(function() {     
	//setInterval("Loop_3Sec()",2000);

  
        /******************************************close按鈕觸發******************************************/
        $(".closer").on({
          mouseover: function(){},
          mouseleave: function(){},                
          click: function(){ 
            close_message();     
          }
        });
        /*------------------------------------鍵盤ESC觸發--------------------------------------*/
        var SubmitOrHidden = function(evt){
            evt = window.event || evt;
            if(evt.keyCode==27){//如果取到的键值是回车   
                   close_message();        
             }
         }
         window.document.onkeydown=SubmitOrHidden;
         /*------------------------------------鍵盤ESC觸發 END--------------------------------------*/

       

        $(".index .goBtn").on({
            mouseover: function(){
              $(".index .goBtn .on").stop(true, false).fadeTo(100,1);
            },
            mouseleave: function(){
              $(".index .goBtn .on").stop(true, false).fadeTo(200,0);
            },                
            click: function(){}
        });
         /******************************************MENU******************************************/
         
        $(".menu .btn0").on({
          mouseover: function(){
            $(".menu .btn0").stop(true, false).animate({left:-117},600,"easeOutExpo");
            $(".menu .btn0").siblings(".btn").stop(true, false).animate({left:0},600,"easeOutQuart");
           
          },
          mouseleave: function(){},                
          click: function(){}
        });

        $(".menu").on({
          mouseover: function(){
          },
          mouseleave: function(){
            $(".menu .btn0").stop(true, false).animate({left:0});
            $(".menu .btn1").stop(true, false).animate({left:-135});
            $(".menu .btn2").stop(true, false).animate({left:-64});
            $(".menu .btn3").stop(true, false).animate({left:-112});
            $(".menu .btn4").stop(true, false).animate({left:-162});
          },                
          click: function(){}
        });
        $(".menu .btn").on({
          mouseover: function(){
            $(this).find(".pinkBg").stop(true, false).animate({width:"100%"},300,"easeOutQuart");
          },
          mouseleave: function(){
            if($(this).attr("alt")!=="on"){
              $(this).find(".pinkBg").stop(true, false).animate({width:"0"},300,"easeOutExpo");
            }
          },                
          click: function(){}
        });
        /*------------------------------------MENU END--------------------------------------*/
        

	fullHeight();

	$(window).resize(function(){
		fullHeight();
	});
        
});//end// DOM ready then go.

	