/* global $ */
$(document).ready(function () {
    "use strict";

    $(".saveDraft").bind("click", function () {
        var message = CKEDITOR.instances.postBox.getData();
        var title = $('.TitleDraft').val();

        $.cookie('DraftTitle', title, { path: '/' });
        $.cookie('DraftMessage', message, { path: '/' });

        console.log('done');

        return false;
    });
});
