var clicks = 0;
var cps = 0;

$(function(){
    
//    $(".navbar-form").submit(function(e){
//        e.preventDefault();
//        alert("That doesn't work yet.");
//    });
    
    $(".clearData").on("click",function(){
        clearInterval(fastTicker);
        clearInterval(ticker);
        clearCookies();
        document.location = document.location;
    });
    
    init();
    
    fastTicker = setInterval(function(){
        checkAutoClickers();
        $(".autoClicker.available").unbind("click");
        $(".autoClicker.available").on("click",function(){
            addAutoClicker($(this));
        });
    },50);
    ticker = setInterval(function(){
        cpsTick();
    },1000);
    
    saver = setInterval(function(){
        save();
    },30000);
    
    $(".msg > button").on("click",function(){
       $.post("posts/ajax.php",{ajax:"delmsg",id:$(this).data("id")});
    });
    $("#navLogout").on("click",function(){
        $.post("posts/ajax.php",{ajax:"logout"},function(data){
            if(data){
                location.reload();
            }
        });
    });
    
});

function init(){
    if(getCookie("cheater")){
        clearCookies();
    }

    if(isNaN(getC("clicks"))){
        clicks = "0";
        setCookie("clicks","0");
    }

    if(isNaN(getC("cps"))){
        cps = "0";
        setCookie("cps","0");
    }

    clicks = getC("clicks");
    cps = getC("cps");

    $(".curClicks .count").html(clicks);
    $(".curCPS .count").html(cps);
    
    $(".autoClicker").each(function(){
         
        if(getC("auto"+$(this).attr("data-id"))){
            $(this).attr("data-cost",getC("auto"+$(this).attr("data-id")));
        }

       $(this).find(".cost").html($(this).attr("data-cost"));
       if($(this).attr("data-cost") <= clicks){
           $(this).addClass("available");
       }else{
           $(this).removeClass("available");
       }
    });

    $(".clickMe").on("click",function(e){
       addClick(1);
    });
}

function clearCookies(){
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
    	var cookie = cookies[i];
    	var eqPos = cookie.indexOf("=");
    	var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    	document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}

function setCookie(c_name,value,exp){
    if(exp){
        var exdate = new date(exp);
    }else{
        var exdate=new Date("2020","06","20");
    }
    exdate.setDate(exdate.getDate());
    var c_value=escape(value) + "; expires="+exdate.toUTCString();
    document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name){
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1){
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1){
        c_value = null;
    }
    else{
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1){
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start,c_end));
    }
    return c_value;
}

function getC(name){
    x = getCookie(name);
    return parseInt(x);
}

function addClick(a){
//    if(!checkWithCookie("clicks") || getCookie("cheater"))
//        return false;
    clicks += parseInt(a);
    setCookie("clicks",clicks);
    $(".curClicks .count").html(clicks);
}

function addCps(a){
//    if(!checkWithCookie("cps") || getCookie("cheater"))
//        return false;
    cps += parseInt(a);
    setCookie("cps",cps);
    $(".curCPS .count").html(cps);
}

function cpsTick(){
//    if(!checkWithCookie("clicks")){
//        checkWithCookie("cps");
//    }
    addClick(cps);
}

//function checkWithCookie(name){
//    x = getC(name);
////    eval("y = " + name);
//    y = parseInt(eval(name));
//    if(x !== y || getCookie("cheater")){
//        clearInterval(ticker);
//        setCookie("cheater",true);
//        alert("stop cheating");
//        $(".clickMe").css("color","#B00");
//        return false;
//    }
//    return true;
//}

function addAutoClicker(row){
    cost = row.attr("data-cost");
    val = row.attr("data-value");
    if(cost<=clicks){
        clicks -= cost;
        newCost = parseInt(cost*row.attr("data-inc"));
        setCookie("auto"+row.attr("data-id"),newCost);
        row.attr("data-cost",parseInt(cost*row.attr("data-inc")));
        row.find(".cost").html(row.attr("data-cost"));
        addCps(val);
    }else{
        
    }
}

function checkAutoClickers(){
    $(".autoClicker").each(function(){
        $(this).find(".cost").html($(this).attr("data-cost"));
        if($(this).attr("data-cost") <= clicks){
            $(this).addClass("available");
        }else{
            $(this).removeClass("available");
        }
    });
}

function statusMessage(msg){
    x=new Date;
    $(".statusInfo").prepend("<div data-x='"+x.getTime()+"'>"+msg+"</div>");
    $(".statusInfo > div[data-x='"+x.getTime()+"']").delay(2000).fadeOut(3000,function(){
        $(".statusInfo > div[data-x='"+x.getTime()+"']").remove();
    });
}

function save(){
    clicks = getC("clicks");
    cps = getC("cps");
    $.post("posts/ajax.php",{ajax:"save",clicks:clicks,cps:cps},function(data){
        if(data){
            statusMessage(data);
        }
    });
}

function debug(){
    $.post("posts/ajax.php",{ajax:"ses"});
}