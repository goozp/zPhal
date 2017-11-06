var Editormd;

$(function () {
    // 编辑器
    Editormd = editormd("editormd", {
        width: "100%",
        height: 640,
        syncScrolling: "single",
        path: "/backend/plugins/editor.md/lib/",
        onload: function () {
            // 加载成功, 执行定时器
            setInterval(autoDraft, 120000);
        }
    });

    // 初始化select2插件
    $('.select2').select2();

    // 时间选择插件
    $('#datetimepicker').datetimepicker({
        //language:  'fr',
        todayBtn: 1, // 底部显示一个 "Today" 按钮用以选择当前日期
        autoclose: 1, // 当选择一个日期之后是否立即关闭此日期时间选择器。
        todayHighlight: 1, // 高亮当前日期
        startView: 'month', // 日期时间选择器打开之后首先显示的视图

    });

    // radio样式初始化
    checkRadio();

    // 图片预览
    $("#imageUrl").blur(function () {
        var url = $("#imageUrl").val();
        if (url == '') {
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
    $("#addNewCategory").click(function () {
        $("#post_category").show();
        var quickAddUrlCategory = $("#ajaxUri").val() + 'admin/post/quickAddTaxonomy/category';
        var categoryParent = $("#newCategoryParent").val();
        var newCategory = $("#newCategory").val();
        $.post(
            quickAddUrlCategory,
            {categoryParent: categoryParent, newCategory: newCategory},
            function (result) {
                res = JSON.parse(result);
                $("#post_category").hide();
                if (res.status == 'success') {
                    //刷新列表
                    $("#categoryList").html(res.data.categoryTree);
                    $("#newCategoryParent").html(res.data.categoryTreeNbsp);
                } else {
                    alert(result.message);
                }
            }
        );
    });

    // 添加标签
    $("#post_tag").hide();
    $("#addNewTag").click(function () {
        $("#post_tag").show();
        var quickAddUrlTag = $("#ajaxUri").val() + 'admin/post/quickAddTaxonomy/tag';
        var newTag = $("#newTag").val();
        $.post(
            quickAddUrlTag,
            {newTag: newTag},
            function (result) {
                res = JSON.parse(result);
                $("#post_tag").hide();
                if (res.status == 'success') {
                    //刷新列表
                    $("#tagsList").html("");//清空tags列表内容
                    $.each(res.data.tags, function (i, item) {
                        $("#tagsList").append("<option value='" + item.term_taxonomy_id + "'>" + item.name + "</option>");
                    });
                } else {
                    alert(res.message);
                }
            }
        );
    });
});

/**
 * 自动保存草稿
 */
function autoDraft() {
    var markdownWord = Editormd.getMarkdown();
    var title = $("#title").val();
    var postId = $("#post_id").val();

    if (markdownWord != '') {
        var autoDraftUrl = $("#ajaxUri").val() + 'admin/post/autodraft';
        $.post(
            autoDraftUrl,
            {markdownWord: markdownWord, title: title, postId: postId},
            function (result) {
                res = JSON.parse(result);
                if (res.status == 'success') {
                    // 更新提示
                    $("#postUrl").html(res.data.post_url);
                    $("#autoDraftTps").html("上一次自动保存草稿于："+res.data.post_date);
                    $("#post_id").val(res.data.post_id);
                } else {
                    alert(res.message);
                }
            }
        );
    }
}


