<?php

defined('ABSPATH') || exit;

class Ecig_Banner_Slider
{
    public function __construct()
    {
        add_shortcode('ecig_banner_slider', [$this, 'render']);
        add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
    }

    public function register_scripts()
    {
        wp_enqueue_script('ecig-banner-slider', ECIG_URL . 'assets/js/ecig-banner-slider.js', ['ecig-swiper'], ECIG_VERSION, true);
    }

    public function render($atts)
    {

        $atts = shortcode_atts([
            'images' => '', // now attachment IDs
            'ratio' => '16/9',
            'size' => 'full', // optional control
        ], $atts);

        $ids = array_filter(array_map('intval', explode(',', $atts['images'])));
        if (empty($ids)) return '';

        ob_start(); ?>

        <div class="ecig-banner-wrap" style="--ecig-ratio: <?php echo esc_attr($atts['ratio']); ?>">

            <div class="swiper ecig-banner-swiper">
                <div class="swiper-wrapper">

                    <?php foreach ($ids as $id):
                        $img = wp_get_attachment_image(
                            $id,
                            $atts['size'],
                            false,
                            [
                                'loading' => 'lazy',
                                'decoding' => 'async'
                            ]
                        );

                        if (!$img) continue;
                    ?>
                        <div class="swiper-slide">
                            <div class="ecig-banner-slide">
                                <?php echo $img; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="ecig-banner-pagination"></div>
            </div>

        </div>

<?php return ob_get_clean();
    }
}
