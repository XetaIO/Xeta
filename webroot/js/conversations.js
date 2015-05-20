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
                error: function (e) {
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
});
