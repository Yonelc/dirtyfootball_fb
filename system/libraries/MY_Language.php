<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Language extends CI_Language {

	/**************************************************
	 configuration
	***************************************************/

	// languages
	var $languages = array(
		'en' => 'english',
		'fr' => 'french'
	);

	// special URIs (not localized)
	var $special = array (
		""
	);
	
	// where to redirect if no language in URI
	var $default_uri = ''; 

	/**************************************************/
	
	
	// from URI, set language in CI config
	function init_language()
	{
		$CI =& get_instance();
		$segment = $CI->uri->segment(1);
		
		if (isset($this->languages[$segment]))	// URI with language -> ok
		{
			$language = $this->languages[$segment];
			$CI->config->set_item('language', $language);
		}
		else if($this->is_special($segment)) // special URI -> no redirect
		{
			return;
		}
		else	// URI without language segment -> redirect
		{
			// set default language
			foreach ($this->languages as $lang => $language)
			{
				$CI->config->set_item('language', $language);
				break;
			}
			$CI->load->helper('url');
			redirect($this->default_uri);
		}
	}
	
	// get current language
	// ex: 'en' if language in CI config is 'english' 
	function lang()
	{
		$CI =& get_instance();
		$language = $CI->config->item('language');
		$lang = array_search($language, $this->languages);
		if ($lang)
		{
			return $lang;
		}
		return "en";
	}
	
	function is_special($uri)
	{
		$exploded = explode('/', $uri);
		if (in_array($exploded[0], $this->special))
		{
			return TRUE;
		}
		if(isset($this->languages[$uri]))
		{
			return TRUE;
		}
		return FALSE;
	}
	
	function switch_uri($lang)
	{
		$CI =& get_instance();

		$uri = $CI->uri->uri_string();
		if ($uri != "")
		{
			$exploded = explode('/', $uri);
			if($exploded[1] == $this->lang())
			{
				$exploded[1] = $lang;
			}
			$uri = implode('/',$exploded);
		}
		return $uri;
	}
}
// END MY_Language Class

/* End of file MY_Language.php */
/* Location: ./system/application/libraries/MY_Language.php */
