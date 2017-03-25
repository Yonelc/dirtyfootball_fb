<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('site_url'))
{
	function site_url($uri = '')
	{
		$CI =& get_instance();

		// if file or special url
		if($CI->lang->is_special($uri) || preg_match('/(.+)\.[a-zA-Z0-9]{2,4}$/', $uri))
		{
			// do nothing
		}
		else
		{
			// otherwise add language segment
			$lang = $CI->lang->lang();
			$uri = $lang . '/' . $uri;
		}

		return $CI->config->site_url($uri);
	}
}

/* End of file url_helper.php */
/* Location: ./system/application/helpers/MY_url_helper.php */