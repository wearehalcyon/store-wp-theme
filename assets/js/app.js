'use_strict';

jQuery(document).ready(function($){
    // Nice Select init
    $('.orderby').niceSelect();
    // Categories
    $('.all-categories-slider').owlCarousel({
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        loop: true,
        nav: false,
        dots: true,
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
                items:3
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
                rating: $('input[name="rating"]').val()
            },
            success: function (response) {
                if ( response ) {
                    $('.sending_preloader').removeClass('show');
                    $('textarea#comment').val('');
                    $('.review_sent').addClass('active');
                    $('.rate_product_please img').removeClass('choosed');
                    $('.rate_product_please img[data-count="1"]').addClass('choosed');
                    $('input[name="rating"]').val(1);
                } else {
                    $('.sending_preloader').removeClass('show');
                    $('.review_not_sent').addClass('active');
                }
            }
        });
    });

    // Rate product - choose star
    $('.rate_product_please img').on('click', function(){
        $(this).prevAll().addClass('choosed');
        $(this).addClass('choosed');
        $(this).nextAll().removeClass('choosed');
        var value = $(this).data('count');
        $('input[name="rating"]').val(value);
    });

    $('.rate_product_please img').hover(function() {
        $(this).prevAll().addClass('hovered');
        $(this).addClass('hovered');
        $(this).nextAll().removeClass('hovered');
    });

    $('.rate_product_please img').on('mouseleave', function(){
        $('.rate_product_please img').removeClass('hovered');
    });

    // Send Advanced Account Data form
    $('form#add_account_form').on('submit', function (event) {
        event.preventDefault();
        $('.sending_preloader').addClass('show');

        let bannerBlob = document.getElementById('banner_preview').src;
        let avatarBlob = document.getElementById('photo_preview').src;

        $.ajax({
            url: ajax_url.url,
            type: 'POST',
            data: {
                action: 'send_advanced_account_data',
                nonce_code: ajax_url.nonce,
                banner: bannerBlob,
                photo: avatarBlob,
                email: $('input[name="email"]').val(),
                description: $('textarea[name="description"]').val(),
                web: $('input[name="web"]').val(),
                nickname: $('input[name="nickname"]').val(),
            },
            success: function (response) {
                if ( response ) {
                    $('.sending_preloader').removeClass('show');
                } else {
                    $('.sending_preloader').removeClass('show');
                }
            }
        });
    });

    // Add item radio changer
    $('input.category').on('click', function(){
        let target = $(this).data('target');

        $('.subcategories').removeClass('show');
        $('.' + target).addClass('show');
    });

    // Progress bar
    if ($(".product-rating").length > 0) {
        $(".product-rating").loading();
    }

    // Manufacturer remove item request
    let remove_item = $('.manufacturer_control .products_list .remove');

    remove_item.on('click', function(event){
        event.preventDefault();

        let itemID = $(this).data('item-id'),
            itemName = $(this).parent().parent().find('> span').text(),
            popup = $('.remove_item_request');

        popup.addClass('active');
        $('.remove-item-name span').text('Item: ' + itemName);
        $('input[name="item_id"]').attr('value', itemID);
        $('input[name="item_name"]').attr('value', itemName);
    });

    $('form#remove_item_req_form').on('submit', function (event) {
        event.preventDefault();
        $('#remove_item_req_form .sending_preloader').addClass('show');

        let itemID = $('input[name="item_id"]').val(),
            itemName = $('input[name="item_name"]').val(),
            uid = $(this).find('> .formcontrol').data('uid'),
            uidval = $('input[name="uid"]').val(),
            message = $('textarea[name="message"]').val();

        if (uid == uidval) {
            let user_id = uidval;
            $.ajax({
                url: ajax_url.url,
                type: 'POST',
                data: {
                    action: 'remove_item_req_form',
                    nonce_code: ajax_url.nonce,
                    subject: 'Remove item request: ' + itemName,
                    item_id: itemID,
                    user_id: user_id,
                    message: message,
                },
                success: function (response) {
                    if ( response ) {
                        $('.sending_preloader').removeClass('show');
                        $('.remove_item_request').removeClass('active');
                        setTimeout(function(){
                            $('.remove_item_request_success').addClass('active');
                        }, 300);
                    } else {
                        $('.sending_preloader').removeClass('show');
                        $('.remove_item_request').removeClass('active');
                        setTimeout(function(){
                            $('.remove_item_request_error').addClass('active');
                        }, 300);
                    }
                }
            });
        }
    });

    // Open search form on mobile
    let open_search = $('.open_search_form');
    open_search.on('click', function(event){
        event.preventDefault();

        if ($('.search').hasClass('active')) {
            $('.search').removeClass('active');
        } else {
            $('.search').addClass('active');
        }
    });

    // Open mobile menu
    let open_mobile_menu = $('.open_mobile_menu'),
        close_mobile_menu = $('.mmc-close');
    open_mobile_menu.on('click', function(event){
        event.preventDefault();

        if ($('.mobile-menu-container').hasClass('show')) {
            $('.mobile-menu-container').removeClass('show');
            $('body').removeClass('no-scroll');
        } else {
            $('.mobile-menu-container').addClass('show');
            $('body').addClass('no-scroll');
        }
    });
    close_mobile_menu.on('click', function(event){
        event.preventDefault();

        $('.mobile-menu-container').removeClass('show');
    });
});

