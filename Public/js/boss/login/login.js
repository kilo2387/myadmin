/**
 * Created by Administrator on 2016/10/20.
 */
BOSS.Login = {
    init : function(){
        var that = this;
        $('input[name="password"]').bind('input propertychange', function() {
            $('input[name="time_password"]').val(BOSS.Util.times33($(this).val()));
        });
        $('body').on('click','.btn-info',function(){
           var data = {
                'user_name' : $('input[name="user_name"]').val(),
                'time_password' : $('input[name="time_password"]').val(),
                'callback_url' : $('input[name="callback_url"]').val()
           };

            that.getAjax('/login/login',data,function(d){
                if(d.errcode == 0){
                    var filter = {
                        'token' : d.token,
                        'user_id' : d.user_id
                    };
                    that.post(d.callback_url,filter);
                    //var filter = {
                    //    'token' : d.token,
                    //    'user_id' : d.user_id
                    //}
                    //for(var i in d.subsystem){
                    //    that.setJsonp(d.subsystem[i], filter);
                    //}
                    //setTimeout(function(){
                    //    window.location.href = d.callback_url;
                    //},500);

                }else{
                    alert(d.errstr);
                }
            });


        });
    },
    getAjax : function (requestLink, filter, suc, err) {
        $.ajax({
            url:requestLink,
            type: 'POST',
            data: filter,
            dataType: 'json',
            success: function(d){
                suc && suc(d);
            },
            error : function(){
                err && err();
            }
        });
    },

    setJsonp : function(url,filter,suc,err){
        $.ajax({
            url:url,
            type: 'GET',
            data: filter,
            dataType: 'jsonp',
            success: function(d){
                suc && suc(d);
            },
            error : function(){
                err && err();
            }
        });
    },

    post : function(URL, PARAMS){
        var temp = document.createElement("form");
        temp.action = URL;
        temp.method = "post";
        temp.style.display = "none";
        for (var x in PARAMS) {
            var opt = document.createElement("textarea");
            opt.name = x;
            opt.value = PARAMS[x];
            // alert(opt.name)
            temp.appendChild(opt);
        }
        document.body.appendChild(temp);
        temp.submit();
        return temp;
    }
}
BOSS.Login.init();
