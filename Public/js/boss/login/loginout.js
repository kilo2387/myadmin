/**
 * Created by Administrator on 2016/10/20.
 */
(function(){
    $('#loginout').click(function(){
        //进行本地退出操作
        getAjax('/login/loginOut',{},function(d){
            if(d.errcode == 0){
                //本地退出失败，通知其他站点
                var filter = {
                    user_id : d.data.user_id,
                    token : d.data.token,
                    is_login : 'n'
                }
                for(var i in d.data.notice_url){
                    setJsonp(d.data.notice_url[i], filter);
                }
                setTimeout(function(){
                    window.location.href = '/login/login';
                },1000);
            } else {
                alert(d.errstr);
            }
        });
    });

    var getAjax = function (requestLink, filter, suc, err) {
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
    };

    var setJsonp = function(url,filter,suc,err){
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
    }




})();