/**
 * Pure JS Scripts
 * @type {Element}
 */

// Upload banner
let inputElement = document.querySelector('.banner')
let bannerContainer = document.querySelector('.banner_img')
inputElement.addEventListener("change", fileBanner, false)
function fileBanner(event) {
    let validFileTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif']
    let fileList = event.target.files;
    let fileType = fileList[0].type;
    let fileData = fileList[0]
    let imageBannerTag = document.getElementById('banner_preview')

    if (validFileTypes.includes(fileType) && fileData.size <= 350000) {
        if (imageBannerTag) {
            imageBannerTag.remove()
        }

        let fileReader = new FileReader()
        fileReader.onload = () => {
            let fileURL = fileReader.result

            let bannerImgTag = document.createElement("img")
            bannerImgTag.src = fileURL
            bannerImgTag.setAttribute('id', 'banner_preview')
            bannerContainer.appendChild(bannerImgTag)
            document.querySelector('.banner_name').value = fileURL
        }
        fileReader.readAsDataURL(fileData)
    }
    else {
        event.target.value = '';
        let errorPopup = document.querySelector('.invalid_add_image')
        errorPopup.classList.add('active')
    }
}

// Remove banner
function removeBanner(event){
    event.preventDefault()
    let imageBannerTag = document.getElementById('banner_preview')
    let inputBanner = document.getElementById('set_banner')
    if (imageBannerTag) {
        imageBannerTag.setAttribute('src', '#')
        imageBannerTag.classList.add('media-unset');
        inputBanner.value = ''
    }
}


// Upload avatar
let photoElement = document.querySelector('.photo')
let photoContainer = document.querySelector('.photo_container')
inputElement.addEventListener("change", filePhoto, false)
function filePhoto(event) {
    let validFileTypes = ['image/jpeg', 'image/jpg', 'image/png']
    
    let fileList = event.target.files;
    let fileType = fileList[0].type;
    let fileData = fileList[0]
    let imageBannerTag = document.getElementById('photo_preview')
    let topPanAvatar = document.querySelector('.top-pan-avatar')

    if (validFileTypes.includes(fileType) && fileData.size <= 200000) {
        if (imageBannerTag) {
            imageBannerTag.remove()
        }

        let fileReader = new FileReader()
        fileReader.onload = () => {
            let fileURL = fileReader.result

            let bannerImgTag = document.createElement("img")
            bannerImgTag.src = fileURL
            topPanAvatar.setAttribute('src', fileURL)
            bannerImgTag.setAttribute('id', 'photo_preview')
            photoContainer.appendChild(bannerImgTag)
            document.querySelector('.photo').value = fileURL
        }
        fileReader.readAsDataURL(fileData)
    }
    else {
        event.target.value = '';
        let errorPopup = document.querySelector('.invalid_add_photo')
        errorPopup.classList.add('active')
    }
}

// Remove avatar
function removePhoto(event){
    event.preventDefault()
    let imageBannerTag = document.getElementById('photo_preview')
    let inputBanner = document.getElementById('set_photo')
    let topPanAvatar = document.querySelector('.top-pan-avatar-uploaded')
    let topPanAvatarDefault = topPanAvatar.getAttribute('data-avatar');
    if (imageBannerTag) {
        imageBannerTag.setAttribute('src', '#')
        topPanAvatar.setAttribute('src', topPanAvatarDefault)
        inputBanner.value = ''
    }
}