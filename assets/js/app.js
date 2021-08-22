'use_strict';

jQuery(document).ready(function($){
    // Categories
    $('.all-categories-slider').owlCarousel({
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        loop: true,
        nav: true,
        dots: false,
        smartSpeed: 450,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });
    // Banners
    $('.banners-slider').owlCarousel({
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        loop: true,
        nav: true,
        dots: true,
        margin: 20,
        smartSpeed: 500,
        navText : ['<img src="/resources/themes/store/assets/images/arrow.svg" alt="Previous Slide">','<img src="/resources/themes/store/assets/images/arrow.svg" alt="Next Slide">'],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:2
            }
        }
    });
    // Signin popup
    $('.open_signin').on('click', function(e){
        e.preventDefault();
        $('.signin_popup').addClass('active');
        $('body').addClass('scoll-disable');
        $('.bglayer, .close_win').on('click', function(){
            $('.signin_popup').removeClass('active');
            $('body').removeClass('scoll-disable');
        });
    });


    // Open quick basket
    $('.cart_list li a').on('click', function(e){
        e.preventDefault();
        var button = $(this),
            target = $('.quick_cart_layer');
        button.toggleClass('active');
        target.toggleClass('active');
    });

    // Close tooltip
    $('.close_tooltip').on('click', function(e){
        e.preventDefault();
        $('.tooltip').addClass('hidden');
    });

    // Read coockie policy
    $('.read_cockie_policy').on('click', function(e){
        e.preventDefault();
        if ($(this).hasClass('reading')) {
            $(this).removeClass('reading').text('Read Coockie Policy');
        } else {
            $(this).addClass('reading').text('Close Coockie Policy Letter');
        }
        $('.read_cpolicy_text').toggleClass('reading');
    });

    // GDPR Banner - Get Cookie
    function getCookie() {
        var cookies = document.cookie;
        if (cookies) {
            $('.coockie_policy').addClass('accepted').removeClass('active');
        } else {
            $('.coockie_policy').addClass('active').removeClass('accepted');
        }
    }
    $('.close_coockie_policy').click(function(e){
        e.preventDefault();
        var expire_time = new Date(new Date().getTime() + 4320 * 60 * 10300);
        document.cookie = 'INTAKE_Market_GDPR_Message=Agreed; path=/; expires=' + expire_time;
        $('.coockie_policy').addClass('accepted').removeClass('active');
    });
    getCookie();

    // Become manufacturer
    $('.get_become_manufacturer').on('click', function(e){
        e.preventDefault();
        var target = $(this).attr('href');
        $(target).addClass('active');
        $('body').addClass('scoll-disable');
    });
    $('.bglayer, .close_win').on('click', function(e){
        e.preventDefault();
        $('.popup_win').removeClass('active');
        $('body').removeClass('scoll-disable');
    });

    // Become Manufacturer AJAX request
    $('.send_request_become_manufacturer').on('click', function (event) {
        event.preventDefault();
        $('span.error_notsent_small').remove();
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'ajax_become_manufacturer',
                user_id: $('.user_id').val(),
                name: $('.name').val(),
                email: $('.email').val(),
                type: $('.type').val(),
                message: $('.message').val(),
                demo_link: $('.demo_link').val(),
                date: $('.date').val()
            },
            success: function (response) {
                console.log(response);
                if (response) {
                    $('.become_manufacturer').removeClass('active');
                    $('body').removeClass('scoll-disable');
                    setTimeout(location.reload.bind(location), 500);
                } else {
                    $('<span class="error_notsent_small" style="display: block; color: #f00;">Error! Not sent. Try again.</span>').appendTo('.signin_win');
                }
            }
        });
    });

    // Messenger
    var params = window
    .location
    .search
    .replace('?','')
    .split('&')
    .reduce(
        function(p,e){
            var a = e.split('=');
            p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
            return p;
        },
        {}
    );

    $('.msid-item').each(function(){
        if ( $(this).hasClass('msid-' + params['msid']) ) {
            $(this).addClass('active');
        }
    });

    $('#messenger_form').on('submit', function (event) {
        event.preventDefault();
        $('span.sending_message_badge').addClass('show');
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'ajax_messenger',
                sender_id: $('.messenger_sender_id').val(),
                user_id: $('.messenger_user_id').val(),
                message: $('.respond_txtarea').val()
            },
            success: function (response) {
                $('.respond_txtarea').val('');
                $('span.sending_message_badge').removeClass('show');
                console.log(response);
            }
        });
    });

    // Delete message
    $('.delete_message a').on('click', function (event) {
        event.preventDefault();
        $('.confirm_deleting').addClass('active');
        $('.confirm_deleting .confiramtion_buttons a.cancel').on('click', function(event){
            event.preventDefault();
            $('.confirm_deleting').removeClass('active');
        });
        $('.confirm_deleting .confiramtion_buttons a.approve').on('click', function(event){
            event.preventDefault();
            $('.confirm_deleting').removeClass('active');
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'ajax_messenger_delete',
                    message_id: $('.delete_message a').data('id')
                },
                success: function (response) {
                    $('.messenger_row ul li a.active').parent().removeClass('live').addClass('deleted').html('<p class="deleted_message">This message was deleted by <strong>you</strong>.</p>');
                    $('.message_head').html('<div class="message_content" style="margin-top: 20px;">Select message to read.</div>');
                    $('.message_footer').remove();
                }
            });
        });
    });

    // Hide deleted message notify
    $('.close_deleted_notiify').on('click', function (event) {
        event.preventDefault();
        var ID = $(this).data('id');
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'ajax_messenger_delete_notify',
                notify_id: ID
            },
            success: function (response) {
                $('.message-' + ID).fadeOut(200);
                console.log(response);
            }
        });
    });

    // Choose account ID from list
    $('.compose_user_items ul li a').on('click', function(event){
        event.preventDefault();
        var ID = $(this).data('id');
        $('input.user_id').val(ID).attr('value', ID);
    });
    $('input.find_account').on('keyup', function(){
        var value = $(this).val();
    
        if ( value.length !== 0 ) {
            $('.compose_user_items ul li a').each(function(){
            var card = $(this).data('name');
      
            if (card.toLowerCase().indexOf(value.toLowerCase()) !== -1) {
              $(this).css('display', 'block');
            } else {
              $(this).css('display', 'none');
            }
          });
        } else {
          $('.compose_user_items ul li a').css('display', 'block');
        }
    });

    // Send composer form
    $('.compose_message_form_container').on('submit', function (event) {
        event.preventDefault();
        $('.loading_spiner').addClass('show');
        $('.messages_alerts .message').removeClass('show');
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'ajax_compose_message',
                sender_id: $('input.sender_id').val(),
                user_id: $('input.user_id').val(),
                message: $('textarea.message').val()
            },
            success: function (response) {
                if (response){
                    $('.user_id').val('');
                    $('.message').val('');
                    $('.messages_alerts .message.sent').addClass('show');
                } else {
                    $('.messages_alerts .message.notsent').addClass('show');
                }
                $('.loading_spiner').removeClass('show');
                console.log(response);
            }
        });
    });

    // Send review form
    $('form#commentform').on('submit', function (event) {
        event.preventDefault();
        $('.sending_preloader').addClass('show');
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'ajax_send_review',
                comment_author_IP: $('input[name="ip"]').val(),
                comment_agent: $('input[name="agent"]').val(),
                comment_post_ID: $('input[name="item_id"]').val(),
                comment_content: $('textarea#comment').val(),
            },
            success: function (response) {
                console.log(response);
                if ( response ) {
                    $('.sending_preloader').removeClass('show');
                    $('textarea#comment').val('');
                    $('.review_sent').addClass('active');
                } else {
                    $('.sending_preloader').removeClass('show');
                    $('.review_not_sent').addClass('active');
                }
            }
        });
    });

    // Rating circle
    var rating = $('#rating_circle').data('rating');
    var bar = new ProgressBar.Circle(rating_circle, {
        strokeWidth: 6,
        easing: 'easeInOut',
        duration: 2000,
        color: '#4CE426',
        trailColor: '#f0f0f0',
        trailWidth: 6,
        svgStyle: null
    });
      
    bar.animate(rating);
});