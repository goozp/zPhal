var Editormd;

$(function() {
    Editormd = editormd("editormd", {
        width   : "100%",
        height  : 640,
        syncScrolling : "single",
        path    : "/backend/plugins/editor.md/lib/"
    });

    //Initialize Select2 Elements
    $('.select2').select2()
});
