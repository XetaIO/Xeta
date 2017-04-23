$(document).ready(function () {
    /**
     * Tooltip / Popover
     */
    $("body").tooltip({
        selector: "[data-toggle=tooltip]",
        trigger : "hover",
        html    : true
    });
    $("body").popover({
        selector: "[data-toggle=popover]"
    });


    /**
     * Polls
     */
    var i = 0;

    $("#create-answer").bind("click", function () {
        var original = $('#duplicate-answer');
        var clone = original.clone();

        clone.attr("id", "new-answer" + ++i);
        clone.attr("class", "form-control");
        clone.appendTo("#answers-container");

        return false;
    });

    /**
     * Notifications
     */
    $('.notification-item').hover(function() {
        var id = $(this).attr("data-id");

        //Prevent for sending inutile request.
        if ($("#notification-" + id + " a .new").length == 0) {
            return false;
        }

        $.ajax({
            type : "POST",
            url : $(this).attr("data-url"),
            headers : {
                'X-CSRF-Token': $(this).attr("data-csrf")
            },
            dataType : "json",
            data : {
                id : id
            },
            success : function (data) {
                if (!data.error) {
                    $("#notification-" + id + " a .new").remove();
                }
            },
            error : function () {
                $(".top-right").notify({
                    message : {
                        text : "Error to mark the notification as readed."
                    },
                    type : "danger"
                }).show();
            }
        });
        return false;
    });
});
