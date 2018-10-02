/**
* @file
* Custom scripts for theme.
*/
$ = jQuery;
/**
* La variable obert, Ã©s uina variable global epr tal que a la portada s'oculti
* els llistat de recursoso en una primera instancia
*/
var mesRecursosObert = false;
var mesNoticiesObert = false;
/*
*/


(function ($, Drupal, window, document, undefined) {
  /* TODO - Behaviors!!! */
  Drupal.behaviors.radix_dropdown = {
    attach: function(context, setting) {

      // -----------------------------------------------------------------------
      // Scrolling
      // -----------------------------------------------------------------------
      if($('.pane-menu-menu-xn17-menu-noticies')[0]){ var frnTop = $('.pane-menu-menu-xn17-menu-noticies').offset().top; }
      if($('.pane-menu-menu-xn17-menu-noticies')[0]){ var frnBot = frnTop + $('.pane-menu-menu-xn17-menu-noticies').outerHeight(true); }
      if($('.panels-flexible-row-76-1')[0]){ var panHei = $('.panels-flexible-row-76-1').outerHeight(true)+600; }

      $(window).scroll(function(){
        var aTop = $('#third-header').offset().top;
        if($('.pane-menu-menu-xn17-menu-noticies')[0]){ var nTop = $('.pane-menu-menu-xn17-menu-noticies').offset().top - $(window).scrollTop(); }
        if($('.pane-menu-menu-xn17-menu-recursos')[0]){	var rTop = $('.pane-menu-menu-xn17-menu-recursos').offset().top - $(window).scrollTop(); }
      	
        // console.log($(window).scrollTop()+' '+panHei);

        if ($(this).scrollTop() >= aTop) {
          $('#third-header-clone').show();
          $('.block-menu').addClass('sticky');
          if($('.pane-menu-menu-xn17-menu-noticies')[0]) {
            if (nTop < $('#third-header-clone').height()) {
              $('.pane-menu-menu-xn17-menu-noticies').addClass('sticky');
            }
            if ($('.pane-menu-menu-xn17-menu-noticies').hasClass('sticky') && ($(window).scrollTop() < frnTop)) {
              $('.pane-menu-menu-xn17-menu-noticies').removeClass('sticky');
            }
            if (rTop < $('#third-header-clone').height()) {
              $('.pane-menu-menu-xn17-menu-recursos').addClass('sticky');
            }
            if ($('.pane-menu-menu-xn17-menu-recursos').hasClass('sticky') && (($(window).scrollTop()) < panHei)) {
              $('.pane-menu-menu-xn17-menu-recursos').removeClass('sticky');
            }
          }
        }
        if ($(this).scrollTop() < aTop) {
          $('#third-header-clone').hide();
          $('.block-menu').removeClass('sticky');
        }
      });

      // -----------------------------------------------------------------------
      // Main menu
      // -----------------------------------------------------------------------
      $(document).ready(function() {

        // On Menu button Click Event
        // ---------------------------------------------------------------------
        
        $(".menu-icon").click(function(){

          // Prevent double click on the button
          
          $(this).click(function() {
            return false;
          });

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
          // only visible the menu just opened
          
          if (wwi >= sm) {
            $('.menu.menu-noticies.sticky, .menu.menu-recursos.sticky').slideToggle("fast");
            $("#main-wrapper").fadeToggle("slow");

            // Forces the noticies/recursos menus to be unsticky and visible, when closing the menu

            // if ($(this).hasClass('active')) {
            //   console.log(':-)');
            //   $('.menu.menu-noticies, .menu.menu-recursos').removeClass('sticky').slideToggle("fast");
            // }

          }

          // Toggles the menu visibility, with a slide effect

          $("#main-menu").slideToggle("slow", function() {
            $(this).toggleClass('active'); // Toggles a flag to determine the button status
          });
        });

        // On Close button Click Event
        // ---------------------------------------------------------------------
        
        $("#close-button, .menu-icon.active").click(function(){

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

          // Toggles the menu visibility, with a slide effect

          $("#main-menu").slideToggle("slow");
          
          // Forces the noticies/recursos menus to be unsticky and visible, when closing the menu
          
          if (wwi >= sm) {
            $("#main-wrapper").fadeToggle("slow");
            $('.menu.menu-noticies, .menu.menu-recursos').slideToggle("fast").removeClass('sticky');
          }
        });

        // Mobile Sub-menus
        
        // Level 2 submenus
        $(".menu-link.depth-2").click(function(){
          var md  = 992 - 15;
          var wwi = $(window).width();
          if (wwi < md) {
            $(this).next(".submenu.depth-3").slideToggle("slow");
            $(this).children().toggleClass("opened");
            $(this).children().toggleClass("closed");
          }
        });
        // Level 1 submenus
        $(".menu-link.depth-1").click(function(){
          var md  = 992 - 15;
          var wwi = $(window).width();
          if (wwi < md) {
            $(this).next(".submenu.depth-2").slideToggle("slow");
            $(this).children().toggleClass("opened");
            $(this).children().toggleClass("closed");
          }
        });
        // -----------------------------------------------------------------------
        // Main menu
        // -----------------------------------------------------------------------
        if ($(window).width() < 768) {
          $(".block-menu").children('h4').click( function(){
            $(this).next(".block__content").slideToggle("slow");
            $(this).parent(".block-menu").toggleClass("opened");
            $(this).parent(".block-menu").toggleClass("closed");
          });
        }

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
        var pattern1 = /^\/opinio/;
        var pattern2 = /^\/opinio\//;
        var pattern3 = /^\/autora\//;
        var path = window.location.pathname;
        if (pattern1.test(path) || pattern2.test(path) || pattern3.test(path)) {
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
		if ($('.menu.menu-noticies').length > 0) {
			if (!!$.cookie('menu-noticies')) {
				if ($.cookie('menu-noticies') == 'expanded') {
					$('.pane-block.pane-menu-menu-xn17-menu-noticies .pane-content').slideDown();
					$('.pane-block.pane-menu-menu-xn17-menu-noticies').addClass('expanded');
				}
				else if ($.cookie('menu-noticies') == 'collapsed') {
					$('.pane-block.pane-menu-menu-xn17-menu-noticies .pane-content').slideUp();
					$('.pane-block.pane-menu-menu-xn17-menu-noticies').addClass('collapsed');
				}
			}
			else {
				$.cookie('menu-noticies', 'expanded');
				$('.pane-block.pane-menu-menu-xn17-menu-noticies').addClass('expanded');
			}

			$('.pane-block.pane-menu-menu-xn17-menu-noticies h4').click(function(e) {
				e.preventDefault();
				$(this).siblings('.pane-content').slideToggle('fast');
				$(this).parent().toggleClass('expanded');
				$(this).parent().toggleClass('collapsed');
				if ($(this).parent().hasClass('expanded')) {
					$.cookie('menu-noticies', 'expanded');
				}
				else if ($(this).parent().hasClass('collapsed')) {
					$.cookie('menu-noticies', 'collapsed');
				}
			});
		}
	});
})(jQuery);
