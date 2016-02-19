/*
 * Theme Name: Point
 */


/*----------------------------------------------------
/* Responsive Navigation
/*--------------------------------------------------*/
jQuery(document).ready(function($) {
  $('.primary-navigation').append('<div id="mobile-menu-overlay" />');

  $('.toggle-mobile-menu').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    $('body').toggleClass('mobile-menu-active');

    if ($('body').hasClass('mobile-menu-active')) {
      if ($(document).height() > $(window).height()) {
        var scrollTop = ($('html').scrollTop()) ? $('html').scrollTop() : $('body').scrollTop();
        $('html').addClass('noscroll').css('top', -scrollTop);
      }
      $('#mobile-menu-overlay').fadeIn();
    } else {
      var scrollTop = parseInt($('html').css('top'));
      $('html').removeClass('noscroll');
      $('html,body').scrollTop(-scrollTop);
      $('#mobile-menu-overlay').fadeOut();
    }
  });
}).on('click', function(event) {

  var $target = jQuery(event.target);
  if (($target.hasClass("fa") && $target.parent().hasClass("toggle-caret")) || $target.hasClass("toggle-caret")) { // allow clicking on menu toggles
    return;
  }
  jQuery('body').removeClass('mobile-menu-active');
  jQuery('html').removeClass('noscroll');
  jQuery('#mobile-menu-overlay').fadeOut();
});

/*----------------------------------------------------
/*  Dropdown menu
/* ------------------------------------------------- */
jQuery(document).ready(function($) {

  function mtsDropdownMenu() {
    var wWidth = $(window).width();
    if (wWidth > 865) {
      $('#navigation ul.sub-menu, #navigation ul.children').hide();
      var timer;
      var delay = 100;
      $('#navigation li').hover(
        function() {
          var $this = $(this);
          timer = setTimeout(function() {
            $this.children('ul.sub-menu, ul.children').slideDown('fast');
          }, delay);

        },
        function() {
          $(this).children('ul.sub-menu, ul.children').hide();
          clearTimeout(timer);
        }
      );
    } else {
      $('#navigation li').unbind('hover');
      $('#navigation li.active > ul.sub-menu, #navigation li.active > ul.children').show();
    }
  }

  mtsDropdownMenu();

  $(window).resize(function() {
    mtsDropdownMenu();
  });
});

/*---------------------------------------------------
/*  Vertical menus toggles
/* -------------------------------------------------*/
jQuery(document).ready(function($) {

  $('.widget_nav_menu, #navigation .menu').addClass('toggle-menu');
  $('.toggle-menu ul.sub-menu, .toggle-menu ul.children').addClass('toggle-submenu');
  $('.toggle-menu ul.sub-menu').parent().addClass('toggle-menu-item-parent');

  $('.toggle-menu .toggle-menu-item-parent').append('<span class="toggle-caret"><i class="point-icon icon-down-dir"></i></span>');

  $('.toggle-caret').click(function(e) {
    e.preventDefault();
    $(this).parent().toggleClass('active').children('.toggle-submenu').slideToggle('fast');
  });
});

/*----------------------------------------------------
/* Back to top smooth scrolling
/*--------------------------------------------------*/
jQuery(document).ready(function($) {
  jQuery("a[href='#top']").click(function() {
    jQuery('html, body').animate({
      scrollTop: 0
    }, 'slow');
    return false;
  });
});

/*----------------------------------------------------
/* Always top when scrolling
/*--------------------------------------------------*/
jQuery(document).ready(function($) {

  function sticky_relocate() {
    var window_top = $(window).scrollTop();
    var div_top = $('#sticky-anchor').offset().top;
    if (window_top > div_top) {
      $('#sticky').addClass('stick');
    } else {
      $('#sticky').removeClass('stick');
    }
  }

  $.getJSON(WPURLS.templateurl + "/php/test-add-money.php",{
      option: "get"
    },
    function(data, status){
        //console.log(data[0].user_money);
        odometer.innerHTML = data[0].user_money;
  });
  var money = 0;
  setInterval(function(){

    $.get(WPURLS.templateurl + "/php/test-add-money.php",{
        option: "set"
      },
      function(data, status){
          //console.log("Data: " + data + "\nStatus: " + status);
    });

    $.getJSON(WPURLS.templateurl + "/php/test-add-money.php",{
        option: "get"
      },
      function(data, status){
          //console.log(data[0].user_money);
          odometer.innerHTML = data[0].user_money;
    });

    //money += Math.floor(Math.random() * 3000);

  }, 60000);
//  odometer.innerHTML = 456000;
  /**var defaults = {
  value: 100000,
  inc: 123,
  pace: 1000,
  auto: false
  };
  var c1 = new flipCounter('c1', defaults);**/

  //$('#sticky').text('วันนี้มีสมาชิกแทงได้รวม 5 บาท');
  //$(window).scroll(sticky_relocate);
    //sticky_relocate();
});
