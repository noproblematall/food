
$(document).ready(function(){

    "use strict";
    function scriptLoader(path, callback)
    {
        var script = document.createElement('script');
        script.type = "text/javascript";
        script.async = true;
        script.src = path;
        script.onload = function(){
            if(typeof(callback) == "function")
            {
                callback();
            }
        }
        try
        {
            var scriptOne = document.getElementsByTagName('script')[0];
            scriptOne.parentNode.insertBefore(script, scriptOne);
        }
        catch(e)
        {
            document.getElementsByTagName("head")[0].appendChild(script);
        }
    }
    
//------------------------------special-tour-slider carousel----------------------------------------
 

    specialTourSlider();
    function specialTourSlider (){
        $('#special-tour-slider').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 2,
            dots:true,
            autoplay:true,
            prevArrow: null,
            nextArrow: null,
            responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true
                    
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 560,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            ]
        });
        
    }




//------------------------------ Destination4 Slider ---------------------------------------- 


    dest4slider('.destination-4-2__slider');
    function dest4slider($Slider) {
        $($Slider).slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            dots:false,
            prevArrow: "<i class='destination-4-2__arrow destination-4-2__arrow--left fa fa-angle-left'></i>",
            nextArrow: "<i class='destination-4-2__arrow destination-4-2__arrow--right fa fa-angle-right'></i>",
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true
                        
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 475,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }



//------------------------------ Destination Item Aside--- tour-item Slider ---------------------------------------- 


    TourRelate('.related-tour');
    function TourRelate($Slider) {
        $($Slider).slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            dots:false,
            prevArrow: "<i class='destination-4-2__arrow destination-4-2__arrow--left fa fa-angle-left'></i>",
            nextArrow: "<i class='destination-4-2__arrow destination-4-2__arrow--right fa fa-angle-right'></i>",
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true
                        
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }



//------------------------------ partnerSlider  ---------------------------------------- 

    if($(window).width()< 1024){
        $('.partner').addClass('partner-slider');
    }
    else {
        $('.partner').removeClass('partner-slider');
    }
    
    partnerSlider('.partner-slider');
    function partnerSlider($slide){

        $($slide).slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            dots:false,
            autoplay:true,
            prevArrow: null,
            nextArrow: null,
            responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 560,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            ]
        });
        
    }


//------------------------------end  partnerSlider  ---------------------------------------- 



//------------------------------ BLOG RELATED ---------------------------------------- ----------------------

    BLogRelate('.related-blog__post');
    function BLogRelate($Slider) {
        $($Slider).slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            dots:false,
            prevArrow: "<i class='destination-4-2__arrow destination-4-2__arrow--left fa fa-angle-left'></i>",
            nextArrow: "<i class='destination-4-2__arrow destination-4-2__arrow--right fa fa-angle-right'></i>",
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true
                        
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }


//------------------------------END BLOG RELATED ---------------------------------------- ----------------------
 



//------------------------------hamburger toggle ----------------------------------------

    function hamburgerMobileToggle($mobileNav,$hamburger){
        $($hamburger).on( 'click', function(){
            $($mobileNav).slideToggle();
            $($hamburger).toggleClass("ham-open");

            $($mobileNav+" ul li a").on('click',function(){
                $(this).toggleClass('sub-menu-open');
            });

        });


    }
    hamburgerMobileToggle('.header-nav-mobile','.header-content1__hamburger');
    hamburgerMobileToggle('.header-nav-mobile','.header-content2__hamburger');
    hamburgerMobileToggle('.header-nav-mobile','.header-content3__hamburger');




