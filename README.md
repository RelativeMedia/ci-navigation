# README

I wrote this library initially for my own use, however after several people asking on Stack Overflow i decided to package it and provide it to the public. It is designed by default to work with the [Twitter Bootstrap] [1] v2.0. The library will auto-detect the current active navigation element and add the `.active` class to the corresponding `<li>`.

## Requirements
 - Codeigniter 2.1.x
 - PHP 5.3.x

## Dependencies
 - url_helper - autoloaded, you do not have to load it manually

## Usage
The library in its current state only accepts a handful of params. It will be extended, at a later date.

### Load The Spark
```php
$this->load->spark('navigation/0.0.1');
```
OR
```php
$autoload['sparks'] = array( 'navigation/0.0.1' );
```
### Configuring Navigation Defaults
Currently the library is very limited when it comes to configuration. This area of the library is planned to be greatly improved and re-worked. For now you can set the `<li>` class name, and the prepend/append before and after the anchor.

Open the library `sparks/navigation/0.0.1/navigation.php`

```php
<?php
	//what to put in front of the anchor element, on no active links
	public static $nav_prepend = '<li>';
	//what to put in front of the anchor element, on active links
	public static $nav_prepend_active_begin = '<li class="';
	//what to put in the end of the anchor element, on active links
	public static $nav_prepend_active_end = '">';
	//name of the class to put in for active links, you can chain these e.g; 'active menu main hi';
	public static $nav_active_class = 'active';
	//what to put at the end of the anchor element, on active links
	public static $nav_append = '</li>';
?>
```

### Build Your Navigation
Building a single navigation element can be done by passing a singular link to the `build()` method.

```php
<?php
/**
 * @param string $url uri segments, or full URL
 * @param string $title what to display the link as, <a>$title</a>
 * @param array $params additional parameters to apply to the <a> tag
 */
echo Navigation::build('blog/post', 'Add New Blog Post', array('id' => 'add-new-blog-post') );
?>
```

Or you can build multiple navigations at once, and define url, title, params all individually.

```php
<?php
$nav = array(
	array(
		'url' => 'blog/post',
		'title' => 'Add New Blog Post',
		'params' => array( 'id' => 'add-new-blog-post' ),
	),
	//you can even define the base_url for your home page
	array(
		'url' => base_url(),
		'title' => 'Home',
	),
	//or external links
	array(
		'url' => 'http://google.com',
		'title' => 'Google Search',
	),
);

/**
 * @param array $nav list of navigation elements to build
 */
echo Navigation::build($nav);
?>
```

# Change Log

**0.0.1**

 - First release


# Road Map
Upcoming features that are planned for implementation

 - add more methods to control output of the navigation
	- ability to add additional classes to the `<li>` elements through methods
	- ability to add id's to the `<li>` elements through methods
	- ability to customize the structure of the `<li>` elements through methods
 - optimize, and clean the library up

[1]: http://twitter.github.com/bootstrap/ 	"Twitter Bootstrap"