<?php 

add_action( 'add_meta_boxes', 'smart_service_add_meta_box' );
function smart_service_add_meta_box() {
    $screen = get_current_screen();

    if ( $screen && $screen->id === 'page' && isset( $_GET['post'] ) ) {
        $homepage_id = get_option( 'page_on_front' );
        $current_post_id = intval( $_GET['post'] );

        if ( $current_post_id === intval( $homepage_id ) ) {
            add_meta_box(
                'smart_service_settings',     // ID
                'Service section',                // Title
                'smart_service_render_box',   // Callback
                'page',                        // Screen
                'normal',                      // Context
                'high'                         // Priority
            );
        }
    }
}

function smart_service_render_box( $post ) {
    // Security nonce
    wp_nonce_field( 'smart_service_meta_nonce_action', 'smart_service_meta_nonce' );

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
        <label for="smart_service_country_select">Select Country:</label>
        <select id="smart_service_country_select" name="smart_service_country_select" class="smart-country-selector">
            <?php foreach ($available_countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ($available_countries as $code => $country) : 
        // Load country-specific values
        $hero_title = get_post_meta( $post->ID, '_service_title_' . $code, true );
        $service_description = get_post_meta( $post->ID, '_service_description_' . $code, true );
        
        // Fallback to default values if country-specific not set
        if ( empty( $hero_title ) ) $hero_title = get_post_meta( $post->ID, '_service_title', true );
        if ( empty( $service_description ) ) $service_description = get_post_meta( $post->ID, '_service_description', true );
    ?>
    <div class="country-content smart-service-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Service Section</h3>
        
        <p>
            <label for="service-title-<?php echo esc_attr( $code ); ?>"><strong>Service Title</strong></label><br>
            <input type="text" name="service_title_<?php echo esc_attr( $code ); ?>" id="service-title-<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $hero_title ); ?>" style="width:100%;">
        </p>

        <p>
            <label for="service-description-<?php echo esc_attr( $code ); ?>"><strong>Service Description</strong></label><br>
            <?php
            $editor_id = 'service-description-' . $code;
            $settings = array(
                'textarea_name' => 'service_description_' . $code,
                'media_buttons' => true,
                'textarea_rows' => 6,
                'teeny' => false,
            );
            wp_editor( $service_description, $editor_id, $settings );
            ?>
        </p>
    </div>
    <?php endforeach; ?>
    <?php
}


add_action( 'save_post', 'smart_service_save_meta_box' );
function smart_service_save_meta_box( $post_id ) {
    // Verify nonce
    if ( ! isset( $_POST['smart_service_meta_nonce'] ) ||
         ! wp_verify_nonce( $_POST['smart_service_meta_nonce'], 'smart_service_meta_nonce_action' ) ) {
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

    // Save country-specific values (dynamic from service_category)
    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post_id) : array('countries' => array('au' => array('slug' => 'au'), 'usa' => array('slug' => 'usa')));
    $countries = array_keys($country_data['countries']);
    
    foreach ( $countries as $code ) {
        if ( isset( $_POST['service_title_' . $code] ) ) {
            update_post_meta( $post_id, '_service_title_' . $code, sanitize_text_field( wp_unslash( $_POST['service_title_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_service_title_' . $code );
        }

        if ( isset( $_POST['service_description_' . $code] ) ) {
            $desc = wp_kses_post( wp_unslash( $_POST['service_description_' . $code] ) );
            update_post_meta( $post_id, '_service_description_' . $code, $desc );
        } else {
            delete_post_meta( $post_id, '_service_description_' . $code );
        }
    }
}
