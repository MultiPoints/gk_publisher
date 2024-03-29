<?php

// This is the code which will be placed in the head section

// No direct access.
defined('_JEXEC') or die;

$this->addTemplateFavicon();
// check the color version
$template_style = $this->getTemplateStyle('style');
// load the CSS files
$this->API->addCSS($this->API->URLtemplate() . '/css/k2.css');
$this->API->addCSS($this->API->URLtemplate() . '/css/normalize.css');
$this->API->addCSS($this->API->URLtemplate() . '/css/layout.css');
$this->API->addCSS($this->API->URLtemplate() . '/css/joomla.css');
$this->API->addCSS($this->API->URLtemplate() . '/css/system/system.css');
$this->API->addCSS($this->API->URLtemplate() . '/css/template.css');
$this->API->addCSS($this->API->URLtemplate() . '/css/menu/menu.css');
$this->API->addCSS($this->API->URLtemplate() . '/css/gk.stuff.css');
$this->API->addCSS($this->API->URLtemplate() . '/css/style'.$template_style.'.css', 'text/css', null, array('id' => 'gkCSSstyle' . $template_style));

//added by jerry@artd.ch
$this->API->addCSS($this->API->URLtemplate() . '/css/custom.css');
$this->API->addCSS($this->API->URLtemplate() . '/css/community.css');
$this->API->addCSS('http://fonts.googleapis.com/css?family=Exo');
// end <=

if($this->API->get('typography', '1') == '1') {
	$this->API->addCSS($this->API->URLtemplate() . '/css/typography/typography.style'.$template_style.'.css', 'text/css', null, array('id' => 'gkCSSTypographyStyle' . $template_style));
	
	if($this->API->get('typo_iconset', '1') == '1') {
		$this->API->addCSS($this->API->URLtemplate() . '/css/typography/typography.iconset.style'.$template_style.'.css', 'text/css', null, array('id' => 'gkCSSTypographyIconsetStyle' . $template_style));
	}
}

if($this->API->get("css_override", '0')) {
	$this->API->addCSS($this->API->URLtemplate() . '/css/override.css');
}

$this->API->addCSSRule($this->API->get('css_custom', ''));

// include fonts
$font_iter = 1;

while($this->API->get('font_name_group'.$font_iter, 'gkFontNull') !== 'gkFontNull') {
 $font_data = explode(';', $this->API->get('font_name_group'.$font_iter, ''));
 if(isset($font_data) && count($font_data) >= 2) {
      $font_type = $font_data[0];
      $font_name = $font_data[1];
      if($this->API->get('font_rules_group'.$font_iter, '') != ''){
           if($font_type == 'standard') {
                $this->API->addCSSRule($this->API->get('font_rules_group'.$font_iter, '') . ' { font-family: ' . $font_name . '; }'."\n");
           } elseif($font_type == 'google') {
                $font_link = preg_replace('/https?:/m', '', $font_data[2]);
                $font_family = $font_data[3];
                $this->API->addCSS($font_link);
                $this->API->addCSSRule($this->API->get('font_rules_group'.$font_iter, '') . ' { font-family: \''.$font_family.'\', Arial, sans-serif; }'."\n");
           } elseif($font_type == 'squirrel') {
                $this->API->addCSS($this->API->URLtemplate() . '/fonts/' . $font_name . '/stylesheet.css');
                $this->API->addCSSRule($this->API->get('font_rules_group'.$font_iter, '') . ' { font-family: ' . $font_name . ', Arial, sans-serif; }'."\n");
           } elseif($font_type == 'adobe') {                
	           $this->API->addJS('//use.edgefonts.net/'.$font_name.'.js');
	           $font_name = explode(":", $font_name);
	           $font_name = $font_name[0];
	           $this->API->addCSSRule($this->API->get('font_rules_group'.$font_iter, '') . ' { font-family: ' . $font_name . ', Arial, sans-serif; }'."\n");
          }
           
      }
 }
 $font_iter++;
}

// add responsive stylesheets
$this->generateLayout();

// include JavaScript
$this->API->addJSFragment("\n".' $GKMenu = { height:'.($this->API->get('menu_height','0') == 1 ? 'true' : 'false') .', width:'.($this->API->get('menu_width','0') == 1 ? 'true' : 'false') .', duration: '.($this->API->get('menu_duration', '500')).' };');

$this->API->addJS($this->API->URLtemplate() . '/js/gk.scripts.js');
$this->API->addJS($this->API->URLtemplate() . '/js/gk.menu.js');
$this->API->addJSFragment( "\n".'$GK_TMPL_URL = "' . $this->API->URLtemplate() . '";'."\n" );
$this->API->addJSFragment( "\n".'$GK_URL = "' . $this->API->URLbase() . '";'."\n" );

if($this->API->get("css_prefixer", '0')) {
	$this->API->addJS($this->API->URLtemplate() . '/js/prefixfree.js');
}

$this->API->addJS($this->API->URLtemplate() . '/js/jquery.popupoverlay.js');
$this->API->addJS($this->API->URLtemplate() . '/js/preview.js');
$this->API->addJS($this->API->URLtemplate() . '/js/jquery.infinitescroll.js');


if($this->API->get('css_compression', '0') == 1 || $this->API->get('css_cache', '0') == 1) {
	$this->cache->registerCache();
}

if($this->API->get('js_compression', '0') == 1 ) {
	$this->cache->registerJSCompression();
}

?>

<!--[if IE 9]>
<link rel="stylesheet" href="<?php echo $this->API->URLtemplate(); ?>/css/ie/ie9.css" type="text/css" />
<![endif]-->

<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo $this->API->URLtemplate(); ?>/css/ie/ie8.css" type="text/css" />
<![endif]-->

<!--[if lte IE 7]>
<link rel="stylesheet" href="<?php echo $this->API->URLtemplate(); ?>/css/ie/ie7.css" type="text/css" />
<![endif]-->

<!--[if (gte IE 6)&(lte IE 8)]>
<script type="text/javascript" src="<?php echo $this->API->URLtemplate() . '/js/selectivizr.js'; ?>"></script>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->