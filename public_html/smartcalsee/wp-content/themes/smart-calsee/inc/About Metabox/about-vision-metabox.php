<?php
add_action( 'add_meta_boxes', 'about_vision_add_metabox' );
function about_vision_add_metabox() {
    $screen = get_current_screen();
    if ( ! $screen ) return;

    if ( $screen->id === 'page' && isset( $_GET['post'] ) ) {
        $about = get_page_by_path( 'about-us' );
        $about_id = $about ? intval( $about->ID ) : 0;
        $current_post_id = intval( $_GET['post'] );

        if ( $about_id && $current_post_id === $about_id ) {
            add_meta_box(
                'about_vision_box',
                'Vision Section',
                'about_vision_render_box',
                'page',
                'normal',
                'high'
            );
        }
    }
}

/* Render meta box */
function about_vision_render_box( $post ) {
    wp_nonce_field( 'about_vision_nonce_action', 'about_vision_nonce' );

    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post->ID) : array('countries' => array('au' => array('name' => 'Australia'), 'usa' => array('name' => 'USA')), 'selected' => 'au');
    $countries = $country_data['countries'];
    $selected_country = $country_data['selected'];
    ?>
    <style>
    .country-selector-wrapper { margin-bottom: 20px; padding: 15px; background: #f5f5f5; border: 1px solid #ddd; }
    .country-selector-wrapper label { font-weight: bold; margin-bottom: 8px; display: block; }
    .country-selector-wrapper select { width: 100%; padding: 8px; }
    .country-content { display: none; }
    .country-content.active { display: block; }
    </style>
    
    <div class="country-selector-wrapper">
        <label>Select Country:</label>
        <select id="about_vision_country_select">
            <?php foreach ($countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ( $countries as $code => $country ) : 
        // Load country-specific values
        $title = get_post_meta( $post->ID, '_about_vision_title_' . $code, true );
        $content = get_post_meta( $post->ID, '_about_vision_content_' . $code, true );
        $img_id = get_post_meta( $post->ID, '_about_vision_image_id_' . $code, true );
        $person_name = get_post_meta( $post->ID, '_about_vision_person_name_' . $code, true );
        $person_role = get_post_meta( $post->ID, '_about_vision_person_role_' . $code, true );
        
        // Fallback to default values if country-specific not set
        if ( empty( $title ) ) $title = get_post_meta( $post->ID, '_about_vision_title', true );
        if ( empty( $content ) ) $content = get_post_meta( $post->ID, '_about_vision_content', true );
        if ( empty( $img_id ) ) $img_id = get_post_meta( $post->ID, '_about_vision_image_id', true );
        if ( empty( $person_name ) ) $person_name = get_post_meta( $post->ID, '_about_vision_person_name', true );
        if ( empty( $person_role ) ) $person_role = get_post_meta( $post->ID, '_about_vision_person_role', true );

        $img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'medium' ) : '';
    ?>
    <div class="country-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Vision Section</h3>
    ?>
        <p>
            <label for="about_vision_title_<?php echo esc_attr( $code ); ?>"><strong>Vision Title</strong></label><br>
            <input type="text" name="about_vision_title_<?php echo esc_attr( $code ); ?>" id="about_vision_title_<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $title ); ?>" style="width:100%;">
        </p>

        <p>
            <label for="about_vision_content_<?php echo esc_attr( $code ); ?>"><strong>Vision Content</strong></label><br>
            <?php
            $editor_id = 'about_vision_content_' . $code;
            wp_editor( $content, $editor_id, [
                'textarea_name' => 'about_vision_content_' . $code,
                'media_buttons' => false,
                'textarea_rows' => 8,
                'teeny' => false,
            ] );
            ?>
        </p>

        <hr>

        <h4>Portrait (right side)</h4>
        <input type="hidden" id="about_vision_image_id_<?php echo esc_attr( $code ); ?>" name="about_vision_image_id_<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $img_id ); ?>">
        <div style="margin-bottom:8px;">
            <img id="about_vision_image_preview_<?php echo esc_attr( $code ); ?>" src="<?php echo esc_url( $img_url ); ?>" style="max-width:200px; <?php echo $img_url ? '' : 'display:none;'; ?>; border-radius:6px;">
        </div>
        <p>
            <button type="button" class="button about_vision_image_upload" data-country="<?php echo esc_attr( $code ); ?>"><?php echo $img_url ? 'Change Image' : 'Upload Image'; ?></button>
            <button type="button" class="button about_vision_image_remove" data-country="<?php echo esc_attr( $code ); ?>" style="<?php echo $img_url ? '' : 'display:none;'; ?>">Remove</button>
        </p>

        <div style="display:flex; gap:10px; align-items:flex-start; margin-top:12px;">
            <div style="flex:1;">
                <label for="about_vision_person_name_<?php echo esc_attr( $code ); ?>"><strong>Person Name</strong></label><br>
                <input type="text" name="about_vision_person_name_<?php echo esc_attr( $code ); ?>" id="about_vision_person_name_<?php echo esc_attr( $code ); ?>"
                       value="<?php echo esc_attr( $person_name ); ?>" style="width:100%;">
            </div>

            <div style="flex:1;">
                <label for="about_vision_person_role_<?php echo esc_attr( $code ); ?>"><strong>Person Designation</strong></label><br>
                <input type="text" name="about_vision_person_role_<?php echo esc_attr( $code ); ?>" id="about_vision_person_role_<?php echo esc_attr( $code ); ?>"
                       value="<?php echo esc_attr( $person_role ); ?>" style="width:100%;">
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Robust uploader JS (runs after document ready) -->
    <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#about_vision_country_select').on('change', function() {
            var country = $(this).val();
            $('.country-content').removeClass('active').hide();
            $('.country-content[data-country="' + country + '"]').addClass('active').show();
        });
        var init = $('#about_vision_country_select').val();
        $('.country-content[data-country="' + init + '"]').show();

        // ensure wp.media is available
        if ( typeof wp === 'undefined' || ! wp.media ) {
            return;
        }

        var frames = {};

        $(document).on('click', '.about_vision_image_upload', function(e){
            e.preventDefault();
            var country = $(this).data('country');
            var frame = frames[country];

            if ( frame ) {
                frame.open();
                return;
            }

            frame = wp.media({
                title: 'Select Portrait Image',
                button: { text: 'Use this image' },
                multiple: false
            });

            frame.on('select', function(){
                var attachment = frame.state().get('selection').first().toJSON();
                if ( attachment ) {
                    $('#about_vision_image_id_' + country).val( attachment.id );
                    var src = (attachment.sizes && attachment.sizes.medium) ? attachment.sizes.medium.url : attachment.url;
                    $('#about_vision_image_preview_' + country).attr('src', src).show();
                    $('.about_vision_image_remove[data-country="' + country + '"]').show();
                    $('.about_vision_image_upload[data-country="' + country + '"]').text('Change Image');
                }
            });

            frames[country] = frame;
            frame.open();
        });

        $(document).on('click', '.about_vision_image_remove', function(e){
            e.preventDefault();
            var country = $(this).data('country');
            $('#about_vision_image_id_' + country).val('');
            $('#about_vision_image_preview_' + country).hide().attr('src','');
            $(this).hide();
            $('.about_vision_image_upload[data-country="' + country + '"]').text('Upload Image');
        });
    });
    </script>

    <?php
}

