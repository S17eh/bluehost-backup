<?php
add_action( 'add_meta_boxes', 'service_page_add_metabox' );
function service_page_add_metabox() {
    $screen = get_current_screen();
    if ( ! $screen || $screen->id !== 'page' ) return;

    $service_page = get_page_by_path( 'our-services' );
    if ( ! $service_page ) return;
    if ( ! isset( $_GET['post'] ) || intval( $_GET['post'] ) !== intval( $service_page->ID ) ) return;

    add_meta_box(
        'service_page_box',
        'Service Page Content',
        'service_page_render_box',
        'page',
        'normal',
        'high'
    );
}

function service_page_render_box( $post ) {
    wp_nonce_field( 'service_page_nonce_action', 'service_page_nonce' );

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
        <label for="service_page_country_select">Select Country:</label>
        <select id="service_page_country_select" class="smart-country-selector">
            <?php foreach ( $countries as $code => $country ) : ?>
                <option value="<?php echo esc_attr( $code ); ?>" <?php selected( $selected_country, $code ); ?>>
                    <?php echo esc_html( $country['name'] ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ( $countries as $code => $country ) : 
        $title = get_post_meta( $post->ID, '_service_page_title_' . $code, true );
        $desc = get_post_meta( $post->ID, '_service_page_description_' . $code, true );
        
        if ( empty( $title ) ) $title = get_post_meta( $post->ID, '_service_page_title', true );
        if ( empty( $desc ) ) $desc = get_post_meta( $post->ID, '_service_page_description', true );
    ?>
    <div class="country-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Service Page Content</h3>
        
        <p>
            <label for="service_page_title_<?php echo esc_attr( $code ); ?>"><strong>Page Title</strong></label><br>
            <input type="text" name="service_page_title_<?php echo esc_attr( $code ); ?>" id="service_page_title_<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $title ); ?>" style="width:100%;">
        </p>

        <p>
            <label for="service_page_description_<?php echo esc_attr( $code ); ?>"><strong>Page Description</strong></label><br>
            <?php
            $editor_id = 'service_page_description_' . $code;
            wp_editor( $desc, $editor_id, array(
                'textarea_name' => 'service_page_description_' . $code,
                'media_buttons' => false,
                'textarea_rows' => 5,
            ) );
            ?>
        </p>
    </div>
    <?php endforeach; ?>

    <script>
    jQuery(document).ready(function($) {
        $('.smart-country-selector').on('change', function() {
            var country = $(this).val();
            $('.country-content').removeClass('active').hide();
            $('.country-content[data-country="' + country + '"]').addClass('active').show();
        });
        
        var init = $('.smart-country-selector').val();
        $('.country-content[data-country="' + init + '"]').show();
    });
    </script>
    <?php
}

add_action( 'save_post', 'service_page_save_meta' );
function service_page_save_meta( $post_id ) {
    if ( ! isset( $_POST['service_page_nonce'] ) || ! wp_verify_nonce( $_POST['service_page_nonce'], 'service_page_nonce_action' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post_id) : array('countries' => array('au' => array('name' => 'Australia'), 'usa' => array('name' => 'USA')));
    $countries = array_keys($country_data['countries']);
    
    foreach ( $countries as $code ) {
        if ( isset( $_POST['service_page_title_' . $code] ) ) {
            update_post_meta( $post_id, '_service_page_title_' . $code, sanitize_text_field( wp_unslash( $_POST['service_page_title_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_service_page_title_' . $code );
        }

        if ( isset( $_POST['service_page_description_' . $code] ) ) {
            $desc = wp_kses_post( wp_unslash( $_POST['service_page_description_' . $code] ) );
            update_post_meta( $post_id, '_service_page_description_' . $code, $desc );
        } else {
            delete_post_meta( $post_id, '_service_page_description_' . $code );
        }
    }
}
