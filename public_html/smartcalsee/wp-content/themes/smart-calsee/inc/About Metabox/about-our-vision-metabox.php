<?php
/**
 * Metabox for About Us Page - Our Vision Section
 */

add_action( 'add_meta_boxes', 'about_our_vision_add_metabox' );
function about_our_vision_add_metabox() {
    $screen = get_current_screen();
    if ( ! $screen ) return;

    if ( $screen->id === 'page' && isset( $_GET['post'] ) ) {
        $about = get_page_by_path( 'about-us' );
        $about_id = $about ? intval( $about->ID ) : 0;
        $current_post_id = intval( $_GET['post'] );

        if ( $about_id && $current_post_id === $about_id ) {
            add_meta_box(
                'about_our_vision_box',
                'Our Vision Section (Second)',
                'about_our_vision_render_box',
                'page',
                'normal',
                'high'
            );
        }
    }
}

/* Render meta box */
function about_our_vision_render_box( $post ) {
    wp_nonce_field( 'about_our_vision_nonce_action', 'about_our_vision_nonce' );

    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post->ID) : array('countries' => array('usa' => array('name' => 'USA', 'slug' => 'usa')), 'selected' => 'usa');
    $countries = $country_data['countries'];
    $selected_country = $country_data['selected'];
    ?>
    <style>
    .country-selector-wrapper { margin-bottom: 20px; padding: 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 4px; }
    .country-selector-wrapper label { font-weight: bold; margin-bottom: 8px; display: block; }
    .country-selector-wrapper select { width: 100%; padding: 8px; }
    .country-content { display: none; }
    .country-content.active { display: block; }
    </style>
    
    <div class="country-selector-wrapper">
        <label>Select Country:</label>
        <select id="about_our_vision_country_select" class="country-selector">
            <?php foreach ($countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ( $countries as $code => $country ) : 
        // Load country-specific values
        $title = get_post_meta( $post->ID, '_about_our_vision_title_' . $code, true );
        $subtitle = get_post_meta( $post->ID, '_about_our_vision_subtitle_' . $code, true );
        $content = get_post_meta( $post->ID, '_about_our_vision_content_' . $code, true );
        $img_id = get_post_meta( $post->ID, '_about_our_vision_image_id_' . $code, true );
        $person_name = get_post_meta( $post->ID, '_about_our_vision_person_name_' . $code, true );
        $person_role = get_post_meta( $post->ID, '_about_our_vision_person_role_' . $code, true );
        
        $img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'medium' ) : '';
    ?>
    <div class="country-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Our Vision Section</h3>

        <p>
            <label for="about_our_vision_title_<?php echo esc_attr( $code ); ?>"><strong>Vision Title</strong></label><br>
            <input type="text" name="about_our_vision_title_<?php echo esc_attr( $code ); ?>" id="about_our_vision_title_<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $title ); ?>" style="width:100%;">
        </p>

        <p>
            <label for="about_our_vision_subtitle_<?php echo esc_attr( $code ); ?>"><strong>Vision Subtitle</strong></label><br>
            <input type="text" name="about_our_vision_subtitle_<?php echo esc_attr( $code ); ?>" id="about_our_vision_subtitle_<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $subtitle ); ?>" style="width:100%;">
        </p>

        <p>
            <label for="about_our_vision_content_<?php echo esc_attr( $code ); ?>"><strong>Vision Content</strong></label><br>
            <?php
            $editor_id = 'about_our_vision_content_' . $code;
            wp_editor( $content, $editor_id, [
                'textarea_name' => 'about_our_vision_content_' . $code,
                'media_buttons' => true,
                'textarea_rows' => 8,
                'teeny' => false,
            ] );
            ?>
        </p>

        <hr>

        <h4>Portrait Card</h4>
        <input type="hidden" id="about_our_vision_image_id_<?php echo esc_attr( $code ); ?>" name="about_our_vision_image_id_<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $img_id ); ?>">
        <div style="margin-bottom:8px;">
            <img id="about_our_vision_image_preview_<?php echo esc_attr( $code ); ?>" src="<?php echo esc_url( $img_url ); ?>" style="max-width:200px; <?php echo $img_url ? '' : 'display:none;'; ?>; border-radius:6px;">
        </div>
        <p>
            <button type="button" class="button about_our_vision_image_upload" data-country="<?php echo esc_attr( $code ); ?>"><?php echo $img_url ? 'Change Image' : 'Upload Image'; ?></button>
            <button type="button" class="button about_our_vision_image_remove" data-country="<?php echo esc_attr( $code ); ?>" style="<?php echo $img_url ? '' : 'display:none;'; ?>">Remove</button>
        </p>

        <div style="display:flex; gap:10px; align-items:flex-start; margin-top:12px;">
            <div style="flex:1;">
                <label for="about_our_vision_person_name_<?php echo esc_attr( $code ); ?>"><strong>Person Name</strong></label><br>
                <input type="text" name="about_our_vision_person_name_<?php echo esc_attr( $code ); ?>" id="about_our_vision_person_name_<?php echo esc_attr( $code ); ?>"
                       value="<?php echo esc_attr( $person_name ); ?>" style="width:100%;">
            </div>

            <div style="flex:1;">
                <label for="about_our_vision_person_role_<?php echo esc_attr( $code ); ?>"><strong>Person Designation</strong></label><br>
                <input type="text" name="about_our_vision_person_role_<?php echo esc_attr( $code ); ?>" id="about_our_vision_person_role_<?php echo esc_attr( $code ); ?>"
                       value="<?php echo esc_attr( $person_role ); ?>" style="width:100%;">
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <script type="text/javascript">
    jQuery(document).ready(function($){
        // Country selector logic is handled by shared script in smart-functions.php
        // Media uploader logic
        if ( typeof wp === 'undefined' || ! wp.media ) return;

        var frames = {};
        $(document).on('click', '.about_our_vision_image_upload', function(e){
            e.preventDefault();
            var country = $(this).data('country');
            if ( frames[country] ) { frames[country].open(); return; }

            frames[country] = wp.media({
                title: 'Select Vision Image',
                button: { text: 'Use this image' },
                multiple: false
            });

            frames[country].on('select', function(){
                var attachment = frames[country].state().get('selection').first().toJSON();
                if ( attachment ) {
                    $('#about_our_vision_image_id_' + country).val( attachment.id );
                    var src = (attachment.sizes && attachment.sizes.medium) ? attachment.sizes.medium.url : attachment.url;
                    $('#about_our_vision_image_preview_' + country).attr('src', src).show();
                    $('.about_our_vision_image_remove[data-country="' + country + '"]').show();
                    $('.about_our_vision_image_upload[data-country="' + country + '"]').text('Change Image');
                }
            });
            frames[country].open();
        });

        $(document).on('click', '.about_our_vision_image_remove', function(e){
            e.preventDefault();
            var country = $(this).data('country');
            $('#about_our_vision_image_id_' + country).val('');
            $('#about_our_vision_image_preview_' + country).hide().attr('src','');
            $(this).hide();
            $('.about_our_vision_image_upload[data-country="' + country + '"]').text('Upload Image');
        });
    });
    </script>
    <?php
}

