/**
 * Created by Administrator on 2016/10/20.
 */
BOSS.Index = {
    init : function(){
        that = this;
        var is_notice = $('input[name="notice"]').val();
        if(is_notice != ''){
            //须要能通知其他子站
            //向后台请求token和要通知的子站
            that.getAjax(BOSS.api.getNoticeInfo,{},function(d){
                if(d.errcode == 0){
                    var filter = {
                        'token' : d.data.token,
                        'user_id' : d.data.user_id
                    }
                    for(var i in d.notice_url){
                        that.setJsonp(d.notice_url[i], filter);
                    }
                }
            });
        }

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
    }
}
BOSS.Index.init();
