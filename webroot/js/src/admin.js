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
