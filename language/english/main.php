<?php
/**
 * Chronolabs Cooperative ~ Xortify Honeypot
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Coopertive (Australia)  http://web.labs.coop
 * @copyright       Xortify Honeypot  https://xortify.com
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         xoops-theme
 * @subpackage		extreme-super-closest
 * @author         	Simon Antony Roberts (wishcraft/mynamesnot/cej) - open@extraterrestrialphysics.us
 */
 
	require_once $GLOBALS['xoops']->path("themes" . DIRECTORY_SEPARATOR . $GLOBALS['xoopsConfig']['theme_set'] . DIRECTORY_SEPARATOR . "include" . DIRECTORY_SEPARATOR . "functions.php");
	
	esctheme_init();
	
	define('ESCTHEME_ICON_FOLDER', esctheme_icon_folder());
	define('ESCTHEME_SLIDER_SUPPORTED', false);
	
	// Modal Popup
	define('ESCTHEME_MISSION_OBJECT', 'Mission Objectivity:');
	define('ESCTHEME_MISSION_CLAUSE', '<em>When <span id="popupmission-slogon-red">Networking and/or Fraud-based</span> dependices layers are detected by this cloud targetting or exploiting our clients/users website; we aim and focus on being to be these network nodes:~<br /><span id="popupmission-slogon-red">Internet entities and malformed networking or issuers topologies greatest bans and abuse notices!</span></em>');
?>