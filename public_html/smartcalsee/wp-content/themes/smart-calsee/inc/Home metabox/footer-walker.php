<?php
function sc_services_stack_shortcode($atts)
{
    // Attributes (optional override)
    $atts = shortcode_atts(array(
        'post_type' => 'services',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ), $atts, 'services_stack');

    $args = array(
        'post_type'      => sanitize_text_field($atts['post_type']),
        'posts_per_page' => intval($atts['posts_per_page']),
        'orderby'        => sanitize_text_field($atts['orderby']),
        'order'          => sanitize_text_field($atts['order']),
        'post_status'    => 'publish',
    );

    $q = new WP_Query($args);

    if (! $q->have_posts()) {
        return '<p>No services found.</p>';
    }

    // Buffer output
    ob_start();
?>

    <div id="menu-card" class="container-fluid mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="d-flex flex-wrap py-0 gap-2 js-services-menu">
                <?php
                $first = true;
                while ($q->have_posts()) {
                    $q->the_post();
                    $slug = sanitize_title(get_post_field('post_name', get_the_ID()));
                    $title = get_the_title();
                    // Get service categories (countries) for this service - use slugs for SEO
                    $categories = wp_get_post_terms(get_the_ID(), 'service_category', array('fields' => 'all'));
                    $country_attr = '';
                    if (!empty($categories) && function_exists('smart_get_country_slug')) {
                      $country_slug = smart_get_country_slug($categories[0]);
                      $country_attr = ' data-country="' . esc_attr($country_slug) . '"';
                    } elseif (!empty($categories)) {
                      // Fallback to slug if function doesn't exist
                      $country_attr = ' data-country="' . esc_attr($categories[0]->slug) . '"';
                    }
                    $active = $first ? ' active' : '';
                    echo '<div class="menu-item-card' . esc_attr($active) . '" data-target="' . esc_attr($slug) . '"' . $country_attr . '>' . esc_html($title) . '</div>';
                    $first = false;
                }
                // Reset pointer so we can loop again for cards
                wp_reset_postdata();
                ?>
            </div>
        </div>
            </div>

    <div class="container-fluid mt-5 mb-5">
        <ul class="stack-cards js-stack-cards">
            <?php
            // Second loop for the cards (preserve same query args)
            $q2 = new WP_Query($args);
            $first = true;
            while ($q2->have_posts()) {
                $q2->the_post();
                $slug = sanitize_title(get_post_field('post_name', get_the_ID()));
                $theme = 'default';
                $activeClass = $first ? ' is-active' : '';
                $title = get_the_title();
                // Prefer ACF field 'service_image' if exists, otherwise post thumbnail
                $img = '';
                if (function_exists('get_field')) {
                    $acf_img = get_field('service_image', get_the_ID());
                    if (! empty($acf_img)) {
                        // if ACF returns array
                        if (is_array($acf_img) && isset($acf_img['url'])) {
                            $img = $acf_img['url'];
                        } else {
                            $img = esc_url($acf_img);
                        }
                    }
                }
                if (empty($img) && has_post_thumbnail()) {
                    $img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                }
                if (empty($img)) {
                    $img = get_template_directory_uri() . '/assets/images/placeholder.png'; // fallback
                }

                // Use excerpt if exists, otherwise trimmed content
                $excerpt = get_the_excerpt();
                if (empty($excerpt)) {
                    $excerpt = wp_trim_words(wp_strip_all_tags(get_the_content()), 30, '...');
                }
                
                // Get service categories (countries) for this service - use slugs for SEO
                $categories = wp_get_post_terms(get_the_ID(), 'service_category', array('fields' => 'all'));
                $country_attr = '';
                if (!empty($categories) && function_exists('smart_get_country_slug')) {
                  $country_slug = smart_get_country_slug($categories[0]);
                  $country_attr = ' data-country="' . esc_attr($country_slug) . '"';
                } elseif (!empty($categories)) {
                  // Fallback to slug if function doesn't exist
                  $country_attr = ' data-country="' . esc_attr($categories[0]->slug) . '"';
                }
            ?>
                <li data-theme="<?php echo esc_attr($theme); ?>" data-key="<?php echo esc_attr($slug); ?>"<?php echo $country_attr; ?> class="stack-cards__item bg-light shadow js-stack-cards__item<?php echo esc_attr($activeClass); ?>">
                    <div class="card-body">
                        <div class="row align-items-center h-100">
                            <div class="col-12 col-md-6">
                                <div class="card-content">
                                    <h2><?php echo esc_html($title); ?></h2>
                                    <p><?php echo esc_html($excerpt); ?></p>
                                    <a class="read-btn" href="<?php echo esc_url(get_permalink()); ?>">Read More</a>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 d-flex justify-content-center">
                                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>" class="img-fluid service-image-card" />
                            </div>
                        </div>
                    </div>
                </li>
            <?php
                $first = false;
            }
            wp_reset_postdata();
            ?>
        </ul>
    </div>

<?php
    // Include JS only once (enqueue might be better; for shortcode injection keep inline)
    $output = ob_get_clean();
    $output .= '<script>
    (function(){
        var menuItems = document.querySelectorAll(".js-services-menu .menu-item-card");
        var stackItems = document.querySelectorAll(".js-stack-cards__item");

        function setActive(targetSlug){
            // toggle active on menu
            menuItems.forEach(function(mi){
                if (mi.getAttribute("data-target") === targetSlug){
                    mi.classList.add("active");
                } else {
                    mi.classList.remove("active");
                }
            });
            // toggle visible on cards
            stackItems.forEach(function(li){
                if (li.getAttribute("data-key") === targetSlug){
                    li.classList.add("is-active");
                } else {
                    li.classList.remove("is-active");
                }
            });
        }

        // click handlers
        menuItems.forEach(function(mi){
            mi.addEventListener("click", function(){
                var target = this.getAttribute("data-target");
                setActive(target);
            });
        });

        // ensure first active on load if none already
        if (menuItems.length && !document.querySelector(".js-services-menu .menu-item-card.active")){
            setActive(menuItems[0].getAttribute("data-target"));
        }
        
        // Dispatch event to notify that stack cards are ready
        document.dispatchEvent(new CustomEvent("stackCardsReady"));
    })();
    </script>';

    return $output;
}
add_shortcode('services_stack', 'sc_services_stack_shortcode');