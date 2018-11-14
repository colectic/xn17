/**
* @file
* Custom scripts for theme.
*/
$ = jQuery;
/**
* La variable obert, és una variable global per tal que a la portada s'oculti
* els llistat de recursoso en una primera instancia
*/
var mesRecursosObert = false;
var mesNoticiesObert = false;
/*
*/

(function ($, Drupal, window, document, undefined) {
  
  Drupal.xn17 = {

    /**
     * Handling of the Sticky Menus on page load & window scroll
     * 
     * Basically, we play with the DOM, cloning the given menu to a fixed placeholder,
     * which behavior is controlled by a offset's comparisions against the window's scroll
     *
     * There are several scenarios:
     *
     *  1) Homepage: With 2 Sticky menus in the same page
     *  2) Internal pages related to Notícies
     *  2) Internal pages related to Recursos
     */
    
    stickyMenu: function() {

      var $body = $('body');
      var $window = $(window);
      var $menu = $('#third-header');
      var $fixedMenu = $('#third-header-clone');
      
      // var $stickyWrapper = $('#sticky-wrapper');
      // var $stickyWrapperInner = $('#sticky-wrapper .inner');
      
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
          // $fixedMenuNoticiesInner.empty();
          // $fixedMenuRecursosInner.empty();
        }
        else if ($windowTop > $paneNoticiesTop && $windowTop < $breakPoint) {
          $fixedMenuNoticies.show();
          $fixedMenuRecursos.hide();
        }
        else if ($windowTop > $breakPoint) {
          $fixedMenuNoticies.hide();
          $fixedMenuRecursos.show();

          // if ($stickyWrapper.is(':hidden')) {
            // $fixedMenuNoticies.hide();
            // $fixedMenuRecursos.show();
          // }
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

          // Maintain the expanded or collapsed state on window scroll
          
          // if (!!$.cookie('stickyMenuState')) {
          //   var state = $.cookie('stickyMenuState');
          //   $stickyWrapper.removeClass().addClass(state);
          // }

          // Determine Fixed Menu's visibility
          
          if ($windowTop < $paneNoticiesTop) {
            $fixedMenuNoticies.hide();
            $fixedMenuRecursos.hide();
          }
          else if ($windowTop > $paneNoticiesTop && $windowTop < $breakPoint) {
            $fixedMenuNoticies.show();
            $fixedMenuRecursos.hide();

            // var $paneNoticiesContents = $paneNoticies.html();
            // $stickyWrapperInner.empty();
            // $stickyWrapperInner.html($paneNoticiesContents);
            // if ($stickyWrapper.is(':hidden')) {
            //   $stickyWrapper.show();
            // }

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

            // var $paneRecursosContents = $paneRecursos.html();
            // $stickyWrapperInner.empty();
            // $stickyWrapperInner.html($paneRecursosContents);
            // if ($stickyWrapper.is(':hidden')) {
            //   $stickyWrapper.show();
            // }
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

    stickyMenuToggler: function() {

      $('.fixed-menu button').click(function() {
        var $button = $(this);
        var state = $button.attr('class');
        var $fixedMenu = $('.fixed-menu'); // This will affect both fixed menus
        
        if (state == 'open') {
          state = 'closed';
        }
        else if (state == 'closed') {
          state = 'open';
        }

        $button.attr('class', state);
        $fixedMenu.removeClass().addClass('fixed-menu ' + state);

        //  Pane based menu (Home page)
         
        if ($fixedMenu.find('.inner .pane-content').length > 0) {
          if ($button.hasClass('closed')) {
            $fixedMenu.find('.inner .pane-content').slideUp(150);
          }
          else if ($button.hasClass('open')) {
           $fixedMenu.find('.inner .pane-content').slideDown(150); 
          }
        }

        // Block based menu (Inner pages)
        
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

    stickyMenuTogglerCookie: function() {

      var $body = $('body');

      // Create a cookie with current Sticky menu state, if not exists
      
      if (!$.cookie('stickyMenuState')) {
        $.cookie('stickyMenuState', 'open');
      }

      // Once it exists, toggle the cookie value on each toggler click event
      
      $('#sticky-toggler').click(function() {
        if ($(this).hasClass('open')) {
          $.cookie('stickyMenuState', 'open');
        }
        else {
          $.cookie('stickyMenuState', 'closed');
        }
      });
    },

    /**
     * Handles the expand/collapse feature of the Sticky Menus
     */

    regularMenuToggler: function() {
      
      // Desktop viewport
      
      enquire.register("screen and (min-width: 1200px)", {
        
        match: function() {
      
          // Remove the toggler and show the submenu contents
      
          $('.block-menu-toggler').remove();
          $('.pane-menu-toggler').remove();
          $('.block-menu.menu .block__content').show();
          $('.pane-block.menu .pane-content').show();

          // Store the 'open' state in da cookie
          
          if (!$.cookie('regularMenuState')) {
            $.cookie('regularMenuState', 'open');
          }
        },
      });
      
      // Mobile viewport
      
      enquire.register("screen and (max-width: 1199px)", {
        
        match: function() {
      
          // Populate a submenu toggler
      
          var srOnlyText = 'Mostra o amaga les categories del submenu';
          var $blockToggler = $('<button class="block-menu-toggler open"><span class="sr-only">' + srOnlyText + '</span></button>');
          var $paneToggler = $('<button class="pane-menu-toggler open"><span class="sr-only">' + srOnlyText + '</span></button>');
          var $block = $('.block-menu.menu');
          var $blockTitle = $('.block-menu.menu .block__title');
          var $pane = $('.pane-block.menu');
          var $paneTitle = $('.pane-block.menu .pane-title');
      
          // If a block is used, ap pend it to the block and bind a click event
      
          if ($block.length > 0) {
            var $blockContent = $block.find('.block__content');
            $blockToggler.appendTo($blockTitle);
            // $blockContent.hide();

            // Store the 'open' state in da cookie
          
            if (!$.cookie('regularMenuState')) {
              $.cookie('regularMenuState', 'open');
            }

            $blockToggler.click(function() {
              $(this).toggleClass('open closed').addClass('block-menu-toggler');
              $(this).parent().siblings('.block__content').slideToggle(150);

              if ($(this).hasClass('open')) {
                $.cookie('regularMenuState', 'open');
              }
              else {
                $.cookie('regularMenuState', 'closed'); 
              }
            });
          }
      
          // If a pane is used, append it to the pane and bind a click event
      
          if ($pane.length > 0) {
            var $paneContent = $pane.find('.pane-content');
            $paneToggler.appendTo($paneTitle);
            // $paneContent.hide();
            
            // Store the 'open' state in da cookie
          
            if (!$.cookie('regularMenuState')) {
              $.cookie('regularMenuState', 'open');
            }

            $('.pane-menu-toggler').click(function() { // Do not use "$paneToggler" here, otherwise it will not work in the homepage
              $(this).toggleClass('open closed').addClass('pane-menu-toggler');
              $(this).parent().siblings('.pane-content').slideToggle(150);

              if ($(this).hasClass('open')) {
                $.cookie('regularMenuState', 'open');
              }
              else {
                $.cookie('regularMenuState', 'closed'); 
              }
            });
          }
        },
      });
    },
  };

  Drupal.behaviors.xn17 = {
    attach: function(context, setting) {
      Drupal.xn17.stickyMenu();
      Drupal.xn17.stickyMenuToggler();
      // Drupal.xn17.regularMenuToggler();
      // Drupal.xn17.stickyMenuTogglerCookie();
    }
  };

  Drupal.behaviors.radix_dropdown = {
    attach: function(context, setting) {

// ===========================================================================================================      

      // -----------------------------------------------------------------------
      // Main menu
      // -----------------------------------------------------------------------
      $(document).ready(function() {

        // On Menu button Click Event
        // ---------------------------------------------------------------------
        
        $('.menu-icon').click(function(){

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

        // On Close button Click Event
        // ---------------------------------------------------------------------
        
        $('#close-button').click(function(){

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

        // Mobile Sub-menus
        
        // Level 2 submenus
        $('.menu-link.depth-2').click(function(){
          var md  = 992 - 15;
          var wwi = $(window).width();
          if (wwi < md) {
            $(this).next('.submenu.depth-3').slideToggle('slow');
            $(this).children().toggleClass('opened');
            $(this).children().toggleClass('closed');
          }
        });
        // Level 1 submenus
        $('.menu-link.depth-1').click(function(){
          var md  = 992 - 15;
          var wwi = $(window).width();
          if (wwi < md) {
            $(this).next('.submenu.depth-2').slideToggle('slow');
            $(this).children().toggleClass('opened');
            $(this).children().toggleClass('closed');
          }
        });
        // -----------------------------------------------------------------------
        // Main menu
        // -----------------------------------------------------------------------
        // if ($(window).width() < 768) {
        //   $('.block-menu').children('h4').click( function(){
        //     $(this).next('.block__content').slideToggle('slow');
        //     $(this).parent('.block-menu').toggleClass('opened');
        //     $(this).parent('.block-menu').toggleClass('closed');
        //   });
        // }

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

        // -----------------------------------------------------------------------
        // Filtre Bilbioteca
        // -----------------------------------------------------------------------
        $("#views-exposed-form-xn17-biblioteca-page #cerca-avancada").click( function(){
          $(this).toggleClass("showicon");
          $(this).toggleClass("hideicon");
          $(this).closest(".content").toggleClass("advanced");
          $("#edit-field-doc-tipologia-tid-wrapper").toggle();
          $("#edit-field-doc-tematica-tid-wrapper").toggle();
          $("#edit-field-doc-data-publi-value-wrapper").toggle();
          $("#edit-field-doc-editorial-tid-wrapper").toggle();
          $(".views-submit-button").toggle();
        });
        // -----------------------------------------------------------------------
        // recull documents biblioteca portada
        // -----------------------------------------------------------------------
        $(".view-xn17-recull-documents .document-biblioteca").mouseover( function(){
          $(".sinopsi",this).fadeIn("1500", function(){});
        });
        $(".view-xn17-recull-documents .document-biblioteca").mouseleave( function(){
          $(".sinopsi",this).fadeOut("250", function(){});
        });
        // -----------------------------------------------------------------------
        // noticies portada
        // -----------------------------------------------------------------------
        if(mesNoticiesObert == false){
          $(".front .view-id-bloc-mes-xn17-noticies .view-content").css("display","none");
          $(".front .view-id-bloc-mes-xn17-noticies .pager__item a").click(function(){
            mesNoticiesObert = true;
            $(".front .view-id-bloc-mes-xn17-noticies .view-content").slideToggle("slow");
            $(".front .view-id-bloc-mes-xn17-noticies .view-content").css("display","inherit");
          });
        };
        // -----------------------------------------------------------------------
        // recursos portada
        // -----------------------------------------------------------------------
        if(mesRecursosObert == false){
          $(".front .view-id-bloc-mes-xn17-recursos .view-content").css("display","none");
          $(".front .view-id-bloc-mes-xn17-recursos .pager__item a").click(function(){
            mesRecursosObert = true;
            $(".front .view-id-bloc-mes-xn17-recursos .view-content").slideToggle("slow");
            $(".front .view-id-bloc-mes-xn17-recursos .view-content").css("display","inherit");
          });
        };
        // -----------------------------------------------------------------------
        // select d'especials
        // -----------------------------------------------------------------------
        $("#form_monografics").change(function(){
	  window.location.href = '/node/'+$("#form_monografics").val();
        });
        // -----------------------------------------------------------------------
        // comentaris
        // -----------------------------------------------------------------------
	     $("#comments-header").click( function(){
          $("#comments-body").slideToggle("slow");
          $("#comments").toggleClass('closed');
        });
        // -----------------------------------------------------------------------
        // FAQ
        // -----------------------------------------------------------------------
        var url = document.location.toString();
        if ( url.match('/faq/#-') ) {
	    $('#qui-gestiona').removeClass('in');
            $('#'+url.split('#-')[1]).addClass('in');
        }
	// Making Youtube videos responsive
	$('iframe[src^="https://www.youtube"]').attr('width', '100%');
	// Override of Search Form placeholder
	$('#search-form #edit-keys').attr('placeholder', 'Cerca');
      });
    }
  };
})(jQuery, Drupal, this, this.document);





/**
 * Initializes a toggler for the sub-homes menu
 */

(function($) {
	$(function() {

// ===========================================================================================================    
		// if ($('.menu.menu-noticies').length > 0) {
		// 	if (!!$.cookie('menu-noticies')) {
		// 		if ($.cookie('menu-noticies') == 'expanded') {
		// 			$('.pane-block.pane-menu-menu-xn17-menu-noticies .pane-content').slideDown();
		// 			$('.pane-block.pane-menu-menu-xn17-menu-noticies').addClass('expanded');
		// 		}
		// 		else if ($.cookie('menu-noticies') == 'collapsed') {
		// 			$('.pane-block.pane-menu-menu-xn17-menu-noticies .pane-content').slideUp();
		// 			$('.pane-block.pane-menu-menu-xn17-menu-noticies').addClass('collapsed');
		// 		}
		// 	}
		// 	else {
		// 		$.cookie('menu-noticies', 'expanded');
		// 		$('.pane-block.pane-menu-menu-xn17-menu-noticies').addClass('expanded');
		// 	}
// ===========================================================================================================

			// $('.pane-block.pane-menu-menu-xn17-menu-noticies h4').click(function(e) {
			// 	e.preventDefault();
			// 	$(this).siblings('.pane-content').slideToggle('fast');
			// 	$(this).parent().toggleClass('expanded');
			// 	$(this).parent().toggleClass('collapsed');
			// 	if ($(this).parent().hasClass('expanded')) {
			// 		$.cookie('menu-noticies', 'expanded');
			// 	}
			// 	else if ($(this).parent().hasClass('collapsed')) {
			// 		$.cookie('menu-noticies', 'collapsed');
			// 	}
			// });
		// }
	});
})(jQuery);
