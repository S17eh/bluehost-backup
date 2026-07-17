<?php
/*---------------------------------
 * Add Meta Box for Contact Page
 *--------------------------------*/
add_action( 'add_meta_boxes', 'contact_info_add_metabox' );
function contact_info_add_metabox() {
    $screen = get_current_screen();
    if ( ! $screen || $screen->id !== 'page' ) return;

    // Only show on "Contact" page (change slug if different)
    $contact_page = get_page_by_path( 'contact-us' );
    if ( ! $contact_page ) return;
    if ( ! isset( $_GET['post'] ) || intval( $_GET['post'] ) !== intval( $contact_page->ID ) ) return;

    add_meta_box(
        'contact_info_box',
        'Contact Page Information',
        'contact_info_render_metabox',
        'page',
        'normal',
        'high'
    );
}

/*---------------------------------
 * Render Meta Box
 *--------------------------------*/
function contact_info_render_metabox( $post ) {
    wp_nonce_field( 'contact_info_nonce_action', 'contact_info_nonce' );

    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post->ID) : array('countries' => array('au' => array('name' => 'Australia'), 'usa' => array('name' => 'USA')), 'selected' => 'au');
    $countries = $country_data['countries'];
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
        <label for="contact_country_select">Select Country:</label>
        <select id="contact_country_select" name="contact_country_select" class="smart-country-selector">
            <?php foreach ( $countries as $code => $country ) : ?>
                <option value="<?php echo esc_attr( $code ); ?>" <?php selected( $selected_country, $code ); ?>>
                    <?php echo esc_html( $country['name'] ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ( $countries as $code => $country ) :
        $name = $country['name']; 
        // Load country-specific values
        $phone = get_post_meta( $post->ID, '_contact_phone_' . $code, true );
        $email = get_post_meta( $post->ID, '_contact_email_' . $code, true );
        $address = get_post_meta( $post->ID, '_contact_address_' . $code, true );
        $hours = get_post_meta( $post->ID, '_contact_hours_' . $code, true );
        $contact_description = get_post_meta( $post->ID, '_contact_description_' . $code, true );
        
        // Fallback to default values if country-specific not set
        if ( empty( $phone ) ) $phone = get_post_meta( $post->ID, '_contact_phone', true );
        if ( empty( $email ) ) $email = get_post_meta( $post->ID, '_contact_email', true );
        if ( empty( $address ) ) $address = get_post_meta( $post->ID, '_contact_address', true );
        if ( empty( $hours ) ) $hours = get_post_meta( $post->ID, '_contact_hours', true );
        if ( empty( $contact_description ) ) $contact_description = get_post_meta( $post->ID, '_contact_description', true );
    ?>
    <div class="country-content contact-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $name ); ?> Contact Information</h3>
        
        <p>
            <label for="contact-description-<?php echo esc_attr( $code ); ?>"><strong>Contact Description</strong></label><br>
            <?php
            $editor_id = 'contact-description-' . $code;
            $settings = array(
                'textarea_name' => 'contact_description_' . $code,
                'media_buttons' => true,
                'textarea_rows' => 6,
                'teeny' => false,
            );
            wp_editor( $contact_description, $editor_id, $settings );
            ?>
        </p>
        
        <table class="form-table">
            <tr>
                <th><label for="contact_phone_<?php echo esc_attr( $code ); ?>">Phone No:</label></th>
                <td><input type="text" name="contact_phone_<?php echo esc_attr( $code ); ?>" id="contact_phone_<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $phone ); ?>" class="regular-text" placeholder="+1 - 123 456 7890"></td>
            </tr>
            <tr>
                <th><label for="contact_email_<?php echo esc_attr( $code ); ?>">Email Address:</label></th>
                <td><input type="email" name="contact_email_<?php echo esc_attr( $code ); ?>" id="contact_email_<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $email ); ?>" class="regular-text" placeholder="business@smartcalsee.com"></td>
            </tr>
            <tr>
                <th><label for="contact_address_<?php echo esc_attr( $code ); ?>">Our Address:</label></th>
                <td>
                    <textarea name="contact_address_<?php echo esc_attr( $code ); ?>" id="contact_address_<?php echo esc_attr( $code ); ?>" rows="3" class="large-text" placeholder="Enter address"><?php echo esc_textarea( $address ); ?></textarea>
                </td>
            </tr>
            <tr>
                <th><label for="contact_hours_<?php echo esc_attr( $code ); ?>">Business Hours:</label></th>
                <td><input type="text" name="contact_hours_<?php echo esc_attr( $code ); ?>" id="contact_hours_<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $hours ); ?>" class="regular-text" placeholder="9AM - 6PM"></td>
            </tr>
        </table>
    </div>
    <?php endforeach; ?>
    
    <script>
    jQuery(document).ready(function($) {
        $('.smart-country-selector').on('change', function() {
            var country = $(this).val();
            $('.contact-content').removeClass('active').hide();
            $('.contact-content[data-country="' + country + '"]').addClass('active').show();
        });
        
        var initialCountry = $('.smart-country-selector').val();
        $('.contact-content').removeClass('active').hide();
        $('.contact-content[data-country="' + initialCountry + '"]').addClass('active').show();
    });
    </script>
    <?php
}

/*---------------------------------
 * Save Meta Values
 *--------------------------------*/
add_action( 'save_post', 'contact_info_save_meta' );
function contact_info_save_meta( $post_id ) {
    if ( ! isset( $_POST['contact_info_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['contact_info_nonce'], 'contact_info_nonce_action' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    
    // Save country-specific values
    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post_id) : array('countries' => array('au' => array('name' => 'Australia'), 'usa' => array('name' => 'USA')));
    $countries = array_keys($country_data['countries']);
    
    foreach ( $countries as $code ) {
        // Save description
        if ( isset( $_POST['contact_description_' . $code] ) ) {
            $desc = wp_kses_post( wp_unslash( $_POST['contact_description_' . $code] ) );
            update_post_meta( $post_id, '_contact_description_' . $code, $desc );
        } else {
            delete_post_meta( $post_id, '_contact_description_' . $code );
        }
        
        // Save other fields
        $fields = array(
            '_contact_phone_' . $code   => sanitize_text_field( $_POST['contact_phone_' . $code] ?? '' ),
            '_contact_email_' . $code   => sanitize_email( $_POST['contact_email_' . $code] ?? '' ),
            '_contact_address_' . $code => sanitize_textarea_field( $_POST['contact_address_' . $code] ?? '' ),
            '_contact_hours_' . $code   => sanitize_text_field( $_POST['contact_hours_' . $code] ?? '' ),
        );

        foreach ( $fields as $key => $val ) {
            if ( ! empty( $val ) ) {
                update_post_meta( $post_id, $key, $val );
            } else {
                delete_post_meta( $post_id, $key );
            }
        }
    }
}
