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
$this->load->spark('navigation/version');
```
OR
```php
$autoload['sparks'] = array( 'navigation/version' );
```
### Configuring Navigation Defaults
By default the library comes configured with the `$element_type = 'li'` and the `$active_class = "active"` this allows the navigation to conform to Twitters standards by default and work out of the box.

You can re-define these on a per-view basis by doing the following:

```php
<?php
$this->navigation->set_parent_element_type('li');
$this->navigation->set_active_class('active');
?>
```

**You can also do method chaining:**
```php
<?php
$this->navigation->set_parent_element_type('li')->set_active_class('active')->build();
```

### Build Your Navigation
Building a single navigation element can be done by passing a singular link to the `build()` method. If you are using Bootstrap you will put the following code in place of your `<li>` elements in your navigation.

```php
<?php
/**
 * @param string $url uri segments, or full URL
 * @param string $title what to display the link as, <a>$title</a>
 * @param array $params additional parameters to apply to the <a> tag
 */
echo $this->navigation->build('blog/post', 'Add New Blog Post', array('id' => 'add-new-blog-post') );
?>
```
This will output something like:

```html
	<li class="active"><a href="http://example.com/blog/post" id="add-new-blog-post">Add New Blog Post</a></li>
```

Or you can build multiple navigations at once, and define `url, title, params` all individually.

```php
<?php
//If you don't like your views cluttered with app logic
//this could be defined in your controller
//and even pulled from a db table, just pass the variable
//to your view, and reference it in the build() method.
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
echo $this->navigation->build($nav);
?>
```

This will output something like:

```html
	<li class="active"><a href="http://example.com/blog/post" id="add-new-blog-post">Add New Blog Post</a></li>
	<li><a href="http://example.com/">Home</a></li>
	<li><a href="http://google.com/">Google Search</a></li>
```



# Change Log

**0.0.3**

 - added: method chaining
 - added: ability to change active_class, and nav_element via methods
 - added: the ability to pass parameters to the nav_elements eg; <li id="" data-attr="" class="navigation awesome">
 - fixed: several code snail's
 - moved: the prepend functionality into its own private method
 - moved: the append functionality into its own private method

**0.0.2**

 - fixed: typo that wasn't allowing parameters on href's to be passed

**0.0.1**

 - First release


# Road Map
Upcoming features that are planned for implementation

 - add more methods to control output of the navigation
	- ability to customize the structure of the `<li>` elements through methods

[1]: http://twitter.github.com/bootstrap/ 	"Twitter Bootstrap"