//------------------------------HEADER SEARe ----------------------------------------


    $(".header-search").find('img').on('click',function(){
        $('.search-area').toggleClass("search-bar-show");
        $('.search-area__close').on('click',function(){
            $('.search-area').removeClass("search-bar-show");
        });
    });

    $(".header-nav-mobile__search-bar").find('img').on('click',function(){
        $('.search-area').toggleClass("search-bar-show");
        $('.search-area__close').on('click',function(){
            $('.search-area').removeClass("search-bar-show");
        });

    });
    $(document).on('keyup',function(e) {
        if (e.keyCode === 27) {
            $('.search-area').removeClass("search-bar-show");
        }
    });




//------------------------------ page marker ----------------------------------------
PageMarker('.header-1-nav ul li','marked1');
PageMarker('.header-2-nav ul li','marked2');
PageMarker('.header-3-nav ul li','marked2');

function PageMarker($link,$Class){
    var path = window.location.pathname.split("/").pop();
    if(path == ''){
        path='index.html'
    }

    var target = $($link+' a[href="'+path+'"]');
    target.addClass($Class);

}



//------------------------------ VIDEO POPUP ----------------------------------------


    function VideoReview ($video,$btnPop,$btnClose,$iframe) {
        // Get the modal  ("#video","#btn-popup","#modal-close")
        var modal = $( $video ),
            // video = $( "#myvideo" ),

            // Get the button that opens the modal
            btn = $($btnPop ),

            // Get the <span> element that closes the modal
            close = $($btnClose),

            href=$($iframe).attr('data-src');

        // When the user clicks on the button, open the modal 
        btn.on( 'click', function(){
            modal.css({"display": "block","z-index":"1"});
            $($iframe).attr('src', href );
            $($btnPop).fadeOut();
            $(close).fadeIn();
        } );

        // When the user clicks on <span> (x), close the modal
        close.on('click', function() {
            modal.fadeOut();
            $($btnPop).fadeIn();
            $(close).fadeOut();
            $($iframe).removeAttr('src');
        
        });
        
    }

    function PreviewVideo ($video,$btnPop) {

        var modal = $( $video ),
            btn = $($btnPop ),
            close = $($video+'__close'),
            $iframe= $($video+'__iframe'),
            href=$($iframe).attr('data-src');
        btn.on( 'click', function(){
            modal.css({"visibility": "visible"});
            $($iframe).attr('src', href );

        } );
        
        $($video+'__btn-close').on('click', function() {
            modal.css({"visibility": "hidden"});
            $($iframe).removeAttr('src');
        
        });
        close.on('click', function() {
            modal.css({"visibility": "hidden"});
            $($iframe).removeAttr('src');
        
        });
        
    }

    PreviewVideo('.preview-video','.tour-item-banner__btn--video-preview');
    PreviewVideo('.preview-video-1','#btn-popup');
    PreviewVideo('.preview-video-2','#btn-popup2');

    /// testimonial video review travel: 
    VideoReview("#video3","#btn-popup3","#modal-close3","#video-popup-iframe3");
    VideoReview("#video4","#btn-popup4","#modal-close4","#video-popup-iframe4");
    //// slide-banner vid index-5: 
    PreviewVideo('.preview-video-3','#btn-popup5');
    ///about ú video

    PreviewVideo('.preview-video-aboutus-popup','.preview-video-aboutus__btn');


      
