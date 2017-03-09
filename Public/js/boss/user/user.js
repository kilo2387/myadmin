/**
 * Created by Administrator on 2016/10/19.
 */
BOSS.User = {
    addAuth : $('#addAuth'),
    editAuth : $('#editAuth'),
    lockedUser : $('#lockedUser'),
    reSetUser : $('#user_repassword'),
    ListDom : $('#listTemplate'),
    pagesize : 15,
    TemplateFilter : {},
    RoleInfo : {},
    ProvinceInfo : {},
    CityInfo : {},
    AreaInfo : {},
    validateParams : {
    },
    init:function(){
        var that = this;
        //获得列表模版
        that.Template.getListTemp();
        //列表辅助信息
        that.getOtherInfo();
        //获取列表信息
        that.getList(1);
        //加载省份筛选
        that.Template.ProvinceDraw();

        //省份改变
        $('body').on('change','#sel_province',function(){
            var province_id = $(this).val();
            //先区的数据清空
            that.Template.AreaDraw({});
            //过滤出属于该省份的城市
            var data = that.getCity(province_id);
            //加载城市信息
            that.Template.CityDraw(data);
        });
        //城市改变
        $('body').on('change','#sel_city',function(){
            var city = $(this).val();
            //过滤出属于该城市的区
            var data = that.getArea(city);
            //加载区信息
            that.Template.AreaDraw(data);
        });

        //搜索按钮
        $('body').on('click','#user-search',function(){
            that.getList(1);
        });

        //添加弹窗
        that.lockedUser.on('show.bs.modal', function (event) {
            var model = $(this), button = $(event.relatedTarget), is_lock = button.data('status'),user_id = button.data('id');
            var flocked_name_title  = is_lock == 0?'锁定':'解锁';
            $('.change-status-title',model).html(flocked_name_title);
            $('input[name="user_id"]',model).val(user_id);
            var is_locked_user = is_lock == 0?'1':'0';
            $('input[name="is_locked_user"]',model).val(is_locked_user);
            that.checklockedValidate(model);
        });

        that.reSetUser.on('show.bs.modal', function (event) {
            var model = $(this), button = $(event.relatedTarget), user_id = button.data('id');
            $('input[name="user_id"]',model).val(user_id);
            //model.find('[name="user_password"]').attr('value', BOSS.Util.times33('123456'));
            $('input[name="user_password"]',model).val(BOSS.Util.times33('123456'));
            that.checkReSetPWValidate(model);
        });



    },
    //通过省份ID筛选出该省份的城市
    getCity : function(province_id){
        var data = [];
        for(var index in BOSS.User.CityInfo){
            if(BOSS.User.CityInfo[index]['fprovince_id'] == province_id){
                data.push(BOSS.User.CityInfo[index]);
            }
        }
        return data;
    },

    //通过城市ID筛选出该城市的区
    getArea : function(city_id){
        var data = [];
        for(var index in BOSS.User.AreaInfo){
            if(BOSS.User.AreaInfo[index]['fcity_id'] == city_id){
                data.push(BOSS.User.AreaInfo[index]);
            }
        }
        return data;
    },

    initselect:function($dom){
        $dom.selectpicker('refresh');
        $dom.selectpicker('show');
    },
    /**
     * 定义ajax请求
     * @param requestLink 请求链接
     * @param filter 传输的数据
     * @param suc
     * @param err
     */
    getAjax : function (requestLink, filter, suc, err) {
        var asyncFlag = true;
        filter.async == 'sync' && (asyncFlag = false);
        $.ajax({
            url:requestLink,
            type: 'POST',
            async: asyncFlag,
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

    //获得列表信息
    getList : function(pageindex){
        if(!BOSS.Lock.lock(BOSS.User.ListDom)){
            return false;
        }
        var filter = {
            province_id : $('#sel_province').val(),
            city_id : $('#sel_city').val(),
            area_id : $('#sel_area').val(),
            mchid : $('select[name="mchid"]').val(),
            is_checked : $('select[name="user_is_checked"]').val(),
            is_locked : $('select[name="user_is_locked"]').val(),
            begDate : $('input[name="begDate"]').val(),
            endDate : $('input[name="endDate"]').val(),
            search_type : $('select[name="search_type"]').val(),
            searchwords : $('input[name="searchWord"]').val(),
            pageindex : pageindex,
            pagesize: this.pagesize,
        }
        BOSS.User.getAjax(BOSS.api.getUserList,filter, function (d) {
            if(d.errcode == 0){
                BOSS.User.Template.Draw(d.data.result);
                $('.orders-num').html(d.data.pageinfo.total);
                BOSS.User.RefreshPage({total : d.data.pageinfo.total, pagesize : d.data.pageinfo.pagesize },$('.panel-footer'),pageindex);
            } else {
                BOSS.floatTips.errorTips(d.errstr);
            }
        });
        BOSS.Lock.unlock(BOSS.User.ListDom);
    },

    getOtherInfo : function(){
        BOSS.User.getAjax(BOSS.api.getOtherInfo,{async:'sync'}, function (d) {
            if(d.errcode == 0){
                BOSS.User.RoleInfo = d.data.roleinfo;
                BOSS.User.ProvinceInfo = d.data.provinceinfo;
                BOSS.User.CityInfo = d.data.cityinfo;
                BOSS.User.AreaInfo = d.data.areainfo;
            } else {
                BOSS.floatTips.errorTips(d.errstr);
            }
        });
    },

    //模版加载
    Template : {
        //得到模版并保存在本地缓存
        getListTemp : function(){
            BOSS.User.TemplateFilter.List = BOSS.User.ListDom.html();
            BOSS.Util.storage.serialize('BOSS_User_List_Template', BOSS.User.TemplateFilter.List);
        },
        Draw : function (data){
            var listStr = '',
                template = BOSS.Util.storage.deserialize('BOSS_User_List_Template'),
                template = BOSS.control.HTMLDeCode(template);

            if(!BOSS.valid.checkEmptyObj(data)){
                for (var i=0; i<data.length; i++){
                    data[i].frole_name = BOSS.User.RoleInfo[data[i].frole_id] != undefined?BOSS.User.RoleInfo[data[i].frole_id]['frole_name']:'';
                    data[i].fdepartment_name = BOSS.User.RoleInfo[data[i].frole_id] != undefined?BOSS.User.RoleInfo[data[i].frole_id]['fdepartment_name']:'';
                    data[i].create_time  = data[i].create_time != undefined?data[i].create_time:'';
                    data[i].office_clerk_name  = data[i].office_clerk_name != undefined?data[i].office_clerk_name:'';
                    data[i].phone  = data[i].phone != undefined?data[i].phone:'';
                    data[i].fis_locked_name  = data[i].fis_locked == 0?'未锁定':'已锁定';
                    data[i].flocked_name_title  = data[i].fis_locked == 0?'锁定':'解锁';
                    data[i].fis_checked_name  = data[i].fis_checked == 0?'未审核':'已审核';
                    listStr += tmpl(template, data[i]);
                }
            } else {
                listStr = '<tr><td class="text-center" colspan="12" rowspan="5">暂无数据</td></tr>';
            }
            listDom = $(listStr);
            BOSS.User.ListDom.html(listDom);
            BOSS.User.ListDom.show();
        },
        ProvinceDraw : function(){
            ListDom = $('#sel_province');
            listStr = '<option value="">选择省</option>';
            for (var index in BOSS.User.ProvinceInfo){
                listStr += '<option value="'+BOSS.User.ProvinceInfo[index]['fprovince_id']+'">'+BOSS.User.ProvinceInfo[index]['fprovince_name']+'</option>';
            }
            ListDom.html(listStr);
        },
        CityDraw : function(data){
            ListDom = $('#sel_city');
            listStr = '<option value="">选择城市</option>';
            for (var index in data){
                listStr += '<option value="'+data[index]['fcity_id']+'">'+data[index]['fcity_name']+'</option>';
            }
            ListDom.html(listStr);
            BOSS.User.initselect(ListDom);
        },
        AreaDraw : function(data){
            ListDom = $('#sel_area');
            listStr = '<option value="">选择区</option>';
            for (var index in data){
                listStr += '<option value="'+data[index]['farea_id']+'">'+data[index]['farea_name']+'</option>';
            }
            ListDom.html(listStr);
            BOSS.User.initselect(ListDom);
        },
    },


    /**
     * 添加验证并提交请求
     * @param model
     * @param validateParams
     */
    checkAddValidate : function (model) {
        var $parentBox = model.find('form');
        $parentBox.validate({
            debug: false,
            ignore: [],
            rules : BOSS.User.validateParams.rules,
            messages :  BOSS.User.validateParams.msg,
            submitHandler : function () {
                if(!BOSS.Lock.lock(BOSS.User.addAuth)){
                    return false;
                }
                BOSS.User.getAjax(BOSS.api.addAuth, $parentBox.serialize(), function (d) {
                    if (d.data != null) {
                        var msg = '添加成功！页面将在2秒内刷新';
                        BOSS.floatTips.successTips(msg);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        BOSS.floatTips.errorTips(d.errstr);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                    BOSS.Lock.unlock(BOSS.User.addAuth);
                    model.hide();
                }, 0);

            }
        });
    },

    /**
     * 修改验证并提交请求
     * @param model
     * @param validateParams
     */
    checkEditValidate : function (model) {
        var $parentBox = model.find('form');
        $parentBox.validate({
            debug: false,
            ignore: [],
            rules : BOSS.User.validateParams.rules,
            messages :  BOSS.User.validateParams.msg,
            submitHandler : function () {
                if(!BOSS.Lock.lock(BOSS.User.editAuth)){
                    return false;
                }
                BOSS.User.getAjax(BOSS.api.editAuth, $parentBox.serialize(), function (d) {
                    if (d.data != null) {
                        var msg = '修改成功！页面将在2秒内刷新';
                        BOSS.floatTips.successTips(msg);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        BOSS.floatTips.errorTips(d.errstr);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                    BOSS.Lock.unlock(BOSS.User.editAuth);
                    model.hide();
                }, 0);

            }
        });
    },

    /**
     * 锁定、解锁验证并提交请求
     * @param model
     * @param validateParams
     */
    checklockedValidate : function (model) {
        var $parentBox = model.find('form');
        $parentBox.validate({
            debug: false,
            ignore: [],
            submitHandler : function () {
                if(!BOSS.Lock.lock(BOSS.User.lockedUser)){
                    return false;
                }
                BOSS.User.getAjax(BOSS.api.lockedUser, $parentBox.serialize(), function (d) {
                    if (d.data != null) {
                        var msg = '修改成功！页面将在2秒内刷新';
                        BOSS.floatTips.successTips(msg);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        BOSS.floatTips.errorTips(d.errstr);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                    BOSS.Lock.unlock(BOSS.User.lockedUser);
                    model.hide();
                }, 0);
            }
        });
    },

    /**
     * 重置密码验证并提交请求
     * @param model
     * @param validateParams
     */
    checkReSetPWValidate : function (model) {
        var $parentBox = model.find('form');
        $parentBox.validate({
            debug: false,
            ignore: [],
            submitHandler : function () {
                if(!BOSS.Lock.lock(BOSS.User.reSetUser)){
                    return false;
                }
                BOSS.User.getAjax(BOSS.api.reSetUserPW, $parentBox.serialize(), function (d) {
                    if (d.data != null) {
                        var msg = '修改成功！页面将在2秒内刷新';
                        BOSS.floatTips.successTips(msg);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        BOSS.floatTips.errorTips(d.errstr);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                    BOSS.Lock.unlock(BOSS.User.reSetUser);
                    model.hide();
                }, 0);
            }
        });
    },

    /**
     * 创建/刷新渠道列表翻页控件
     * @param  {[type]} pg          翻页信息
     * @param  {[type]} pgContainer 控件容器
     * @param  {[type]} filter      渠道过滤关键词
     * @return {[type]}             [description]
     */
    RefreshPage: function(pg, pgContainer,pageNow) {
        var that = this;
        pageNum = Math.ceil(pg.total / pg.pagesize);
        if (pageNum > 1) {
            var p = {
                pageDom: pgContainer,
                pageNum: pageNum,
                pageNow: pageNow,
                onPageSwitch: function(index,onPageSwitchedCB) {
                    that.getList(index);
                }
            };
            new BOSS.control.page(p);
        } else {
            pgContainer.empty();
        }
    },

};
BOSS.User.init();