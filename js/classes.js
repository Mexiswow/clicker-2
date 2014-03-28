function Cookies(){}
Cookies.prototype = {
    get:function(name){
        var c_name = name;
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
    },
    set:function(name,value){
        var c_name = name;
        var exdate=new Date("2020","06","20");
        exdate.setDate(exdate.getDate());
        var c_value=escape(value) + "; expires="+exdate.toUTCString();
        document.cookie=c_name + "=" + c_value;
        return this.get(name);
    },
    delete:function(name){
        document.cookie=name + "=0; expires -1";
        return this.get(name);
    }
};
function AjaxClient(){}
AjaxClient.prototype = {
    post:function(func,data){
        var sendData = {ajax:func};
        var retData = {responseText:""};
        for(var dat in data){
            sendData[dat] = data[dat];
        }
        $.ajax({
            type:"POST",
            url:"posts/ajax.php",
            data:sendData,
            async:false
        }).done(function(d){
            retData = d;
        });
        return retData;
    }
};

function Timer(){}
Timer.prototype = {
    initCps:function(){
        var cps;
        if(cps = setInterval(function(){
            curCps = Cookies.prototype.get("cps");
            curClicks = Cookies.prototype.get("clicks");
            newClicks = curClicks + curCps;
            Cookies.prototype.set("clicks",newClicks);
        },1000)){
            return true;
        }
        return false;
    },
    destroyCps:function(){
        if(clearInterval(cps)){
            return true;
        }
        return false;
    }
};

function Clicker(){}
Clicker.prototype = {
    itemIdentAuto:".autoClickerList .autoClicker",
    itemIdentUpgr:".upgradeList .upgrade",
    clicks:0,
    cps:0,
    checkItems:function(){
        clicks = this.clicks;
        $(this.itemIdentAuto).each(function(){
            if(clicks >= parseInt($(this).attr("data-cost"))){
                console.log($(this).attr("data-cost")+":"+clicks);
                if(!$(this).hasClass("available")){
                    $(this).addClass("available");
                }
            }else{
                if($(this).hasClass("available")){
                    $(this).removeClass("available");
                }
            }
        });
    },
    click:function(){
        c=new Cookies;
        this.clicks = c.set("clicks",parseFloat(c.get("clicks"))+1);
        this.checkItems();
        return this.clicks;
    }
};