//------------------------------Testi-----------------------------------------
    

    travelReviewSlider('#travel-review-area',3,2,true,false);
    travelReviewSlider2();

    // travel-review-4 -------- about us
    travelReviewSlider('.travel-review-4',2,1,false,true);


    function travelReviewSlider($contain,$show,$scroll,$arrow,$dot){
        $($contain).slick({
            infinite: true,
            slidesToShow: $show,
            slidesToScroll: $scroll,
            arrows:$arrow,
            dots:$dot,
            prevArrow: "<i class='review-arrow-left fas fa-angle-left'></i>",
            nextArrow: "<i class='review-arrow-right fas fa-angle-right'></i>",
            responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true
                    
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            ]
        });
    
    }

    function travelReviewSlider2(){
        $(".travel-review-2-slider").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow: "<div class='testi-arrow-2-left'><img src='assets/images/testi/sliderArowLeft.png' alt='sliderArrowleft'></div>",
            nextArrow: "<div class='testi-arrow-2-right'><img src='assets/images/testi/sliderArrowright.png' alt='sliderArrowright'></div>"
        });
    }

    travelTip2();
    function travelTip2(){
        $(".travel-tip-2").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow:false,
            nextArrow: false,
            dots:true,
        });
    }

    // trvel-tip1
    TravelTip1ShowOut('.travel-tip-1__btn','btns-display','.travel-tip-1__tip');
    function TravelTip1ShowOut($btn,$btnAction,$tip){
        $($btn).on('click',function(){
            $($btn).removeClass($btnAction);
            $($tip).hide(300);
            var location = "";
            location = $(this).attr("data-rel");
        
            if($(this).attr('data-click-state') == 1) {
                $(this).attr('data-click-state', 0);
                $(this).removeClass($btnAction);
                $($tip+'.'+ location).hide(300);
            } else {
            $(this).attr('data-click-state', 1);
            $(this).addClass($btnAction);
            $($tip+'.'+ location).show(300);
            }
            $($btn).not('.'+$btnAction).attr('data-click-state', 0);
        })
    }

    


//------------------------------Form-----------------------------------------
 

    // FormCheckin();
    // function FormCheckin(){
    //     var x, i, j, selElmnt, a, b, c;
    //     /*look for any elements with the class "custom-select":*/
    //     x = document.getElementsByClassName("custom-select");
    //     for (i = 0; i < x.length; i++) {
    //       selElmnt = x[i].getElementsByTagName("select")[0];
    //       /*for each element, create a new DIV that will act as the selected item:*/
    //       a = document.createElement("DIV");
    //       a.setAttribute("class", "option-item select-selected");
    //       a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    //       x[i].appendChild(a);
    //       /*for each element, create a new DIV that will contain the option list:*/
    //       b = document.createElement("ul");
    //       b.setAttribute("class", "option-item select-items select-hide");
    //       for (j = 1; j < selElmnt.length; j++) {
    //         /*for each option in the original select element,
    //         create a new DIV that will act as an option item:*/
    //         c = document.createElement("li");
    //         c.innerHTML = selElmnt.options[j].innerHTML;
    //         c.addEventListener("click", function(e) {
    //             /*when an item is clicked, update the original select box,
    //             and the selected item:*/
    //             var y, i, k, s, h;
    //             s = this.parentNode.parentNode.getElementsByTagName("select")[0];
    //             h = this.parentNode.previousSibling;
    //             for (i = 0; i < s.length; i++) {
    //               if (s.options[i].innerHTML == this.innerHTML) {
    //                 s.selectedIndex = i;
    //                 h.innerHTML = this.innerHTML;
    //                 y = this.parentNode.getElementsByClassName("same-as-selected");
    //                 for (k = 0; k < y.length; k++) {
    //                   y[k].removeAttribute("class");
    //                 }
    //                 this.setAttribute("class", "same-as-selected");
    //                 break;
    //               }
    //             }
    //             h.click();
    //         });
    //         b.appendChild(c);
    //       }
    //       x[i].appendChild(b);
    //       a.addEventListener("click", function(e) {
    //           /*when the select box is clicked, close any other select boxes,
    //           and open/close the current select box:*/
    //           e.stopPropagation();
    //           closeAllSelect(this);
    //           this.nextSibling.classList.toggle("select-hide");
    //           this.classList.toggle("select-arrow-active");
    //         });
    //     }
    //     function closeAllSelect(elmnt) {
    //       /*a function that will close all select boxes in the document,
    //       except the current select box:*/
    //       var x, y, i, arrNo = [];
    //       x = document.getElementsByClassName("select-items");
    //       y = document.getElementsByClassName("select-selected");
    //       for (i = 0; i < y.length; i++) {
    //         if (elmnt == y[i]) {
    //           arrNo.push(i)
    //         } else {
    //           y[i].classList.remove("select-arrow-active");
    //         }
    //       }
    //       for (i = 0; i < x.length; i++) {
    //         if (arrNo.indexOf(i)) {
    //           x[i].classList.add("select-hide");
    //         }
    //       }
    //     }
    //     /*if the user clicks anywhere outside the select box,
    //     then close all select boxes:*/
    //     document.addEventListener("click", closeAllSelect);
    


    //   /////------------------- change color icon input

    //   $(".form-area input").on('focusin',function(){
    //     $(this).parent().find('.far').addClass("colorChange");
        
    //   });
    //   $(".form-area input").on('focusout',function(){
    //     $(this).parent().find('.far').removeClass("colorChange");
    //   });


    //   $('.option-item').on('click',function(){
    //     if($(this).hasClass('select-arrow-active')){
    //         $(this).parent().addClass('solid-border');
    //     }   
    //     else {
    //         $(this).parent().removeClass('solid-border');
    //     } 
    //   });

    // }



