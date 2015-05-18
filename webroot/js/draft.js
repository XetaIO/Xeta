/* global $ */
$(document).ready(function () {
    "use strict";

    $(".saveDraft").bind("click", function () {
        var message = CKEDITOR.instances.postBox.getData();
        var title = $('.TitleDraft').val();

        $.cookie('DraftTitle', title, { path: '/' });
        $.cookie('DraftMessage', message, { path: '/' });

        $(".top-right").notify({
            message : {
                text : $(".saveDraft").attr('data-text')
            },
            type : "primary"
        }).show();

        return false;
    });

    $(".cleanDraft").bind("click", function () {

        $.removeCookie('DraftTitle', { path: '/' });
        $.removeCookie('DraftMessage', { path: '/' });

        $(".top-right").notify({
            message : {
                text : $(".cleanDraft").attr('data-text')
            },
            type : "primary"
        }).show();

        return false;
    });
});
