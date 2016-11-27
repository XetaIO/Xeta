$(document).ready(function () {
    "use strict";

    /**
     * Tooltip / Popover
     */
    $("body").tooltip({
        selector : "[data-toggle=tooltip]",
        trigger : "hover",
        html : true
    });
    $("body").popover({
        selector : "[data-toggle=popover]"
    });

    /**
     * ScrollUp.
     */
    $.scrollUp({
        scrollName : "scrollUp",
        scrollDistance : 300,
        scrollFrom : "top",
        scrollSpeed : 1000,
        easingType : "easeInOutCubic",
        animation : "fade",
        animationInSpeed : 200,
        animationOutSpeed : 200,
        scrollText : '<i class="fa fa-chevron-up"></i>',
        scrollTitle : " ",
        scrollImg : 0,
        activeOverlay : 0,
        zIndex : 1001
    });

    /**
     * Prettify.
     */
    prettyPrint();

    /**
     * Blog.
     */
    $(".confirmDeleteComment").bind("click", function () {
        var url = $(this).attr("data-url");

        $("#modalDeleteComment .btnDeleteComment").attr("href", url);
        $('#modalDeleteComment').modal('show');

        return false;
    });

    $(".editComment").bind("click", function () {
        var commentId = $(this).attr("data-id");

        $.ajax({
            type : "POST",
            url : $(this).attr("data-url"),
            headers : {
                'X-CSRF-Token': $(this).attr("data-csrf")
            },
            data : {
                id : commentId
            },
            dataType: "json",
            success : function (data) {
                if (!data.error) {
                    if (!$("#editingComment-" + commentId).length) {
                        var commentContent = $("#comment-" + commentId + " .content");

                        commentContent.fadeOut();
                        commentContent.after(data.html);

                        CKEDITOR.replace('commentBox-' + commentId, {
                            customConfig: 'config/comment.js'
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
            error : function (e) {
                $(".top-right").notify({
                    message: {
                        text: "Error to edit the comment."
                    },
                    type   : "danger"
                }).show();
            }
        });
        return false;
    });

    $(".ReplyQuote").bind("click", function () {
        $.ajax({
            type : "POST",
            url : $(this).attr("data-url"),
            headers : {
                'X-CSRF-Token': $(this).attr("data-csrf")
            },
            dataType : "json",
            success : function (data) {
                if (!data.error) {
                    CKEDITOR.instances.commentBox.insertHtml(data.comment);
                    $('html,body').animate({
                        scrollTop: $("#comment-form").offset().top
                    }, 'slow');
                } else {

                    $(".top-right").notify({
                        message: {
                            text: data.comment
                        },
                        type   : "danger"
                    }).show();
                }
            },
            error : function (e) {
                $(".top-right").notify({
                    message: {
                        text: "Error to quote the comment."
                    },
                    type   : "danger"
                }).show();
            }
        });
        return false;
    });


    $(".ArticleLike").bind("click", function () {
        var like = $(this),
            type = $(this).attr("data-type");
        $.ajax({
            type : "POST",
            url : $(this).attr("data-url"),
            headers : {
                'X-CSRF-Token': $(this).attr("data-csrf")
            },
            dataType : "json",
            success : function (data) {
                if (!data.error) {

                    if (like.attr("data-type") === "like") {

                        like.find('i').addClass('text-primary');
                        like.attr("data-original-title", data.title);
                        like.attr("data-url", data.url);
                        like.attr("data-type", "unlike");

                        $(".like-count").text(Number($(".like-count").text()) + 1);

                        /**
                         * Display message.
                         */
                        $(".top-right").notify({
                            message: { html: data.message },
                            type   : "primary"
                        }).show();
                    } else if (like.attr("data-type") === "unlike") {

                        like.find('i').removeClass('text-primary');

                        like.attr("data-original-title", data.title);
                        like.attr("data-url", data.url);
                        like.attr("data-type", "like");

                        $(".like-count").text(Number($(".like-count").text()) - 1);
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
            error : function () {
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

    /**
     * Users
     */
    $('.account-sidebar').affix({
        offset : {
            top : function () {
                var c = $('.account-sidebar').offset().top,
                    d = parseInt($('.account-sidebar').children(0).css("margin-top"), 10),
                    e = $(".navbar").height() + 10;
                return this.top = c - e - d;
            },
            bottom : function() {
                return this.bottom = $(".footer").outerHeight(!0);
            }
        }
    });

    $('.sidebar-profile').affix({
        offset : {
            top : function () {
                var c = $('.sidebar-profile').offset().top,
                    d = parseInt($('.sidebar-profile').children(0).css("margin-top"), 10),
                    e = $(".navbar").height() + 10;
                return this.top = c - e - d;
            },
            bottom : function() {
                return this.bottom = $(".footer").outerHeight(!0);
            }
        }
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
            dataType: "json",
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
                    message: {
                        text: "Error to mark the notification as readed."
                    },
                    type   : "danger"
                }).show();
            }
        });
        return false;
    });

    /**
     * Carousel Articles on Home page.
     */
    var news_articles_slide = $("#news-articles-slide");

    news_articles_slide.owlCarousel({
        items : 4,
        itemsDesktop : [1199,4],
        itemsDesktopSmall : [979,3],
        itemsTablet: [768,2],
        itemsMobile : [479,1],
        pagination: false
    });

    // Custom Navigation Events
    $(".next").click(function(){
        news_articles_slide.trigger('owl.next');
    });
    $(".prev").click(function(){
        news_articles_slide.trigger('owl.prev');
    });

    var news_comments_slide = $("#news-comments-slide");

    news_comments_slide.owlCarousel({
        items : 3,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,2],
        itemsTablet: [768,1],
        itemsMobile : [479,1],
        pagination: true,
        autoPlay : true,
        stopOnHover : true
    });

    $("#owl-related-posts").owlCarousel({
        autoPlay: 5000,
        stopOnHover: true,
        navigation: true,
        pagination: true,
        rewindNav: true,
        items: 2,
        itemsDesktopSmall: [1199, 2],
        itemsTablet: [977, 2],
        navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"]
    });


    /**
     * Cookies.
     */
    $('.closeCookies').bind("click", function () {
        $.ajax({
            type    : "POST",
            url     : $(this).attr("data-url"),
            dataType: "json",
            success : function (data) {
                $(".top-right").notify({
                    message: { text: data.message },
                    type   : "primary"
                }).show();
                $('.cookies').remove();
            },
            error : function (e) {
                $(".top-right").notify({
                    message: {
                        text: "Unable to write the cookie, please try again later."
                    },
                    type   : "danger"
                }).show();
            }
        });
        return false;
    });
});

//Sidebar
!(function ($) {
    "use strict";

    function mobilecheck() {
        var check = false;
        (function (a) {
            if (/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4)))check = true;
        })(navigator.userAgent || navigator.vendor || window.opera);
        return check;
    }

    function init() {
        var menu = $('#sidebar'),
            trigger = $('.sidebar-trigger'),
            overlay = $('<div></div>').addClass('sidebar-overlay'),

            eventtype = mobilecheck() ? 'touchstart' : 'click',

            resetMenu = function () {
                menu.removeClass('sidebar-opened');
                menu.addClass('sidebar-closed');
                overlay.remove();
            },

            closeClickFn = function (e) {
                resetMenu();
                overlay.unbind(eventtype, closeClickFn);
            };

        trigger.on(eventtype, function (e) {
            e.stopPropagation();
            e.preventDefault();

            if (menu.hasClass('sidebar-opened')) {
                resetMenu();

            } else {
                menu.removeClass('sidebar-closed');
                menu.addClass('sidebar-opened');
                menu.after(overlay);
                overlay.on(eventtype, closeClickFn);
            }
        });
    }

    init();

})(jQuery);
