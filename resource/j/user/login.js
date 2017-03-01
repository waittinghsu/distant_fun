if (typeof String.prototype.trim !== 'function') {
    String.prototype.trim = function() {
        return this.replace(/^\s+|\s+$/g, '');
    }
}

var accessToken = '';
var login_status = '';  //登入狀態
var fb_id = '';
function Yes_do_work(work){
    switch(work){
        case 'login' :
                $.ajax({
                    type: "POST",
                    url: do_login_url,
                    dataType: 'text',
                    data: "access_token=" + accessToken,
                    success: function(result) {
                        var resultobj = jQuery.parseJSON(result);
                        console.log(resultobj);
                        if(resultobj.status == 'done'){
                            window.location=resultobj.href;
                        }
                    }, error: function(doc, error) {
                            alert(error + doc);
                        }
                });
            break;
        case 'profile' :
                document.forms["profile_modify_form"].submit();
            break;   
        default :    
            break ;
    }
    
}
function get_login_status() {
    return login_status;
}
function get_accessToken() {
    return accessToken;
}
function get_fb_id() {
    return fb_id;
}
function fb_login(work) {
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
                                Yes_do_work(work);                            
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
    $("#facebooklogin").bind("click",function(){
        fb_login('login');
    });
    $('#profile_submit').bind('click',function(){        
        fb_login('profile');
    });   
 
    
});
