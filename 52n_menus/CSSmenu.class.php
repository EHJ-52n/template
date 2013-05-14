<?php
defined( '_VALID_MOS' ) or defined('_JEXEC') or die;
if (!defined ('_JA_CSS_MENU_CLASS')) {
	define ('_JA_CSS_MENU_CLASS', 1);
	require_once (dirname(__FILE__).DS."Base.class.php");
	
	class JA_CSSmenu extends JA_Base{
		// empty methods because there is not content required for CSSMenus
		function beginMenu($startlevel=0, $endlevel = 10){}
		function endMenu($startlevel=0, $endlevel = 10){}
  
  		function beginMenuItems($pid=1, $level=1){
			if($level==1)
			{
				echo "<ul id=\"ja-cssmenu\" class=\"clearfix\">\n";
			}
			else
			{
				 echo "<ul>";
			}
		}
        
        function hasSubMenu($level) {
            return false;
        }
        
        function beginMenuItem($row=null, $level = 0, $pos = '') {
		// echo "<!-- beginMenuItem(row: $row, level: $level, pos: $pos) -->\n";
		$active = in_array($row->id, $this->open);
            $active = ($active) ? " active" : "";
            if ($level == 1 && @$this->children[$row->id])
            {
            	echo "<li class=\"havechild{$active}\">";
            }
            else if ($level > 1 && @$this->children[$row->id])
            {
            	echo "<li class=\"havesubchild{$active}\">";
            }
            else
            {
            	echo "<li ".(($active) ? "class=\"active\"" : "").">";
            }
        }
        function endMenuItem($mitem=null, $level = 0, $pos = ''){
            echo "</li> \n";
        }
		
		function genMenuItem($item, $level = 0, $pos = '', $ret = 0) {
			//if ($level) return parent::genMenuItem($item, $level, '', $ret);
			//else 
			return parent::genMenuItem($item, $level, $pos, $ret);
		}

		function genMenuHead () {
			?>
			<link href="<?php echo $this->getParam('menupath'); ?>/52n_cssmenu/52n.cssmenu.css" rel="stylesheet" type="text/css" />
			<script src="<?php echo $this->getParam('menupath'); ?>/52n_cssmenu/52n.cssmenu.js" language="javascript" type="text/javascript"></script>
			<?php
		}

	}
}
?>
