<?php

defined('ABSPATH') || exit;

class Ecig_Product_Slider
{

    public function __construct()
    {
        add_shortcode('ecig_product_slider', [$this, 'render']);
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
    }

    public function register_assets()
    {
        wp_enqueue_style('ecig-product-slider',  ECIG_URL . 'assets/css/ecig-product-slider.css', [], ECIG_VERSION);
        wp_enqueue_script('ecig-product-slider', ECIG_URL . 'assets/js/ecig-product-slider.js', ['ecig-swiper'], ECIG_VERSION, true);
    }

    public function render($atts)
    {

        $atts = shortcode_atts([
            'include'  => '',
            'exclude'  => '',
            'post_no'  => 12,
        ], $atts);

        $args = [
            'post_type'      => 'product',
            'posts_per_page' => intval($atts['post_no']),
        ];

        if (!empty($atts['include'])) {
            $args['post__in'] = array_map('intval', explode(',', $atts['include']));
        }

        if (!empty($atts['exclude'])) {
            $args['post__not_in'] = array_map('intval', explode(',', $atts['exclude']));
        }

        $query = new WP_Query($args);

        if (!$query->have_posts()) return '';

        ob_start(); ?>

        <div class="ecig-swiper-wrapper">

            <!-- Skeleton -->
            <div class="ecig-skeleton">
                <?php for ($i = 0; $i < 5; $i++): ?>
                    <div class="ecig-skeleton-slide"></div>
                <?php endfor; ?>
            </div>

            <!-- Swiper -->
            <div class="swiper ecig-swiper ecig-product-carousel" style="display:none;">
                <div class="swiper-wrapper">

                    <?php while ($query->have_posts()): $query->the_post();
                        global $product;

                        $img1 = get_the_post_thumbnail_url(get_the_ID(), 'medium') ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : ECIG_IMG;
                        $gallery = $product->get_gallery_image_ids();
                        $img2 = !empty($gallery) ? wp_get_attachment_image_url($gallery[0], 'medium') : $img1;
                    ?>

                        <div class="swiper-slide">
                            <div class="ecig-card">

                                <a href="<?php the_permalink(); ?>" class="ecig-img-wrap">
                                    <img src="<?php echo $img1 ? esc_url($img1) : ECIG_IMG; ?>" loading="lazy" />
                                    <img class="ecig-img-secondary" src="<?php echo esc_url($img2); ?>" loading="lazy" />
                                </a>

                                <div class="ecig-card-info">
                                    <a href="<?php the_permalink(); ?>" class="ecig-title">
                                        <?php the_title(); ?>
                                    </a>

                                    <div class="ecig-price">
                                        <?php echo $product->get_price_html() ? $product->get_price_html() : wc_price(0); ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                    <?php endwhile;
                    wp_reset_postdata(); ?>

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

<?php
        return ob_get_clean();
    }
}