//------------------------------filterable tour-----------------------------------------
 

    FilterableTours();
    function FilterableTours(){
        var content=$("#filterable-posts"),tabs=$(".filterable-tour__categories span");
        tabs.on('click', function(){
      
          tabs.removeClass('active-filter').filter(this).addClass('active-filter');
          var filter=$(this).data('filter');
          
          content.isotope({
            filter: filter
          });
          return false;
        });
    }


//------------------------------ GALLERY -----------------------------------------


    slidercounter('.gallery');

////  slick slider with count

    function slidercounter($slider){

        if ($($slider).length) {
            var currentSlide;
            var slidesCount;

            var updateSliderCounter = function(slick, currentIndex) {
                currentSlide = slick.slickCurrentSlide() + 1;
                slidesCount = slick.slideCount;
                var rangeStep  = 100/slidesCount;
                /// dot width
                $($slider).find(".slick-dots li").css("width",rangeStep+"% ");
                $(".gallery-control__counter--current").text(currentSlide);
                $(".gallery-control__counter--total").text(slidesCount);
            };
        
            $($slider).on('init', function(event, slick) {
                // $($slider).append(sliderCounter);
                updateSliderCounter(slick);
            });
        
            $($slider).on('afterChange', function(event, slick, currentSlide) {
                updateSliderCounter(slick, currentSlide);
            });
        
        
            $($slider).slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                dots:true,
                nextArrow: false,
            });
            $('.rightArrow').on('click', function(){
                $($slider).slick("slickNext");
            });
            $('.leftArrow').on('click', function(){
                $($slider).slick("slickPrev");
            });

        }
    };
 
//------------------------------ END GALLERY -----------------------------------------



//------------------------------  ITEM SHOW OUT -----------------------------------------
    // tour-item : schedule,faq
    function ItemShowOut($toggleElement,$classAction){

        $($toggleElement).on('click',function(){
          
            $($toggleElement).removeClass($classAction);
            $($toggleElement).find('p').slideUp();
            if($(this).attr('data-click-state') == 1) {
                $(this).attr('data-click-state', 0);
                $(this).removeClass($classAction);
                $(this).find('p').slideUp();
            } else {
            $(this).attr('data-click-state', 1);
            $(this).addClass($classAction);
            $(this).find('p').slideDown();

            }
            
            $($toggleElement).not('.'+$classAction).attr('data-click-state', 0);
           

        });
  
    }

    ItemShowOut('.tour-infomation__content__schedule__day','schedule-show');
    ItemShowOut('.tour-infomation__content__FAQ__item','faq-show');



//------------------------------ END ITEM SHOW OUT -----------------------------------------



