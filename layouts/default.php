<?php 
// No direct access.
defined('_JEXEC') or die;
//
$app = JFactory::getApplication();
$user = JFactory::getUser();
// getting User ID
$userID = $user->get('id');
// getting params
$option = JRequest::getCmd('option', '');
$view = JRequest::getCmd('view', '');
// defines if com_users
define('GK_COM_USERS', $option == 'com_users' && ($view == 'login' || $view == 'registration'));
// other variables
$btn_login_text = ($userID == 0) ? JText::_('TPL_GK_LANG_LOGIN') : JText::_('TPL_GK_LANG_LOGOUT');
$tpl_page_suffix = $this->page_suffix != '' ? ' class="'.$this->page_suffix.'"' : '';

$menu = & JSite::getMenu();
if ($menu->getActive() == $menu->getDefault('de-DE') || $menu->getActive() == $menu->getDefault('fr-FR') || $menu->getActive() == $menu->getDefault('it-IT')) $ishome = 1;
else $ishome = null;

$option = JRequest::getVar('option');
$view = JRequest::getVar('view');
$task = JRequest::getVar('task');

JHTML::_('behavior.modal');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->APITPL->language; ?>" <?php echo $tpl_page_suffix; ?>>
<head>
	<?php $this->layout->addTouchIcon(); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <?php if($this->API->get('rwd', 1)) : ?>
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <?php else : ?>
    	<meta name="viewport" content="width=<?php echo $this->API->get('template_width', 1020)+80 ?>">
    <?php endif; ?>
    <jdoc:include type="head" />
    <?php $this->layout->loadBlock('head'); ?>
	<?php $this->layout->loadBlock('cookielaw'); ?>
    <script type="text/javascript">
		jQuery(document).ready(function(e) {
			jQuery('ul.maximenuck .floatck').append('<span class="close"></span>');
/*            jQuery('ul.maximenuck > li').hover(
				function(e) {
					jQuery(this).find('img').css('display', 'block');
				},
				
				function(e) {
					jQuery(this).find('img').css('display', 'none');
				}
			)
	*/		
			jQuery('ul.maximenuck > li > span.separator').click(function(e) {
				jQuery(this).parent().find('img').css('display', 'block');
				jQuery(this).parent().siblings().find('img').css('display', 'none');
				jQuery(this).parent().addClass('hover');
			});
			
			jQuery('ul.maximenuck .close').click(function(e) {
                jQuery(this).parent('.floatck').css('display', 'none');
				jQuery('.level1 .separator img').css('display', 'none');
				jQuery(this).closest('li.level1').removeClass('hover');
            });
			
			jQuery('.maximenuck.level2 ul li ul.nav-child >li').hover(
				function () {
					jQuery('ul', this).stop().slideDown(200);
				},
				function () {
					jQuery('ul', this).stop().slideUp(200);
				}
			);

<?php //if ($ishome) :?>
//Smooth Scrolling
		/*   function filterPath(string) {
			  return string
				.replace(/^\//,'')
				.replace(/(index|default).[a-zA-Z]{3,4}$/,'')
				.replace(/\/$/,'');
			  }
			  var locationPath = filterPath(location.pathname);
			  var scrollElem = scrollableElement('html', 'body');
			 
			  jQuery('a[href*=#]').each(function() {
				var thisPath = filterPath(this.pathname) || locationPath;
				if (  locationPath == thisPath
				&& (location.hostname == this.hostname || !this.hostname)
				&& this.hash.replace(/#/,'') ) {
				  var $target = jQuery(this.hash), target = this.hash;
				  if (target) {
					var targetOffset = $target.offset().top;
					jQuery(this).click(function(event) {
					  event.preventDefault();
					  jQuery(scrollElem).animate({scrollTop: targetOffset}, 400, function() {
						location.hash = target;
					  });
					});
				  }
				}
			  });
			 
			  // use the first element that is "scrollable"
			  function scrollableElement(els) {
				for (var i = 0, argLength = arguments.length; i <argLength; i++) {
				  var el = arguments[i],
					  $scrollElement = jQuery(el);
				  if ($scrollElement.scrollTop()> 0) {
					return el;
				  } else {
					$scrollElement.scrollTop(1);
					var isScrollable = $scrollElement.scrollTop()> 0;
					$scrollElement.scrollTop(0);
					if (isScrollable) {
					  return el;
					}
				  }
				}
				return [];
			  }*/
<?php //endif;?>
        });
		
	</script>
	<meta name="google-site-verification" content="2mAxfScj-ngcG2fxchilbqd4NW4HzhsukTdLlGU_gnI" />
