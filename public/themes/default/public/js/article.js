$(document).ready(function() {
    /**
     * 代码高亮highlight
     */
    $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
    });

    /**
     * 科学公式TeX(KaTeX)
     */
    $("#editormd-view").find(".editormd-tex").each(function(){
        var tex  = $(this);
        katex.render(tex.text(), tex[0]);

        tex.find(".katex").css("font-size", "1.6em");
    });
});
