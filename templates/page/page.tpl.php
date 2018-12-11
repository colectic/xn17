<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 */
?>

<header id="third-header-clone" class="header hidde" role="header">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="sticky-logo hidden-xs">
	<a href="/"><img src="/sites/all/themes/xn17/assets/images/logo/logo-30-white.svg" alt="logo"/></a>
      </div>
      <div class="menu-icon">
        <img src="/sites/all/themes/xn17/assets/images/icon/icon-menu-gray.svg" alt="menu icon"/>
      </div>
      <div class="main-selector main-resources">
        <a href="/recursos">recursos</a>
      </div>
      <div class="main-selector main-news">
        <a href="/noticies">notícies</a>
      </div>
      <div class="social-icons hidden-xs hidden-sm">
        <a href="https://www.facebook.com/xarxanet" target="_blank"><img src="/sites/all/themes/xn17/assets/images/icon/icon-fb-circle.svg" alt="facebook icon"/></a>
        <a href="https://twitter.com/xarxanetorg" target="_blank"><img src="/sites/all/themes/xn17/assets/images/icon/icon-tw-circle.svg" alt="twitter icon"/></a>
        <a href="https://www.instagram.com/xarxanetorg" target="_blank"><img src="/sites/all/themes/xn17/assets/images/icon/icon-ig-circle.svg" alt="instagram icon"/></a>
        <a href="http://xarxanet.org/butlletins"><img src="/sites/all/themes/xn17/assets/images/icon/icon-newsletter-circle.svg" alt="newsletter icon"/></a>
      </div>
    </div>
  </div>
</header>
<header id="first-header" class="header" role="header">
  <div class="container">
    <?php if ($site_slogan): ?>
      <div class="header-region col-lg-6 col-md-6 col-sm-12 col-xs-12 first hidden-sm hidden-xs">
        <div id="site-slogan"><?php print $site_slogan; ?></div>
      </div>
    <?php endif; ?>
    <?php if ($secondary_menu): ?>
      <div class="header-region col-lg-6 col-md-6 col-sm-12 col-xs-12 second">
        <ul id="secondary-menu" class="menu nav navbar-nav">
          <?php print render($secondary_menu); ?>
          <li class="leaf active hidden-md hidden-lg"><img id="search-icon" src="/sites/all/themes/xn17/assets/images/icon/icon-search-white.svg" alt="search icon"/></li>
        </ul>
      </div>
    <?php endif; ?>
  </div>
</header>
<header id="second-header" class="header hidden-sm" role="header">
  <div class="container">
    <?php if ($logo): ?>
      <div class="header-region col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div id="site-logo">
          <a href="<?php print $front_page; ?>" class="navbar-brand" rel="home" title="<?php print t('Home'); ?>">
            <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" id="logo" />
          </a>
        </div>
      </div>
    <?php endif; ?>
    <?php if ($search_form): ?>
      <div class="header-region col-lg-6 col-md-6 col-sm-12 col-xs-12 hidden-xs">
        <div id="search-form">
          <?php print $search_form; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</header>
<header id="third-header" class="header" role="header">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="sticky-logo hidden-xs hidden-md hidden-lg">
        <img src="/sites/all/themes/xn17/assets/images/logo/logo-30-white.svg" alt="menu icon"/>
      </div>
      <div class="menu-icon">
        <img src="/sites/all/themes/xn17/assets/images/icon/icon-menu-gray.svg" alt="menu icon"/>
      </div>
      <div class="main-selector main-resources">
        <a href="/recursos">recursos</a>
      </div>
      <div class="main-selector main-news">
        <a href="/noticies">notícies</a>
      </div>
      <div class="social-icons hidden-xs hidden-sm">
        <a href="https://www.facebook.com/xarxanet" target="_blank"><img src="/sites/all/themes/xn17/assets/images/icon/icon-fb-circle.svg" alt="facebook icon"/></a>
        <a href="https://twitter.com/xarxanetorg" target="_blank"><img src="/sites/all/themes/xn17/assets/images/icon/icon-tw-circle.svg" alt="twitter icon"/></a>
        <a href="https://www.instagram.com/xarxanetorg" target="_blank"><img src="/sites/all/themes/xn17/assets/images/icon/icon-ig-circle.svg" alt="instagram icon"/></a>
        <a href="http://xarxanet.org/butlletins"><img src="/sites/all/themes/xn17/assets/images/icon/icon-newsletter-circle.svg" alt="newsletter icon"/></a>
      </div>
    </div>
  </div>