//------------------------------ RATING REVIEW -----------------------------------------

    $('.tour-infomation__content__write-comment__rating input').on('click',function() {
        if ($(this).is(':checked'))
        {
            $('.tour-infomation__content__write-comment__rating input').addClass('visible');
        }
    });

// ------------------------------ END RATING REVIEW -----------------------------------------



// ------------------------------  GALERY SYNCING -----------------------------------------

GallerySlierSyncing('.gallery__syncing__single','.gallery__syncing__nav',7);

GallerySlierSyncing('.gallery-syncing-item__single','.gallery-syncing-item__nav',5);

function GallerySlierSyncing($singleSlider,$navSlider,$thumbNum){
    $($singleSlider).slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: "<i class='fa fa-angle-left'></i>",
        nextArrow: "<i class='fa fa-angle-right'></i>",
        fade: false,
        adaptiveHeight: true,
        infinite: true,
        useTransform: true,
        speed: 400,
        cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
    });
    
    $($navSlider)
        .on('init', function(event, slick) {
            $($navSlider+' .slick-slide.slick-current').addClass('is-active');
        })
        .slick({
            slidesToShow:$thumbNum,
            slidesToScroll: 2,
            arrows: false,
            dots: false,
            focusOnSelect: false,
            infinite: false,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                }
            }, {
                breakpoint: 640,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
               }
            }, {
                breakpoint: 420,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
           }
            }]
        });
    
    $($singleSlider).on('afterChange', function(event, slick, currentSlide) {
        $($navSlider).slick('slickGoTo', currentSlide);
        var currrentNavSlideElem = $navSlider+' .slick-slide[data-slick-index="' + currentSlide + '"]';
        $($navSlider+' .slick-slide.is-active').removeClass('is-active');
        $(currrentNavSlideElem).addClass('is-active');
    });
    
    $($navSlider).on('click', '.slick-slide', function(event) {
        event.preventDefault();
        var goToSingleSlide = $(this).data('slick-index');
    
        $($singleSlider).slick('slickGoTo', goToSingleSlide);
    });
};
/// active action for popup one
$('.tour-item-banner__btn--view-photos').on('click',function() {
    $('.gallery__syncing').css('visibility','visible');
});
$('.gallery__syncing__close').on('click',function() {
    $('.gallery__syncing').css('visibility','hidden');
});
$('.gallery__syncing__btn-close').on('click',function() {
    $('.gallery__syncing').css('visibility','hidden');
});

// ------------------------------ END GALERY SYNCING -----------------------------------------



// ------------------------------ SIDEBAR TITTLE PRICE -----------------------------------------


    if($('.right-sidebar__item__sale').text().length === 0){
        $('.right-sidebar__item__from').css('color','#ebebeb');
    }


// ------------------------------ END SIDEBAR TITTLE PRICE -----------------------------------------
 


// ------------------------------  SCROLL TO TOP  -----------------------------------------

ScrollToTop(".scroll-top");

function ScrollToTop($ref){
    var scrollTop = $($ref);

    $(window).scroll(function() {
      // declare variable
      var topPos = $(this).scrollTop();
      // if user scrolls down - show scroll to top button
      if (topPos > 200) {
        $(scrollTop).addClass('scroll-top__showing');
  
      } else {
        $(scrollTop).removeClass('scroll-top__showing');
      }
  
    }); // scroll END
  
    //Click event to scroll to top
    $(scrollTop).on('click',function() {
      $('html, body').animate({
        scrollTop: 0
      }, 600);
      return false;
  
    });
}
// ------------------------------ END SCROLL TO TOP  -----------------------------------------



// ----------------------------------PAGE LOADER------------------------------------
    // $(window).on("load", function () {
    //     // $("body").prepend("<section class='loading'><div class='lds-dual-ring'></div></section>");
    //     $('.loading').fadeOut();
    //     setTimeout(function() {
    //         $('.loading').remove();
    //     }, 1000);
    // });


// ----------------------------------END PAGE LOADER------------------------------------

});









