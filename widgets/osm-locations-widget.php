<?php
class Elementor_OSM_Locations_Widget_Main extends \Elementor\Widget_Base {
    public function get_name() {
        return 'osm_locations_widget';
    }

    public function get_title() {
        return esc_html__('OSM Locations Map', 'elementor-osm-locations-widget');
    }

    public function get_icon() {
        return 'eicon-map-pin';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_style_depends() {
        return ['elementor-osm-locations-widget'];
    }

    public function get_script_depends() {
        return ['elementor-osm-locations-widget'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Locations', 'elementor-osm-locations-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'location_name',
            [
                'label' => esc_html__('Name', 'elementor-osm-locations-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Location Name', 'elementor-osm-locations-widget'),
            ]
        );

        $repeater->add_control(
            'location_lat',
            [
                'label' => esc_html__('Latitude', 'elementor-osm-locations-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => '20.7222544',
            ]
        );

        $repeater->add_control(
            'location_lng',
            [
                'label' => esc_html__('Longitude', 'elementor-osm-locations-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => '-103.4251896',
            ]
        );

        $repeater->add_control(
            'location_description',
            [
                'label' => esc_html__('Description', 'elementor-osm-locations-widget'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
            ]
        );

        $repeater->add_control(
            'location_phone',
            [
                'label' => esc_html__('Phone', 'elementor-osm-locations-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'locations_list',
            [
                'label' => esc_html__('Locations', 'elementor-osm-locations-widget'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ location_name }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="elementor-osm-locations-widget">
            <div class="locations-container">
                <div class="locations-list">
                    <h2><?php echo esc_html__('Nuestras ubicaciones', 'elementor-osm-locations-widget'); ?></h2>
                    <?php foreach ($settings['locations_list'] as $index => $location) : ?>
                        <div class="location-item" data-location-id="<?php echo esc_attr($index); ?>"
                             data-lat="<?php echo esc_attr($location['location_lat']); ?>"
                             data-lng="<?php echo esc_attr($location['location_lng']); ?>">
                            <div class="location-info">
                                <h3><?php echo esc_html($location['location_name']); ?></h3>
                                <p class="status"><?php echo esc_html__('Abierto Ahora', 'elementor-osm-locations-widget'); ?></p>
                                <p class="phone"><?php echo esc_html($location['location_phone']); ?></p>
                                <p class="description"><?php echo esc_html($location['location_description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="osm-map"></div>
            </div>
        </div>
        <script>
            window.locationsData = <?php echo json_encode($settings['locations_list']); ?>;
        </script>
        <?php
    }
}