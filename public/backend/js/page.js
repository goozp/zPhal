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

    /**
     * 发布时间
     */
    $('#editTimestamp').on('click', function() {
        initDateTimeSelect();
        $('#timestampDiv').slideDown();
        $('#editTimestamp').hide();
    });
    $('#cancelTimestamp').on('click', function() {
        $('#timestamp').html('立即发布'); 
        $('#publishDate').val('now');
        $('#timestampDiv').slideUp();
        $('#editTimestamp').show();
    });
    $('#saveTimestamp').on('click', function() {
        var year = $('#year').val();
        var month = $('#month').val();
        var day = $('#day').val();
        var hour = $('#hour').val();
        var minute = $('#minute').val();
        var str = "发布于 "+year+'-'+month+'-'+day+' '+hour+':'+minute;
        $('#timestamp').html(str);
        $('#publishDate').val('edit');
        $('#timestampDiv').slideUp();
        $('#editTimestamp').show();
    });
    $('#day,#hour,#minute').blur(function () {
        var value = $(this).val();
        if (value < 10){
            var length = value.toString().length;
            if (length == 0){
                $(this).val("00");
            }else if(length == 1){
                $(this).val("0"+value);
            }
        }
    });
});

/**
 * 初始化编辑时间
 */
function initDateTimeSelect() {
    var myDate = new Date();
    var cur_year=myDate.getFullYear();
    var cur_month=appendZero(myDate.getMonth()+1);
    var cur_day=appendZero(myDate.getDate());
    var cur_hour=appendZero(myDate.getHours());
    var cur_minute=appendZero(myDate.getMinutes());
    var second=appendZero(myDate.getSeconds());
    $('#cur_year').val(cur_year);
    $('#cur_month').val(cur_month);
    $('#cur_day').val(cur_day);
    $('#cur_hour').val(cur_hour);
    $('#cur_minute').val(cur_minute);
    $('#second').val(second);

    var hidden_year = $('#hidden_year');
    var year = $('#year');
    if (hidden_year.val() == ''){
        hidden_year.val(cur_year);
        year.val(cur_year);
    }else{
        if (year.val() == ''){
            year.val(hidden_year.val());
        }
    }

    var hidden_month = $('#hidden_month');
    var month = $('#month');
    if (hidden_month.val() == ''){
        hidden_month.val(cur_month);
        month.val(cur_month);
    }else{
        if (month.val() == ''){
            month.val(hidden_month.val());
        }
    }

    var hidden_day = $('#hidden_day');
    var day = $('#day');
    if (hidden_day.val() == ''){
        hidden_day.val(cur_day);
        day.val(cur_day);
    }else{
        if (day.val() == ''){
            day.val(hidden_day.val());
        }
    }

    var hidden_hour = $('#hidden_hour');
    var hour = $('#hour');
    if (hidden_hour.val() == ''){
        hidden_hour.val(cur_hour);
        hour.val(cur_hour);
    }else{
        if (hour.val() == ''){
            hour.val(hidden_hour.val());
        }
    }

    var hidden_minute = $('#hidden_minute');
    var minute = $('#minute');
    if (hidden_minute.val() == ''){
        hidden_minute.val(cur_minute);
        minute.val(cur_minute);
    }else{
        if (minute.val() == ''){
            minute.val(hidden_minute.val());
        }
    }
}

/**
 * 日期补0
 * @param obj
 * @returns {*}
 */
function appendZero (obj) {
    if (obj < 10) return "0" + obj; else return obj;
}

/**
 * 自动保存草稿
 */
function autoDraft() {
    var markdownWord = Editormd.getMarkdown();
    var title = $("#title").val();
    var postId = $("#post_id").val();
    var slugName = $("#slugName").val();

    if (markdownWord != '') {
        var autoDraftUrl = $("#ajaxUri").val() + 'admin/page/autodraft';
        $.post(
            autoDraftUrl,
            {markdownWord: markdownWord, title: title, postId: postId, slugName: slugName},
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