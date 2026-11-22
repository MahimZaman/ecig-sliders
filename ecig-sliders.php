<?php

/**
 * Plugin Name: Ecig Sliders
 * Plugin URI: https://condixia.com
 * Author: Mahim Zaman (Condixia)
 * Author URI: https://mahimzaman.com
 * Description: 3 Custom sliders for showcasing products and images
 * Requires Plugins: woocommerce
 */

defined('ABSPATH') || exit;

define('ECIG_PATH', trailingslashit(plugin_dir_path(__FILE__)));
define('ECIG_URL', trailingslashit(plugin_dir_url(__FILE__)));
define('ECIG_IMG', ECIG_URL . 'assets/image/placeholder.png');
define('ECIG_VERSION', time());

class Ecig_Sliders
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'ecig_scripts']);
        $this->init();
        $this->instances();
    }

    public function ecig_scripts()
    {
        wp_enqueue_style('ecig-swiper', ECIG_URL . 'assets/css/ecig-swiper.css');
        wp_enqueue_script('ecig-swiper', ECIG_URL . 'assets/js/ecig-swiper.js', [], null, false);
        wp_enqueue_style('ecig-global', ECIG_URL . 'assets/css/ecig-global.css', [], ECIG_VERSION);
    }

    private function init()
    {
        require_once ECIG_PATH . 'includes/ecig-product_slider.php';
        require_once ECIG_PATH . 'includes/ecig-category_slider.php';
        require_once ECIG_PATH . 'includes/ecig-banner_slider.php';
    }

    private function instances()
    {
        new Ecig_Product_Slider();
        new Ecig_Category_Slider();
        new Ecig_Banner_Slider();
    }
}

new Ecig_Sliders();
