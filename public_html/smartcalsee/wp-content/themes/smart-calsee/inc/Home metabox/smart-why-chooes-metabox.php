<?php
/**
 * Meta Box: Why Choose Section (with repeaters for stats + buttons)
 */

add_action( 'add_meta_boxes', 'smart_why_add_metabox' );
function smart_why_add_metabox() {
    $screen = get_current_screen();
    if ( ! $screen ) return;

    if ( $screen->id === 'page' && isset( $_GET['post'] ) ) {
        $homepage_id = get_option( 'page_on_front' );
        $current_post_id = intval( $_GET['post'] );

        // Only show on homepage edit screen
        if ( $current_post_id === intval( $homepage_id ) ) {
            add_meta_box(
                'smart_why_box',
                'Why Choose Section',
                'smart_why_render_box',
                'page',
                'normal',
                'high'
            );
        }
    }
}

/**
 * Render the meta box
 */
function smart_why_render_box( $post ) {
    wp_nonce_field( 'smart_why_nonce_action', 'smart_why_nonce' );

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
        <label for="smart_why_country_select">Select Country:</label>
        <select id="smart_why_country_select" name="smart_why_country_select" class="smart-country-selector">
            <?php foreach ($available_countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ($available_countries as $code => $country) : 
        // Load country-specific values
        $title = get_post_meta( $post->ID, '_smart_why_title_' . $code, true );
        $desc = get_post_meta( $post->ID, '_smart_why_description_' . $code, true );
        $stats = get_post_meta( $post->ID, '_smart_why_stats_' . $code, true );
        $buttons = get_post_meta( $post->ID, '_smart_why_buttons_' . $code, true );
        
        // Fallback to default values if country-specific not set
        if ( empty( $title ) ) $title = get_post_meta( $post->ID, '_smart_why_title', true );
        if ( empty( $desc ) ) $desc = get_post_meta( $post->ID, '_smart_why_description', true );
        if ( empty( $stats ) ) $stats = get_post_meta( $post->ID, '_smart_why_stats', true );
        if ( empty( $buttons ) ) $buttons = get_post_meta( $post->ID, '_smart_why_buttons', true );

        if ( ! is_array( $stats ) ) $stats = [];
        if ( ! is_array( $buttons ) ) $buttons = [];
    ?>
    <div class="country-content smart-why-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Why Choose Section</h3>

        <p>
            <label for="smart_why_title_<?php echo esc_attr( $code ); ?>"><strong>Why Choose Title</strong></label><br>
            <input type="text" name="smart_why_title_<?php echo esc_attr( $code ); ?>" id="smart_why_title_<?php echo esc_attr( $code ); ?>" value="<?php echo esc_attr( $title ); ?>" style="width:100%;">
        </p>

        <p>
            <label for="smart_why_description_<?php echo esc_attr( $code ); ?>"><strong>Why Choose Description</strong></label><br>
            <?php
            $editor_id = 'smart_why_description_' . $code;
            wp_editor( $desc, $editor_id, [
                'textarea_name' => 'smart_why_description_' . $code,
                'media_buttons' => false,
                'textarea_rows' => 6,
                'teeny' => false,
            ] );
            ?>
        </p>

        <hr>

        <!-- Stats Repeater -->
        <h4>Stats (Repeatable)</h4>
        <div id="smart_why_stats_wrap_<?php echo esc_attr( $code ); ?>">
            <?php
            if ( empty( $stats ) ) $stats = [ [ 'num' => '', 'label' => '' ] ];
            foreach ( $stats as $s ) :
                $num = isset( $s['num'] ) ? $s['num'] : '';
                $lbl = isset( $s['label'] ) ? $s['label'] : '';
            ?>
            <div class="smart_why_stat_row" style="display:flex; gap:8px; margin-bottom:8px;">
                <input type="text" name="smart_why_stats_num_<?php echo esc_attr( $code ); ?>[]" placeholder="Number (e.g. 10+)" value="<?php echo esc_attr( $num ); ?>" style="width:30%;">
                <input type="text" name="smart_why_stats_lbl_<?php echo esc_attr( $code ); ?>[]" placeholder="Label (e.g. Years of Expertise)" value="<?php echo esc_attr( $lbl ); ?>" style="width:60%;">
                <button type="button" class="button smart_why_remove_stat" style="width:8%;">Remove</button>
            </div>
            <?php endforeach; ?>
        </div>
        <p><button type="button" class="button smart_why_add_stat" data-country="<?php echo esc_attr( $code ); ?>">Add</button></p>

        <hr>

        <!-- Buttons Repeater -->
        <h4>Buttons (Repeatable)</h4>
        <div id="smart_why_buttons_wrap_<?php echo esc_attr( $code ); ?>">
            <?php
            if ( empty( $buttons ) ) $buttons = [ [ 'text' => '', 'link' => '' ] ];
            foreach ( $buttons as $b ) :
                $text = isset( $b['text'] ) ? $b['text'] : '';
                $link = isset( $b['link'] ) ? $b['link'] : '';
            ?>
            <div class="smart_why_button_row" style="display:flex; gap:8px; margin-bottom:8px;">
                <input type="text" name="smart_why_buttons_text_<?php echo esc_attr( $code ); ?>[]" placeholder="Button Text" value="<?php echo esc_attr( $text ); ?>" style="width:40%;">
                <input type="url"  name="smart_why_buttons_link_<?php echo esc_attr( $code ); ?>[]" placeholder="Button Link" value="<?php echo esc_attr( $link ); ?>" style="width:50%;">
                <button type="button" class="button smart_why_remove_button" style="width:8%;">Remove</button>
            </div>
            <?php endforeach; ?>
        </div>
        <p><button type="button" class="button smart_why_add_button" data-country="<?php echo esc_attr( $code ); ?>">Add</button></p>
    </div>
    <?php endforeach; ?>

    <script type="text/javascript">
    (function($){
        // Country dropdown switching
        $('.smart-country-selector').on('change', function() {
            var country = $(this).val();
            $('.smart-why-content').removeClass('active').hide();
            $('.smart-why-content[data-country="' + country + '"]').addClass('active').show();
        });
        
        var initialCountry = $('.smart-country-selector').val();
        $('.smart-why-content').removeClass('active').hide();
        $('.smart-why-content[data-country="' + initialCountry + '"]').addClass('active').show();
        
        // Add Stat
        $(document).on('click', '.smart_why_add_stat', function(e){
            e.preventDefault();
            var country = $(this).data('country');
            var tpl = '<div class="smart_why_stat_row" style="display:flex; gap:8px; margin-bottom:8px;">' +
                      '<input type="text" name="smart_why_stats_num_' + country + '[]" placeholder="Number (e.g. 10+)" value="" style="width:30%;">' +
                      '<input type="text" name="smart_why_stats_lbl_' + country + '[]" placeholder="Label (e.g. Years of Expertise)" value="" style="width:60%;">' +
                      '<button type="button" class="button smart_why_remove_stat" style="width:8%;">Remove</button>' +
                      '</div>';
            $('#smart_why_stats_wrap_' + country).append(tpl);
        });

        // Remove Stat
        $(document).on('click', '.smart_why_remove_stat', function(e){
            e.preventDefault();
            $(this).closest('.smart_why_stat_row').remove();
        });

        // Add Button
        $(document).on('click', '.smart_why_add_button', function(e){
            e.preventDefault();
            var country = $(this).data('country');
            var tpl = '<div class="smart_why_button_row" style="display:flex; gap:8px; margin-bottom:8px;">' +
                      '<input type="text" name="smart_why_buttons_text_' + country + '[]" placeholder="Button Text" value="" style="width:40%;">' +
                      '<input type="url"  name="smart_why_buttons_link_' + country + '[]" placeholder="Button Link" value="" style="width:50%;">' +
                      '<button type="button" class="button smart_why_remove_button" style="width:8%;">Remove</button>' +
                      '</div>';
            $('#smart_why_buttons_wrap_' + country).append(tpl);
        });

        // Remove Button
        $(document).on('click', '.smart_why_remove_button', function(e){
            e.preventDefault();
            $(this).closest('.smart_why_button_row').remove();
        });

    })(jQuery);
    </script>

    <?php
}

/**
 * Save meta box
 */
add_action( 'save_post', 'smart_why_save_meta' );
function smart_why_save_meta( $post_id ) {
    // Verify nonce
    if ( ! isset( $_POST['smart_why_nonce'] ) ||
         ! wp_verify_nonce( $_POST['smart_why_nonce'], 'smart_why_nonce_action' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    // Save country-specific values (dynamic from service_category)
    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post_id) : array('countries' => array('au' => array('slug' => 'au'), 'usa' => array('slug' => 'usa')));
    $countries = array_keys($country_data['countries']);
    
    foreach ( $countries as $code ) {
        // Title
        if ( isset( $_POST['smart_why_title_' . $code] ) ) {
            update_post_meta( $post_id, '_smart_why_title_' . $code, sanitize_text_field( wp_unslash( $_POST['smart_why_title_' . $code] ) ) );
        } else {
            delete_post_meta( $post_id, '_smart_why_title_' . $code );
        }

        // Description
        if ( isset( $_POST['smart_why_description_' . $code] ) ) {
            $desc = wp_kses_post( wp_unslash( $_POST['smart_why_description_' . $code] ) );
            update_post_meta( $post_id, '_smart_why_description_' . $code, $desc );
        } else {
            delete_post_meta( $post_id, '_smart_why_description_' . $code );
        }

        // Stats repeater
        $nums = isset( $_POST['smart_why_stats_num_' . $code] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['smart_why_stats_num_' . $code] ) ) : [];
        $lbls = isset( $_POST['smart_why_stats_lbl_' . $code] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['smart_why_stats_lbl_' . $code] ) ) : [];

        $stats = [];
        $count = max( count( $nums ), count( $lbls ) );
        for ( $i = 0; $i < $count; $i++ ) {
            $num = $nums[$i] ?? '';
            $lbl = $lbls[$i] ?? '';
            if ( $num === '' && $lbl === '' ) continue;
            $stats[] = [ 'num' => $num, 'label' => $lbl ];
        }
        if ( ! empty( $stats ) ) {
            update_post_meta( $post_id, '_smart_why_stats_' . $code, $stats );
        } else {
            delete_post_meta( $post_id, '_smart_why_stats_' . $code );
        }

        // Buttons repeater
        $texts = isset( $_POST['smart_why_buttons_text_' . $code] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['smart_why_buttons_text_' . $code] ) ) : [];
        $links = isset( $_POST['smart_why_buttons_link_' . $code] ) ? array_map( 'esc_url_raw', wp_unslash( $_POST['smart_why_buttons_link_' . $code] ) ) : [];

        $buttons = [];
        $countb = max( count( $texts ), count( $links ) );
        for ( $j = 0; $j < $countb; $j++ ) {
            $t = $texts[$j] ?? '';
            $l = $links[$j] ?? '';
            if ( $t === '' && $l === '' ) continue;
            $buttons[] = [ 'text' => $t, 'link' => $l ];
        }
        if ( ! empty( $buttons ) ) {
            update_post_meta( $post_id, '_smart_why_buttons_' . $code, $buttons );
        } else {
            delete_post_meta( $post_id, '_smart_why_buttons_' . $code );
        }
    }
}
