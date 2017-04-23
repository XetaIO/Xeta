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
     * Navbar Home Page.
     */
    var scroll_start = 0;
    var change_navbar = $('#change-navbar');
    var offset = change_navbar.offset();

    if (change_navbar.length){
      $(document).scroll(function() {
          scroll_start = $(this).scrollTop();
          if(scroll_start > (offset.top - 60)) {
              $(".navbar-inverse").attr('style', 'background-color: #fff !important;border-bottom: 4px solid rgba(0,0,0,0.1) !important;color: inherit !important');
          } else {
              $('.navbar-inverse').attr('style', 'background-color: transparent !important;border-bottom: transparent !important;color: #fff !important');
          }
      });
    }

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
                'X-CSRF-Token': Xeta.csrfToken
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
                'X-CSRF-Token': Xeta.csrfToken
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
                'X-CSRF-Token': Xeta.csrfToken
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
            headers : {
                'X-CSRF-Token': Xeta.csrfToken
            },
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
            type : "POST",
            url: $(this).attr("data-url"),
            headers: {
                'X-CSRF-Token': Xeta.csrfToken
            },
            dataType : "json",
            success : function (data) {
                $(".top-right").notify({
                    message : { text: data.message },
                    type : "primary"
                }).show();
                $('.cookies').remove();
            },
            error : function (e) {
                $(".top-right").notify({
                    message : {
                        text : "Unable to write the cookie, please try again later."
                    },
                    type : "danger"
                }).show();
            }
        });
        return false;
    });
});
