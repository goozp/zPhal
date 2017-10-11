var Editormd;

$(function() {
    Editormd = editormd("editormd", {
        width   : "100%",
        height  : 640,
        syncScrolling : "single",
        path    : "/backend/plugins/editor.md/lib/"
    });

    // 初始化select2插件
    $('.select2').select2();


    $('#datetimepicker').datetimepicker({
        //language:  'fr',
        todayBtn:  1, // 底部显示一个 "Today" 按钮用以选择当前日期
        autoclose: 1, // 当选择一个日期之后是否立即关闭此日期时间选择器。
        todayHighlight: 1, // 高亮当前日期
        startView: 'month', // 日期时间选择器打开之后首先显示的视图

    });
});

