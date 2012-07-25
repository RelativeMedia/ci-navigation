<?php
class Navigation {

	/** CI instance */
	protected $ci;

    /**
     * class name for a nav_element that is active
     * @var string
     */
    public $active_class = 'active';
    /**
     * html element type for a nav_element
     * @var string
     */
    public $parent_element_type = 'li';

    /**
     * Type of child element to be used,
     * by default this is a ul.
     * @var string
     * @todo create a public method to change this
     */
    public $child_element_type = 'ul';
    /**
     * Parameters for the child element,
     * by default this is a class of dropdown-menu
     * on a ul.
     * @var string
     * @todo create a public method to change this
     */
    public $child_element_class = 'dropdown-menu';
    /**
     * Additional parameters to pass to the parent anchor element
     * By default this adds a class to the anchor element.
     * @var array default is class = 'dropdown-toggle'
     * @todo create a public method to change this
     */
    public $child_anchor_params = array( 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown');
    /**
     * The parameters to be set on the parent element of
     * the dropdown. By default this is an li.
     * @var array default is class = 'dropdown'
     * @todo create a public method to change this
     */
    public $dropdown_prepend_params = array('class' => 'dropdown');
    /**
     * Append an icon to the end of the anchor element for dropdowns
     * @var string
     * @todo create a public method to change this
     */
    public $dropdown_anchor_caret = ' <b class="caret"></b>';

    /**
     * Class object container for all of the nav elements
     * @var string
     */
    public $nav_elements;

    function __construct($params = array()) {
        $this->ci = & get_instance();
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
    public function build( $url, $title = NULL, $params = array() ){

    	/** are we dealing with one nav item, or multiple? */
    	if( is_array($url) ){

    		/** go through each item, and begin to build the nav */
    		foreach( $url as $u ){

	    		if( !isset($u['params']) ){
	    			$u['params'] = array();
	    		}

                if( !isset($u['children']) ){
                    $u['children'] = array();
                }

    			/** invoke the builder  */
    			$built[] = $this->_build( $u['url'], $u['title'], $u['params'], $u['children'] );
    		}

    		/** @var string implode the navigation to create a string of li's to be used in html */
    		$this->nav_elements = implode($built);

    	/** only dealing with one url item */
    	}else{
    		$this->nav_elements = $this->_build( $url, $title, $params );
    	}
    	return $this->nav_elements;
    }

    /**
     * allows the element_type to be set externally
     * from the library.
     * @param string $elementType html element type, e.g; li, div, nav
     */
    public function set_parent_element_type( $elementType ){
        $this->parent_element_type = $elementType;
        return $this;
    }

    /**
     * allows the class name for an active nav element
     * to be set externally from the library.
     * @param string $activeClass class name of the active nav element
     */
    public function set_active_class( $activeClass ){
        $this->active_class = $activeClass;
        return $this;
    }

    /**
     * allows the child_element_type to be set externally
     * from the library.
     * @param string $childElementType html element type, e.g; ul
     */
    public function set_child_element_type( $childElementType ){
        $this->child_element_type = $childElementType;
        return $this;
    }

    /**
     * allows the class to be defined for the child element
     * externally from the library.
     * @param string $childElementClass class name of the child element.
     */
    public function set_child_element_class( $childElementClass ){
        $this->child_element_class = $childElementClass;
        return $this;
    }

    /**
     * allows the parameters to be defined for the dropdown 
     * element. The dropdown element is the parent to the child Elements
     * @param array $dropdownPrependParams array of parameters e.g; class, data attribs
     */
    public function set_dropdown_prepend_params( $dropdownPrependParams ){
        $this->dropdown_prepend_params = $dropdownPrependParams;
        return $this;
    }

    /**
     * allows the parameters tob e defiend for the child anchor elements
     * to a dropdown. These elements are by default located within the ul li
     * @param array $childAnchorParams array of params, e.g; class, data-attribs
     */
    public function set_child_anchor_params( $childAnchorParams ){
        $this->child_anchor_params = $childAnchorParams;
        return $this;
    }

    /**
     * allows the caret, or icon text to be added to the end of the parent anchor
     * tag for a link with children.
     * @param string $dropdownAnchorCaret html string of content
     */
    public function set_dropdown_anchor_caret( $dropdownAnchorCaret ){
        $this->dropdown_anchor_caret = $dropdownAnchorCaret;
        return $this;
    }

    /**
     * Create the starting nav_element
     *
     * This defaults to the class object defaults of an <li> element
     * with a active class of "active".
     *
     * @param  boolean $active whether the navigation item is active or not
     * @param  array   $params parameters to be passed
     * @return string          returns back the prepended navigation element
     */
    private function _prepend( $active = false, $params = array() ){
        $prepend = '<'.$this->parent_element_type;

        /** did we pass any class names in? If so, implode the array into a string */
        if ( isset($params['class']) && is_array($params['class']) ){
            $classes = implode($params['class'], ' ');
        }elseif( isset($params['class']) ){
            $classes = $params['class'];
        }

        /** Is the navigation item active? If so prepend the active_class object */
        if ($active){
            /** Since the nav element is active, add the active class */
            $prepend .= ' class="'.$this->active_class;
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
                $prepend .= ' class="'.$classes.'" ';
            }
        }
        /** did we pass an id in? If so add it to the nav element*/
        if( isset($params['id']) ){
            $prepend .= 'id="'.$ids.'" ';
        }
        /** Did we pass any data objects in? If so add them to the nav element */
        if( isset($params['data']) ){

        }

        /** Close the element */
        $prepend .= '>';

        return $prepend;
    }

    /**
     * Create the ending nav_element
     *
     * This defaults to the class object
     * defaults of an <li> element
     *
     * @return string closing html nav_element
     */
    private function _append(){
        $append = '</'.$this->parent_element_type.'>';
        return $append;
    }
    /**
     * Compiles the children list elements
     * starting at the UL and traversing through
     * each, creating an LI and an anchor element
     * for each child.
     * @param  array $children array of children elements
     * @return string html string of the child elements
     */
    private function _children( $children ){
        $child = '<'.$this->child_element_type;
        $child .= ' class="'.$this->child_element_class.'">';

        foreach( $children  as $c ){
            $child .= $this->_prepend().anchor( $c['url'], $c['title'] ).$this->_append();
        }
        $child .= '</'.$this->child_element_type.'>';

        return $child;
    }

    /**
     * builds the navigation and returns it
     * @param  string $url    string or array of urls, if array,other params are invalid
     * @param  string $title  what to display in the href
     * @param  array $params additional parameters to pass to the anchor() helper to add to hrefs
     * @return string         returns compiled navigation
     */
    private function _build( $url, $title, $params, $children ){
        /** if the passed url is equal to the current uri_string, set this li active */
        if( $url == $this->ci->uri->uri_string() || $url == current_url() ){

            /** If we have children, setup the prepend differently. */
            if( isset($children) && !empty($children) ){
                $built = $this->_prepend(true, $this->dropdown_prepend_params );
            }else{
                $built = $this->_prepend(true);
            }

            $built .= anchor( $url, $title, $params );

            if( isset($children) && !empty($children) ){
                $built .= "\n".$this->_children( $children )."\n";
            }

            $built .= $this->_append()."\n";

        /** else if the passed url is equal to the base_url(), set this li active */
        }else{

            /** If we have children, setup the prepend differently. */
            if( isset($children) && !empty($children) ){
                $built = $this->_prepend(false, $this->dropdown_prepend_params );
                $params = $this->child_anchor_params;
                $title .= $this->dropdown_anchor_caret;

            }else{
                $built = $this->_prepend(false);
            }

            $built .= anchor( $url, $title, $params );

            if( isset($children) && !empty($children) ){
                $built .= "\n".$this->_children( $children )."\n";
            }
            $built .= $this->_append()."\n";

        }
        return $built;
    }

}//end lib