</head>
<body<?php echo $tpl_page_suffix; ?><?php if($this->browser->get("tablet") == true) echo ' data-tablet="true"'; ?><?php if($this->browser->get("mobile") == true) echo ' data-mobile="true"'; ?><?php $this->layout->generateLayoutWidths(); ?> class="<?php echo $ishome ? 'homepage': ''; echo (($option == 'com_community' && $view == 'events') && ($task == 'search' || $task == '' || $task == 'display' || $task == 'myevents')) ? ' events': '';?>">
	<?php if ($this->browser->get('browser') == 'ie7' || $this->browser->get('browser') == 'ie6') : ?>
	<!--[if lte IE 7]>
	<div id="ieToolbar"><div><?php echo JText::_('TPL_GK_LANG_IE_TOOLBAR'); ?></div></div>
	<![endif]-->
	<?php endif; ?>	
    
    <section id="gkPageWrap" <?php if($header_nobg): ?> class="nobg"<?php endif; ?>>
    	<div id="gkPageTopBar">
    		<div class="gkPage">
			    <?php if(count($app->getMessageQueue())) : ?>
			    <jdoc:include type="message" />
			    <?php endif; ?>
			    
			    <?php if($this->API->modules('social')) : ?>
			    <div id="gkSocial">
			    	<jdoc:include type="modules" name="social" style="<?php echo $this->module_styles['social']; ?>" />
			    </div>
			    <?php endif; ?>
			    
			    <?php if(($this->API->get('register_link', 1) && $userID == 0) || $this->API->modules('login', 1)) : ?>
			    <div id="gkUserArea">			    	
			    	<?php if($this->API->modules('login')) : ?>
			    	<a href="<?php echo $this->API->get('login_url', 'index.php?option=com_users&view=login'); ?>" id="gkLogin"><?php echo ($userID == 0) ? JText::_('TPL_GK_LANG_LOGIN') : JText::_('TPL_GK_LANG_LOGOUT'); ?></a>
			    	<?php endif; ?>
			    	
			    	<?php if($this->API->get('register_link', 1) && $userID == 0) : ?>
			    	<a href="<?php echo $this->API->get('register_url', 'index.php?option=com_users&view=registration'); ?>" id="gkRegister"><?php echo JText::_('TPL_GK_LANG_REGISTER'); ?></a>
			    	<?php endif; ?>
			    </div>
			    <?php endif; ?>

			    <?php if($this->API->modules('topbanner')) : ?>
			    <div id="gkTopBanner">
			    	<jdoc:include type="modules" name="topbanner" style="<?php echo $this->module_styles['topbanner']; ?>" />
			    </div>
			    <?php endif; ?>
			    
		    </div>
		</div>
		   
		<div id="gkPageLogo">
		    <div class="gkPage">
            	<div id="before-logo"><jdoc:include type="modules" name="before-logo" /></div>
			    <div id="logo"><?php $this->layout->loadBlock('logo'); ?></div>
            	<div id="after-logo"><jdoc:include type="modules" name="after-logo" /></div>
			    
			    <?php if($this->API->get('show_menu', 1)) : ?>
			    <div id="gkMobileMenu">
			    	<?php echo JText::_('TPL_GK_LANG_MOBILE_MENU'); ?>
			    	<select onChange="window.location.href=this.value;">
			    	<?php 
			    	    $this->mobilemenu->loadMenu($this->API->get('menu_name','mainmenu')); 
			    	    $this->mobilemenu->genMenu($this->API->get('startlevel', 0), $this->API->get('endlevel',-1));
			    	?>
			    	</select>
			    </div>
			    <?php endif; ?>
			    
			    <?php if($this->API->get('show_menu', 1)) : ?>
			    <div id="gkMainMenu">
			    	<?php
			    		$this->mainmenu->loadMenu($this->API->get('menu_name','mainmenu')); 
			    	    $this->mainmenu->genMenu($this->API->get('startlevel', 0), $this->API->get('endlevel',-1));
			    	?>   
		    	</div>
		    	<?php endif; ?>
	    	</div>
    	</div>
    
	    <?php if($this->API->modules('slogan')) : ?>
        <div id="slogan" class="nonmobile">
        	<div class="gkPage"><jdoc:include type="modules" name="slogan" /></div>
        </div>
        <?php endif;?>
        
		<?php if(!$this->API->get('show_menu', 1)) : ?>
        <div id="mainmenu">
        	<div class="gkPage"><a name="mainmenu"></a><jdoc:include type="modules" name="mainmenu" /></div>
        </div>
        <?php endif;?>
        
	    <?php if($this->API->modules('banner')) : ?>
	    <section id="gkBanner">
	    	<div class="gkPage">
	    		<jdoc:include type="modules" name="banner" style="<?php echo $this->module_styles['banner']; ?>" />
	    	</div>
	    </section>
	    <?php endif; ?>

		<?php if($this->API->modules('top1')) : ?>
		<section id="gkTop1" class="gkPage gkCols3">
			<div>
				<jdoc:include type="modules" name="top1" style="<?php echo $this->module_styles['top1']; ?>"  modnum="<?php echo $this->API->modules('top1'); ?>" modcol="3" />
			</div>
		</section>
		<?php endif; ?>
		
		<?php if($this->API->modules('top2')) : ?>
		<section id="gkTop2" class="gkPage gkCols3">
			<div>
				<jdoc:include type="modules" name="top2" style="<?php echo $this->module_styles['top2']; ?>" modnum="<?php echo $this->API->modules('top2'); ?>" modcol="3" />
			</div>
		</section>
		<?php endif; ?>
		<div id="gkContentWrap" class="gkPage">
	    	<div id="gkContentWrap2"<?php if($this->API->get('sidebar_position', 'right') == 'left') : ?> class="gkLeftSidebar"<?php endif; ?>>
		    	<?php if($this->API->modules('banner_mainbody_top')) : ?>
		    	<section id="gkBannerMainbodyTop">
		    		<jdoc:include type="modules" name="banner_mainbody_top" style="<?php echo $this->module_styles['banner_mainbody_top']; ?>" />
		    	</section>
		    	<?php endif; ?>
		    	
		    	<section id="gkContent">
					<?php if($this->API->modules('mainbody_top')) : ?>
					<section id="gkMainbodyTop">
						<jdoc:include type="modules" name="mainbody_top" style="<?php echo $this->module_styles['mainbody_top']; ?>" />
					</section>
					<?php endif; ?>	
					
					<?php if($this->API->modules('breadcrumb') || $this->getToolsOverride()) : ?>
					<section id="gkBreadcrumb">
						<?php if($this->API->modules('breadcrumb')) : ?>
						<jdoc:include type="modules" name="breadcrumb" style="<?php echo $this->module_styles['breadcrumb']; ?>" />
						<?php endif; ?>
						
						<?php if($this->getToolsOverride()) : ?>
							<?php $this->layout->loadBlock('tools/tools'); ?>
						<?php endif; ?>
					</section>
					<?php endif; ?>
					
					<section id="gkMainbody">
						<?php if(($this->layout->isFrontpage() && !$this->API->modules('mainbody')) || !$this->layout->isFrontpage()) : ?>
							<jdoc:include type="component" />
						<?php else : ?>
							<jdoc:include type="modules" name="mainbody" style="<?php echo $this->module_styles['mainbody']; ?>" />
						<?php endif; ?>
					</section>
					
					<?php if($this->API->modules('mainbody_bottom')) : ?>
					<section id="gkMainbodyBottom">
						<jdoc:include type="modules" name="mainbody_bottom" style="<?php echo $this->module_styles['mainbody_bottom']; ?>" />
					</section>
					<?php endif; ?>
		    	</section>
		    	
		    	<?php if($this->API->modules('banner_mainbody_bottom')) : ?>
		    	<section id="gkBannerMainbodyBottom">
		    		<jdoc:include type="modules" name="banner_mainbody_bottom" style="<?php echo $this->module_styles['banner_mainbody_bottom']; ?>" />
		    	</section>
		    	<?php endif; ?>
	    	</div>
	    	
	    	<?php if($this->API->modules('sidebar')) : ?>
	    	<aside id="gkSidebar"<?php if($this->API->modules('sidebar') == 1) : ?> class="gkOnlyOne"<?php endif; ?>>
	    		<jdoc:include type="modules" name="sidebar" style="<?php echo $this->module_styles['sidebar']; ?>" />
	    	</aside>
	    	<?php endif; ?>
	    </div>
	    
		<?php if($this->API->modules('bottom0')) : ?>
		<section id="gkBottom0" class="gkPage">
			<div>
				<jdoc:include type="modules" name="bottom0" />
			</div>
		</section>
		<?php endif; ?>
		
		<?php if($this->API->modules('bottom1')) : ?>
		<section id="gkBottom1" class="gkPage gkCols6">
			<div>
				<jdoc:include type="modules" name="bottom1" style="<?php echo $this->module_styles['bottom1']; ?>" modnum="<?php echo $this->API->modules('bottom1'); ?>" />
			</div>
		</section>
		<?php endif; ?>
		
		<div class="ieclear"></div>
	</section>
    
    <?php if($this->API->modules('bottom2')) : ?>
    <section id="gkBottom2" class="gkCols6">
    	<div class="gkPage">
    		<div>
    			<jdoc:include type="modules" name="bottom2" style="<?php echo $this->module_styles['bottom2']; ?>" modnum="<?php echo $this->API->modules('bottom2'); ?>" />
    		</div>
    	</div>
    </section>
    <?php endif; ?>
    
    <?php if($this->API->modules('lang')) : ?>
    <section id="gkLang">
    	<div class="gkPage">
         	<jdoc:include type="modules" name="lang" style="<?php echo $this->module_styles['lang']; ?>" />
         </div>
    </section>
    <?php endif; ?>
    
    <?php $this->layout->loadBlock('footer'); ?>
    	
   	<?php $this->layout->loadBlock('social'); ?>
	
	<?php $this->layout->loadBlock('tools/login'); ?>
	<div id="gkPopupOverlay"></div>
		
	<jdoc:include type="modules" name="debug" />
	<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);

  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://activ50plus.ch/stats/";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "1"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Piwik Code -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46965128-1', 'activ50plus.ch');
  ga('send', 'pageview');

</script>
</body>
</html>