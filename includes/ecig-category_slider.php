<?php

defined('ABSPATH') || exit;

class Ecig_Category_Slider
{
    public function __construct()
    {
        add_shortcode('ecig_cat_slider', [$this, 'render']);
        add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
        add_action('wp_ajax_ecig_load_cat_products', [$this, 'ajax']);
        add_action('wp_ajax_nopriv_ecig_load_cat_products', [$this, 'ajax']);
    }

    public function register_scripts()
    {
        wp_enqueue_style('ecig-category-slider', ECIG_URL . 'assets/css/ecig-category-slider.css', [], ECIG_VERSION);
        wp_enqueue_script('ecig-category-slider', ECIG_URL . 'assets/js/ecig-category-slider.js', ['ecig-swiper'], ECIG_VERSION, true);
        wp_localize_script('ecig-category-slider', 'ecigCat', array(
            'ajax' => admin_url('admin-ajax.php'),
        ));
    }

    public function render($atts)
    {

        $atts = shortcode_atts([
            'cat' => '',
            'post_per_cat' => 100,
        ], $atts);

        $cat_ids = array_filter(array_map('intval', explode(',', $atts['cat'])));

        if (empty($cat_ids)) {
            $cat_ids = get_terms([
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'fields'     => 'ids',
            ]);
        }

        if (empty($cat_ids)) return '';

        ob_start(); ?>

        <div class="ecig-cat-wrap"
            data-cats='<?php echo json_encode(array_values($cat_ids)); ?>'
            data-limit="<?php echo esc_attr($atts['post_per_cat']); ?>">

            <!-- Tabs Swiper -->
            <div class="ecig-tabs swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($cat_ids as $i => $cat_id):
                        $term = get_term($cat_id, 'product_cat'); ?>
                        <div class="swiper-slide">
                            <button class="ecig-tab <?php echo $i === 0 ? 'active' : ''; ?>"
                                data-cat="<?php echo $cat_id; ?>">
                                <?php echo esc_html($term->name); ?>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Skeleton -->
            <div class="ecig-skeleton" style="margin-block: 8px; animation: ecigBlink 0.4s alternate infinite">
                <?php for ($i = 0; $i < 5; $i++): ?>
                    <div class="ecig-sk">
                        <div class="ecig-sk-img" style="border-radius: 12px;"></div>
                        <div class="ecig-sk-info" style="border-radius: 12px;"></div>
                    </div>
                <?php endfor; ?>
            </div>

            <!-- Product Swiper -->
            <div class="swiper ecig-products ecig-cat-products" style="display:none;">
                <div class="swiper-wrapper"></div>

                <!-- Category Controls -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

        </div>

    <?php return ob_get_clean();
    }

    public function ajax()
    {

        $cat_id = intval($_POST['cat']);
        $limit  = intval($_POST['limit']);

        $term = get_term($cat_id, 'product_cat');
        $thumb_id = get_term_meta($cat_id, 'thumbnail_id', true);
        $img = wp_get_attachment_url($thumb_id);

        $q = new WP_Query([
            'post_type' => 'product',
            'posts_per_page' => $limit,
            'tax_query' => [[
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $cat_id
            ]]
        ]);

        ob_start();

        // Category slide
    ?>
        <div class="swiper-slide ecig-cat-slide" style="background-image: url(<?php echo $img ? esc_url($img) : ECIG_IMG; ?>)"></div>
        <?php

        while ($q->have_posts()): $q->the_post();
            global $product;
            $img1 = get_the_post_thumbnail_url(get_the_ID(), 'medium') ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : ECIG_IMG;
            $gallery = $product->get_gallery_image_ids();
            $img2 = !empty($gallery) ? wp_get_attachment_image_url($gallery[0], 'medium') : $img1;
        ?>
            <div class="swiper-slide">
                <div class="ecig-card">
                    <a href="<?php the_permalink(); ?>" class="ecig-img-wrap">
                        <img src="<?php echo esc_url($img1); ?>" loading="lazy" />
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

        wp_reset_postdata();

        echo ob_get_clean();
        wp_die();
    }
}