/* Save meta box */
add_action( 'save_post', 'about_our_vision_save_meta' );
function about_our_vision_save_meta( $post_id ) {
    if ( ! isset( $_POST['about_our_vision_nonce'] ) || ! wp_verify_nonce( $_POST['about_our_vision_nonce'], 'about_our_vision_nonce_action' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post_id) : array('countries' => array('usa' => array('slug' => 'usa'), 'australia' => array('slug' => 'australia')));
    $countries = array_keys($country_data['countries']);
    
    foreach ( $countries as $code ) {
        if ( isset( $_POST['about_our_vision_title_' . $code] ) ) {
            update_post_meta( $post_id, '_about_our_vision_title_' . $code, sanitize_text_field( wp_unslash( $_POST['about_our_vision_title_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_about_our_vision_title_' . $code );
        }
        if ( isset( $_POST['about_our_vision_subtitle_' . $code] ) ) {
            update_post_meta( $post_id, '_about_our_vision_subtitle_' . $code, sanitize_text_field( wp_unslash( $_POST['about_our_vision_subtitle_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_about_our_vision_subtitle_' . $code );
        }
        if ( isset( $_POST['about_our_vision_content_' . $code] ) ) {
            update_post_meta( $post_id, '_about_our_vision_content_' . $code, wp_kses_post( wp_unslash( $_POST['about_our_vision_content_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_about_our_vision_content_' . $code );
        }
        if ( isset( $_POST['about_our_vision_image_id_' . $code] ) ) {
            update_post_meta( $post_id, '_about_our_vision_image_id_' . $code, intval( $_POST['about_our_vision_image_id_' . $code] ) );
        } else {
            delete_post_meta( $post_id, '_about_our_vision_image_id_' . $code );
        }
        if ( isset( $_POST['about_our_vision_person_name_' . $code] ) ) {
            update_post_meta( $post_id, '_about_our_vision_person_name_' . $code, sanitize_text_field( wp_unslash( $_POST['about_our_vision_person_name_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_about_our_vision_person_name_' . $code );
        }
        if ( isset( $_POST['about_our_vision_person_role_' . $code] ) ) {
            update_post_meta( $post_id, '_about_our_vision_person_role_' . $code, sanitize_text_field( wp_unslash( $_POST['about_our_vision_person_role_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_about_our_vision_person_role_' . $code );
        }
    }
}