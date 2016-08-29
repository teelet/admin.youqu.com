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
    // 删除前提示
    $(".delete").click(function(e){
        if(!confirm("确认删除该文章？")){
            e.preventDefault();
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
        $("#secondClassTagCollect").append("<input type='checkbox' name='"+name+"' value='"+value+"' tag='"+$("#firstClassTag").val()+"'  id='"+name+"'/>&nbsp;<label for='"+name+"'>"+value+"</label>&nbsp;&nbsp;");
        secondClassArray[$("#firstClassTag").val()][name] = new Array();
        secondClassArray[$("#firstClassTag").val()][name][0] = false;
        secondClassArray[$("#firstClassTag").val()][name][1] = value;
    });
    // 点击取消
    $("input[name=cancel]").click(function(){
        location.href = "/contentManage";
    });

    // 删除权限
    $(".authTable #delAuth").click(function(e){
        var user = $(".authTable #del_mailbox").val();
        if(user == ""){
            alert("邮箱前缀不能为空！");
            return;
        }
        var index = $(".authTable #del_auth").val();
        var msg = "";
        if(index == 0){
            msg = "确认删除账号"+user+"？";
        }else{
            var auth = $(".authTable #del_auth").find("option").eq(index).text();
            msg = "确认删除"+user+"的“"+auth+"”权限？";
        }
        if(!confirm(msg)){
            e.preventDefault();
        }
    });
    // 增加权限
    $(".authTable #addAuth").click(function(){
        var user = $(".authTable #add_mailbox").val();
        if(user == ""){
            alert("邮箱前缀不能为空！");
            return;
        }
    });
});