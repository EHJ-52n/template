<?php header("Content-type: text/css"); ?>
/*------------------------------------------------------------------------
# JA Helio 1.0 - May, 2008
# ------------------------------------------------------------------------
# Copyright (C) 2004-2008 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
-------------------------------------------------------------------------*/
<?php
$template_path = dirname( dirname( dirname( $_SERVER['REQUEST_URI'] ) ) );
?>

#ja-cssmenu li ul a:hover,
#ja-cssmenu li ul a:active,
#ja-cssmenu li ul a:focus,
#ja-cssmenu ul li:hover,
#ja-cssmenu ul li.sfhover,
#ja-cssmenu ul li.havesubchildsfhover,
#ja-cssmenu ul li.havesubchild-activesfhover,
#ja-cssmenu ul ul li:hover,
#ja-cssmenu ul ul li.sfhover,
#ja-cssmenu ul ul li.havesubchildsfhover,
#ja-cssmenu ul ul li.havesubchild-activesfhover {
	background: #13939e!important;
}
