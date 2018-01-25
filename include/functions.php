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




if (!function_exists("esctheme_init"))
{
	define('PLSURL', 'http://yp.shoutcast.com/sbin/tunein-station.pls?id=%s');
	function esctheme_init() 
	{
		mt_srand(mt_rand(-microtime(true), microtime(true)));
		mt_srand(mt_rand(-microtime(true), microtime(true)));
		mt_srand(mt_rand(-microtime(true), microtime(true)));
		mt_srand(mt_rand(-microtime(true), microtime(true)));
		mt_srand(mt_rand(-microtime(true), microtime(true)));
		mt_srand(mt_rand(-microtime(true), microtime(true)));
		
		if (empty(session_id()))
			session_start();
		if (!isset($_SESSION['radiostreamerbkgnd'])||empty($_SESSION['radiostreamerbkgnd']))
			$_SESSION['radiostreamerbkgnd'] = esctheme_getStationsFromAPI(APIKEY);
			
	}
}

if (!function_exists("esctheme_icon_folder"))
{
	function esctheme_icon_folder($src = 'honey')
	{
		xoops_load('XoopsLists');
		$folders = XoopsLists::getDirListAsArray($GLOBALS['xoops']->path("themes" . DIRECTORY_SEPARATOR . $GLOBALS['xoopsConfig']['theme_set'] . DIRECTORY_SEPARATOR . 'icons' . DS . $src));
		$keys = array_keys($folders);
		return $src . "/" . $folders[$keys[mt_rand(0, count($keys)-1)]];
	}
}

