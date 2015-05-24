$(document).ready(function () {
    "use strict";

    var colorAllConversationBackground = false;

    $(".colorConversationBackground").click(function(){
        if($(this).is(":checked")){
            $("#conversation-" + $(this).attr("value") + " td").css("background-color","#B5F3E7");
        } else {
            $("#conversation-" + $(this).attr("value") + " td").removeAttr('style');
        }
    });

    $(".colorAllConversationBackground").click(function(){
        if(colorAllConversationBackground === false) {
            $('.colorConversationBackground').each(function(){
                if(!$(this).is(":checked")) {
                    $(this).prop('checked', true);

                    $("#conversation-" + $(this).attr("value") + " td").each(function(){
                        $(this).css("background-color","#B5F3E7");
                    });

                    colorAllConversationBackground = true;
                }
            });
        } else {
            $('.colorConversationBackground').each(function(){
                if($(this).is(":checked")) {
                    $(this).prop('checked', false);

                    $("#conversation-" + $(this).attr("value") + " td").each(function(){
                        $(this).removeAttr('style');
                    });

                    colorAllConversationBackground = false;
                }
            });
        }

        return false;
    });

    $(".conversationActionSubmit").change(function(){
        var array = [];
        $('.colorConversationBackground:checked').each(function(){
            array.push($(this).attr("value"));
        });

        if($(this).val() === "exit") {
            $('#conversationQuitModal').modal('show');
        } else if($(this).val() !== "") {
            $.ajax({
                type: "POST",
                url: $("#conversationsForm").attr("action"),
                dataType: "json",
                data: {
                    conversations: array,
                    action: $(".conversationActionSubmit").val()
                },
                success: function (data) {
                    if (data.error == "0") {
                        $(".top-right").notify({
                            message: {
                                text: data.message
                            },
                            type: "success"
                        }).show();

                        setTimeout(function () {
                            $(location).attr("href", data.redirect);
                        }, 2e3);

                    } else if (data.error == "1") {
                        $(".top-right").notify({
                            message: {
                                text: data.message
                            },
                            type: "danger"
                        }).show();
                    }
                },
                error: function () {
                    $(".top-right").notify({
                        message: {
                            text: "Error to do this action."
                        },
                        type: "danger"
                    }).show();
                }
            });
            return false;
        }
    });

    $(".conversationQuitConfirm").click( function(){
        $('#conversationQuitModal').modal('hide');

        var array = [];
        $('.colorConversationBackground:checked').each(function(){
            array.push($(this).attr("value"));
        });

        $.ajax({
            type: "POST",
            url: $("#conversationsForm").attr("action"),
            dataType: "json",
            data: {
                conversations: array,
                action: $(".conversationActionSubmit").val()
            },
            success: function (data) {
                if (data.error == "0") {
                    $(".top-right").notify({
                        message: {
                            text: data.message
                        },
                        type: "success"
                    }).show();

                    setTimeout(function () {
                        $(location).attr("href", data.redirect);
                    }, 2e3);

                } else if (data.error == "1") {
                    $(".top-right").notify({
                        message: {
                            text: data.message
                        },
                        type: "danger"
                    }).show();
                }
            },
            error: function () {
                $(".top-right").notify({
                    message: {
                        text: "Error to do this action."
                    },
                    type: "danger"
                }).show();
            }
        });
        return false;

    });

    $("#InviteConversationUsers").typeahead({
        items: 12,
        comma: true,
        source: function (e, t) {
            var array = e.split(", ");
            var last = array[array.length-1];
            return $.post($("#InviteConversationUsers").attr("data-url"), {
                query: last
            }, function (e) {
                return t(e);
            }, "json");
        }
    });

    $(".QuoteMessage").bind("click", function () {
        $.ajax({
            type : "GET",
            url : $(this).attr("data-url"),
            dataType : "json",
            success : function (data) {
                if (!data.error) {
                    CKEDITOR.instances.messageBox.insertHtml(data.message);
                    $('html,body').animate({
                        scrollTop : $(".conversationComment").offset().top
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
                        text : "Error to quote the messsage."
                    },
                    type : "danger"
                }).show();
            }
        });
        return false;
    });

    $(".editMessage").bind("click", function () {
        var messageId = $(this).attr("data-id");

        $.ajax({
            type : "POST",
            url : $(this).attr("data-url"),
            data : {
                id : messageId
            },
            dataType: "json",
            success : function (data) {
                if (!data.error) {
                    if (!$("#editingMessage-" + messageId).length) {
                        var messageContent = $("#message-" + messageId + " .message");

                        messageContent.fadeOut();
                        messageContent.after(data.html);

                        CKEDITOR.replace('messageBox-' + messageId, {
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
});
