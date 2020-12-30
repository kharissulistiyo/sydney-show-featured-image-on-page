<?php

/**
 * Sydney Show Featured Image on Page
 *
 * @package     Sydney Show Featured Image on Page
 * @author      kharisblank
 * @copyright   2020 kharisblank
 * @license     GPL-2.0+
 *
 * @sydney
 * Plugin Name: Sydney Show Featured Image on Page
 * Plugin URI:  https://easyfixwp.com/
 * Description: Show header image on a page that has featured image. No settings, just activate the plugin. That's it! This plugin is build exclusively for Sydney WordPress theme.
 * Version:     0.0.6
 * Author:      kharisblank
 * Author URI:  https://easyfixwp.com
 * Text Domain: sydney
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 */

if( !class_exists('SY_Show_Featured_Image_On_Page') ) :

  class SY_Show_Featured_Image_On_Page {

    public function  __construct() {
      add_filter('body_class', array($this, 'custom_body_class'));
      add_action('wp_head', array($this, 'css'));
      add_action('sydney_inside_hero', array($this, 'page_header'));
    }

    /**
     * Check whether Sydney theme is active or not
     * @return boolean true if either Sydney or Sydney Pro is active
     */
    public function is_sydney_active() {

      $theme  = wp_get_theme();
      $parent = wp_get_theme()->parent();

      if ( ($theme != 'Sydney' ) && ($theme != 'Sydney Pro' ) && ($parent != 'Sydney') && ($parent != 'Sydney Pro') ) {
        return false;
      }

      return true;

    }

    /**
     * CSS
     * @return void
     */
    public function css() {
      if( $this->is_sydney_active() && 'nothing' == get_theme_mod('site_header_type') && !is_front_page() ) { ?>
        <style media="screen" type="text/css">
        .page-has-featured-image .sydney-hero-area > .header-image:nth-of-type(1) { display: none; }
        .page-has-featured-image .header-inner, .page-has-featured-image .header-image{ display: block; }
        .page-has-featured-image .header-inner {width: 100%; object-fit: cover;}
        </style>
        <?php
      }
    }

    /**
     * Custom body class
     * @param  array $classes
     * @return array
     */
    public function custom_body_class( $classes ) {
        if ( is_page() && has_post_thumbnail() && $this->is_sydney_active() && 'nothing' == get_theme_mod('site_header_type') && !is_front_page() ) {
            $classes[] = 'page-has-featured-image';
        }
        return $classes;
    }

    /**
     * Show featured image on page header
     * @return void
     */
    public function page_header() {
      if( $this->is_sydney_active() && 'nothing' == get_theme_mod('site_header_type') && !is_front_page() ) {
        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $page_title = get_the_title(get_the_ID());
        ?>
        <div class="header-image">
          <img class="header-inner" src="<?php echo $featured_img_url; ?>" alt="<?php echo $page_title; ?>">
        </div>
        <?php
      }
    }

  }

  new SY_Show_Featured_Image_On_Page();

endif;
