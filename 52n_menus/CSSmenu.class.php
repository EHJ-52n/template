<?php
defined( '_VALID_MOS' ) or defined('_JEXEC') or die;
if (!defined ('_JA_CSS_MENU_CLASS')) {
	define ('_JA_CSS_MENU_CLASS', 1);
	require_once (dirname(__FILE__).DS."Base.class.php");
	
	class JA_CSSmenu extends JA_Base{
		function beginMenu($startlevel=0, $endlevel = 10){
			echo "<!-- CSSmenu::beginMenu -->\n";
		}
  
  		function beginMenuItems($pid=1, $level=0){
  			echo "<!-- beginMenuItems(); -->\n";
			if($level==1)
			{
				echo "<ul id=\"ja-cssmenu\" class=\"clearfix\">\n";
			}
			else
			{
				 echo "<ul>";
			}
		}
      
		// Warum ist das hier leer?
		function endMenu($startlevel=0, $endlevel = 10){
			echo "<!-- CSSMenu::endMenu -->\n";
		}
        
        function hasSubMenu($level) {
            return false;
        }
        
        function beginMenuItem($row=null, $level = 0, $pos = '') {
		echo "<!-- beginMenuItem(row: $row, level: $level, pos: $pos) -->";
		$active = in_array($row->id, $this->open);
            $active = ($active) ? " active" : "";
            if ($level == 0 && @$this->children[$row->id])
            {
            	echo "<li class=\"havechild{$active}\">";
            }
            else if ($level > 0 && @$this->children[$row->id])
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
