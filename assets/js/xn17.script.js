/**
* @file
* Custom scripts for theme.
*/

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
        if($('.pane-menu-menu-xn17-menu-noticies')[0]){	var rTop = $('.pane-menu-menu-xn17-menu-recursos').offset().top - $(window).scrollTop(); }
	console.log($(window).scrollTop()+' '+panHei);

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
        $(".menu-icon").click(function(){
	  window.scrollTo(0,0);
          $("#main-menu").slideToggle("slow", function(){
            $("#main-wrapper").fadeToggle();
          });
        });
        $("#close-button").click(function(){
          $("#main-menu").slideToggle("slow", function(){
            $("#main-wrapper").fadeToggle();
          });
        });
	if ($(window).width() < 768) {
          $(".menu-link.depth-2").click(function(){
            $(this).next(".submenu.depth-3").slideToggle("slow");
            $(this).children().toggleClass("opened");
            $(this).children().toggleClass("closed");
          });
	}
        if ($(window).width() < 768) {
          $(".menu-link.depth-1").click(function(){
            $(this).next(".submenu.depth-2").slideToggle("slow");
            $(this).children().toggleClass("opened");
            $(this).children().toggleClass("closed");
          });
        }
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
        if ( url.match('/faq/#') ) {
            $('#'+url.split('#')[1]).addClass('in');
        }
      });
    }
  };
})(jQuery, Drupal, this, this.document);
