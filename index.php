<?php  
defined( '_JEXEC' ) or die; 

/* The following line loads some additional helpers */
include_once (dirname(__FILE__).DS.'52n_vars_2.5.php');

JHTML::_('behavior.framework', true);
$app = JFactory::getApplication();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
	<!--
		The following JDOC Head tag loads all the header and meta information from your site config and content.
	-->
	<jdoc:include type="head" />
	<!-- END: Joomla Head -->
	<!--
		BEGIN: CSS
	-->
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>templates/system/css/system.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>templates/system/css/general.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/typo.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/52n_newsmoo.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/colors/<?php echo $tmpTools->getParam(JA_TOOL_COLOR); ?>.css" type="text/css" />
	<!--
		END: CSS
	-->
    <script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/52n.script.js"></script>
    <!-- 
		BEGIN: MENU_HEAD
	-->
    <?php $jamenu->genMenuHead(); ?>
	<!-- 
		END: MENU_HEAD
	-->
    <!--
		Browser Switch for IE6 and IE7
	-->
    <!--[if lte IE 6]>
    <style type="text/css">
		.clearfix {height: 1%;}
		img {border: none;}
    </style>
    <![endif]-->
    <!--[if gte IE 7.0]>
    <style type="text/css">
		.clearfix {display: inline-block;}
    </style>
    <![endif]-->
	<!-- if(IE6) CSS from template tools for IE6 -->
	<?php if ($tmpTools->isIE6()) { ?>
		<!--[if lte IE 6]>
		<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie6.php" rel="stylesheet" type="text/css" />
		<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/colors/<?php echo $tmpTools->getParam(JA_TOOL_COLOR); ?>-ie6.php" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			var siteurl = '<?php echo $this->baseurl?>';
			window.addEvent ('load', makeTransBG);
			function makeTransBG() {
				makeTransBg($$('img'));
			}
		</script>
		<![endif]-->
    <?php } ?>
	<!-- END: if(IE6) -->
	<!-- END: CSS -->
</head>
<!--
  
		HTML BODY
		