</header>

<header id="fixed-menu-noticies" class="fixed-menu open">
  <div class="container">
    <button id="fixed-menu-noticies-toggler" class="open"><span class="sr-only">Mostra o amaga les categories de notícies</span></button>
    <div class="row">
      <div class="inner"></div>
    </div>
  </div>
</header>

<header id="fixed-menu-recursos" class="fixed-menu open">
  <div class="container">
    <button id="fixed-menu-recursos-toggler" class="open"><span class="sr-only">Mostra o amaga les categories de recursos</span></button>
    <div class="row">
      <div class="inner"></div>
    </div>
  </div>
</header>

<div id="main-menu">
  <div class="container">
    <div class="top-menu-region col-xs-10 first">
      <div id="contact-form">
        <!--TODO-->
        <a href="/contacte" title="formulari de contacte">Formulari de contacte</a>
      </div>
    </div>
    <div class="top-menu-region col-xs-2 second">
      <div id="close-button">
        <img src="/sites/all/themes/xn17/assets/images/icon/icon-close-gray.svg" alt="close icon"/>
      </div>
    </div>
    <?php
      print $main_menu_rendered;
    ?>
  </div>
</div>

<div id="main-wrapper">
  <div id="main" class="main">
    <div class="container">
      <?php if ($messages): ?>
        <div id="messages">
          <?php print $messages; ?>
        </div>
      <?php endif; ?>
      <div id="page-header">
        <?php if ($title): ?>
          <div class="page-header">
            <h1 class="title"><?php print $title; ?></h1>
          </div>
        <?php endif; ?>
        <?php if ($tabs): ?>
          <div class="tabs">
            <?php print render($tabs); ?>
          </div>
        <?php endif; ?>
        <?php if ($action_links): ?>
          <ul class="action-links">
            <?php print render($action_links); ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
    <div id="content" class="container">
      <?php print render($page['content-header']); ?>
      <?php
        if(!empty($page['content-sidebar'])) {
          print '<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">'.render($page['content']).'</div>';
          print '<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">'.render($page['content-sidebar']).'</div>';
        } else {
          print render($page['content']);
        }
      ?>
    </div>
    <div id="content-footer" class="container">
      <?php print render($page['content-footer']); ?>
    </div>
    <div id="main-footer" class="container">
      <?php print render($page['main-footer']); ?>
    </div>
  </div> <!-- /#main -->
</div> <!-- /#main-wrapper -->

<footer id="footer" class="footer" role="footer">
  <div class="container">
    <div class="footer-region col-lg-6 col-md-12 col-sm-12 col-xs-12 first">
      <div id="footer-logo">
	<a href="/">
 	      <img src="/sites/all/themes/xn17/assets/images/logo/logo-30-white.svg" alt="logo"/>
	</a>
      </div>
    </div>
    <div class="footer-region col-lg-4 col-md-5 col-sm-12 col-xs-12 second">
      <div id="footer-links">
  <a href="/butlletins">BUTLLETINS</a>  /
	<a href="/contacte">CONTACTE</a>  /
	<a href="/avis-legal">AVÍS LEGAL</a>  /
	<a href="/politica_cookies">POLÍTICA DE COOKIES</a>
      </div>
    </div>
    <div class="footer-region col-lg-2 col-md-7 col-sm-12 col-xs-12 third">
      <div id="social-icons">
        <a href="https://www.facebook.com/xarxanet" target="_blank"><img src="/sites/all/themes/xn17/assets/images/icon/icon-fb-circle.svg" alt="facebook icon"/></a>
        <a href="https://twitter.com/xarxanetorg" target="_blank"><img src="/sites/all/themes/xn17/assets/images/icon/icon-tw-circle.svg" alt="twitter icon"/></a>
        <a href="https://www.instagram.com/xarxanetorg" target="_blank"><img src="/sites/all/themes/xn17/assets/images/icon/icon-ig-circle.svg" alt="instagram icon"/></a>
      </div>
    </div>
  </div>
</footer>
