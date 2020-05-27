(function ($) {
  // collapsed dropdown
  $('#main-wrapper-page .accordion').click(function(){
    $(this).find('.accordionInner').slideToggle("fast");
    $(this).find('.accordionState').toggleClass('active');
  });

  $('.accordion-header').each(function(i, elem){
    var $elem = $(elem);
    var $nextElem = $elem.next('.accordion-content');
    var $accordion = $('<div />');
    var $accordionInner = $('<div >');

    $accordion
      .addClass('accordion')
      .on('click', function(){
        $(this).find('.accordionInner').slideToggle("fast");
        $(this).find('.accordionState').toggleClass('active');
      });

    while($nextElem.hasClass('accordion-content')) {
        $accordionInner.append($nextElem.clone());
        var $tmp = $nextElem;
        $nextElem = $nextElem.next();
        $tmp.remove();
    }

    $accordionInner.css('display', 'none').addClass('accordionInner');

    $elem.wrap($accordion).addClass('anchorTitle accordionState');
    $elem.parent().append($accordionInner);
  });

  // Footer menu group links.
  if ($(window).width() <= 768){
    $('#footer .accordion').click(function(){
      $(this).find('.accordionInner').slideToggle("fast");
      $(this).find('.accordionState').toggleClass('active');
    });
  }
  $( window ).resize(function() {
    if ($(window).width() > 768) {
      $('#footer .accordion').find('.xaccordionInner').show();
      $('#footer .accordion').find('.accordionState').removeClass('active');
    }
  });

  // Sticky nav
  if ($(document).height() > $(window).height()) {
    var header_position = $('#headerSecond').position();
    $(window).scroll(function() {
      // Si el scroll de la ventana llega a la posicion del header colocamos la clase
      if ($(this).scrollTop() >= header_position.top) {

        // Add Clases.
        $('#headerSecond, #headerFirst').addClass('header-sticky');
        $('div.sticky').addClass('active-sticky');
        $('#main-wrapper-page').css('margin-top', '90px');

      } else if ($(this).scrollTop() < header_position.top) {
        // Remove Clasess.
        $('#headerSecond, #headerFirst').removeClass('header-sticky');
        $('div.sticky').removeClass('active-sticky');
        $('#main-wrapper-page').css('margin-top', '0px');
      }
    });
  }

  $('.js__dropdown_login').on('click', function(e) {
    $('.dashboard_dropdown').slideToggle('fast');
  });

  // Slider
  $("#slider > img:gt(0)").hide();
  setInterval(function()
  {
    $('#slider > img:first')
      .fadeOut('slow').next().fadeIn('slow').end().appendTo('#slider');
  }, 5000);
  // End slider

  // Click on filter options.
  $('.filter-action').click(function(){
    $(this).parent().find('li').show();
    $(this).hide();
  });

  // MAP and filters.
  $( "#map-svg-states g" )
  .mouseover(function() {
    $(this).css('cursor', 'pointer');
    // Backgound.
    var path = $(this).find('path');
    path.css('fill', '#2E6E82');

    // Text.
    var text = $(this).find('#text-state');
    text.css('fill', '#CDE9F1');
  })
  .mouseout(function() {
    // Backgound.
    var path = $(this).find('path');
    path.css('fill', '#CDE9F1');

    // Text.
    var text = $(this).find('#text-state');
    text.css('fill', '#2E6E82')
  })
  .click(function(){
    var state = $(this).attr('id');
    window.location.href = "/support-and-services/?services=&query=&population=&state="+ state +"&sort=";
  });

  // Menu user.
  $('div.user.logged-in').click(function(e) {
    $element = $(this);
    e.preventDefault();
    $element.find('ul').slideToggle("fast");
    $element.toggleClass('active');
  });

  // User options, LoggedIn user dashboard.
  if ($('div.nav.user-options .submenu-user').length && $(window).width() <= 768) {
    createOptionsSelect($('div.nav.user-options .submenu-user'));
  }

  $( window ).resize(function() {
    if ($('div.nav.user-options .submenu-user').length) {
      createOptionsSelect($('div.nav.user-options .submenu-user'));
    }
  });

  $( ".tabs" ).tabs();
  $( ".calendar" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
  // $( "#event_tab" ).tabs();

  function createOptionsSelect(element) {
    $element = element;
    if (!$element.hasClass('changed') && $(window).width() <= 768) {
      $element.hide();
      var parent = $element.parent();

      // Create Select.
      $("<select />").prependTo($(parent));
      $(parent).find('select').addClass('menu-drop-mobile');

      // Build Options.
      $("<option />", {
        "selected": "selected",
        "value"   : "",
        "text"    : "Menu ..."
      }).appendTo($(parent).find('select'));

      //
      $element.find('li').each(function(index, value) {
        $("<option />", {
           "value"   : $(value).find('a').attr("href"),
           "text"    : $(value).text()
        }).appendTo($(parent).find('select'));
      });

      $('select.menu-drop-mobile').change(function(){
        var option = $(this).find("option:selected").val();
        window.location.href = option;
      });

      $element.addClass('changed');
    }

    if ($element.hasClass('changed') && $(window).width() > 768) {
      $element.removeClass('changed');
      $element.show();
      $element.parent().find('.menu-drop-mobile').remove();
    }
  }

  // Menu mobile.
  if ($('#headerSecond ul.nav.main-menu').length && $(window).width() <= 768) {
    menuMobile();
    $('#headerSecond ul.nav.main-menu').click(function() {
      $('#headerSecond').find('#menu-mobile-wrapper').toggleClass('active');
    });
  }

  $( window ).resize(function() {
    if ($('#headerSecond ul.nav.main-menu').length) {
      menuMobile();
    }
  });

  // Click Button.
  $('#menu-mobile-wrapper .menu-close').click(function() {
    $('#headerSecond ul.nav.main-menu').click();
  });

  $('.btnBookmark').on('click', function(e) {
    e.preventDefault();

    var $this = $(this);
    var operation = ($this.hasClass('active')) ? 'remove' : 'add';
    var url_segments = [operation, $this.data('type'), $this.data('id')];

    $.ajax({
      url: '/member/bookmark/' + url_segments.join('/'),
      beforeSend: function() {
        if(operation == 'add') $this.find('.fa.fa-star').addClass('fa-spin');
        else $this.prepend('<i class="fa fa-refresh fa-spin"></i> ');
      },
      success: function() {
        if(operation == 'add') {
          $this.addClass('active');
          $this.find('.fa.fa-star').remove();
          $this.text('Bookmarked!');
        } else {
          $this.removeClass('active');
          $this.find('.fa.fa-refresh').remove();
          $this.text('Bookmark');
          $this.prepend('<i class="fa fa-star"></i> ');
        }
      },
      error: function() {
        if(operation == 'add') $this.find('.fa.fa-star').removeClass('fa-spin');
        else $this.find('.fa.fa-refresh').remove();
      }
    });
  });

  function menuMobile() {
    if ($(window).width() <= 768 && !$('#headerSecond').hasClass('active-mm')) {
      var menu = $('#headerSecond ul.nav.main-menu');

      $('.sb-menu').hide();
      $('.sub-menu-2').hide();
      $('.js__arrow').on('click', function() {
          $(this).closest('li.item-menu').find('.sb-menu').slideToggle(100);
          $(this).closest('li.item-menu').toggleClass('expanded');
      });

      $('.js__arrow_child').on('click', function() {
        $(this).closest('li.item-menu-3').find('.sub-menu-2').slideToggle(100);
        $(this).closest('li.item-menu-3').toggleClass('expanded_child');
      })
    }
    else {
      if ($(window).width() > 768) {
        $('#headerSecond ul.nav.main-menu').find('.nedc-menu-mobile');
        $('#headerSecond').removeClass('active-mm');
        $('.nedc-menu-mobile').remove();
      }
    }
  }
  // -- END Menu mobile.

  // Move elements around DOM.
  function processObjectsOrder(elements) {
    $.each( elements, function( key, value ) {
      var data_append = $(value).attr('data-append');
      $(data_append).after($(value).clone());
      $(value).hide();
    });
  }

  if ($('.move-on-mobile').length && $(window).width() <= 768) {
    var objects = $('.move-on-mobile');
    processObjectsOrder(objects);
  }
  if ($('.move-on-mobile-ipad').length && $(window).width() <= 1199) {
    var objects = $('.move-on-mobile-ipad');
    processObjectsOrder(objects);
  }
  // -- END Move elements around DOM.

  // Newly Added

  /**
   * Get val() from clone select tag
   * NOTE: This is for Support and Services Page
   * @version 1.0.0
   */
  $('#au_states').on('change', function(){
    $('#Form_ServicesForm_state, #SearchForm_SearchForm_State').val($(this).val()).closest('form').submit();
  });

  $('#sort_by').on('change', function() {
    $('#Form_ServicesForm_sort').val($(this).val()).closest('form').submit();
  });

  // E-Learning Page
  $('#Form_SortForm select').on('change', function(){
    $(this).closest('form').submit();
  });

  $('#sort_resources').on('change', function(){
    if ($('#Form_ResourceSearchForm_sort')) {
      $('#Form_ResourceSearchForm_sort').val($(this).val()).closest('form').submit();
    }
    if ($('#Form_SortForm_sort')) {
      $('#Form_SortForm_sort').val($(this).val()).closest('form').submit();
    }
  });

  $('#sliders').slick({
    dots: true,
    slidesToShow: 1,
    infinite: false,
    speed: 500,
    nextArrow: '<i class="fa fa-angle-right slick-arrow-right"></i>',
    prevArrow: '<i class="fa fa-angle-left slick-arrow-left"></i>',
    autoplay: true,
    autoplaySpeed: 5000,
    responsive:  [
      {
        breakpoint: 768,
          settings: {
           arrows: false,
          }
      }
    ]
  });

    $('#slick-slide').slick({
    dots: false,
    // centerMode: true,
    centerPadding: '60px',
    slidesToShow: 3,
    infinite: false,
    speed: 500,
    adaptiveHeight: true,
    nextArrow: '<i class="fa fa-angle-right slick-arrow-right offset-right"></i>',
    prevArrow: '<i class="fa fa-angle-left slick-arrow-left offset-left"></i>',
    autoplay: true,
    autoplaySpeed: 5000,
    responsive:  [
      {
        breakpoint: 768,
        settings: {
         arrows: false,
         centerMode: false,
         slidesToShow: 1,
        }
      },
      {
        breakpoint: 1268,
          settings: {
           arrows: false,
           slidesToShow: 2,
          }
        }
    ]
  });

  $('#slider').slick({
    dots: false,
    slidesToShow: 1,
    infinite: false,
    speed: 500,
    arrows: false,
    autoplay: true,
    autoplaySpeed: 5000,
  });

  /**
   * // Add attr selected to select tag clone
   *  NOTE: This is for Support and Services Page
   */
  function onloadState()
  {
    // Au States Clone
    var s = $('#Form_ServicesForm_state').val();
    $('#au_states').val(s);

    // Sort by Clone
    var sb =  $('#Form_ServicesForm_sort').val();
    $('#sort_by').val(sb);

     // Sort by Clone
    var sr =  $('#Form_ResourceSearchForm_sort').val();
    $('#sort_resources').val(sr);

  }
  // init build
  onloadState();

  $('main.dashboard-page .tabs').on('tabsactivate', function(e, ui) {
    if(!ui.newTab.hasClass('nested-tab-link')) {
      Cookies.set('dashboard-page-active-tab', ui.newTab.attr('id'));
    }
  });

  $('main.dashboard-page .nested-tabs').tabs();

  if(dashboardPageActiveTab = Cookies.get('dashboard-page-active-tab')) {
    var active_idx = $('main.dashboard-page .tabs').find('#' + dashboardPageActiveTab).index();
    $('main.dashboard-page .tabs').tabs('option', 'active', active_idx)
  }

  $('main.dashboard-page a.open-tab').on('click', function(e) {
    e.preventDefault();
    $('main.dashboard-page .tabs').tabs('option', 'active', $(this).data('tab-index'));
  });

  $('a.open_settings_tab').on('click', function(e) {
    e.preventDefault();
    $('main.dashboard-page .tabs').tabs('option', 'active', $(this).data('tab-index'));
  });

  // Homepage event numbering and UX
  var news = $('#eventNews').find('.grid').children();
  // If eventNews wrapper > grid has 1 child, make it full width
  if (news.length >= 1 ) {
    $('#eventNews').find('.events').css({'width' : '100%'});
  }

  if (news.length >= 2 ) {
      if ( $('#eventNews .events .wrap > .time').length >= 4 ){
        $('#eventNews .events .wrap').find('.time:nth-last-child(-n + 2)').css({'display' : 'none'});
      }
  }

  $('#share_event_tabs li ').on('click', function() {
    var tab_id = $(this).data('tab');
    var tab_content = $('#'+tab_id);//.offset().top-170;

    $('#share_event_tabs li ').removeClass('active');
    $('.tab-content').removeClass('current');

    if ($('#'+tab_id)) {
      $(this).addClass('active');
    }
    tab_content.addClass('current');

    // $('body, html').animate({scrollTop : tab_content}, 300);
  });

  $('.js__next_tab').on('click', function() {
    var $lis =  $('#share_event_tabs > li'),
        $selected = $('.active').removeClass('active'),
        $current = $('.current').removeClass('current'),
        $tab_content = $('.tab-content');

    ($selected.next().length > 0 ? $selected.next() : $lis.first()).addClass('active');
    ($current.next().length > 0 ? $current.next() : $tab_content.first()).addClass('current');

  });

  $('#search-form').hide();

  $('.js__open_search').on('click', function() {
    $('#search-form').slideToggle(100);
  });

  $('.js__close_search').on('click', function() {
    $('#search-form').slideUp(100);
  });

  function index() {
    var input = $('#tab-2').find('.clone_input');

    input.eq(0).find('input').attr('name', function(i,oldVal) {
      return oldVal.replace(/\[()\]/, '[0]');
    });
    input.eq(0).find('a.remove').hide();
  }
  index();

  $('a.clone').on('click', function() {
    $('.clone_input').last().clone(true).appendTo('#tab-2')
    .find('input').attr('name', function(i,oldVal) {
      return oldVal.replace(/\[(\d+)\]/,function(_,m){
          return "[" + (+m + 1) + "]";
      });
    })
    .removeClass('hasDatepicker').removeAttr('id')

    $('.clone_input').last().find('a.remove').show();

    $('.calendar').each(function() {
      $(this).datepicker({ dateFormat: 'yy-mm-dd' }).val();
    });
  });

  $('a.remove').on('click', function() {
    $(this).closest('.clone_input').remove();
  });

  function factSheet() {
    $('.fact-sheet').each(function() {
      var items_shown  = 2;
      var $self = $(this);
      var items = $self.find('ul.f-list > li').length;

      $self.find('li:lt('+ items_shown +')').show();
      $self.find('.js__view_less').hide();

      if(items <= 2) {
        $self.find('.js__view_more').hide();
        $self.find('.js__view_less').hide();
      }
      // 
      $self.find('.js__view_more').on('click', function() {
        // items_shown = (items_shown + 2 <= items) ? items_shown + 2  : items;
        $self.find('ul.f-list > li:lt('+items+')').slideDown(100);
        $(this).hide();
        $self.find('.js__view_less').show();
      });

      $self.find('.js__view_less').on('click', function() {
        console.log('hi')
        $self.find('ul.f-list > li').not(':lt(2)').slideUp(100);
        $(this).hide();
        $self.find('.js__view_more').show();
      });
    });
  }
  factSheet();
  
  $('.js__open_modal').attr('href', function(i, old){
    return '#' + old;
  });

  $('.js__open_modal').leanModal({ overlay : 0.4, closeButton: ".modal_close" });
  $('.js__open_modal').on('click', function(e) {
    e.stopPropagation();
      var $modal = $('.modal_box');
      $modal.css('position', 'absolute');
  });

  $('.js__remove_event').on('click', function() {
    $(this).closest('.eventMember').fadeOut();
  });

  $('.js_minimize-survey').on('click', function() {
    $('.survey-content').slideToggle();
  });

  if(survey_closed = Cookies.get('surveyClose')) {
    $('.survey').addClass(survey_closed);
  }
  
  $('.js_close-survey').on('click', function() {
    var time = 1; //day
    Cookies.set('surveyClose', 'close', {expires : time});
    $('.survey').addClass('close');
  });

  var stickIt = function() {
    if ($(window).width() >= 1200){
      $('#sticky').stick_in_parent({offset_top: 170});
    } else {
      $("#sticky").trigger("sticky_kit:detach");
    }
  }
  //  load sticky on resize and on load
  $(document).ready(stickIt);
  $(window).resize(stickIt);

})(jQuery);