--> 
<body id="bd" class="<?php echo $tmpTools->getParam(JA_TOOL_SCREEN);?> fs<?php echo $tmpTools->getParam(JA_TOOL_FONT);?>" >
    <a name="Top" id="Top"></a>
    <ul class="accessibility">
        <li><a href="<?php echo $tmpTools->getCurrentURL();?>#ja-content" title="<?php echo JText::_("Skip to content");?>"><?php echo JText::_("Skip to content");?></a></li>
        <li><a href="<?php echo $tmpTools->getCurrentURL();?>#ja-mainnav" title="<?php echo JText::_("Skip to main navigation");?>"><?php echo JText::_("Skip to main navigation");?></a></li>
        <li><a href="<?php echo $tmpTools->getCurrentURL();?>#ja-col1" title="<?php echo JText::_("Skip to 1st column");?>"><?php echo JText::_("Skip to 1st column");?></a></li>
        <li><a href="<?php echo $tmpTools->getCurrentURL();?>#ja-col2" title="<?php echo JText::_("Skip to 2nd column");?>"><?php echo JText::_("Skip to 2nd column");?></a></li>
    </ul>
    <div style="height:90px; background: url('<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/bg.png') 50% 50% no-repeat;">
        <jdoc:include type="modules" name="vitrine" />
    </div>
    <div id="ja-wrapper">
        <!--
			BEGIN: MAIN NAVIGATION
		-->
        <div id="ja-mainnavwrap">
            <div id="ja-mainnav">
                <?php
                	// the first parameter defines the root element (since j2.5 it's 1, before 0)
                	// the second parameter defines the maximum level to generate menus (CSS menu supports up to 3)
                	$jamenu->genMenu(1,3);
                	if ($this->countModules('user4')) { 
				?>
					<div id="ja-search">
						<jdoc:include type="modules" name="user4" style="raw" />
					</div>
                <?php } ?>
            </div>
        </div>
        <!-- END: MAIN NAVIGATION -->
        <!--
			BEGIN: HEADER
		-->
        <div id="ja-headerwrap">
            <div id="ja-header" class="clearfix">
                <?php
                $siteName = $tmpTools->sitename();
                if ($tmpTools->getParam('logoType')=='image') { ?>
                <h1 class="logo-image">
                    <a href="index.php" title="<?php echo $siteName; ?>"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/52n-logo.gif" border="0" /></span></a>
                </h1>
                <?php } else {
                    $logoText = (trim($tmpTools->getParam('logoText'))=='') ? $config->sitename : $tmpTools->getParam('logoText');
                    $sloganText = (trim($tmpTools->getParam('sloganText'))=='') ? JText::_('SITE SLOGAN') : $tmpTools->getParam('sloganText');	?>
				<!-- next line changed from logo-text to logo-image during upgrade -->	
                <h1 class="logo-image">
                    <a href="index.php" title="<?php echo $siteName; ?>"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/52n-logo.gif" border="0" /></span></a>
                </h1>
                <?php } ?>
                <?php if ($this->countModules('top')) { ?>
                <div id="ja-login">
                    <jdoc:include type="modules" name="top" style="raw" />
                </div>
                <?php } ?>
            </div>
        </div>
        <!-- END: HEADER -->
		<div id="ja-containerwrap<?php echo $divid; ?>">
            <div id="ja-container" class="clearfix">
				<!--
					BEGIN: PATHWAY
				-->
				<div id="ja-pathwaywrap">
					<div id="ja-pathway">
						<div class="ja-innerpad">
							<jdoc:include type="module" name="breadcrumbs" />
						</div>
					</div>
				</div>
				<!-- END: PATHWAY -->
                <div id="ja-mainbody" class="clearfix">
                    <?php if ($this->countModules('user5') && $ja_right) { ?>
						<!--
							BEGIN:  TOPSPOTLIGHT
						-->
						<div id="ja-topsl">
							<jdoc:include type="modules" name="user5" style="raw" />
						</div>
						<!-- END: TOPSPOTLIGHT -->
                    <?php } ?>
                    <!--
						BEGIN: CONTENT
					-->
                    <div id="ja-content" class="clearfix">
                        <jdoc:include type="message" />
                        <div id="ja-current-content" class="clearfix">
							<jdoc:include type="modules" name="debug" />
                            <jdoc:include type="component" />
                            <?php if($this->countModules('banner')) : ?>
								<!--
									BEGIN: BANNER
								-->
								<br /><div id="ja-banner">
									<jdoc:include type="modules" name="banner" />
								</div>
								<!-- END: BANNER -->
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- END: CONTENT -->
                    <?php if ($ja_left) { ?>
						<!-- BEGIN: LEFT COLUMN -->
						<div id="ja-col1">
							<div class="ja-innerpad">
								<jdoc:include type="modules" name="left" style="rounded" />
							</div>
						</div><br />
						<!-- END: LEFT COLUMN -->
                    <?php } ?>
                </div>
                <?php if ($ja_right) { ?>
					<!-- BEGIN: RIGHT COLUMN -->
					<div id="ja-col2">
						<div id="ja-col2-top">
							<div id="ja-col2-bot" class="clearfix">

									<?php if ($hasSubnav) { ?>
								<div id="ja-subnav" class="moduletable-hilite">
									<h3>On this page</h3>
											<?php $jamenu->genMenu (1,1);	?>
								</div>
									<?php } ?>

								<jdoc:include type="modules" name="right" style="xhtml" />
							</div>
						</div>
					</div>
					<!-- END: RIGHT COLUMN -->
                <?php } ?>
            </div>
			<!-- END: ja-container -->
		</div>
		<!-- END: ja-containerwrap$divid -->
        <?php
        $spotlight = array ('user1','user2', 'user6','user7');
        $botsl = $tmpTools->calSpotlight ($spotlight,$tmpTools->isOP()?100:99.9);
        if( $botsl ) { ?>
			<!--
				BEGIN: BOTTOM SPOTLIGHT
			-->
			<div id="ja-botslwrap">
				<div style="margin: 0 auto; width: 920px;">
					<div id="ja-botsl" class="clearfix">
						<?php if( $this->countModules('user1') ) {?>
							<div class="ja-box<?php echo $botsl['user1']['class']; ?>" style="width: <?php echo $botsl['user1']['width']; ?>;">
								<jdoc:include type="modules" name="user1" style="xhtml" />
							</div>
								<?php } 
								if( $this->countModules('user2') ) {?>
							<div class="ja-box<?php echo $botsl['user2']['class']; ?>" style="width: <?php echo $botsl['user2']['width']; ?>;">
								<jdoc:include type="modules" name="user2" style="xhtml" />
							</div>
								<?php }
								if( $this->countModules('user6') ) {?>
							<div class="ja-box<?php echo $botsl['user6']['class']; ?>" style="width: <?php echo $botsl['user6']['width']; ?>;">
								<jdoc:include type="modules" name="user6" style="xhtml" />
							</div>
								<?php }
								if( $this->countModules('user7') ) {?>
							<div class="ja-box<?php echo $botsl['user7']['class']; ?>" style="width: <?php echo $botsl['user7']['width']; ?>;">
								<jdoc:include type="modules" name="user7" style="xhtml" />
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<!-- END: BOTTOM SPOTLIGHT -->
        <?php } ?>
        <!--
			BEGIN: FOOTER
		-->
        <div id="ja-footerwrap">
			<div style="margin: 0 auto; width: 920px;">
				<div id="ja-footer" class="clearfix">
					<jdoc:include type="modules" name="user3" />
					<jdoc:include type="modules" name="footer" />
				</div>
			</div>
        </div>
        <!-- END: FOOTER -->
    </div>
	<!--
		BEGIN: Piwik
	-->
	<script type="text/javascript">
		var pkBaseURL = (("https:" == document.location.protocol) ? "https://wiki.52north.org/piwik/" : "http://wiki.52north.org/piwik/");
		document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
		try {
		var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
		piwikTracker.trackPageView();
		piwikTracker.enableLinkTracking();
		} catch( err ) {}
	</script>
	<noscript>
		<p><img src="http://wiki.52north.org/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p>
	</noscript>
	<!-- END: Piwik -->
  </body>
</html>
