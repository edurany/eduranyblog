jQuery(function($) {


    /****************
    **  MENU/HEADER
    *****************/

    // Enable menu hover
    if(blu.menuhover){
        $('.nav li').mouseover(function(){
            $( this ).addClass('open');
        });
        $('.nav li').mouseout(function(){
            $( this ).removeClass('open');
        });
    }
    // Shrink header on scroll down
    if(!blu.disable_fixed_header){
        var y;
        y = $(window).scrollTop();

        if($(window).resize()){
            if($(window).width() > 979){
                masthead_height = $('#masthead').height();

                if($('body').hasClass('admin-bar')){ 
                    masthead_top = ($('#masthead').offset().top-28); 
                }
                else{ 
                    masthead_top = $('#masthead').offset().top; 
                }
                if(y > masthead_top){ 
                    $('.masthead-container').addClass('fixed'); 
                    $('#main').css('padding-top', (masthead_height+25)+'px'); 
                }
                if(y > 300){  $('.masthead-container').addClass('shrink'); }

                else{ $('.masthead-container').removeClass('shrink'); }
                // Shrink menu on scroll
                var didScroll = false;
                $(window).scroll(function() {
                    didScroll = true;
                });
                setInterval(function() {
                    if ( didScroll ) {
                        didScroll = false;
                        y = $(window).scrollTop();
                        if(y > masthead_top){ $('.masthead-container').addClass('fixed'); $('#main').css('padding-top', (masthead_height+25)+'px'); }
                        else{ $('.masthead-container').removeClass('fixed'); $('#main').css('padding-top', ''); }
                        if(y > 300){  $('.masthead-container').addClass('shrink'); }
                        else{ $('.masthead-container').removeClass('shrink'); }
                    }
                }, 70);
            }else{
                $('.masthead-container').removeClass('shrink');
                $('.masthead-container').removeClass('fixed');

            }
        }
    }else{
        $('#page').addClass('static-header'); 
    }

    /****************
    **  SOCIAL POSTS LOAD
    *****************/

    var didScroll2,
        normalLayout = false;
    // if the layout isn't twocolumn or three column then load the posts that are already in view immediately
    if(!$('#content').hasClass('twocolumn') && !$('#content').hasClass('threecolumn') && !$('#content').hasClass('fourcolumn') && !$('#content').hasClass('fivecolumn')){
        normalLayout = true;
        didScroll2 = false;
    }else{
        didScroll2 = true;
    }
    $(window).scroll(function() {
        didScroll2 = true;
    });
    setInterval(function() {
        if ( didScroll2 ) {
            didScroll2 = false;
            y2 = $(window).scrollTop();

            if($('.facebook-store').length > 0){
                $('.facebook-store').each(function(e){
                    if((y2 > $(this).offset().top - 800 && y2 < $(this).offset().top + 200) && !$(this).data('loaded') ) {
                        $(this).data('loaded', '1');
                        $(this).html($(this).data('code'));
                        FB.XFBML.parse($(this).get(0));
                        // if it's a column layout then remove the iframe and put in an icon with a link
                        if(!normalLayout){   
                            // $(this).find('iframe').remove();
                            $(this).html('<a class="facebook-fallback" href="'+$(this).find('.fb-post').data('href')+'"><i class="icon-facebook-1"></i></a>');
                        }
                    }
                });
            }
            if($('.twitter-store').length > 0){
                $('.twitter-store').each(function(e){
                    if((y2 > $(this).offset().top - 800 && y2 < $(this).offset().top + 200) && !$(this).data('loaded') ) {
                        $(this).data('loaded', '1');
                        $(this).html($(this).data('code'));
                        twttr.widgets.load();
                    }
                });
            }
            if($('.google-store').length > 0){
                $('.google-store').each(function(e){
                    if((y2 > $(this).offset().top - 800 && y2 < $(this).offset().top + 200) && !$(this).data('loaded') ) {
                        $(this).data('loaded', '1');
                        $(this).html($(this).data('code'));
                        gapi.follow.go();
                    }
                });
            }
        }
    }, 600);


    /****************
    **  COMMENT SCORE
    *****************/
    // AJAX Comment Vote
    $('.blu-comment-vote').unbind('click').click( function(e) {
        e.stopPropagation();
        e.preventDefault();
        var previousScore = +$(this).parent().find('.total-score').html();
        var commentID = $(this).data('commentid');
        var voteType;
        if($(this).hasClass('blu-comment-vote-up')){
            previousScore++;
            voteType = 'up';
        }else{
            previousScore--;
            voteType = 'down';
        }
        $that = $(this);
        $.ajax({  
            type: 'POST',  
            url: blu.ajaxurl,  
            data: {  
                action: 'blu_ajax_comment_score',
                commentid: commentID,
                votetype: voteType,
                previousScore: previousScore
            },  
            success: function(data, textStatus, XMLHttpRequest){  
                if(!data){  
                    $that.css('color','#DDDDDD');
                    $that.parent().find('.total-score').html(previousScore++).addClass('vote-'+voteType);
                }else{
                    $that.parent().find('.total-score').after('<span class="already-voted">Already voted!</span>'); 
                }
            },  
            error: function(MLHttpRequest, textStatus, errorThrown){  
                $that.parent().find('.total-score').after('<span class="already-voted">Error: ' + errorThrown + '</span>'); 
            }  
        });
    }); 


    /****************
    **  SWIPER
    *****************/
    if( $('.swiper-gallery').length ){
            
        var galleryswiper = Array();
        var galleryswiperNumber = 1;

        imagesLoaded( document.querySelector('#content'), function( instance ) {

            $('.swiper-gallery').each(function(e){

                $that = $(this);

                $(this).attr('id', 'swiper-gallery-'+galleryswiperNumber);

                galleryswiper[e] = $('.swiper-gallery').swiper({

                    resizeReInit: true,
                    pagination: '#swiper-gallery-'+galleryswiperNumber+' .swiper-pagination',
                    calculateHeight: false,
                    watchActiveIndex: true,
                    centeredSlides: true,

                    onInit: function(swiper){

                        if( $( swiper.activeSlide() ).find('.container').length ){

                            $(swiper.container).height( $( swiper.activeSlide() ).find('.container').height() );

                        }else{

                            $(swiper.container).height( $( swiper.activeSlide() ).find('img').height() );

                        }

                    },
                    onImagesReady: function(swiper){
                        $('.swiper-gallery').css( 'opacity', '1' );
                    },
                    onSlideChangeEnd: function(swiper){

                        if( $( swiper.activeSlide()).find('.container').length ){

                            $( swiper.container ).height( $( swiper.activeSlide() ).find('.container').height() );
                            $( swiper.activeSlide() ).height( $( swiper.activeSlide()).find('.container').height() );

                        }else{

                            $(swiper.container).height( $( swiper.activeSlide() ).find('img').height() );

                        }
                    },
                });


                // enable pagination arrows
                if( $that.find('.arrow-left').length ){

                    $that.find('.arrow-left').on('click', function(ev){
                        ev.preventDefault();
                        galleryswiper[e].swipePrev();
                    });
                    
                }
                if( $that.find('.arrow-right').length ){

                    $that.find('.arrow-right').on('click', function(ev){
                        ev.preventDefault();
                        galleryswiper[e].swipeNext();
                    });

                }

            });
        });
    }


    if($('.swiper-gallery').length > 0){

        /*galleryswiperNumber = 1;
        imagesLoaded( document.querySelector('#content'), function( instance ) {
            // Gallery
            $('.swiper-gallery').each(function(e){
                $(this).attr('id', 'swiper-gallery-'+galleryswiperNumber);

                var gallery_swiper = new Swiper('#swiper-gallery-'+galleryswiperNumber, {
                    pagination: '#swiper-gallery-'+galleryswiperNumber+' .swiper-pagination',
                    loop:true,
                    paginationClickable: true,
                    slidesPerView: 1,
                    preventLinks: false,
                    releaseFormElements: true,
                    keyboardControl: true,
                    watchActiveIndex: true,
                    noSwiping: true,
                    calculateHeight: true,
                    onSlideChangeStart: function(swiper){
                        $(swiper.container).height( $( swiper.activeSlide()).find('img').height() );
                    },
                    onImagesReady: function(swiper){
                        $('.swiper-gallery').css( 'opacity', '1' );
                        $(swiper.container).height( $( swiper.activeSlide()).find('img').height() );
            
                    }
                });
                galleryswiperNumber++;

                gallery_swiper.reInit();
            });

            
            $('.swiper-gallery .arrow-left').on('click', function(e){
                e.preventDefault();
                $(this).closest('.swiper-gallery').swiper().swipePrev();
                $(this).closest('.swiper-gallery').height($(this).closest('.swiper-gallery').find('.swiper-slide-active img').height());
            });
            $('.swiper-gallery .arrow-right').on('click', function(e){
                e.preventDefault();
                $(this).closest('.swiper-gallery').swiper().swipeNext();
                $(this).closest('.swiper-gallery').height($(this).closest('.swiper-gallery').find('.swiper-slide-active img').height());
            });
        });*/
    }

    imagesLoaded( document.querySelector('#content'), function( instance ) {

        /****************
        **  IMAGE COMMENTS
        *****************/
        // Add Image Comment functionality
        if($('.image-comment').length > 0){
            $('.image-comment-on .image-comment').each(function(){
                // insert lightbox button
                // if(!$(this).hasClass('entry-head')){
                    $(this).find('img').after('<a href="' + $(this).data('href') + '" class="image-open lightbox btn btn-default"><i class="icon-resize-full-1"></i></a>');
                    $(this).find('.image-open').magnificPopup({type:'image'});
                // }
            });

            $('.image-comment-on .image-comment .image-open').click( function(e) {
                e.stopPropagation();
                // e.preventDefault();
            });
            $('.image-comment-on .image-comment').click( function(e) {
                e.stopPropagation();
                e.preventDefault();
                cropClose();
                // comment container
                var information = "";
                if($('#author').length > 0){ information = "<input id='image-author' type='text' placeholder='Your Name'><input id='image-email' type='text' placeholder='Your Email'>"; }
                var container = '<div id="image-comment-crop-container" class="swiper-no-swiping"><div class="crop-center"><div class="crop-close">×</div></div><div class="submit-container swiper-no-swiping">' + information;
                if($(window).width() > 979){
                    container +=  '<textarea rows="5" class="swiper-no-swiping"></textarea><a class="btn btn-primary btn-block">Submit Comment</a></div></div>';
                }
                $(this).remove('#image-comment-crop-container');
                if($('#image-comment-crop-container').length < 1){
                    $(this).append(container);
                }
                $('#image-comment-crop-container #image-author').click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                });
                $('#image-comment-crop-container #image-author').change(function(e){
                    $('#author').val($(this).val());
                });
                $('#image-comment-crop-container #image-email').click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                });
                $('#image-comment-crop-container #image-email').change(function(e){
                    $('#email').val($(this).val());
                });
                $('#image-comment-crop-container textarea').click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                });
                $('#image-comment-crop-container textarea').change(function(e){
                    $('#comment').val($(this).val());
                });

                // put in the correct information when clicked ( if there is any )
                if( $('#image-comment-crop-container #image-author').val() == '' ){
                    $('#image-comment-crop-container #image-author').val($('#author').val());
                }
                if( $('#image-comment-crop-container #image-email').val() == ''  ){
                    $('#image-comment-crop-container #image-email').val($('#email').val());
                }
                if( $('#image-comment-crop-container textarea').text() == ''  ){
                    $('#image-comment-crop-container textarea').text($('#comment').val());
                }

                $('#image-comment-crop-container *:first-child').focus();

                $('#image-comment-crop-container .btn').click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    $('#comment').val($('#image-comment-crop-container textarea').val());
                    $('#commentform #submit').trigger('click');
                    $(this).unbind('click');
                    $('#image-comment-crop-container textarea').unbind('click');
                    $('#image-comment-crop-container textarea').unbind('change');
                    $('#image-comment-crop-container #image-author').unbind('click');
                    $('#image-comment-crop-container #image-author').unbind('change');
                    $('#image-comment-crop-container #image-email').unbind('click');
                    $('#image-comment-crop-container #image-email').unbind('change');
                });

                // close the crop tool and remove the selection
                $('.crop-close').click(function(e){
                    e.preventDefault();
                    cropClose();
                    e.stopPropagation();
                });

                var posX_old = $(this).offset().left,
                    posY_old = $(this).offset().top,
                    posX = $(this).offset().left,
                    posY = $(this).offset().top,
                    image_width = $(this).children('img').attr('width'),
                    image_container_height = $(this).height(),
                    image_container_width = $(this).width(),
                    image_ratio = (image_width/image_container_width),
                    mobile_multiplication = 1,
                    mobileY_fix = 0,
                    mobileX_fix = 0,
                    crop_tool_scale = 100,
                    crop_tool_position_X = crop_tool_scale/2,
                    crop_tool_position_Y = crop_tool_scale/2;

                $('#image-comment-crop-container .crop-center').css('height',crop_tool_scale);
                $('#image-comment-crop-container .crop-center').css('width',crop_tool_scale);
                $(this).find('.submit-container').css('width', (crop_tool_scale*3)+'px');
                $(this).find('.submit-container').css('margin-left', -(crop_tool_scale)+'px');
                container_positionY = (image_container_height - (e.pageY - posY_old));
                container_positionX = (image_container_width - (e.pageX - posX_old));
                // if it's at the bottom
                if( container_positionY < (crop_tool_scale+100) || container_positionX < (crop_tool_scale+100)){
                    $(this).find('.submit-container').css('top','-'+(crop_tool_scale+50)+'px');
                    $(this).find('.submit-container').css('left', '-'+(crop_tool_scale+125)+'px');
                }
                // if it's all the way to the left
                if( container_positionX > image_container_width - (crop_tool_scale+100) || ( container_positionY < (crop_tool_scale+100) && container_positionX > image_container_width - 500 )){
                    $(this).find('.submit-container').css('top','-'+(crop_tool_scale+50)+'px');
                    $(this).find('.submit-container').css('left','auto');
                    $(this).find('.submit-container').css('right', '-'+(crop_tool_scale+125)+'px');
                }
                // if the image has an alignright class then put it to the left
                if( $(this).hasClass('alignright') ){
                    $(this).find('.submit-container').css('top','-'+(crop_tool_scale+50)+'px');
                    $(this).find('.submit-container').css('left', '-'+(crop_tool_scale+125)+'px');
                    $(this).find('.submit-container').css('right','auto');
                }
                // if it's a mobile view then stop the nonsense and just display it below!
                if( $(window).width() < 979 ){
                    // add multiplier if it's mobile to enlargen the image
                    mobile_multiplication = 2;
                    mobileY_fix = -50;
                    mobileX_fix = -50;
                    $(this).find('.submit-container').css('display','none');
                }

                // fix the height if it's out of bounds ( bottom, top )
                if( (image_container_height - (e.pageY - posY)) < (crop_tool_scale/2)){
                    posY = image_container_height - crop_tool_scale;
                    crop_tool_position_Y = crop_tool_scale;
                }else if( (e.pageY - posY) < (crop_tool_scale/2) ){
                    posY = 0;
                }else{
                    posY = (e.pageY - posY) - (crop_tool_scale/2);
                }

                // fix the width if it's out of bounds ( right, left )
                if( (image_container_width - (e.pageX - posX)) < (crop_tool_scale/2)){
                    posX = image_container_width - crop_tool_scale;
                    crop_tool_position_X = crop_tool_scale;
                }else if( (e.pageX - posX) < (crop_tool_scale/2) ){
                    posX = 0;
                }else{
                    posX = (e.pageX - posX) - (crop_tool_scale/2);
                }

                $('#image-comment-crop-container').css('left', posX).css('top', posY);
                posX = (posX * mobile_multiplication)-crop_tool_position_X - mobileY_fix;
                posY = (posY * mobile_multiplication)-crop_tool_position_Y - mobileY_fix;
                if(posY < 0){ posY = 0; }
                if(posX < 0){ posX = 0; }
                image_container_width = image_container_width * mobile_multiplication;
                image_container_height = image_container_height * mobile_multiplication;

                // put the image in the correct positions
                var img_src = $(this).children('img').attr('src');

                // display the placeholder
                $('#image-comment-placeholder').css('display', 'block');

                // position the image in the placeholder
                $('#image-comment-placeholder').html('<img src="' + img_src + '" style="width: ' + image_container_width + 'px; left: -' + posX + 'px; top: -' + posY + 'px;">').append('<div class="crop-close">×</div>').click(function(e){
                    cropClose();
                    e.stopPropagation();
                });
                $('#respond #comment-textfield-area').css('padding-left', '215px');
                $('#comment_image_location').val(posY+ ',' + posX + ',' + img_src + ',' + image_container_width);
            });
        }
    });
    // Image Crop Container Close
    function cropClose(){
        if($('#image-comment-crop-container').length > 0){
            $('#image-comment-crop-container').remove();
            $('#image-comment-placeholder').css('display','none');
            $('#respond #comment-textfield-area').css('padding-left', '0');
            $('#comment_image_location').val('false');
        }
    }

    /****************
    **  HELPERS
    *****************/
    $( '.share-post' ).click(function(e){ e.preventDefault(); });
    if( $( 'time.timeago' ).length > 0 ){ $('time.timeago').timeago(); }
    if( $( '.tips' ).length > 0 ){ $('.tips').tooltip(); }
    if( $( '.bl_popover' ).length > 0 ){ $('.bl_popover').popover(); }
    
    /****************
    **  LIGHTBOX
    *****************/
    if( $( '.lightbox' ).length > 0 ){
      $('.lightbox' ).magnificPopup({type:'image'});

      $( '.entry-content p .lightbox' ).each(function(){
        $( this ).css('float', $( this ).children('img').css('float') );
      });
    }
    // fade everything in on page load
    $('.entry-content').animate({opacity:'1'}, 800, 'swing');
    // Lightbox Gallery
    suffixjpg = '.jpg';
    suffixjpeg = '.jpeg';
    suffixpng = '.png';
    suffixgif = '.gif';
    if( $( '.gallery' ).length > 0 ){
      if( $( '.gallery-item a' ).eq(0).attr( 'href' ).indexOf(suffixjpg, $( '.gallery-item a' ).eq(0).length - suffixjpg.length) !== -1 || $( '.gallery-item a' ).eq(0).attr( 'href' ).indexOf(suffixjpeg, $( '.gallery-item a' ).eq(0).length - suffixjpeg.length) !== -1 || $( '.gallery-item a' ).eq(0).attr( 'href' ).indexOf(suffixpng, $( '.gallery-item a' ).eq(0).length - suffixpng.length) !== -1 || $( '.gallery-item a' ).eq(0).attr( 'href' ).indexOf(suffixgif, $( '.gallery-item a' ).eq(0).length - suffixgif.length) !== -1){
        $( '.gallery' ).magnificPopup({
            delegate: '.gallery-item a', // the container for each your gallery items
            type: 'image',
            gallery:{ enabled:true }
        });
      }
    }
    // Jetpack Lightbox Gallery
    if( $( '.tiled-gallery').length > 0 ){
      if( $( '.tiled-gallery-item a' ).eq(0).attr( 'href' ).indexOf(suffixjpg, $( '.tiled-gallery-item a' ).eq(0).length - suffixjpg.length) !== -1 || $( '.tiled-gallery-item a' ).eq(0).attr( 'href' ).indexOf(suffixjpeg, $( '.tiled-gallery-item a' ).eq(0).length - suffixjpeg.length) !== -1 || $( '.tiled-gallery-item a' ).eq(0).attr( 'href' ).indexOf(suffixpng, $( '.tiled-gallery-item a' ).eq(0).length - suffixpng.length) !== -1 || $( '.tiled-gallery-item a' ).eq(0).attr( 'href' ).indexOf(suffixgif, $( '.tiled-gallery-item a' ).eq(0).length - suffixgif.length) !== -1){
        $( '.tiled-gallery' ).magnificPopup({
            delegate: '.tiled-gallery-item a', // the container for each your gallery items
            type: 'image',
            gallery:{ enabled:true }
        });
      }
    }
    
    /****************
    **  SYNTAX HIGHLIGHTING
    *****************/
    if( $("pre").length > 0 ){
        $("pre.html").snippet("html",{style:"emacs"});
        $("pre.css").snippet("css",{style:"emacs"});
        $("pre.php").snippet("php",{style:"emacs"});
        $("pre.js").snippet("javascript",{style:"emacs"});
    }

    /****************
    **  Post Title fixes
    *****************/
    $('.format-quote .quote-area').each(function(e){
        var width = $(this).width();
        var height = $(this).height();
        var image_height = $(this).next('img').height();
        var font_change = 0;
        var final_width = width;
        // if the height of the text is larger than the height of the image, then shrink the final font size
        if(height > image_height-80){ 
            final_width = final_width - (height - image_height + 50);
        }
        if(final_width < 200){ final_width = 200; }
        if(final_width > 1000){ final_width = 1000; }

        $(this).find('.quote-text').css('font-size', (final_width/12)+'px');
        height = $(this).height();
        $(this).height(height);
        
        $(this).css('margin-top', '-'+(height/2)+'px');
        $(this).css('opacity', '1');
    });
    $('.author-posts-item').each(function(e){
        var width = $(this).width();
        $(this).height($(this).width());
        $(this).find('h3').css('font-size', (width/10)+'px');
        var height = $(this).height();
        
        $(this).find('a').height(height);
        $(this).find('h3').css('margin-top', '-'+($(this).find('h3').height()/2)+'px');
        // $(this).css('opacity', '1');
    });

    /****************
    **  Instagram Widget
    *****************/
    if($('.blu_instagram').length > 0){
        slidesPerView = 1;

        // Init Instagram widget
        var instagram_swiper = new Swiper('.swiper-container-instagram', {
          loop: true,
          paginationClickable: true,
          slidesPerView: slidesPerView,
          onTouchEnd : function(element) { $('.swiper-container').removeClass('active'); },
          onTouchStart : function(element) { $('.swiper-container').addClass('active'); },
          onSlideChangeEnd : function(element) { $('.swiper-container').removeClass('active'); },       
          calculateHeight: true,
        });

        // enable pagination arrows
        $('.swiper-container-instagram .arrow-left').on('click', function(e){
          e.preventDefault();
          instagram_swiper.swipePrev();
        });
        $('.swiper-container-instagram .arrow-right').on('click', function(e){
          e.preventDefault();
          instagram_swiper.swipeNext();
        });

          instagram_swiper.reInit();
    }
    /****************
    **  Flickr Widget
    *****************/
    if($('.blu_flickr').length > 0){
        slidesPerView = 1;

        // Init Instagram widget
        var flickr_swiper = new Swiper('.swiper-container-flickr', {
          loop: true,
          paginationClickable: true,
          slidesPerView: slidesPerView,
          onTouchEnd : function(element) { $('.swiper-container').removeClass('active'); },
          onTouchStart : function(element) { $('.swiper-container').addClass('active'); },
          onSlideChangeEnd : function(element) { $('.swiper-container').removeClass('active'); },       
          calculateHeight: true,
        });

        // enable pagination arrows
        $('.swiper-container-flickr .arrow-left').on('click', function(e){
          e.preventDefault();
          flickr_swiper.swipePrev();
        });
        $('.swiper-container-flickr .arrow-right').on('click', function(e){
          e.preventDefault();
          flickr_swiper.swipeNext();
        });

        flickr_swiper.reInit();
    }    
    /****************
    **  Featured Posts Widget
    *****************/
    if($('.bl_featured_post').length > 0){
        slidesPerView = 1;
        swiperNumber = 1;
        var swiperClass = '';
        // Init Swiper
        $('.swiper-container-featured').each(function(e){
            $(this).attr('id', 'featured-swiper-'+swiperNumber);
            swiperClass = $(this).attr('class').split(' ')[1];

            var featured_swiper = new Swiper('#featured-swiper-'+swiperNumber, {
                pagination: '#featured-swiper-'+swiperNumber+' .swiper-pagination',
                loop: true,
                slidesPerView: slidesPerView,
                paginationClickable: true,   
                calculateHeight: true,
            });

            // enable pagination arrows
            $('.swiper-container-featured .arrow-left').on('click', function(e){
              e.preventDefault();
              $(this).closest('.swiper-container-featured').swiper().swipePrev();
              // $('#featured-swiper-'+swiperNumber).swipePrev();
            });
            $('.swiper-container-featured .arrow-right').on('click', function(e){
              e.preventDefault();
              $(this).closest('.swiper-container-featured').swiper().swipeNext();
              // $('#featured-swiper-'+swiperNumber).swipeNext();
            });

            $(this).find('.swiper-slide a').each(function(e){
                var width = $(this).find('.post-title').width();
                $(this).find('.post-title').css('font-size', (width/12)+'px');
                var height = $(this).height();
                $(this).height(height);
                $(this).find('.post-title').css('margin-top', '-'+($(this).find('.post-title').height()/2)+'px');
                $(this).find('.post-title').css('opacity', '1');
            });
            swiperNumber++;

            featured_swiper.reInit();
        });
    }
    /****************
    **  Next Page Animation
    *****************/
    $('.single-pagination.animate').click(function(e){
        e.preventDefault();
        $that = $(this);
        topOffset = $('#content').offset().top;
        $('article').addClass('box');
        $('.entry-content').animate({opacity:'0'}, 400, 'swing');
        if($('.entry-image').length > 0){
            $('.entry-image').animate({opacity:'0'}, 400);
        }
        if($('.entry-video').length > 0){
            $('.entry-video iframe').remove();
            $('.entry-video').animate({opacity:'0'}, 0);
        }
        $('#side-bar').animate({opacity:'0'}, 500, 'swing');
        $('html, body').animate({scrollTop:'0'}, 400, 'swing');
        $(this).animate({top:'-'+($(this).offset().top-topOffset)+'px'}, 400, 'swing', function(){
            $that.find('h3').animate({opacity:'0'}, 400);
            window.location = $that.attr('href');
        });
    })
    if($('article.fromnext .entry-image').length > 0){
        $('article.fromnext .entry-image').animate({height:$('article.fromnext .entry-image img').height()}, 400, 'swing');
    }

    

    /****************
    **  MASONRY
    *****************/

    if($('#content').hasClass('twocolumn') || $('#content').hasClass('threecolumn') || $('#content').hasClass('fourcolumn') || $('#content').hasClass('fivecolumn')){

        var $container = $('#content .columns');
        // initialize
        $container.masonry({
            itemSelector: 'article'
        });

        var didTimeOut = false;
        $('#content .columns article .entry-image').resize(function(e){
            $('#content .columns').masonry();
        });

        imagesLoaded( document.querySelector('#content'), function( instance ) {
            $('#content .columns').masonry();
        });
    }

    /****************
    **  FIX VIDEO SIZES
    *****************/
    if( $(".entry-video iframe").length > 0){
        var $container  = $("#content article .entry-video");
        var added_padding = 0;

        var $video  = $(".entry-video iframe"),
            did_resize  = false;

        var width = 16;
        var height = 9;

        $video.attr('data-aspectRatio', height / width).removeAttr('height').removeAttr('width');

        $(window).resize(function() {
            did_resize = true;
        }).resize();
         
        setInterval(function() {
            if(did_resize){
                did_resize = false;

                var newWidth = $container.width() + added_padding;
                $video.width(newWidth).height(newWidth * $video.attr('data-aspectRatio'));
            }
        }, 300);
    }


    /****************
    **  STICKY SIDEBAR
    *****************/
    // if the sticky header is active then add 60 to the offset to make it look good
    if(!blu.disable_fixed_header){
        offsetAdd = 65;
    }else{
        offsetAdd = 15;
    }
    if($(window).width() > 979){
        if($('.sticky_sidebar').length > 0){
            imagesLoaded( document.querySelector('#side-bar'), function( instance ) {
                if($('.sticky_sidebar').length > 0){
                    var stickyTop = $('.sticky_sidebar').offset().top-20-offsetAdd,
                        stickyTopFirstChild = $('.sticky_sidebar div:first-child').height(),
                        stickyBottom = $('.site-footer').height();

                    $('.sticky_sidebar').affix({
                        offset: {
                            top: stickyTop,
                            bottom: stickyBottom+5
                        }
                    })
                    $('.sticky_sidebar').css('width', $('.sticky_sidebar').parent().width()+'px');
                }
            });
        }
    }

    /*
        REFRESH ON WINDOW RESIZE
    */
});
function social_share(data) {
    window.open( data, "fbshare", "height=450,width=760,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0" );
}
