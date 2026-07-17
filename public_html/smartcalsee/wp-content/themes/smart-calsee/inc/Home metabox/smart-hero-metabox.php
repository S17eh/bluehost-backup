<?php
/**
 * Homepage meta box (procedural, classic editor for description)
 */

/* ---------------------------
 * Add meta box (only for homepage)
 * --------------------------- */
add_action( 'add_meta_boxes', 'smart_homepage_add_meta_box' );
function smart_homepage_add_meta_box() {
    $screen = get_current_screen();

    if ( $screen && $screen->id === 'page' && isset( $_GET['post'] ) ) {
        $homepage_id = get_option( 'page_on_front' );
        $current_post_id = intval( $_GET['post'] );

        if ( $current_post_id === intval( $homepage_id ) ) {
            add_meta_box(
                'smart_homepage_settings',     // ID
                'Hero section',                // Title
                'smart_homepage_render_box',   // Callback
                'page',                        // Screen
                'normal',                      // Context
                'high'                         // Priority
            );
        }
    }
}

function smart_homepage_render_box( $post ) {

    // Security nonce
    wp_nonce_field( 'smart_homepage_meta_nonce_action', 'smart_homepage_meta_nonce' );

    // Get countries dynamically from service_category
    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post->ID) : array('countries' => array('au' => array('name' => 'Australia', 'slug' => 'au')), 'selected' => 'au');
    $available_countries = $country_data['countries'];
    $selected_country = $country_data['selected'];
    ?>
    <style>
    .country-selector-wrapper { margin-bottom: 20px; padding: 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 4px; }
    .country-selector-wrapper label { font-weight: bold; margin-bottom: 8px; display: block; }
    .country-selector-wrapper select { width: 100%; padding: 8px; font-size: 14px; }
    .country-content { display: none; }
    .country-content.active { display: block; }
    </style>
    
    <div class="country-selector-wrapper">
        <label for="smart_hero_country_select">Select Country:</label>
        <select id="smart_hero_country_select" name="smart_hero_country_select" class="smart-country-selector">
            <?php foreach ($available_countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ($available_countries as $code => $country) : 
        // Load country-specific values
        $hero_title = get_post_meta( $post->ID, '_hero_title_' . $code, true );
        $hero_description = get_post_meta( $post->ID, '_hero_description_' . $code, true );
        $badge1_number = get_post_meta( $post->ID, '_badge1_number_' . $code, true );
        $badge1_text = get_post_meta( $post->ID, '_badge1_text_' . $code, true );
        $badge2_number = get_post_meta( $post->ID, '_badge2_number_' . $code, true );
        $badge2_text = get_post_meta( $post->ID, '_badge2_text_' . $code, true );
        
        // Fallback to default values if country-specific not set
        if ( empty( $hero_title ) ) $hero_title = get_post_meta( $post->ID, '_hero_title', true );
        if ( empty( $hero_description ) ) $hero_description = get_post_meta( $post->ID, '_hero_description', true );
        if ( empty( $badge1_number ) ) $badge1_number = get_post_meta( $post->ID, '_badge1_number', true );
        if ( empty( $badge1_text ) ) $badge1_text = get_post_meta( $post->ID, '_badge1_text', true );
        if ( empty( $badge2_number ) ) $badge2_number = get_post_meta( $post->ID, '_badge2_number', true );
        if ( empty( $badge2_text ) ) $badge2_text = get_post_meta( $post->ID, '_badge2_text', true );
    ?>
    <div class="country-content smart-hero-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Content</h3>
        
        <p>
            <label for="hero_title_<?php echo esc_attr( $code ); ?>"><strong>Hero Title</strong></label><br>
            <?php
            $editor_id = 'hero_title_' . $code;
            $settings = array(
                'textarea_name' => 'hero_title_' . $code,
                'textarea_rows' => 3,
                'media_buttons' => false,
                'teeny' => true,
                'tinymce' => array( 'wpautop' => false ),
                'quicktags' => true,
                'wpautop' => false,
            );
            wp_editor( $hero_title, $editor_id, $settings );
            ?>
        </p>

        <p>
            <label for="hero_description_<?php echo esc_attr( $code ); ?>"><strong>Hero Description</strong></label><br>
            <?php
            $editor_id = 'hero_description_' . $code;
            $settings = array(
                'textarea_name' => 'hero_description_' . $code,
                'media_buttons' => true,
                'textarea_rows' => 6,
                'teeny' => false,
            );
            wp_editor( $hero_description, $editor_id, $settings );
            ?>
        </p>

        <h4>Badge 1</h4>
        <p>
            <label for="badge1_number_<?php echo esc_attr( $code ); ?>">Number</label><br>
            <input type="text" name="badge1_number_<?php echo esc_attr( $code ); ?>" id="badge1_number_<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $badge1_number ); ?>" placeholder="e.g. 10+">
            <br><br>
            <label for="badge1_text_<?php echo esc_attr( $code ); ?>">Text</label><br>
            <textarea name="badge1_text_<?php echo esc_attr( $code ); ?>" id="badge1_text_<?php echo esc_attr( $code ); ?>" rows="2" style="width:100%;"><?php echo esc_textarea( $badge1_text ); ?></textarea>
            <small class="description">Press Enter for a line break (will be rendered as &lt;br&gt; on the site).</small>
        </p>

        <h4>Badge 2</h4>
        <p>
            <label for="badge2_number_<?php echo esc_attr( $code ); ?>">Number</label><br>
            <input type="text" name="badge2_number_<?php echo esc_attr( $code ); ?>" id="badge2_number_<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $badge2_number ); ?>" placeholder="e.g. 100+">
            <br><br>
            <label for="badge2_text_<?php echo esc_attr( $code ); ?>">Text</label><br>
            <textarea name="badge2_text_<?php echo esc_attr( $code ); ?>" id="badge2_text_<?php echo esc_attr( $code ); ?>" rows="2" style="width:100%;"><?php echo esc_textarea( $badge2_text ); ?></textarea>
            <small class="description">Press Enter for a line break (will be rendered as &lt;br&gt; on the site).</small>
        </p>
    </div>
    <?php endforeach; ?>
    
    <script>
    jQuery(document).ready(function($) {
        $('.smart-country-selector').on('change', function() {
            var country = $(this).val();
            $('.smart-hero-content').removeClass('active').hide();
            $('.smart-hero-content[data-country="' + country + '"]').addClass('active').show();
        });
        
        var initialCountry = $('.smart-country-selector').val();
        $('.smart-hero-content').removeClass('active').hide();
        $('.smart-hero-content[data-country="' + initialCountry + '"]').addClass('active').show();
    });
    </script>
    <?php
}

