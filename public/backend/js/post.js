var Editormd;

$(function() {
    // 编辑器
    Editormd = editormd("editormd", {
        width   : "100%",
        height  : 640,
        syncScrolling : "single",
        path    : "/backend/plugins/editor.md/lib/"
    });

    // 初始化select2插件
    $('.select2').select2();

    // 时间选择插件
    $('#datetimepicker').datetimepicker({
        //language:  'fr',
        todayBtn:  1, // 底部显示一个 "Today" 按钮用以选择当前日期
        autoclose: 1, // 当选择一个日期之后是否立即关闭此日期时间选择器。
        todayHighlight: 1, // 高亮当前日期
        startView: 'month', // 日期时间选择器打开之后首先显示的视图

    });

    // radio样式初始化
    checkRadio();

    // 图片预览
    $("#imageUrl").blur(function(){
        var url = $("#imageUrl").val();
        if (url == ''){
            url = '/backend/img/error_image.png';
        }
        $("#imagePreview").html(
            "<label>预览</label> " +
            "<div> " +
            "<img src='" + url + "' width='200' height='200'> " +
            "</div>"
        );
    });

    // 添加分类
    $("#post_category").hide();
    $("#addNewCategory").click(function(){
        $("#post_category").show();
        var quickAddUrlCategory = $("#quickAddUrlCategory").val();
        var categoryParent = $("#newCategoryParent").val();
        var newCategory = $("#newCategory").val();
        $.post(
            quickAddUrlCategory,
            {categoryParent:categoryParent, newCategory:newCategory},
            function(result){
                $("#post_category").hide();
                console.log(result);
                if (result.status == 'success'){
                    //刷新列表

                }else{
                    alert(result.message);
                }
            }
        );
    });

    // 添加标签
    $("#post_tag").hide();
    $("#addNewTag").click(function(){
        $("#post_tag").show();
        var quickAddUrlTag = $("#quickAddUrlTag").val();
        var newTag = $("#newTag").val();
        $.post(
            quickAddUrlTag,
            {newTag:newTag},
            function(result){
                $("#post_tag").hide();
                console.log(result);
                if (result.status == 'success'){
                    //刷新列表

                }else{
                    alert(result.message);
                }
            }
        );
    });
});

function changePublishTime(type) {
    if (type == 'now'){
        $("#publishTimeNowDiv").addClass("has-success");
        $("#publishTimeCustomDiv").removeClass("has-success");
    } else if (type == 'custom'){
        $("#publishTimeNowDiv").removeClass("has-success");
        $("#publishTimeCustomDiv").addClass("has-success");
    }

}

function checkRadio() {
    var checkedRadio = $("input[name='publishTime']:checked").val();
    if (checkedRadio == 'now'){
        $("#publishTimeNowDiv").addClass("has-success");
    } else if(checkedRadio == 'custom') {
        $("#publishTimeCustomDiv").addClass("has-success");
    }
}

