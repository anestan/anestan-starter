<?php
/**
 *
 * Anestan functions and definitions
 *
 * @package Anestan
 * @author  dao team
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 */

/**
 * Set constant for version.
 */
define( 'ANESTAN_VERSION', '1.0.0' );



/**
 * Check to see if development mode is active.
 * If set the 'true', then serve standard theme files,
 * instead of minified .css and .js files.
 */
define( 'ANESTAN_DEBUG', true );



if ( ! function_exists( 'anestan_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function anestan_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Essay, use a find and replace
		 * to change 'anestan' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'anestan' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 140, 140, true );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'anestan' ),
			'social'  => esc_html__( 'Social Menu', 'anestan' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( 'css/editor-style.css' ) );
	}
endif; // anestan_setup.
add_action( 'after_setup_theme', 'anestan_setup' );



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function anestan_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'anestan_content_width', 644 );
}
add_action( 'after_setup_theme', 'anestan_content_width', 0 );



/**
 * Enqueue scripts and styles.
 */
function anestan_scripts() {

	/**
	 * Check whether WP_DEBUG or SCRIPT_DEBUG or ANESTAN_DEBUG is set to true.
	 * If so, we’ll load the unminified versions of the main theme stylesheet. If not, load the compressed and combined version.
	 * This is also similar to how WordPress core does it.
	 *
	 * @link https://codex.wordpress.org/WP_DEBUG
	 */
	if ( WP_DEBUG || SCRIPT_DEBUG || ANESTAN_DEBUG || is_child_theme() ) {

		// Add the main stylesheet.
		wp_enqueue_style( 'anestan-style', get_stylesheet_uri() );

	} else {
		// Add the main minified stylesheet.
		wp_enqueue_style( 'anestan-minified-style', get_template_directory_uri() . '/style.min.css', false, '1.0', 'all' );
	}

	// Load the standard WordPress comments reply javascript.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * Now let's check the same for the scripts.
	 */

	wp_enqueue_script( 'jquery' );

	if ( WP_DEBUG || SCRIPT_DEBUG || ANESTAN_DEBUG ) {

		// Load the NProgress progress bar loader javascript.
		wp_enqueue_script( 'nprogress', get_template_directory_uri() . '/js/vendor/nprogress.js', array( 'jquery' ), ANESTAN_VERSION, true );

		// Load the FitVids responsive video javascript.
		wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/vendor/fitvids.js', array( 'jquery' ), ANESTAN_VERSION, true );

		// Load the custom theme javascript custom.
		wp_enqueue_script( 'anestan-custom', get_template_directory_uri() . '/js/custom/custom.js', array( 'jquery' ), ANESTAN_VERSION, true );

	} else {
		// Load the combined javascript library.
		wp_enqueue_script( 'anestan-combined-scripts', get_template_directory_uri() . '/js/vendor.min.js', array(), ANESTAN_VERSION, true );

		// Load the minified javascript functions.
		wp_enqueue_script( 'anestan-minified-functions', get_template_directory_uri() . '/js/custom.min.js', array( 'jquery' ), ANESTAN_VERSION, true );
	}
}
add_action( 'wp_enqueue_scripts', 'anestan_scripts' );

