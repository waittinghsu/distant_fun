/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function prototype (){    
}



///<reference path="jquery-1.11.0.min.js" />
///<reference path="WebModule.js" />

//ga code  
//var _gaq = _gaq || [];
//_gaq.push(['_setAccount', 'UA-54276726-1']);
//_gaq.push(['_setDomainName', 'none']); 
//_gaq.push(['_trackPageview']);
//
//(function() {
//    var ga = document.createElement('script');
//    ga.type = 'text/javascript';
//    ga.async = true;
//    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
//    var s = document.getElementsByTagName('script')[0];
//    s.parentNode.insertBefore(ga, s);
//})();
//
//function save_analysis(cate, act, tag) {
//    _gaq.push(['_trackEvent', cate, act, tag]);
//}
//function save_analysis_PV(cate_path) {
//    _gaq.push(['_trackPageview', cate_path]);
//}

(function(i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function() {
        (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
ga('create', 'UA-54276726-1', 'auto');
ga('send', 'pageview');

function save_analysis_NEVE(cate, act, tag) {
    ga('send', 'event',cate , act, tag);  
}

function save_analysis_NPV(cate_path) {
    ga('send', 'pageview', cate_path);  
}



//取得目前頁面位置 
navList_init.getClass = function () {
    var webpage = location.pathname.split('/');
    if (webpage[webpage.length - 1] == "" || webpage[webpage.length - 1] == "index.php")
        return "index";
    else if (webpage[webpage.length - 1] == "blogger")//目前頁面為XXXX
        return "blogger";
    else if (webpage[webpage.length - 1] == "test")
        return "test";
    else if (webpage[webpage.length - 1] == "product")
        return "product";
    else if (webpage[webpage.length - 1] == "actions")
        return "actions";
};

//還原參數  設定新網址
var getUrl = function (strUrl) {
    var Parameter = "";
    var utm_source = getParameter("utm_source");
    var utm_medium = getParameter("utm_medium");
    var utm_campaign = getParameter("utm_campaign");
    var utm_term = getParameter("utm_term");
    var utm_content = getParameter("utm_content");

    if (utm_source != undefined) Parameter = Parameter + ((Parameter == "") ? "utm_source=" + utm_source : "&utm_source=" + utm_source);
    if (utm_medium != undefined) Parameter = Parameter + ((Parameter == "") ? "utm_medium=" + utm_medium : "&utm_medium=" + utm_medium);
    if (utm_campaign != undefined) Parameter = Parameter + ((Parameter == "") ? "utm_campaign=" + utm_campaign : "&utm_campaign=" + utm_campaign);
    if (utm_term != undefined) Parameter = Parameter + ((Parameter == "") ? "utm_term=" + utm_term : "&utm_term=" + utm_term);
    if (utm_content != undefined) Parameter = Parameter + ((Parameter == "") ? "utm_content=" + utm_content : "&utm_content=" + utm_content);

    return (Parameter == "") ? strUrl : strUrl + "?" + Parameter;
};

//取得本頁面網址參數
var getParameter = function (strParam) {
    try {
        var url = unescape(window.location.search);
        var allParam = url.split("?")[1];
        var Params = allParam.split("&");
        for (var i = 0; i < Params.length; i++) {
            var Param = Params[i].split("=");
            if (Param[0] == strParam)
                return Param[1];
        }
        return undefined;
    }
    catch (e) {
        return undefined;
    }
};


function getCookie(name) {
    var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
    if (arr != null)
        return unescape(arr[2]);
    return null;

}
//例:SetCookie("opencookie", "Y");
function SetCookie(name, value) {
    var exp = new Date();
    exp.setTime(exp.getTime() + 1 * 60 * 60 * 1000); //keep 1 hour
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString() + ";path=/";
}



////網站meta設定
//var shareData = {
//    title: "test",
//    type: "website",
//    description: "tset",
//    image: "http://event.ah-solution.com.tw/omega_test/ahlogo.png",
//    url: "",//www.xxx.xxx.xx?utm_source=FB&utm_medium=referral&utm_campaign=earned_txtlink&utm_term=share&utm_content=e_metronews_1
//    Search: {
//        keywords: "test",
//        description: "test"
//    }
//};
////取得分享資訊
//$(function () {
//    //搜尋description
//    if ($("meta[name=\"description\"]").length === 0) {
//        var Search_description = document.createElement("meta");
//        $(Search_description).attr("name", "description");
//        $(Search_description).attr("content", shareData.Search.description);
//        $("head title").after(Search_description);
//    }
//    else {
//        shareData.Search.description = $("meta[name=\"description\"]").attr("content");
//    }
//    //搜尋keywords
//    if ($("meta[name=\"keywords\"]").length === 0) {
//        var Search_keywords = document.createElement("meta");
//        $(Search_keywords).attr("name", "keywords");
//        $(Search_keywords).attr("content", shareData.Search.keywords);
//        $("head title").after(Search_keywords);
//    }
//    else {
//        shareData.Search.keywords = $("meta[name=\"keywords\"]").attr("content");
//    }
//    //分享網址
//    if ($("meta[property=\"og:url\"]").length === 0) {
//        var og_url = document.createElement("meta");
//        $(og_url).attr("property", "og:url");
//        $(og_url).attr("content", shareData.url);
//        $("head title").after(og_url);
//    }
//    else if (typeof shareData.url === "undefined") {
//        shareData.url = location.href.replace(location.hash, "").replace(location.search, "");
//    }
//    else {
//        shareData.url = $("meta[property=\"og:url\"]").attr("content");
//    }
//    //圖片來源
//    if ($("meta[property=\"og:image\"]").length === 0) {
//        var og_image = document.createElement("meta");
//        $(og_image).attr("property", "og:image");
//        $(og_image).attr("content", shareData.image);
//        $("head title").after(og_image);
//    }
//    else {
//        shareData.image = $("meta[property=\"og:image\"]").attr("content");
//    }
//    //文案內容
//    if ($("meta[property=\"og:description\"]").length === 0) {
//        var og_description = document.createElement("meta");
//        $(og_description).attr("property", "og:description");
//        $(og_description).attr("content", shareData.description);
//        $("head title").after(og_description);
//    }
//    else {
//        shareData.description = $("meta[property=\"og:description\"]").attr("content");
//    }
//    //Type
//    if ($("meta[property=\"og:type\"]").length === 0) {
//        var og_type = document.createElement("meta");
//        $(og_type).attr("property", "og:type");
//        $(og_type).attr("content", shareData.type);
//        $("head title").after(og_type);
//    }
//    else {
//        shareData.type = $("meta[property=\"og:type\"]").attr("content");
//    }
//    //標題
//    if ($("meta[property=\"og:title\"]").length === 0) {
//        var og_title = document.createElement("meta");
//        $(og_title).attr("property", "og:title");
//        $(og_title).attr("content", shareData.title);
//        $("head title").after(og_title);
//    }
//    else {
//        shareData.title = $("meta[property=\"og:title\"]").attr("content");
//    }
//});



