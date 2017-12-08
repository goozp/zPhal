$(function() {
    EditormdView = editormd.markdownToHTML("editormd-view", {
        htmlDecode      : "style,script,iframe",  // you can filter tags decode
        tocm            : true,    // Using [TOCM]
        tocContainer    : "#custom-toc-container", // 自定义 ToC 容器层
        //markdownSourceCode : false, // 是否保留 Markdown 源码，即是否删除保存源码的 Textarea 标签
        //saveHTMLToTextarea : true,
        emoji           : false,
        taskList        : true,
        tex             : true,  // 默认不解析
        flowChart       : true,  // 默认不解析
        sequenceDiagram : true  // 默认不解析
    });
});