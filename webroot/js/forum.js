$(document).ready(function () {

    $(".editPost").bind("click", function () {
        var postId = $(this).attr("data-id");

        $.ajax({
            type : "POST",
            url : $(this).attr("data-url"),
            data : {
                id : postId
            },
            dataType: "html",
            success : function (data) {
                if(!$("#editingPost-" + postId).length) {
                    var postContent = $("#post-" + postId + " .message");

                    postContent.fadeOut();
                    postContent.after(data);

                    CKEDITOR.replace('postBox-' + postId, {
                        customConfig: 'config/forum.js'
                    });
                }
            },
            error   : function (e) {
                $(".top-right").notify({
                    message: {
                        text: "Error to edit the post."
                    },
                    type   : "danger"
                }).show();
            }
        });
        return false;
    });
});