if (!function_exists("esctheme_getExternal"))
{
	function esctheme_getExternal($url, $vars = array()) {
		if (!isset($GLOBALS['debug']) || !is_array($GLOBALS['debug']))
			$GLOBALS['debug'] = array();
		$data = '';
		if (strlen($data)==0 && function_exists('curl_init')) {
			$cc = curl_init();
			curl_setopt($cc, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
			curl_setopt($cc, CURLOPT_POST, (count($vars)>0?true:false));
			if (count($vars)>0)
				curl_setopt($cc, CURLOPT_POSTFIELDS, http_build_query($vars) );
			curl_setopt($cc, CURLOPT_URL, $url);
			curl_setopt($cc, CURLOPT_HEADER, FALSE);
			curl_setopt($cc, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($cc, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($cc, CURLOPT_FORBID_REUSE, TRUE);
			curl_setopt($cc, CURLOPT_VERBOSE, false);
			curl_setopt($cc, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($cc, CURLOPT_SSL_VERIFYPEER, false);
			$data = curl_exec($cc);
			curl_close($cc);
			$GLOBALS['debug'][] = '<!-- cURL: ' . str_replace(APIKEY, '---api---key---', $url ) . '  -- bytes retrieved: ' .strlen($data) . " -->";
		}
		if (strlen($data)==0 && function_exists('file_get_contents'))
		{
			$data = file_get_contents($url);
			$GLOBALS['debug'][] = '<!-- wGET: ' . str_replace(APIKEY, '---api---key---', $url ) . '  -- bytes retrieved: ' .strlen($data) . " -->";
		}
		return (strlen($data)>0?$data:false);
	}
}

if (!function_exists("esctheme_getStationsFromAPI"))
{
	
	define('ESCTHEME_MIME_FORMATS', 'mp3|m4a|m4v|webma|webmv|oga|ogv|fla|flv|wav');
	define('ESCTHEME_MIME_FORMAT_MP3', 'audio/mpeg3|audio/x-mpeg-3|video/mpeg|video/x-mpeg|audio/mpeg');
	define('ESCTHEME_MIME_FORMAT_M4A', 'audio/mp4');
	define('ESCTHEME_MIME_FORMAT_M4V', 'video/mp4');
	define('ESCTHEME_MIME_FORMAT_WEBMA', 'audio/webm|audio/webma');
	define('ESCTHEME_MIME_FORMAT_WEBMV', 'audio/webmv');
	define('ESCTHEME_MIME_FORMAT_OGA', 'audio/ogg|audio/oga');
	define('ESCTHEME_MIME_FORMAT_OGV', 'video/ogg');
	define('ESCTHEME_MIME_FORMAT_FLA', 'application/x-shockwave-flash');
	define('ESCTHEME_MIME_FORMAT_FLV', 'video/x-flv');
	define('ESCTHEME_MIME_FORMAT_WAV', 'audo/x-wav|audio/wav');
	
	function esctheme_getStationsFromAPI()
	{
		mt_srand(-microtime(true), microtime(true));
		mt_srand(-microtime(true), microtime(true));
		mt_srand(-microtime(true), microtime(true));
		$ret = array();
		$until = microtime(true) + 13;
		while (empty($ret) && $until>microtime(true)) {
			mt_srand(-microtime(true), microtime(true));
			mt_srand(-microtime(true), microtime(true));
			mt_srand(-microtime(true), microtime(true));
			$state = mt_rand(1,2);
			switch ("$state") {
				default:
				case "1":
					$stations = array(0=>json_decode(esctheme_getExternal("http://www.shoutcast.com/Home/GetRandomStation", array('query' => '')), true));
					break;
				case "2":
					$stations = json_decode(esctheme_getExternal("http://www.shoutcast.com/Home/Top", array('query' => '')), true);
					break;
			}
			$ret = esctheme_parseStationArray($stations, esctheme_generateMimetypes(ESCTHEME_MIME_FORMATS, 'ESCTHEME_MIME_FORMAT_%s'));
		}
		return $ret;
	
	}
}


if (!function_exists("esctheme_parseStationArray"))
{
	function esctheme_parseStationArray($stations = array(), $mimetypes = array())
	{
		$ret = array();
		$until = microtime(true) + 5;
		while ((empty($ret) && count($stations) > 0) && $until>microtime(true)) {
			$keys = array_keys($stations);
			$ret = array();
			$station = $stations[$keys[mt_rand(0, count($keys)-1)]];
			unset($stations[$keys[mt_rand(0, count($keys)-1)]]);
			$streamUrls = esctheme_parsePlaylist(sprintf(PLSURL, $station['ID']));
			if (count($streamUrls)>0) {
				$ret['url'] = $streamUrls[mt_rand(0, count($streamUrls)-1)];
			}
			if (isset($ret['url']) && !empty($ret['url'])) {
				if (!$ret['format'] = esctheme_matchMimetypes($station['Format'], $mimetypes))
					$ret['format'] = 'mp3';
				$ret['mimetype'] = $station['Format'];
				$ret['name'] = $station['Name'];
				$ret['bitrate'] = $station['Bitrate'];
				return $ret;
	
			} else
				$ret = array();
				
		}
		return $ret;
	}
}

if (!function_exists("esctheme_matchMimetypes"))
{
	function esctheme_matchMimetypes($type = '', $list = array())
	{
		foreach($list as $format => $types)
		foreach($types as $typal)
		if ($typal == $type)
			return $format;
		return false;
	}
}

if (!function_exists("esctheme_generateMimetypes"))
{
	function esctheme_parsePlaylist($playlistUrl) {
		$playlistUrlData = parse_url($playlistUrl);
		$headers = array();
		$response = esctheme_getExternal($playlistUrl, array());
		$playlist = parse_ini_string($response);
		$streamUrls = array();
		foreach($playlist as $key => $value)
		{
			if (substr($key, 0, 4) == 'File')
				$streamUrls[] = $value;
		}
		return $streamUrls;
	}
}

if (!function_exists("esctheme_generateMimetypes"))
{
	function esctheme_generateMimetypes($typestr = '', $defnaming = '')
	{
		static $ret = array();
		if (empty($ret)) {
			foreach (explode('|', $typestr) as $format) {
				if (defined(sprintf($defnaming, strtoupper($format)))) {
					foreach (explode('|', constant(sprintf($defnaming, strtoupper($format)))) as $mimetype) {
						$ret[$format][$mimetype] = $mimetype;
					}
				}
			}
		}
		return $ret;
	}
}