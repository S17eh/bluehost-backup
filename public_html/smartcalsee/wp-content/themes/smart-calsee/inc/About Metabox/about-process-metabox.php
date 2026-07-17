<?php
/* Add Meta Box */
add_action( 'add_meta_boxes', 'easy_process_add_metabox' );
function easy_process_add_metabox() {
        $screen = get_current_screen();
    if ( ! $screen || $screen->id !== 'page' ) return;
    if ( ! isset( $_GET['post'] ) ) return;

    $about = get_page_by_path( 'about-us' );
    if ( ! $about ) return;

    $about_id = intval( $about->ID );
    $current_post_id = intval( $_GET['post'] );
    if ( $current_post_id === $about_id ) {
    add_meta_box(
        'easy_process_box',
        'Easy To Process Section',
        'easy_process_render_box',
        'page',     // show only on pages
        'normal',
        'high'
    );
}
}

/* Render Meta Box */
function easy_process_render_box( $post ) {
    wp_nonce_field( 'easy_process_nonce_action', 'easy_process_nonce' );

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
        <select id="easy_process_country_select">
            <?php foreach ($countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ( $countries as $code => $country ) : 
        // Load country-specific values
        $title = get_post_meta( $post->ID, '_easy_process_title_' . $code, true );
        $desc = get_post_meta( $post->ID, '_easy_process_description_' . $code, true );
        $steps = get_post_meta( $post->ID, '_easy_process_steps_' . $code, true );
        
        // Fallback to default values if country-specific not set
        if ( empty( $title ) ) $title = get_post_meta( $post->ID, '_easy_process_title', true );
        if ( empty( $desc ) ) $desc = get_post_meta( $post->ID, '_easy_process_description', true );
        if ( empty( $steps ) ) $steps = get_post_meta( $post->ID, '_easy_process_steps', true );

        if ( ! is_array( $steps ) || empty( $steps ) ) {
            $steps = array( array( 'icon_id' => '', 'title' => '' ) );
        }
    ?>
    <div class="country-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Easy To Process Section</h3>

        <!-- Section Title -->
        <p>
            <label for="easy_process_title_<?php echo esc_attr( $code ); ?>"><strong>Section Title</strong></label><br>
            <input type="text" name="easy_process_title_<?php echo esc_attr( $code ); ?>" id="easy_process_title_<?php echo esc_attr( $code ); ?>"
                   value="<?php echo esc_attr( $title ); ?>" style="width:100%;">
        </p>

        <!-- Section Description -->
        <p>
            <label for="easy_process_description_<?php echo esc_attr( $code ); ?>"><strong>Section Description</strong></label><br>
            <?php
            $editor_id = 'easy_process_description_' . $code;
            wp_editor( $desc, $editor_id, array(
                'textarea_name' => 'easy_process_description_' . $code,
                'media_buttons' => false,
                'textarea_rows' => 5,
            ) );
            ?>
        </p>

        <hr>

        <h4>Process Steps (Repeatable)</h4>

        <div id="easy_process_steps_wrap_<?php echo esc_attr( $code ); ?>">
            <?php foreach ( $steps as $s ) :
                $icon_id = ! empty( $s['icon_id'] ) ? intval( $s['icon_id'] ) : '';
                $icon_url = $icon_id ? wp_get_attachment_image_url( $icon_id, 'thumbnail' ) : '';
                $step_title = isset( $s['title'] ) ? $s['title'] : '';
            ?>
            <div class="easy_process_step" style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                <input type="hidden" name="easy_process_icon_id_<?php echo esc_attr( $code ); ?>[]" class="easy_process_icon_id" value="<?php echo esc_attr( $icon_id ); ?>">

                <div style="width:90px; text-align:center;">
                    <img class="easy_process_preview" src="<?php echo esc_url( $icon_url ); ?>"
                         style="max-width:70px; display:<?php echo $icon_url ? 'block' : 'none'; ?>; margin-bottom:6px;">
                    <button type="button" class="button easy_process_upload"><?php echo $icon_url ? 'Change' : 'Upload'; ?></button>
                    <button type="button" class="button easy_process_remove" style="display:<?php echo $icon_url ? 'inline-block' : 'none'; ?>;">Remove</button>
                </div>

                <div style="flex:1;">
                    <input type="text" name="easy_process_step_title_<?php echo esc_attr( $code ); ?>[]" placeholder="Step Title"
                           value="<?php echo esc_attr( $step_title ); ?>" style="width:100%;">
                </div>

                <button type="button" class="button easy_process_delete">Remove Step</button>
            </div>
            <?php endforeach; ?>
        </div>

        <p><button type="button" class="button easy_process_add" data-country="<?php echo esc_attr( $code ); ?>">Add Step</button></p>
    </div>
    <?php endforeach; ?>

    <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#easy_process_country_select').on('change', function() {
            var country = $(this).val();
            $('.country-content').removeClass('active').hide();
            $('.country-content[data-country="' + country + '"]').addClass('active').show();
        });
        var init = $('#easy_process_country_select').val();
        $('.country-content[data-country="' + init + '"]').show();

        var frames = {};

        // Add new step
        $(document).on('click', '.easy_process_add', function(e){
            e.preventDefault();
            var country = $(this).data('country');
            var tpl = '<div class="easy_process_step" style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">' +
                        '<input type="hidden" name="easy_process_icon_id_' + country + '[]" class="easy_process_icon_id" value="">' +
                        '<div style="width:90px; text-align:center;">' +
                            '<img class="easy_process_preview" src="" style="max-width:70px; display:none; margin-bottom:6px;">' +
                            '<button type="button" class="button easy_process_upload">Upload</button>' +
                            '<button type="button" class="button easy_process_remove" style="display:none;">Remove</button>' +
                        '</div>' +
                        '<div style="flex:1;">' +
                            '<input type="text" name="easy_process_step_title_' + country + '[]" placeholder="Step Title" value="" style="width:100%;">' +
                        '</div>' +
                        '<button type="button" class="button easy_process_delete">Remove Step</button>' +
                      '</div>';
            $('#easy_process_steps_wrap_' + country).append(tpl);
        });

        // Delete step
        $(document).on('click', '.easy_process_delete', function(e){
            e.preventDefault();
            $(this).closest('.easy_process_step').remove();
        });

        // Upload icon
        $(document).on('click', '.easy_process_upload', function(e){
            e.preventDefault();
            var $btn = $(this);
            var $row = $btn.closest('.easy_process_step');

            if (!frames['process']) {
                frames['process'] = wp.media({
                    title: 'Select Step Icon',
                    button: { text: 'Use this Icon' },
                    multiple: false
                });

                frames['process'].on('select', function(){
                    var attachment = frames['process'].state().get('selection').first().toJSON();
                    $row.find('.easy_process_icon_id').val(attachment.id);
                    var src = (attachment.sizes && attachment.sizes.thumbnail) ? attachment.sizes.thumbnail.url : attachment.url;
                    $row.find('.easy_process_preview').attr('src', src).show();
                    $row.find('.easy_process_remove').show();
                    $btn.text('Change');
                });
            }

            frames['process'].open();
        });

        // Remove icon
        $(document).on('click', '.easy_process_remove', function(e){
            e.preventDefault();
            var $row = $(this).closest('.easy_process_step');
            $row.find('.easy_process_icon_id').val('');
            $row.find('.easy_process_preview').hide().attr('src', '');
            $(this).hide();
            $row.find('.easy_process_upload').text('Upload');
        });
    });
    </script>
    <?php
}

