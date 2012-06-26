<?php
class Navigation {

	/** CI instance */
	private static $ci;
	/** @var array built navigation items */
	protected static $_navs;

	public static $nav_prepend = '<li>';
	public static $nav_prepend_active_begin = '<li class="';
	public static $nav_prepend_active_end = '">';
	public static $nav_active_class = 'active';
	public static $nav_append = '</li>';

    function __construct($params = array()) {
        self::$ci = & get_instance();
    }

    /**
     * parses the navigation from the view
     *
     * this function is typically called from a view, it is responsible for parsing navigation
     * into a set of li/href elements. This function also determines the active link and 
     * assigns a class to it.
     *
     * @param  string $url    string or array of urls, if array,other params are invalid
     * @param  string $title  what to display in the href
     * @param  array $params additional parameters to pass to the _build() function to add to hrefs
     * @return string         returns final navigation elements
     */
    public static function build( $url, $title = NULL, $params = array() ){

    	/** are we dealing with one nav item, or multiple? */
    	if( is_array($url) ){

    		/** go through each item, and begin to build the nav */
    		foreach( $url as $u ){

	    		if( !isset($u['params']) ){
	    			$u['params'] = array();
	    		}

    			/** invoke the builder  */
    			$built[] = self::_build( $u['url'], $u['title'], $u['params'] );
    		}

    		/** @var string implode the navigation to create a string of li's to be used in html */
    		$built_url = implode($built);

    	/** only dealing with one url item */
    	}else{
    		$built = self::_build( $url, $title, $params );
    	}
    	return $built_url;
    }

    /**
     * builds the navigation and returns it
     * @param  string $url    string or array of urls, if array,other params are invalid
     * @param  string $title  what to display in the href
     * @param  array $params additional parameters to pass to the anchor() helper to add to hrefs
     * @return string         returns compiled navigation
     */
    private static function _build( $url, $title, $params = array() ){
		/** if the passed url is equal to the current uri_string, set this li active */
		if( $url == self::$ci->uri->uri_string() || $url == current_url() ){
			$built = self::$nav_prepend_active_begin.self::$nav_active_class.self::$nav_prepend_active_end.anchor( $url, $title ).self::$nav_append."\n";
		/** else if the passed url is equal to the base_url(), set this li active */
		}else{
			$built = self::$nav_prepend.anchor( $url, $title ).self::$nav_append."\n";
		}
		return $built;
    }

}//end lib