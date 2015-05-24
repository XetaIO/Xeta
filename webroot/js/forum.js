/* global $ */
$(document).ready(function () {
    "use strict";

    $(".editPost").bind("click", function () {
        var postId = $(this).attr("data-id");

        $.ajax({
            type : "POST",
            url : $(this).attr("data-url"),
            data : {
                id : postId
            },
            dataType: "json",
            success : function (data) {
                if (!data.error) {
                    if (!$("#editingPost-" + postId).length) {
                        var postContent = $("#post-" + postId + " .message");

                        postContent.fadeOut();
                        postContent.after(data.html);

                        CKEDITOR.replace('postBox-' + postId, {
                            customConfig: 'config/forum.js'
                        });
                    }
                } else {
                    $(".top-right").notify({
                        message: {
                            text: data.errorMessage
                        },
                        type   : "danger"
                    }).show();
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

    $(".QuotePost").bind("click", function () {
        $.ajax({
            type : "GET",
            url : $(this).attr("data-url"),
            dataType : "json",
            success : function (data) {
                if (!data.error) {
                    CKEDITOR.instances.postBox.insertHtml(data.post);
                    $('html,body').animate({
                        scrollTop : $(".threadComment").offset().top
                    }, 'slow');
                } else {
                    $(".top-right").notify({
                        message : {
                            text : data.post
                        },
                        type : "danger"
                    }).show();
                }
            },
            error : function (e) {
                $(".top-right").notify({
                    message : {
                        text : "Error to quote the post."
                    },
                    type : "danger"
                }).show();
            }
        });
        return false;
    });

    $(".LikePost").bind("click", function () {
        var like = $(this),
            type = like.attr("data-type"),
            id = like.attr("data-id");

        $.ajax({
            type    : "POST",
            url     : like.attr("data-url"),
            data : {
                id : id,
                type : type
            },
            dataType: "json",
            success : function (data) {
                if (!data.error) {

                    if (type === 'like') {

                        like.removeClass('text-primary').addClass('text-success');
                        like.attr("data-original-title", data.title);
                        like.attr("data-url", data.url);
                        like.attr("data-type", "unlike");
                        like.html(data.text);

                        $(".likeCounter-" + id).text(Number($(".likeCounter-" + id).text()) + 1);

                        /**
                        * Display message.
                        */
                        $(".top-right").notify({
                            message: { html: data.message },
                            type   : "primary"
                        }).show();
                    } else if (type === "unlike") {

                        like.removeClass('text-success').addClass('text-primary');

                        like.attr("data-original-title", data.title);
                        like.attr("data-url", data.url);
                        like.attr("data-type", "like");
                        like.html(data.text);

                        $(".likeCounter-" + id).text(Number($(".likeCounter-" + id).text()) - 1);
                    }

                } else {

                    $(".top-right").notify({
                        message: {
                            text: data.message
                        },
                        type   : "danger"
                    }).show();
                }
            },
            error   : function () {
                $(".top-right").notify({
                    message: {
                        text: "Error to like/unlike the article."
                    },
                    type   : "danger"
                }).show();
            }
        });
        return false;
    });
});
