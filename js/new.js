var clicker;
var cookies;
var timer;
var ajaxClient;
$(function(){
    clicker = new Clicker;
    cookies = new Cookies;
    timer = new Timer;
    ajaxClient = new AjaxClient;
    $(".clickMe").on("click",function(){
        clicker.click();
    });
});
