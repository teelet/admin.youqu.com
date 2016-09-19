/**
 * Created by shaohua5 on 16/8/25.
 */
$(function () {
    //获取游戏下的角色
    $('#gid').on('change', function () {
        var gid = $(this).val();
        if(gid){
            $.ajax({
                url  : '/ajax_game/getgameroles',
                type : 'GET',
                dataType : 'json',
                data : {'gid' : gid},
                success : function (data) {
                    $('#rid').html(data.result);
                }
            });
        }
    });
});