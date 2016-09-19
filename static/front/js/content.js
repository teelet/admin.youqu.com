/**
 * Created by zhaoteng on 16/8/25.
 */
$(function () {
    
    // 保存二级标签的状态,secondClassArray 是二维数组arr[i][j][k],i表示一级标签，j表示二级标签,k=0 ischecked ; k= 1 val
    var secondClassArray = new Array();
    var oriFirstClass = $("#firstClassTag").val();
    var firstClassLength = $("#firstClassTag option").length;
    for(var i=0;i<firstClassLength;i++){
        secondClassArray[i] = new Array();
    }
    initSecond();
    function initSecond(){
        $("#secondClassTagCollect input").each(function(){
            secondClassArray[oriFirstClass][$(this).attr("name")] = new Array();
            secondClassArray[oriFirstClass][$(this).attr("name")][0] = $(this).is(":checked");
            secondClassArray[oriFirstClass][$(this).attr("name")][1] = $(this).val();
        });
    }
    function updateSecond(){
        $("#secondClassTagCollect input").each(function(){
            secondClassArray[$(this).attr("tag")][$(this).attr("name")] = new Array();
            secondClassArray[$(this).attr("tag")][$(this).attr("name")][0] = $(this).is(":checked");
            secondClassArray[$(this).attr("tag")][$(this).attr("name")][1] = $(this).val();
        });
    }
    //修改文章内容
    $('#updateArticleContent').on('click', function () {
        var title = $('#articleTitle').val().trim();
        if(title == ''){
            alert('文章标题不可为空');
            return;
        }
        var summary = $('#summary').val().trim();
        if(summary == ''){
            alert('文章摘要不可为空');
            return;
        }
        var articleType = $('#contentType').val();
        var articleForm = $('#contentStyle').val();
        if(confirm("确认修改该文章内容？")){
            var param = {};
            var aid = $('#aid').val();
            param['title'] = title;
            param['summary'] = summary;
            param['a_t_id'] = articleType;
            param['a_f_id'] = articleForm;
            var date = new Date($('#ctime').text().trim());
            param['ctime'] = date.getTime() / 1000;
            $.ajax({
                url  : '/ajax_article/updatecontent',
                type : 'POST',
                dataType : 'json',
                data : {'aid' : aid, 'json' : param},
                success : function (data) {
                    if(data.status == 0){
                        alert(data.result);
                        window.location.reload();
                    }
                }
            });
        }
    });
    //修改文章标签
    $('#updateArticletag').on('click', function () {
        if(confirm("确认修改该文章标签？")){

        }
    });
    // 删除前提示
    $(".delete").click(function(){
        if(confirm("确认删除该文章？")){
            var aid = $(this).attr('data-aid');
            $.ajax({
                url  : '/ajax_article/setarticlestatus',
                type : 'POST',
                dataType : 'json',
                data : {'aid' : aid, 'type' : 1},
                success : function (data) {
                    if(data.status == 0){
                        alert(data.result);
                        window.location.reload();
                    }
                }
            });
        }
    });
    // 一级标签改变，二级标签跟着变，如果一级标签的值和最开始的相同，则显示开始时的内容
    $("#firstClassTag").change(function(){
        updateSecond();
        var firstClass = $(this).val();
        var html = "";
        for(var k in secondClassArray[firstClass]){
            var check = secondClassArray[firstClass][k][0] == true ? "checked" : ""; 
            html += "<input type='checkbox' name='"+k+"' value='"+secondClassArray[firstClass][k][1]+"' tag='"+firstClass+"' id='"+k+"' "+check+"/>&nbsp;<label for='"+k+"'>"+secondClassArray[firstClass][k][1]+"</label>&nbsp;&nbsp;";
        }
        $("#secondClassTagCollect").html(html);
       
    });
    // 添加标签
    $("#addTag").click(function(){
        if($("#tag2add").val() == "0"){
            alert("请选择标签！");
            return;
        }
        var reg = /^[\-\+]?\d+(.\d+)?$/;
        if($("#tagScore").val() == "" || !reg.test($("#tagScore").val())){
            alert("请确认标签得分不为空，且为数字！");
            return;
        }
        
        // secondClassArray的长度
        var secondLength = 0;
        for(var i in secondClassArray){
            for(var m in secondClassArray[i]){
                secondLength ++;
            }
        }
        var index=secondLength + 1;
        var name="secondClassTag" + index;
        var value = $("#tag2add").val() + ":" +$("#tagScore").val();
        $("#secondClassTagCollect").append("<input type='checkbox' name='"+name+"' value='"+value+"' tag='"+$("#firstClassTag").val()+"'  id='"+name+"' checked/>&nbsp;<label for='"+name+"'>"+value+"</label>&nbsp;&nbsp;");
        secondClassArray[$("#firstClassTag").val()][name] = new Array();
        secondClassArray[$("#firstClassTag").val()][name][0] = false;
        secondClassArray[$("#firstClassTag").val()][name][1] = value;
    });
    // 点击取消
    $("input[name=cancel]").click(function(){
        location.href = "/contentManage";
    });

    // 修改密码
    $(".authTable #changePasswd").click(function(){
        var user = $(".authTable #change_mailbox").val().trim();
        if(user == ""){
            alert("用户名不能为空！");
            return false;
        }
        var password = $(".authTable #passwd_show").val().trim();
        if(password == ""){
            alert("密码不能为空！");
            return false;
        }
        $(".authTable #passwd_hidden").val($.sha1(password))
        return true;

    });

    // 修改权限
    $(".authTable #addAuth").click(function(){
        return check();
    });

    function check(){
        var user = $(".authTable #add_mailbox").val().trim();
        if(user == ""){
            alert("用户名不能为空！");
            return false;
        }
        if(user == "root"){
            alert("不可操作root用户！");
            return false;
        }
        var selected = new Array();
        $("#authModify input[type=checkbox]").each(function(){
            if($(this).is(":checked")){
                selected.push($(this).next("label").text());    
            }
        });
        var len = selected.length;
        var msg = "";
        if(len == 0){
            msg = "未选择任何权限，将删除账号 "+user+" ，是否继续？";
        }else{
            var auth = selected.join(",");
            msg = "确认修改账号 "+user+" 的权限为 “"+auth+"” ？";
        }
        if(!confirm(msg)){
            return false;
        }
        return true;
    }

    $(".selectPrevCheckbox").click(function(){
        var chk = $(this).prev("input[type=checkbox]");
        var clicked = chk.is(":checked");
        if(clicked){
            chk.prop("checked",false);            
        }else{
            chk.prop("checked",true);
        }
    });

    // 设置res_msg 自动隐藏
    if($("#res_msg").text() != ""){
        $("#res_msg").slideDown();
        $("#res_msg").slideUp(1500);
    }
    

});