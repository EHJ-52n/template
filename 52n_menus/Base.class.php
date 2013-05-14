<?php
defined( '_VALID_MOS' ) or defined('_JEXEC') or die;

if (!defined ('_JA_BASE_MENU_CLASS')) {
	define ('_JA_BASE_MENU_CLASS', 1);

	class JA_Base{
		var $_params = null;
		var $children = null;
		var $open = null;
		var $items = null;
		var $Itemid = 0; 
		var $showSeparatedSub = false;

		function JA_Base( &$params ){
			global $Itemid;
			$this->_params = $params;
			$jinput = JFactory::getApplication()->input;
			$this->Itemid = $jinput->getInt('Itemid');
			$this->loadMenu();
		}

		function createParameterObject($param, $path='', $type='menu') {
			if(defined( '_JEXEC' )) { 
				return new JParameter($param, $path);
			} else { 
				return new mosParameters($param, $path, $type);
			}
		}

		function getPageTitle($params) {
			if(defined( '_JEXEC' )) {
				return $params->get ('page_title');
			} else {
				return $params->get ('header');
			}
		}

	    function loadMenu(){
			$app = JFactory::getApplication(); // new
    	    $menu = &$app->getMenu();
    	    if(strtolower(get_class($menu)) == 'jexception') {
    	    	$menu = @JMenu :: getInstance('site');
    	    	echo "<!--\n Exception thrown: Menu: $menu\n-->\n";
    	    }
    	    $user = &JFactory::getUser();
			// children stores at i the children for menuElement with id i
			$children = array ();

			// Get Menu Items
			$items = &JSite::getMenu();
			// get all items with the correct menutype
			$rows = $items->getItems('menutype', $this->getParam('menutype'));
			// first pass - collect children
    	    $cacheIndex = array();
 		    $this->items = array();
 		    $highestUserGroup = $this->getHighestGroupLevel($user);
 		    foreach ($rows as $index => $menuElement)
 		    {
   	    	 	// check if user is allowed to access the menu element?
    		    if ($menuElement->access <= $highestUserGroup)
    		    {
    			    $parent = $menuElement->parent_id;
    			    // get list of current children for the parent of this menuElement or create new "list"
    			    $list = @ $children[$parent] ? $children[$parent] : array ();

    			    // set menuElement->url depending on type
					switch ($menuElement->type)
					{
						case 'separator' :  
							// total break here?
							return '<span class="separator">'.$menuElement->title.'</span>';
							break;
						case 'url' :
							if ((strpos($menuElement->link, 'index.php?') !== false) && (strpos($menuElement->link, 'Itemid=') === false))
							{
								$menuElement->url = $menuElement->link.'&amp;Itemid='.$menuElement->id;
							} 
							else
							{
								$menuElement->url = $menuElement->link;
							}
							break;
						default :
							$router = JSite::getRouter();
							// adds field "url" to menuElement because 
							$menuElement->url = $router->getMode() == JROUTER_MODE_SEF ? 'index.php?Itemid='.$menuElement->id : $menuElement->link.'&Itemid='.$menuElement->id;
							break;

					}
					// Handle SSL links
					$iParams = $this->createParameterObject($menuElement->params);
					$iSecure = $iParams->def('secure', 0);
					if ($menuElement->home == 1) 
					{
						// reset the url of the homepage element
						$menuElement->url = JURI::base();
					} 
					elseif (strcasecmp(substr($menuElement->url, 0, 4), 'http') && (strpos($menuElement->link, 'index.php?') !== false))
					{
						// if the url of the menuElement starts with http AND the link doesn't start with index.php -> no internal link
						$menuElement->url = JRoute::_($menuElement->url, true, $iSecure);
					} 
					else
					{
						// all other internal links are cleaned regarding "&"
						$menuElement->url = str_replace('&', '&amp;', $menuElement->url);
					}
					// save the number of children or position in children array?
					$menuElement->_idx = count($list);			
					// add current element to the list of children for the parent of this element						
					array_push($list, $menuElement);
					// save children list
    			    $children[$parent] = $list;
    		    }
    		    $cacheIndex[$menuElement->id] = $index;
				$this->items[$menuElement->id] = $menuElement; // seems useless
    	    }

            $this->children = $children;
    	    // second pass - collect 'open' menus
    	    // starting with the currently selected item stored in $this->Itemid
    	    $open = array ($this->Itemid);
    	    $count = 20; // maximum levels - to prevent runaway loop
    	    $id = $this->Itemid;

    	    while (-- $count) // if $count == 0 than the loop is ended
    	    {
    		    if (isset($cacheIndex[$id]))
    		    {
    			    $index = $cacheIndex[$id];
    			    if (isset ($rows[$index]) && $rows[$index]->parent_id > 1)
    			    {
    				    $id = $rows[$index]->parent_id;
    				    $open[] = $id;
    			    }
    			    else
    			    {
    				    break;
    			    }
    		    }
    	    }
            $this->open = $open;
	    }
	    
	    function getHighestGroupLevel($user) {
	    	$highestGroupLevel = -1;
	    	foreach ($user->getAuthorisedGroups() as $groupLevel)
	    	{
	    		if ($groupLevel > $highestGroupLevel)
	    		{
	    			$highestGroupLevel = $groupLevel;
	    		}
	    	}
	    	return $highestGroupLevel;
	    }

		function genMenuItem($item, $level = 1, $pos = '', $returnResult = 0) {
			$data = null;
			$tmp = $item;

			if ($tmp->type == 'separator')
			{
				$data = '<a href="#" title=""><span class="separator">'.$tmp->title.'</span></a>';
				if (!$returnResult)
				{
					echo $data;
				} else {
					return $data;
				} 
			}

			// Print a link if it exists
			$active = $this->genClass($tmp, $level, $pos);

			$id='id="menu' . $tmp->id . '"';
			$iParams = $this->createParameterObject( $item->params );
			$itembg = '';
			if ($this->getParam('menu_images') && $iParams->get('menu_image') && $iParams->get('menu_image') != -1)
			{
				if ($this->getParam('menu_background')) { 
					$itembg = ' style="background-image:url(images/stories/'.$iParams->get('menu_image').');"';
					$txt = '<span class="menu-title">' . $tmp->title . '</span>';
				} else {
					$txt = '<img src="images/stories/'.$iParams->get('menu_image').'" alt="'.$tmp->title.'" title="'.$tmp->title.'" /><span class="menu-title">' . $tmp->title . '</span>';
				}
			} else {
				$txt = '<span class="menu-title">' . $tmp->title . '</span>';
			}
			//Add page title to item
			if ($level == 1 && $this->getParam('menu_title')) {
				if ($this->getPageTitle($iParams)) {
					$txt .= '<span class="menu-desc">'. $this->getPageTitle($iParams).'</span>';
				} else {
					$txt .= '<span class="menu-desc">'. $tmp->title.'</span>';
				}
			}

			$title = "title=\"$tmp->title\"";

			if ($tmp->url != null)
			{
				switch ($tmp->browserNav)
				{
					default:
					case 0:
						// _top
						$data = '<a href="'.$tmp->url.'" '.$active.' '.$id.' '.$title.$itembg.'>'.$txt.'</a>';
						break;
					case 1:
						// _blank
						$data = '<a href="'.$tmp->url.'" target="_blank" '.$active.' '.$id.' '.$title.$itembg.'>'.$txt.'</a>';
						break;
					case 2:
						// window.open
						$attribs = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,'.$this->getParam('window_open');

						// hrm...this is a bit dickey
						$link = str_replace('index.php', 'index2.php', $tmp->url);
						$data = '<a href="'.$link.'" onclick="window.open(this.href,\'targetWindow\',\''.$attribs.'\');return false;" '.$active.' '.$id.' '.$title.$itembg.'>'.$txt.'</a>';
						break;
				}
			} else {
				$data = '<a '.$active.' '.$id.' '.$title.$itembg.'>'.$txt.'</a>';
			}
				
			if ($returnResult) return $data; else echo $data;
		}

		function getParam($paramName){
			return $this->_params->get($paramName);
		}

		function setParam($paramName, $paramValue){
			return $this->_params->set($paramName, $paramValue);
		}

		function beginMenu($startlevel=1, $endlevel = 10){
			echo "<div>";
		}
		
		function endMenu($startlevel=1, $endlevel = 10){
			echo "</div>";
		}

		function beginMenuItems($parentId=1, $level=1){
			echo "<ul>";
		}

		function endMenuItems($parentId=1, $level=1){
			echo "</ul>";
		}

		function beginMenuItem($mitem=null, $level = 1, $pos = ''){
			echo "<li>";
		}
		
		function endMenuItem($mitem=null, $level = 1, $pos = ''){
			echo "</li>";
		}

		function genClass ($mitem, $level, $pos) {
			$active = in_array($mitem->id, $this->open);
			$cls = ($level?"":"menu-item{$mitem->_idx}"). ($active?" active":"").($pos?" $pos-item":"");
			return $cls?"class=\"$cls\"":"";
		}

		function hasSubMenu($level) {
			$parentId = $this->getParentId($level);
			if (!$parentId) return false;
			return $this->hasSubItems ($parentId);
		}
		
		function hasSubItems($id){
			if (@$this->children[$id]) return true;
			return false;
		}
		
		function genMenu($startlevel=1, $endlevel = 10){
			$this->setParam('startlevel', $startlevel);
			$this->setParam('endlevel', $endlevel);
			$this->beginMenu($startlevel, $endlevel);

			if ($this->getParam('startlevel') == 1) {
				//First level
				$this->genMenuItems (1, 1);
			}else{
				//Sub level
				$parentId = $this->getParentId($this->getParam('startlevel'));
				echo "<!-- pid: " . $parentId + " -->\n";
				if ($parentId){
					$this->genMenuItems ($parentId, $this->getParam('startlevel'));
				}
			}
			$this->endMenu($startlevel, $endlevel);
		}

		/*
		 $parentId: parent id
		 $level: menu level
		 $pos: position of parent
		 */
		function genMenuItems($parentId, $level) {
			// if the current parent has children
			if (@$this->children[$parentId]) {
				$this->beginMenuItems($parentId, $level);
				$i = 0;
				foreach ($this->children[$parentId] as $row) {
					$pos = ($i == 0 ) ? 'first' : (($i == count($this->children[$parentId])-1) ? 'last' :'');

					$this->beginMenuItem($row, $level, $pos);
					$this->genMenuItem( $row, $level, $pos);

					// show menu with menu expanded - submenus visible
					if ($level < $this->getParam('endlevel')){
						$this->genMenuItems( $row->id, $level+1 );
					}
					$i++;

					if ($level == 1 && $pos == 'last' && in_array($row->id, $this->open)) {
						global $jaMainmenuLastItemActive;
						$jaMainmenuLastItemActive = true;
					}
					$this->endMenuItem($row, $level, $pos);
				}
				$this->endMenuItems($parentId, $level);
			}
		}

		function indentText($level, $text) {
			echo "\n";
			for ($i=0;$i<$level;++$i) echo "   ";
			echo $text;
		}

		function getParentId($level) {
			// if level is not set or 
			if ($level == 1 || (count($this->open) < $level))
			{	
				return 1;
			} else {
				return $this->open[count($this->open)-$level];
			}
		}

		function getParentText ($level) {
			$parentId = $this->getParentId ($level);
			if ($parentId) {
				return $this->items[$parentId]->name;
			} else {
				return "";
			}
		}

		function genMenuHead () {}
	}
}
?>
