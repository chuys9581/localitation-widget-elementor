<?php
/**
 * Plugin Name: Elementor OSM Locations Widget
 * Description: Custom locations widget with OpenStreetMap
 * Version: 1.0.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

final class Elementor_OSM_Locations_Widget {
    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init() {
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_elementor']);
            return;
        }

        // Add Widget
        add_action('elementor/widgets/register', [$this, 'register_widget']);
        
        // Register Widget Styles
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'widget_styles']);

        // Register Widget Scripts
        add_action('elementor/frontend/after_enqueue_scripts', [$this, 'widget_scripts']);
    }

    public function register_widget($widgets_manager) {
        require_once(__DIR__ . '/widgets/osm-locations-widget.php');
        $widgets_manager->register(new \Elementor_OSM_Locations_Widget_Main());
    }

    public function widget_styles() {
        wp_register_style(
            'leaflet',
            'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css',
            [],
            '1.7.1'
        );

        wp_register_style(
            'elementor-osm-locations-widget',
            plugins_url('assets/css/osm-locations-widget.css', __FILE__),
            ['leaflet'],
            self::VERSION
        );
    }

    public function widget_scripts() {
        wp_register_script(
            'leaflet',
            'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js',
            [],
            '1.7.1',
            true
        );

        wp_register_script(
            'elementor-osm-locations-widget',
            plugins_url('assets/js/osm-locations-widget.js', __FILE__),
            ['jquery', 'leaflet'],
            self::VERSION,
            true
        );
    }
}

new Elementor_OSM_Locations_Widget();