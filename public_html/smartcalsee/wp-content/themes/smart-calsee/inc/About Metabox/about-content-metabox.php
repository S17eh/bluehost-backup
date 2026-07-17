<?php

/* Add meta box for About Us page only */
add_action( 'add_meta_boxes', 'smart_about_contact_add_meta_box' );
function smart_about_contact_add_meta_box() {
    $screen = get_current_screen();
    if ( ! $screen || $screen->id !== 'page' ) return;
    if ( ! isset( $_GET['post'] ) ) return;

    $about = get_page_by_path( 'about-us' );
    if ( ! $about ) return;

    $about_id = intval( $about->ID );
    $current_post_id = intval( $_GET['post'] );

    if ( $current_post_id === $about_id ) {
        add_meta_box(
            'smart_about_contact_settings',   
            'About Contact section',        
            'smart_about_contact_render_box', 
            'page',                           
            'normal',                         
            'high'
        );
    }
}

/* Render meta box */
function smart_about_contact_render_box( $post ) {
    wp_nonce_field( 'smart_about_contact_meta_nonce_action', 'smart_about_contact_meta_nonce' );

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
        <label for="about_content_country_select">Select Country:</label>
        <select id="about_content_country_select" name="about_content_country_select" class="smart-country-selector">
            <?php foreach ($available_countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ($available_countries as $code => $country) : 
        // Load country-specific values
        $contact_title = get_post_meta( $post->ID, '_about_contact_title_' . $code, true );
        $contact_description = get_post_meta( $post->ID, '_about_contact_description_' . $code, true );
        $button_text = get_post_meta( $post->ID, '_about_contact_button_text_' . $code, true );
        $button_link = get_post_meta( $post->ID, '_about_contact_button_link_' . $code, true );
        
        // Fallback to default values if country-specific not set
        if ( empty( $contact_title ) ) $contact_title = get_post_meta( $post->ID, '_about_contact_title', true );
        if ( empty( $contact_description ) ) $contact_description = get_post_meta( $post->ID, '_about_contact_description', true );
        if ( empty( $button_text ) ) $button_text = get_post_meta( $post->ID, '_about_contact_button_text', true );
        if ( empty( $button_link ) ) $button_link = get_post_meta( $post->ID, '_about_contact_button_link', true );
    ?>
    <div class="country-content about-content-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Contact Section</h3>
        <p>
            <label for="about-contact-title-<?php echo esc_attr( $code ); ?>"><strong>Contact Title</strong></label><br>
            <input type="text" name="about_contact_title_<?php echo esc_attr( $code ); ?>" id="about-contact-title-<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $contact_title ); ?>" style="width:100%;">
        </p>

        <p>
            <label for="about-contact-description-<?php echo esc_attr( $code ); ?>"><strong>Contact Description</strong></label><br>
            <?php
            $editor_id = 'about_contact_description_' . $code;
            wp_editor( $contact_description, $editor_id, array(
                'textarea_name' => 'about_contact_description_' . $code,
                'media_buttons' => true,
                'textarea_rows' => 6,
                'teeny' => false,
            ) );
            ?>
        </p>

        <hr>

        <h4>Button Settings</h4>
        <p>
            <label for="about-contact-button-text-<?php echo esc_attr( $code ); ?>"><strong>Button Text</strong></label><br>
            <input type="text" name="about_contact_button_text_<?php echo esc_attr( $code ); ?>" id="about-contact-button-text-<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $button_text ); ?>" style="width:100%;">
        </p>

        <p>
            <label for="about-contact-button-link-<?php echo esc_attr( $code ); ?>"><strong>Button Link</strong></label><br>
            <input type="url" name="about_contact_button_link_<?php echo esc_attr( $code ); ?>" id="about-contact-button-link-<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $button_link ); ?>" style="width:100%;">
        </p>
    </div>
    <?php endforeach; ?>
    
    <script>
    jQuery(document).ready(function($) {
        $('.smart-country-selector').on('change', function() {
            var country = $(this).val();
            $('.about-content-content').removeClass('active').hide();
            $('.about-content-content[data-country="' + country + '"]').addClass('active').show();
        });
        
        var initialCountry = $('.smart-country-selector').val();
        $('.about-content-content').removeClass('active').hide();
        $('.about-content-content[data-country="' + initialCountry + '"]').addClass('active').show();
    });
    </script>
    <?php
}

/* Save meta box data */
add_action( 'save_post', 'smart_about_contact_save_meta_box' );
function smart_about_contact_save_meta_box( $post_id ) {
    if ( ! isset( $_POST['smart_about_contact_meta_nonce'] ) ||
         ! wp_verify_nonce( $_POST['smart_about_contact_meta_nonce'], 'smart_about_contact_meta_nonce_action' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    // Save country-specific values (dynamic from service_category)
    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post_id) : array('countries' => array('au' => array('slug' => 'au'), 'usa' => array('slug' => 'usa')));
    $countries = array_keys($country_data['countries']);
    
    foreach ( $countries as $code ) {
        if ( isset( $_POST['about_contact_title_' . $code] ) ) {
            update_post_meta( $post_id, '_about_contact_title_' . $code, sanitize_text_field( wp_unslash( $_POST['about_contact_title_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_about_contact_title_' . $code );
        }

        if ( isset( $_POST['about_contact_description_' . $code] ) ) {
            $desc = wp_kses_post( wp_unslash( $_POST['about_contact_description_' . $code] ) );
            update_post_meta( $post_id, '_about_contact_description_' . $code, $desc );
        } else {
            delete_post_meta( $post_id, '_about_contact_description_' . $code );
        }

        if ( isset( $_POST['about_contact_button_text_' . $code] ) ) {
            update_post_meta( $post_id, '_about_contact_button_text_' . $code, sanitize_text_field( wp_unslash( $_POST['about_contact_button_text_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_about_contact_button_text_' . $code );
        }

        if ( isset( $_POST['about_contact_button_link_' . $code] ) ) {
            update_post_meta( $post_id, '_about_contact_button_link_' . $code, esc_url_raw( wp_unslash( $_POST['about_contact_button_link_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_about_contact_button_link_' . $code );
        }
    }
}