/* ---------------------------
 * Save meta box data
 * --------------------------- */
add_action( 'save_post', 'smart_homepage_save_meta_box' );
function smart_homepage_save_meta_box( $post_id ) {
    // Verify nonce
    if ( ! isset( $_POST['smart_homepage_meta_nonce'] ) ||
         ! wp_verify_nonce( $_POST['smart_homepage_meta_nonce'], 'smart_homepage_meta_nonce_action' ) ) {
        return;
    }

    // Do not save during autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Capability check
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Only save when editing the homepage
    $homepage_id = get_option( 'page_on_front' );
    if ( intval( $post_id ) !== intval( $homepage_id ) ) {
        return;
    }

    // Save country-specific values
    // Get countries dynamically from service_category
    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post_id) : array('countries' => array('au' => array('slug' => 'au'), 'usa' => array('slug' => 'usa')));
    $countries = array_keys($country_data['countries']);
    
    foreach ( $countries as $code ) {
        // Save hero title
        if ( isset( $_POST['hero_title_' . $code] ) ) {
            $raw = wp_unslash( $_POST['hero_title_' . $code] );
            $clean = wp_kses_post( $raw );
            update_post_meta( $post_id, '_hero_title_' . $code, $clean );
        } else {
            delete_post_meta( $post_id, '_hero_title_' . $code );
        }

        // Save hero description
        if ( isset( $_POST['hero_description_' . $code] ) ) {
            $desc = wp_kses_post( wp_unslash( $_POST['hero_description_' . $code] ) );
            update_post_meta( $post_id, '_hero_description_' . $code, $desc );
        } else {
            delete_post_meta( $post_id, '_hero_description_' . $code );
        }

        // Save badges
        if ( isset( $_POST['badge1_number_' . $code] ) ) {
            update_post_meta( $post_id, '_badge1_number_' . $code, sanitize_text_field( wp_unslash( $_POST['badge1_number_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_badge1_number_' . $code );
        }

        if ( isset( $_POST['badge1_text_' . $code] ) ) {
            $b1 = sanitize_textarea_field( wp_unslash( $_POST['badge1_text_' . $code] ) );
            update_post_meta( $post_id, '_badge1_text_' . $code, $b1 );
        } else {
            delete_post_meta( $post_id, '_badge1_text_' . $code );
        }

        if ( isset( $_POST['badge2_number_' . $code] ) ) {
            update_post_meta( $post_id, '_badge2_number_' . $code, sanitize_text_field( wp_unslash( $_POST['badge2_number_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_badge2_number_' . $code );
        }

        if ( isset( $_POST['badge2_text_' . $code] ) ) {
            $b2 = sanitize_textarea_field( wp_unslash( $_POST['badge2_text_' . $code] ) );
            update_post_meta( $post_id, '_badge2_text_' . $code, $b2 );
        } else {
            delete_post_meta( $post_id, '_badge2_text_' . $code );
        }
    }
}