/* Save meta box */
add_action( 'save_post', 'about_vision_save_meta' );
function about_vision_save_meta( $post_id ) {
    // Verify nonce
    if ( ! isset( $_POST['about_vision_nonce'] ) || ! wp_verify_nonce( $_POST['about_vision_nonce'], 'about_vision_nonce_action' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    // Save country-specific values
//     $countries = array( 'usa', 'au' );
   $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post_id) : array('countries' => array('au' => array('slug' => 'au'), 'usa' => array('slug' => 'usa')));
    $countries = array_keys($country_data['countries']);
    
    foreach ( $countries as $code ) {
        if ( isset( $_POST['about_vision_title_' . $code] ) ) {
            update_post_meta( $post_id, '_about_vision_title_' . $code, sanitize_text_field( wp_unslash( $_POST['about_vision_title_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_about_vision_title_' . $code );
        }

        if ( isset( $_POST['about_vision_content_' . $code] ) ) {
            $content = wp_kses_post( wp_unslash( $_POST['about_vision_content_' . $code] ) );
            update_post_meta( $post_id, '_about_vision_content_' . $code, $content );
        } else {
            delete_post_meta( $post_id, '_about_vision_content_' . $code );
        }

        if ( isset( $_POST['about_vision_image_id_' . $code] ) ) {
            $img_id = intval( $_POST['about_vision_image_id_' . $code] );
            if ( $img_id ) {
                update_post_meta( $post_id, '_about_vision_image_id_' . $code, $img_id );
            } else {
                delete_post_meta( $post_id, '_about_vision_image_id_' . $code );
            }
        }

        if ( isset( $_POST['about_vision_person_name_' . $code] ) ) {
            update_post_meta( $post_id, '_about_vision_person_name_' . $code, sanitize_text_field( wp_unslash( $_POST['about_vision_person_name_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_about_vision_person_name_' . $code );
        }
        
        if ( isset( $_POST['about_vision_person_role_' . $code] ) ) {
            update_post_meta( $post_id, '_about_vision_person_role_' . $code, sanitize_text_field( wp_unslash( $_POST['about_vision_person_role_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_about_vision_person_role_' . $code );
        }
    }
}