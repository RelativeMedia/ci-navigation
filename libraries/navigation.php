<?php
class Navigation {

	/** CI instance */
	private static $ci;
	/** @var array built navigation items */
	protected static $_navs;

    public static $active_class = 'active';
    public static $element_type = 'li';

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
     * [_prepend description]
     * @param  boolean $active whether the navigation item is active or not
     * @param  array   $params parameters to be passed
     * @return string          returns back the prepended navigation element
     */
    private static function _prepend( $active = false, $params = array() ){
        $prepend = '<'.self::$element_type;

        /** did we pass any class names in? If so, implode the array into a string */
        if ( isset($params['class']) ){
            $classes = implode($params['class'], ' ');
        }
        /** Is the navigation item active? If so prepend the active_class object */
        if ($active){
            /** Since the nav element is active, add the active class */
            $prepend .= ' class="'.self::$active_class;
            /** Were other classes defined, if true then add them to the nav element */
            if( isset($classes) ){
                $prepend .= ' '.$classes.'"';
            /** Otherwise close the class on the nav element */
            }else{
                $prepend .= '"';
            }
        /** Otherwise just use the passes classes if they're set. */
        }else{
            /** were other classes defined, if true then add them to the nav element */
            if( isset($classes) ){
                $prepend .= ' class="'.$classes.'"';
            }
        }
        /** did we pass an id in? If so add it to the nav element*/
        if( isset($params['id']) ){
            $prepend .= ' id="'.$ids.'"';
        }
        /** Did we pass any data objects in? If so add them to the nav element */
        if( isset($params['data']) ){

        }

        /** Close the element */
        $prepend .= ' >';

        return $prepend;
    }

    private static function _append( $params = array() ){
        $append = '</'.self::$element_type.'>';
        return $append;
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

            $built =
                    self::_prepend(true).
                    anchor( $url, $title, $params ).
                    self::_append()."\n";

        /** else if the passed url is equal to the base_url(), set this li active */
        }else{

            $built =
                    self::_prepend().
                    anchor( $url, $title, $params ).
                    self::_append()."\n";

        }
        return $built;
    }

}//end lib