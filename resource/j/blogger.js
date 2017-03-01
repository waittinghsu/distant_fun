if (typeof String.prototype.trim !== 'function') {
    String.prototype.trim = function() {
        return this.replace(/^\s+|\s+$/g, '');
    }
}
function fb_pop_open() {
//            $(".fb_bb").show();
    $(".des").css("display", "");
    $(".popblock").css('display', "");
    $(".publish").css("display", "");
    $(".publish").stop(true, false).animate({right: "20%"}, 1000, "easeOutExpo");
}
function fb_pop_close() {
//    $(".fb_bb").hide();
        $(".des").css('display', "none");
        $(".popblock").css('display', "none");
        $(".publish").css('display', "none");
}
function is_valid_email(email) {
    return /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9])+$/.test(email);
}
function is_valid_phone(phone) {
    return /^09[0-9]{8}$/.test(phone);
}
var NowOn = 1; //目前鎖定的blogger
var blogger_url = new Array(10);
var blogger_pic = new Array(10);
//FB發文網址設定
blogger_url[0] = 'http://www.google.com.tw/?utm_source=event!!!utm_medium=fbtitle!!!utm_campaign=ah-event-fb-title';  // 20140630changeV2 -分享 塗鴉牆文字
blogger_url[1] = 'http://www.google.com.tw/?utm_source=event!!!utm_medium=fbtitle!!!utm_campaign=ah-event-fb-title';
blogger_url[2] = 'http://www.google.com.tw/?utm_source=event!!!utm_medium=fbtitle!!!utm_campaign=ah-event-fb-title';
blogger_url[3] = 'http://www.google.com.tw/?utm_source=event!!!utm_medium=fbtitle!!!utm_campaign=ah-event-fb-title';
blogger_url[4] = 'http://www.google.com.tw/?utm_source=event!!!utm_medium=fbtitle!!!utm_campaign=ah-event-fb-title';
blogger_url[5] = 'http://www.google.com.tw/?utm_source=event!!!utm_medium=fbtitle!!!utm_campaign=ah-event-fb-title';
blogger_url[6] = 'http://www.google.com.tw/?utm_source=event!!!utm_medium=fbtitle!!!utm_campaign=ah-event-fb-title';
//發文圖片設定  圖片需要600*600
blogger_pic[0] = 'fbShare600_BAS.jpg';// 20140630changeV 600*600-FB圖
blogger_pic[1] = 'fbShare600_BAS.jpg';
blogger_pic[2] = 'fbShare600_BAS.jpg';
blogger_pic[3] = 'fbShare600_BAS.jpg';
blogger_pic[4] = 'fbShare600_BAS.jpg';
blogger_pic[5] = 'fbShare600_BAS.jpg';
blogger_pic[6] = 'fbShare600_BAS.jpg';
var accessToken = '';
var login_status = '';  //登入狀態
var fb_id = '';
function get_login_status() {
    return login_status;
}
function get_accessToken() {
    return accessToken;
}
function get_fb_id() {
    return fb_id;
}
function fb_login() {
    //因為權限不夠所以暫時關閉
    var check_auth = "publish_stream,email,user_birthday,publish_actions";          //
    //沒有權限情況下的繞道
    //var check_auth="email";         
    FB.login(function(response) {
        if (response.authResponse) {
            FB.api('/me', function(response) {
                FB.getLoginStatus(function(response) {
                    if (response.status === 'connected') {  // 程式有連結到 Facebook 帳號
                        FB.api({method: 'fql.query', query: 'SELECT ' + check_auth + ' FROM permissions WHERE uid=me()'}, function(resp) {
                            accessToken = response.authResponse.accessToken;
                            for (var key in resp[0]) {
                                if (resp[0][key] === "1") {
                                    accessToken = response.authResponse.accessToken; // 取得 accessToken
                                    login_status = 'Y';
                                    fb_id = response.authResponse.userID;
                                } else {
                                    login_status = 'NA';
                                    break;
                                }
                            }
                            if (login_status == 'Y') {
                                //開啟輸入框填寫分享文章
                                fb_pop_open();
                                //end
                                //若有留過資料, 則自動代入上次留的                                                                        
                                $.ajax({
                                    type: "POST",
                                    url: user_data_url,
                                    dataType: 'text',
                                    data: "access_token=" + accessToken,
                                    success: function(result) {
                                        var user_data = jQuery.parseJSON(result);
//		    			$("#user_name").val(user_data.user_name);
                                        $("#phone").val(user_data.phone);
                                        $("#email").val(user_data.email);
                                        $("#address").val(user_data.address);
                                        //	alert(result);
                                    }, error: function(doc, error) {
                                        alert(error + doc);
                                    }
                                });
                            }
                        });
                    } else if (response.status === 'not_authorized') {  // 帳號沒有連結到 Facebook 程式	    		    
                        login_status = 'NA';
                    } else {
                        login_status = 'E';
                    }
                });
            });
        } else {
            login_status = 'C';
        }
    }, {scope: 'publish_stream,email,user_birthday'});
}
var submit = false;
var user_move = false;
$(document).ready(function() {
    //分享文章消除預設內容，強迫user輸入內容，避免FB APP被停權
    $("#message").bind("click", function() {
        $("#message").removeAttr("placeholder");
    }); 
    $(".share").bind("click", function() {
        NowOn = parseInt($(this).attr("class").substr(1, 2));
        var blogger_name = '';
        switch (NowOn) {
            case 1:
                blogger_name = 'who';
                break;
            case 2:
                blogger_name = 'who';
                break;
            case 3:
                blogger_name = 'who';
                break;
            case 4:
                blogger_name = 'who';
                break;
            case 5:
                blogger_name = 'who';
                break;
            case 6:
                blogger_name = 'who';
                break;
            case 7:
                blogger_name = 'who';
                break;
        }
        //save_analysis_NEVE('人氣網模推薦','點擊','人氣網模推薦-'+blogger_name+'分享FB');
        //如果要掠過FB做測試要開啟  輸入框               
//        fb_pop_open();
        fb_login();
    });

    $(".confirm").bind("click", function() {
        //save_analysis_NEVE('人氣網模推薦','點擊','確認並發佈');
        if (submit == true) {
            return;
        }
        if ($("#message").val().trim() == "") {
            alert("請填入分享文字");
            return;
        }
//        if ($("#user_name").val().trim() == "") {
//            alert("請填入您的姓名");
//            return;
//        }
        if (is_valid_email($("#email").val()) != true) {
            alert("您的E-mail格式不正確呢");
            return;
        }
        if ($("#phone").val().trim() == "") {
            alert("您的聯絡電話忘了填呢");
            return;
        }
//        if (is_valid_phone($("#phone").val().trim()) != true) {
//            alert("您的聯絡電話格式不正確");
//            return;
//        }
        if ($("#address").val().trim() == "") {
            alert("您的聯絡地址忘了填呢");
            return;
        }
        submit = true;      
        $.ajax({
//            async: false,
            type: "POST",
            url: publish_url,
            dataType: 'text',
            data:{
                "access_token":  accessToken,
                "message":       $("#message").val().trim(),
//                "user_name":     $("#user_name").val().trim(),
                "email":         $("#email").val().trim() ,
                "phone":         $("#phone").val().trim(),
                "address":       $("#address").val().trim(),
                "blogger_url":   blogger_url[NowOn - 1],
                "blogger_pic":   blogger_pic[NowOn - 1],
            },          
            success: function(result) {
                submit = false;
                //alert(result);
            }, error: function(doc, error) {
                //alert(error+doc);
                submit = false;
            }
        });
        //關閉輸入框
        $(".publish").stop(true, false).animate({right: "-100%"}, 3600, "easeInQuart", function() {
            fb_pop_close();
        });
        alert('資料已送出');

    });


});
/**
 * 
var publish_url = "網址/index.php/ajax/publish";
  $.ajax({
//                            type: "json",
                            url: publish_url,
                            dataType: 'Jsonp',
                            contentType: "application/json; charset=utf-8",
                            jsonp: 'callback',
                            jsonpCallback: 'remoteANS',
                            data: {
                                "access_token": accessToken,
                                "phone": $("#phone").val().trim(),
                                "user_name": $("#user_name").val().trim(),
                                "email": $("#email").val().trim(),
                                "message":$("#message").val().trim(),
                                "blogger_url": blogger_url[NowOn-1],
                                "blogger_pic": blogger_pic[NowOn-1],  
                                "address":$("#address").val().trim(),
                            },
                            success: function(json) {
                                if (json.ans != "Y") {
                                    alert(json.ans);                                  
                                    return;
                                }
                                submit = false;                              
                            }
                        });
 * 
 */

/*
 * 
 user_data_url = '網址/index.php/ajax/user_data';
        $.ajax({
            url: user_data_url,
            dataType: 'Jsonp',
            contentType: "application/json; charset=utf-8",
            jsonp: 'callback',
            jsonpCallback: 'remoteANS',
            data: {
                "access_token": accessToken,                                
            },
            success: function(json) {
                $("#user_name").val(json.user_name);
                $("#phone").val(json.phone);
                $("#email").val(json.email);
                $("#address").val(json.address);
            }
        });
 * 
 */