/* Save Meta Box */
add_action( 'save_post', 'easy_process_save_meta' );
function easy_process_save_meta( $post_id ) {
    if ( ! isset( $_POST['easy_process_nonce'] ) || ! wp_verify_nonce( $_POST['easy_process_nonce'], 'easy_process_nonce_action' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    // Save country-specific values
    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post_id) : array('countries' => array('au' => array('name' => 'Australia'), 'usa' => array('name' => 'USA')));
    $countries = array_keys($country_data['countries']);
    
    foreach ( $countries as $code ) {
        // Title
        if ( isset( $_POST['easy_process_title_' . $code] ) ) {
            update_post_meta( $post_id, '_easy_process_title_' . $code, sanitize_text_field( wp_unslash( $_POST['easy_process_title_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_easy_process_title_' . $code );
        }

        // Description
        if ( isset( $_POST['easy_process_description_' . $code] ) ) {
            $desc = wp_kses_post( wp_unslash( $_POST['easy_process_description_' . $code] ) );
            update_post_meta( $post_id, '_easy_process_description_' . $code, $desc );
        } else {
            delete_post_meta( $post_id, '_easy_process_description_' . $code );
        }

        // Steps
        $icons  = isset( $_POST['easy_process_icon_id_' . $code] ) ? array_map( 'intval', wp_unslash( $_POST['easy_process_icon_id_' . $code] ) ) : [];
        $titles = isset( $_POST['easy_process_step_title_' . $code] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['easy_process_step_title_' . $code] ) ) : [];

        $steps = [];
        $count = max( count( $icons ), count( $titles ) );
        for ( $i = 0; $i < $count; $i++ ) {
            $id  = $icons[$i] ?? '';
            $ttl = $titles[$i] ?? '';
            if ( empty( $id ) && empty( $ttl ) ) continue;
            $steps[] = [ 'icon_id' => $id, 'title' => $ttl ];
        }

        if ( ! empty( $steps ) ) {
            update_post_meta( $post_id, '_easy_process_steps_' . $code, $steps );
        } else {
            delete_post_meta( $post_id, '_easy_process_steps_' . $code );
        }
    }
}