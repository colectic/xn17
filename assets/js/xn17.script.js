/**
* @file   xn17.script.js
*         Custom scripts for theme.
*/

$ = jQuery;

/**
* La variable Obert, és una variable global per tal que a la portada s'ocultin
* els llistat de recursos en una primera instància
*/

var mesRecursosObert = false;
var mesNoticiesObert = false;


(function ($, Drupal, window, document, undefined) {
  
  Drupal.xn17 = {

    /**
     * Handles in a more accurately manner the anchors of the Resources' indexs
     * 
     * This prevent to scroll to the target element, that by default gets hidden by the browser
     * after going to it. This snippets prevents that.
     */

    resourcesIndexAnchors: function() {

      if ($('body').hasClass('node-type-recurs-general')) {
      
        $('.field-name-seccions-recurs-index .view li a').click(function(event) {
          
          event.preventDefault();

          // Getting the target element and it's offset's top

          var targetId = $(this).attr('href').replace('#', '');
          var $targetElement = $('#' + targetId);
          var targetElementOffsetTop = parseInt($targetElement.offset().top);
          
          // Calculating the height of some fixed elements of the page

          var marginTop = 15;
          var drupalAdminMenu = 0;
          if ($('#admin-menu').length > 0) {
            drupalAdminMenu = parseInt($('#admin-menu').height());
          }
          var mainFixedHeaderHeight = parseInt($('#third-header-clone').height());
          var resourcesFixedToolbarHeight = parseInt($('#fixed-menu-recursos').height());
          var targetElementHeight = $targetElement.height();

          // Calculating the real amount of pixels to scroll to reach the target element
          // One we know the total height of fixed elements on the page

          var scrollTo = targetElementOffsetTop - resourcesFixedToolbarHeight - mainFixedHeaderHeight - drupalAdminMenu - marginTop;
          
          // Finally, scroll to the target element (without any animation)

          window.scrollTo(0, scrollTo);
        });
      }
    },

    equalHeight: function () {
      var options = {property: 'height'};
      $('.agenda .views-field-nothing').matchHeight(options);
      $('.financament .views-field-nothing').matchHeight(options);
      // $('.node-type-panel .modul_2x1 .titular').matchHeight(options);
      // $('.pager--infinite-scroll.pager--infinite-scroll').click(function () {
      //   $('body').ajaxComplete(function () {
      //     $('.node-type-panel .modul_2x1 .titular').matchHeight(options);
      //   });
      // });
      //$('.page-opinio .views-field').matchHeight(options);
    },

    buttonSearch: function () {
      $('#secondary-menu .btn-search').click(function () {
        var display = $('#second-header .header-search').css('display');
        if(display=='none'){
          $('#second-header .header-search').css('display','block');
        }
        else {
          $('#second-header .header-search').css('display','none');
        }
      });
    },

    /**
     * Handling of the Fixed Menus on page load & window scroll event
     * 
     * Basically, we play with the DOM, cloning both menus to a pair of css-fixed placeholders,
     * which behavior is controlled by a offset's comparisions against the window's scroll
     *
     * There are several scenarios:
     *
     *  1) Homepage: With 2 Fixed menus in the same page, build with Panes
     *  2) Internal pages related to Notícies, build with Blocks
     *  2) Internal pages related to Recursos, build with Blocks
     */
    
    fixedMenu: function() {

      var $body = $('body');
      var $window = $(window);
      var $menu = $('#third-header');
      var $fixedMenu = $('#third-header-clone');
      var $fixedMenuNoticies = $('#fixed-menu-noticies');
      var $fixedMenuNoticiesInner = $('#fixed-menu-noticies .inner');
      var $fixedMenuRecursos = $('#fixed-menu-recursos');
      var $fixedMenuRecursosInner = $('#fixed-menu-recursos .inner');
      var $paneNoticies = $('.pane-menu-menu-xn17-menu-noticies');
      var $paneRecursos = $('.pane-menu-menu-xn17-menu-recursos');
      var $blockNoticies = $('.block-menu.menu.menu-noticies');
      var $blockRecursos = $('.block-menu.menu.menu-recursos');
      var $panelRecursos = $('.front .panels-flexible-row-76-2');

      /**
       * Not-front pages
       */

      if ($body.hasClass('not-front')) {

        // Noticies
        
        if ($blockNoticies.length > 0) {
          var $blockNoticiesTop = parseInt($blockNoticies.offset().top);
          var $menuTop = parseInt($menu.offset().top);
          var $windowTop = parseInt($window.scrollTop());

          // Clone Noticies menu content in their regarding fixed clon

          var $blockNoticiesContents = $blockNoticies.html();
          $fixedMenuNoticiesInner.empty().html($blockNoticiesContents);
          $fixedMenuRecursos.hide();

          if ($windowTop > $blockNoticiesTop) {
            $fixedMenuNoticies.show();
          }
          else {
            $fixedMenuNoticies.hide();
          }

          if ($windowTop > $menuTop) {
            $fixedMenu.show();
          }
          else {
            $fixedMenu.hide();
          }

          $(window).scroll(function() {
            var $windowTop = parseInt($window.scrollTop());

            if ($windowTop > $blockNoticiesTop) {
              $fixedMenuNoticies.show();

              // Hide the fixed menu when scrolling the page with the Main menu open
              
              if ($('#main-menu').is(':visible')) {
                $fixedMenuNoticies.addClass('hidden');
              }
              else {
                $fixedMenuNoticies.removeClass('hidden');
              }
            }
            else {
              $fixedMenuNoticies.hide();
            }

            if ($windowTop > $menuTop) {
              $fixedMenu.show();
            }
            else {
              $fixedMenu.hide();
            }
          });
        }

        // Recursos
        
        if ($blockRecursos.length > 0) {
          var $blockRecursosTop = parseInt($blockRecursos.offset().top);
          var $menuTop = parseInt($menu.offset().top);
          var $windowTop = parseInt($window.scrollTop());

          // Clone Recursos menu content in their regarding fixed clon

          var $blockRecursosContents = $blockRecursos.html();
          $fixedMenuRecursosInner.empty().html($blockRecursosContents);
          $fixedMenuNoticies.hide();

          if ($windowTop > $blockRecursosTop) {
            $fixedMenuRecursos.show();
          }
          else {
            $fixedMenuRecursos.hide();
          }

          if ($windowTop > $menuTop) {
            $fixedMenu.show();
          }
          else {
            $fixedMenu.hide();
          }

          $(window).scroll(function() {
            var $windowTop = parseInt($window.scrollTop());

            if ($windowTop > $blockRecursosTop) {
              $fixedMenuRecursos.show();

              // Hide the fixed menu when scrolling the page with the Main menu open
              
              if ($('#main-menu').is(':visible')) {
                $fixedMenuRecursos.addClass('hidden');
              }
              else {
                $fixedMenuRecursos.removeClass('hidden');
              }
            }
            else {
              $fixedMenuRecursos.hide();
            }

            if ($windowTop > $menuTop) {
              $fixedMenu.show();
            }
            else {
              $fixedMenu.hide();
            }
          });
        }        

        // On pages without any menu: remove the fixed menus

        if ($blockNoticies.length == 0 && $blockRecursos.length == 0) {
          $fixedMenuNoticies.remove();
          $fixedMenuRecursos.remove();
        }
      }

      /**
       * Front page
       */

      if ($body.hasClass('front')) {
        
        var correction = 664;
        var $menuTop = parseInt($menu.offset().top);
        var $windowTop = parseInt($window.scrollTop());
        var $paneNoticiesTop = parseInt($paneNoticies.offset().top);
        var $paneRecursosTop = parseInt($paneRecursos.offset().top);
        var $breakPoint = parseInt($panelRecursos.offset().top) - correction;

        // Clone both Noticies & Recursos menu in their regarding fixed clones
        
        var $paneNoticiesContents = $paneNoticies.html();
        var $paneRecursosContents = $paneRecursos.html();
        $fixedMenuNoticiesInner.empty().html($paneNoticiesContents);
        $fixedMenuRecursosInner.empty().html($paneRecursosContents);

        // Determine Fixed Menu's visibility
        
        if ($windowTop < $paneNoticiesTop) {
          $fixedMenuNoticies.hide();
          $fixedMenuRecursos.hide();
        }
        else if ($windowTop > $paneNoticiesTop && $windowTop < $breakPoint) {
          $fixedMenuNoticies.show();
          $fixedMenuRecursos.hide();
        }
        else if ($windowTop > $breakPoint) {
          $fixedMenuNoticies.hide();
          $fixedMenuRecursos.show();
        }

        // Determine fixed header visibility

        if ($windowTop > $menuTop) {
          $fixedMenu.show();
        }
        else {
          $fixedMenu.hide();
        }

        $(window).scroll(function() {
          var $windowTop = parseInt($window.scrollTop());

          // Determine Fixed Menu's visibility
          
          if ($windowTop < $paneNoticiesTop) {
            $fixedMenuNoticies.hide();
            $fixedMenuRecursos.hide();
          }
          else if ($windowTop > $paneNoticiesTop && $windowTop < $breakPoint) {
            $fixedMenuNoticies.show();
            $fixedMenuRecursos.hide();

            // Hide both Fixed menus when scrolling the page with the Main menu open
            
            if ($('#main-menu').is(':visible')) {
              $fixedMenuNoticies.addClass('hidden');
              $fixedMenuRecursos.addClass('hidden');
            }
            else {
              $fixedMenuNoticies.removeClass('hidden');
              $fixedMenuRecursos.removeClass('hidden');
            }
          }
          else if ($windowTop > $breakPoint) {
            $fixedMenuNoticies.hide();
            $fixedMenuRecursos.show();
          }

          // Determine Sticky-menu visibility

          if ($windowTop > $menuTop) {
            $fixedMenu.show();
          }
          else {
            $fixedMenu.hide();
          }
        });
      }
    },

    /**
     * Handles the expand/collapse feature of the Fixed Menus
     * 
     * Also includes support for cookies, in order to remember the user's choice
     * about the fixed menu state (collapsed or expanded)
     */

    fixedMenuToggler: function() {

      // Set initial state, if a cookie exists

      if (!!$.cookie('fixedMenuState')) {
        var stateByCookie = $.cookie('fixedMenuState');
       
        $('.fixed-menu button').removeClass().addClass(stateByCookie);
        $('.fixed-menu').removeClass().addClass('fixed-menu ' + stateByCookie);

        // Collapse any fixed menu content, as fast as possible, if the cookie says 'closed'

        if (stateByCookie == 'closed') {
          $('.fixed-menu').find('.inner > div').slideUp(1);
        }
      }

      // Toggler (Click event)

      $('.fixed-menu button').click(function() {

        var $button = $(this);
        var state = $button.attr('class');
        var $fixedMenu = $('.fixed-menu'); // This will affect both fixed menus (if they are present)
        
        if (state == 'open') {
          state = 'closed';
        }
        else if (state == 'closed') {
          state = 'open';
        }

        // Updating classes with the new state value on button & fixed menus

        $('.fixed-menu button').removeClass().addClass(state);  // This will affect both fixed menus buttons (if they are present)
        $fixedMenu.removeClass().addClass('fixed-menu ' + state);

        // Update the cookie that will remember the state in future page loads
        
        $.cookie('fixedMenuState', state);

        //  Toggling Pane based menu (Home page)
         
        if ($fixedMenu.find('.inner .pane-content').length > 0) {
          if ($button.hasClass('closed')) {
            $fixedMenu.find('.inner .pane-content').slideUp(150);
          }
          else if ($button.hasClass('open')) {
           $fixedMenu.find('.inner .pane-content').slideDown(150); 
          }
        }

        // Toggling Block based menu (Inner pages)
        
        if ($fixedMenu.find('.inner .block__content').length > 0) {
          if ($button.hasClass('closed')) {
            $fixedMenu.find('.inner .block__content').slideUp(150);
          }
          else if ($button.hasClass('open')) {
           $fixedMenu.find('.inner .block__content').slideDown(150); 
          }
        }
      });
    },

    /**
     * Handles the expand/collapse feature of the Regular Menus
     * 
     * Also includes support for cookies, in order to remember the user's choice
     * about the regular menu state (collapsed or expanded)
     */

    regularMenuToggler: function() {
      
      // Desktop viewport
      
      enquire.register('screen and (min-width: 1200px)', {
        
        match: function() {
      
          // Remove the toggler and show the submenu contents
      
          $('.block-menu-toggler').remove();
          $('.pane-menu-toggler').remove();
          $('.block-menu.menu .block__content').show();
          $('.pane-block.menu .pane-content').show();
        },
      });
      
      // Tablet & Mobile viewports
      
      enquire.register('screen and (max-width: 1199px)', {
        
        match: function() {
      
          // Populate a submenu toggler
      
          var srOnlyText = 'Mostra o amaga les categories del submenu';
          var $blockToggler = $('<button class="block-menu-toggler closed"><span class="sr-only">' + srOnlyText + '</span></button>');
          var $paneToggler = $('<button class="pane-menu-toggler closed"><span class="sr-only">' + srOnlyText + '</span></button>');
          var $block = $('.block-menu.menu');
          var $blockTitle = $('.block-menu.menu .block__title');
          var $pane = $('.pane-block.menu');
          var $paneTitle = $('.pane-block.menu .pane-title');
      
          // If a Block is used
      
          if ($block.length > 0) {

            // Append it to the block
            
            var $blockContent = $block.find('.block__content');
            $blockToggler.appendTo($blockTitle);

            // Set initial state, if a cookie exists

            if (!!$.cookie('regularMenuState')) {
              var stateByCookie = $.cookie('regularMenuState');
             
              $('.block-menu-toggler').removeClass().addClass('block-menu-toggler ' + stateByCookie);
              $('.block-menu.menu').removeClass('closed').removeClass('open').addClass(stateByCookie);

              // Collapse any fixed menu content, as fast as possible, if the cookie says 'closed'

              if (stateByCookie == 'closed') {
                $('.block-menu.menu').find('.block__content').slideUp(1);
              }
              else if (stateByCookie == 'open') {
                $('.block-menu.menu').find('.block__content').slideDown(1);
              }
            }

            // Bind a click event
          
            $('.block-menu-toggler').click(function() {

              if ($(this).hasClass('open')) {
                $(this).removeClass().addClass('block-menu-toggler closed');
                $(this).parent().siblings('.block__content').slideUp(150);
                $.cookie('regularMenuState', 'closed');
              }
              else if ($(this).hasClass('closed')) {
                $(this).removeClass().addClass('block-menu-toggler open');
                $(this).parent().siblings('.block__content').slideDown(150);
                $.cookie('regularMenuState', 'open');
              }
            });
          }
      
          // If a Pane is used

          if ($pane.length > 0) {

            // Append it to the pane
            
            var $paneContent = $pane.find('.pane-content');
            $paneToggler.appendTo($paneTitle);

            // Set initial state, if a cookie exists

            if (!!$.cookie('regularMenuState')) {
              var stateByCookie = $.cookie('regularMenuState');
             
              $('.pane-menu-toggler').removeClass().addClass('pane-menu-toggler ' + stateByCookie);
              $('.pane-block.menu').removeClass('closed').removeClass('open').addClass(stateByCookie);

              // Collapse any fixed menu content, as fast as possible, if the cookie says 'closed'

              if (stateByCookie == 'closed') {
                $('.pane-block.menu').find('.pane-content').slideUp(1);
              }
              else if (stateByCookie == 'open') {
                $('.pane-block.menu').find('.pane-content').slideDown(1);
              }
            }

            // Bind a click event
          
            $('.pane-menu-toggler').click(function() {

              if ($(this).hasClass('open')) {
                $('.pane-menu-toggler').removeClass().addClass('pane-menu-toggler closed'); // Affects both menus: Noticies & Recursos
                $('.pane-block.menu').find('.pane-content').slideUp(150); // Affects both menus: Noticies & Recursos
                $.cookie('regularMenuState', 'closed');
              }
              else if ($(this).hasClass('closed')) {
                $('.pane-menu-toggler').removeClass().addClass('pane-menu-toggler open'); // Affects both menus: Noticies & Recursos
                $('.pane-block.menu').find('.pane-content').slideDown(150); // Affects both menus: Noticies & Recursos
                $.cookie('regularMenuState', 'open');
              }
            });
          }
        },
      });
    },

    /**
     * Handles the opening event of the Main Menu
     */
    
    mainMenuOpenEvent: function() {

      $('.menu-icon').click(function() {

        // Variables
        
        var sm  = 768 - 15;
        var md  = 992 - 15;
        var wst = $(window).scrollTop();
        var wwi = $(window).width();
        var tht = $('#third-header').offset().top;

        // Force a document scroll, based on the header's height

        if (wst >= 41 && (wwi >= sm && wwi < md)) {
          window.scrollTo({
            'top': 41,
            'left': 0,
            'behavior': 'auto'
          });
        }
        else if (wst >= 120 && wwi >= md) {
          window.scrollTo({
            'top': 120,
            'left': 0,
            'behavior': 'auto'
          });
        }
        
        // On large viewports, we hide the entire page content, leaving
        // only visible the menu just open
        
        if (wwi >= sm) {

          if ($(this).hasClass('active')) {
            // Forces the noticies/recursos menus to be unsticky and visible, when closing the menu
            $('#main-wrapper').fadeToggle('slow');
            $('.menu.menu-noticies, .menu.menu-recursos').removeClass('sticky').slideDown('fast');
          }
          else {
            $('.menu.menu-noticies.sticky, .menu.menu-recursos.sticky').slideToggle('fast');
            $('#main-wrapper').fadeToggle('slow');
          }
        }
        
        // Toggles a flag to determine the button status
        
        $('.menu-icon').toggleClass('active'); 

        // Toggles the menu visibility, with a slide effect

        $('#main-menu').slideToggle('slow');
      });
    },

    /**
     * Handles the closing event of the Main Menu
     */
    
    mainMenuCloseEvent: function() {

      $('#close-button').click(function() {

        // Variables

        var sm  = 768 - 15;
        var md  = 992 - 15;
        var wst = $(window).scrollTop();
        var wwi = $(window).width();
        var tht = $('#third-header').offset().top;

        // Toggles a flag to determine the button status

        $(this).toggleClass('active'); 

        // Force a document scroll, based on the header's height
        
        if (wst >= 41 && (wwi >= sm && wwi < md)) {
          window.scrollTo({
            'top': 41,
            'left': 0,
            'behavior': 'auto'
          });
        }
        else if (wst >= 120 && wwi >= md) {
          window.scrollTo({
            'top': 120,
            'left': 0,
            'behavior': 'auto'
          });
        }

        // Toggles the menu visibility, with a slide effect

        $('#main-menu').slideToggle('slow');
        
        // Forces the noticies/recursos menus to be unsticky and visible, when closing the menu
        
        if (wwi >= sm) {
          $('#main-wrapper').fadeToggle('slow');
          $('.menu.menu-noticies, .menu.menu-recursos').slideDown('fast').removeClass('sticky');
        }
      });
    },

    /**
     * Handles the toggling events of the inner items of the Main Menu
     */

    mainMenuSubmenus: function() {

      // Level 2 submenus
      
      $('.menu-link.depth-2').click(function() {
        var md  = 992 - 15;
        var wwi = $(window).width();
        if (wwi < md) {
          $(this).next('.submenu.depth-3').slideToggle('slow');
          $(this).children().toggleClass('opened');
          $(this).children().toggleClass('closed');
        }
      });
      
      // Level 1 submenus
      
      $('.menu-link.depth-1').click(function() {
        var md  = 992 - 15;
        var wwi = $(window).width();
        if (wwi < md) {
          $(this).next('.submenu.depth-2').slideToggle('slow');
          $(this).children().toggleClass('opened');
          $(this).children().toggleClass('closed');
        }
      });      
    },

    /**
     * Handles the overriding of the default titles of Notícies & Recursos
     * menús, by doing a comparision between a given pattern and the current 
     * pathname taken from the url being viewed
     */

    subMenuTitleOverrides: function() {

      // Overrides header's menu title when viewing Monogràfics's related pages
      
      var pattern1 = /^\/monografics/;
      var pattern2 = /^\/especial\//;
      var path = window.location.pathname;
      if (pattern1.test(path) || pattern2.test(path)) {
        $('.block-menu.menu.menu-noticies h4').text('Monogràfics');
      }
      if (pattern1.test(path)) {
        $('#page-header').remove();
      }
      
      // Overrides header's menu title when viewing Opinió's related pages
      
      var pattern1 = /^\/opinio$/;
      var pattern2 = /^\/opinio\//;
      var pattern3 = /^\/autora\//;
      var pattern4 = /^\/autors-es$/;
      var path = window.location.pathname;
      if (pattern1.test(path) || pattern2.test(path) || pattern3.test(path) || pattern4.test(path)) {
        $('.block-menu.menu.menu-noticies h4').text('Opinió');
      }
      if (pattern1.test(path)) {
        $('#page-header').remove();
      }
      
      // Overrides header's menu title when viewing Finançament's related pages
      
      var pattern1 = /^\/financament/;
      var pattern2 = /^\/financament\//;
      var path = window.location.pathname;
      if (pattern1.test(path) || pattern2.test(path)) {
        $('.block-menu.menu.menu-recursos h4').text('Finançament');
      }
      
      // Overrides header's menu title when viewing Agenda's related pages
      
      var pattern1 = /^\/agenda/;
      var pattern2 = /^\/agenda\//;
      var path = window.location.pathname;
      if (pattern1.test(path) || pattern2.test(path)) {
        $('.block-menu.menu.menu-noticies h4').text('Agenda');
      }
      
      // Overrides header's menu title when viewing Biblioteca's related pages
      
      var pattern1 = /^\/biblioteca/;
      var pattern2 = /^\/biblioteca\//;
      var path = window.location.pathname;
      if (pattern1.test(path) || pattern2.test(path)) {
        $('.block-menu.menu.menu-recursos h4').text('Biblioteca');
      }
      
      // Overrides header's menu title when viewing Fes voluntariat's related pages
      
      var pattern1 = /^\/fes-voluntariat/;
      var pattern2 = /^\/etiquetes\/general\/crida-de-voluntariat/;
      var path = window.location.pathname;
      if (pattern1.test(path)) {
        $('.block-menu.menu.menu-recursos h4').text('Fes voluntariat');
        $('#page-header').remove();
      }
      if (pattern2.test(path)) {
        $('#page-header h1').text('Demandes de voluntariat');
      }      
    },

    /**
     * Helper function to retrieve the raw value of a url parameter
     */

    getUrlParameter: function(param) {

      var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;

      for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === param) {
          return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
      }
    },

    /**
     * Gets the date value of a url param in '/agenda', sent from the Homepage's calendar
     * puts the value in the date field and auto-submits the form
     */

    agendaSetCalendarDateInForm: function() {

      var date = Drupal.xn17.getUrlParameter('field_date_event_value[value][date]');
      var $form = $('#views-exposed-form-xn17-agenda-page');
      var $input  = $('#edit-field-date-event-value2-value-datepicker-popup-1');

      // Set a regex pattern to validate date in format dd/mm/yyyy or dd-mm-yyyy
      
      var pattern = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
      
      // If there's a valid date, puts it in the field and submits the form
      
      if (typeof(date) !== 'undefined' && pattern.test(date)) {
        $input.val(date);
        $form.submit();
      }
    },

    /**
     * In the 'Covid-19 special' page we have to dynamically append a banner after
     * the 3th element of the grid.
     * 
     * In order to do it fast & easy, it will be done through this function
     * with pure Javascript/jQuery.
     * 
     * This function can be removed when the page ('/especial/covid-19') would be unpublished.
     */
    
    covid19SpecialOverrides: function() {

      if ($('#covid19-special').length > 0) {
        var html;
        var banner = '';
        banner += '<div class="views-row col-lg-3 col-md-3 col-sm-6 col-xs-12 modul-2x1">';
        banner += '<div class="modul_2x1" id="covid19-grid-banner">';
        banner += '<a class="first" target="_blank" href="https://voluntariat.gencat.cat/recursos-i-serveis/serveis-dassessorament-i-acompanyament/">';
        banner += '<span>' + Drupal.t('Servei d\'Assessorament gratuït per a entitats') +'</span>';
        banner += '</a>';
        banner += '<a class="last" target="_blank" href="https://voluntariat.gencat.cat/recursos-i-serveis/serveis-dassessorament-i-acompanyament/">';
        banner += '<span>' + Drupal.t('Informa\'t!') +'</span>';
        banner += '</a>';
        banner += '</div>';
        banner += '</div>';
        html = $.parseHTML(banner);
        
        // Prepare the element and the target
        
        var $banner = $(html);
        var $target = $('#covid19-special .view-xn17-etiquetes').find('.views-row:eq(2)');
        
        // Append the banner, avoiding duplicates (due to AJAX triggered by the 'View more' button)

        if ($('#covid19-grid-banner').length > 0) {
          $('#covid19-grid-banner').parent().remove();
        }
        $banner.insertAfter($target);
      }
    },

    /**
     * Helper function to improve the a11y of the tables, by adding
     * a hidden caption just before the <thead> tag.
     *
     * @param   {object}  params  
     *          An object containing the following data:
     *            
     *            - tableSelector {string}  A valid CSS selector to identify the table.
     *            - captionText:  {string}  A fully descriptive text explaining the table structure and data.
     */
    addCaptionToTable: function(params) {
      var tableSelector = params.tableSelector;
      var captionText = params.captionText;
      if ($(tableSelector).find('caption').length < 1) { // Avoids weird caption duplicates
        if (tableSelector && captionText) { // Ensure both params exists
          var $caption = $('<caption class="sr-only"></caption');
          $caption.text(captionText);
          $(tableSelector).prepend($caption);
        }
      }
    }
  };

  Drupal.behaviors.xn17_tothomweb = {
    attach: function(context, setting) {
      Drupal.xn17.resourcesIndexAnchors();
      Drupal.xn17.fixedMenu();
      Drupal.xn17.fixedMenuToggler();
      Drupal.xn17.regularMenuToggler();
      Drupal.xn17.mainMenuOpenEvent();
      Drupal.xn17.mainMenuCloseEvent();
      Drupal.xn17.mainMenuSubmenus();
      Drupal.xn17.subMenuTitleOverrides();
      Drupal.xn17.agendaSetCalendarDateInForm();
      Drupal.xn17.equalHeight();
      Drupal.xn17.buttonSearch();
      Drupal.xn17.covid19SpecialOverrides(); // Can be removed when the landing would be unpublished
      Drupal.xn17.addCaptionToTable({
        'tableSelector': '.front .view-xn17-agenda-portada .calendar-calendar table',
        'captionText': 'La taula és una vista de calendari amb el mes actual; amb el nom abreviat dels dies de la setmana a la capçalera, començant pel dilluns.'
      });
      Drupal.xn17.addCaptionToTable({
        'tableSelector': '.page-politica-cookies .pane-1 table',
        'captionText': 'La taula ofereix informació sobre les galetes que es fan servir en aquest lloc web. Consta de 4 columnes: procedència de la cookie, nom de la cookie, la seva finalitat i el venciment d\'aquesta.'
      });
      Drupal.xn17.addCaptionToTable({
        'tableSelector': '.page-node-135151 .views-field-field-continguts table',
        'captionText': 'Taula on es detallen els porcentatges de deducció en base a l\'import de deducció. Fins un import de 150€ el percentatge de la deducció arriba al 75%; per la resta d\'imports, és del 30%.'
      });
    }
  };

  Drupal.behaviors.xn17_collectic = {
    attach: function(context, setting) {

      // Filtres Biblioteca

      $('#views-exposed-form-xn17-biblioteca-page #cerca-avancada').click( function() {
        $(this).toggleClass('showicon');
        $(this).toggleClass('hideicon');
        $(this).closest('.content').toggleClass('advanced');
        $('#edit-field-doc-tipologia-tid-wrapper').toggle();
        $('#edit-field-doc-tematica-tid-wrapper').toggle();
        $('#edit-field-doc-data-publi-value-wrapper').toggle();
        $('#edit-field-doc-editorial-tid-wrapper').toggle();
        $('.views-submit-button').toggle();
      });
      
      // Recull de documents de Biblioteca a la Home
      
      $('.view-xn17-recull-documents .document-biblioteca').mouseover( function() {
        $('.sinopsi', this).fadeIn('1500', function() {});
      });
      $('.view-xn17-recull-documents .document-biblioteca').mouseleave( function() {
        $('.sinopsi', this).fadeOut('250', function() {});
      });
      
      // Notícies a la Home
      
      if (mesNoticiesObert == false) {
        $('.front .view-id-bloc-mes-xn17-noticies .view-content').css('display', 'none');
        $('.front .view-id-bloc-mes-xn17-noticies .pager__item a').click(function() {
          mesNoticiesObert = true;
          $('.front .view-id-bloc-mes-xn17-noticies .view-content').slideToggle('slow');
          $('.front .view-id-bloc-mes-xn17-noticies .view-content').css('display', 'inherit');
        });
      };
      
      // Recursos a la Home
      
      if (mesRecursosObert == false) {
        $('.front .view-id-bloc-mes-xn17-recursos .view-content').css('display', 'none');
        $('.front .view-id-bloc-mes-xn17-recursos .pager__item a').click(function() {
          mesRecursosObert = true;
          $('.front .view-id-bloc-mes-xn17-recursos .view-content').slideToggle('slow');
          $('.front .view-id-bloc-mes-xn17-recursos .view-content').css('display', 'inherit');
        });
      };

      // Select dropdown d'Especials

      $('#form_monografics').change(function() {
        window.location.href = '/node/' + $('#form_monografics').val();
      });

      // Comentaris
      
      $('#comments-header').click( function() {
        $('#comments-body').slideToggle('slow');
        $('#comments').toggleClass('closed');
      });

      // FAQs

      var url = document.location.toString();
      if (url.match('/faq/#-')) {
        $('#qui-gestiona').removeClass('in');
        $('#' + url.split('#-')[1]).addClass('in');
      }

      // Making Youtube videos responsive
      
      $('iframe[src^="https://www.youtube"]').attr('width', '100%');
      
      // Override of Search Form placeholder
      
      $('#search-form #edit-keys').attr('placeholder', 'Cerca');
    }
  };

})(jQuery, Drupal, this, this.document);
