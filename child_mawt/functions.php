<?php
/**
 * My Awesome WordPress Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mawt
 * @subpackage child_mawt
 * @since 1.0.0
 * @version 1.0.0
 */

 //Más info
  //https://codex.wordpress.org/Child_Themes
  //https://make.wordpress.org/training/handbook/theme-school/child-themes/
  //https://developer.wordpress.org/themes/advanced-topics/child-themes/

//Funciones importantes
  //get_template_directory_uri() – URL para acceder al tema padre
  //get_stylesheet_directory_uri() – UR
  

if ( !function_exists( 'mawt_scripts' ) ):
  function mawt_scripts () {
    wp_register_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Raleway:400,700', array(), '1.0.0', 'all' );
    wp_register_style( 'parent-style', get_template_directory_uri() . '/style.css', array('google-fonts'), '1.0.0', 'all' );
    wp_register_style( 'style', get_stylesheet_uri(), array('google-fonts', 'parent-style'), '1.0.0', 'all' );

    wp_enqueue_style( 'google-fonts' );
    wp_enqueue_style( 'parent-style' );
    wp_enqueue_style( 'style' );

    wp_register_script( 'parent-scripts', get_template_directory_uri() . '/scripts.js', array('jquery'), '1.0.0', true );
    wp_register_script( 'scripts', get_stylesheet_directory_uri() . '/scripts.js', array('jquery', 'parent-scripts'), '1.0.0', true );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'parent-scripts' );
    wp_enqueue_script( 'scripts' );
  }
endif;

add_action('wp_enqueue_scripts', 'mawt_scripts');

if ( !function_exists( 'child_mawt_setup' ) ):
  function child_mawt_setup () {
    load_child_theme_textdomain( 'child_mawt', get_stylesheet_directory_uri() . '/languages' );
  }
endif;

add_action( 'after_setup_theme', 'child_mawt_setup' );
?>
