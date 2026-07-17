<?php
/**
 * ABOUT TIMELINE META BOX + FRONT-END SETUP
 */

/* Add meta box on About Us page only */
add_action( 'add_meta_boxes', 'about_timeline_add_metabox' );
function about_timeline_add_metabox() {
    $screen = get_current_screen();
    if ( ! $screen || $screen->id !== 'page' ) return;
    if ( ! isset( $_GET['post'] ) ) return;

    $about = get_page_by_path( 'about-us' ); // slug of About page
    if ( ! $about ) return;

    $about_id = intval( $about->ID );
    $current  = intval( $_GET['post'] );

    if ( $current !== $about_id ) return;

    add_meta_box(
        'about_timeline_box',
        'About Timeline',
        'about_timeline_render_box',
        'page',
        'normal',
        'high'
    );
}

/* Render meta box */
function about_timeline_render_box( $post ) {
    wp_nonce_field( 'about_timeline_nonce_action', 'about_timeline_nonce' );

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
        <select id="about_timeline_country_select">
            <?php foreach ($countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ( $countries as $code => $country ) : 
        // Load country-specific values
        $items = get_post_meta( $post->ID, '_about_timeline_items_' . $code, true );
        
        // Fallback to default values if country-specific not set
        if ( empty( $items ) ) $items = get_post_meta( $post->ID, '_about_timeline_items', true );
        
        if ( ! is_array( $items ) || empty( $items ) ) {
            $items = array( array( 'year' => '', 'headline' => '', 'description' => '' ) );
        }
    ?>
    <div class="country-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Timeline</h3>
        <div id="about_timeline_wrap_<?php echo esc_attr( $code ); ?>">
            <?php foreach ( $items as $i => $it ) :
                $year        = isset( $it['year'] ) ? $it['year'] : '';
                $headline    = isset( $it['headline'] ) ? $it['headline'] : '';
                $description = isset( $it['description'] ) ? $it['description'] : '';
            ?>
            <div class="about_timeline_item" style="border:1px solid #eee; padding:12px; margin-bottom:10px;">
                <div style="display:flex; gap:10px; align-items:flex-start;">
                    <div style="flex:0 0 100px;">
                        <label><strong>Year</strong></label><br>
                        <input type="text" name="about_timeline_year_<?php echo esc_attr( $code ); ?>[]" value="<?php echo esc_attr( $year ); ?>" style="width:100%;">
                    </div>

                    <div style="flex:1;">
                        <label><strong>Headline</strong></label><br>
                        <input type="text" name="about_timeline_headline_<?php echo esc_attr( $code ); ?>[]" value="<?php echo esc_attr( $headline ); ?>" style="width:100%;">

                        <label style="margin-top:8px; display:block;"><strong>Description</strong></label>
                        <textarea name="about_timeline_description_<?php echo esc_attr( $code ); ?>[]" rows="4" style="width:100%;"><?php echo esc_textarea( $description ); ?></textarea>
                    </div>

                    <div style="flex:0 0 85px; text-align:right;">
                        <button type="button" class="button about_timeline_remove">Remove</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <p><button type="button" class="button about_timeline_add" data-country="<?php echo esc_attr( $code ); ?>">Add Timeline Item</button></p>
    </div>
    <?php endforeach; ?>

    <script type="text/javascript">
    (function($){
        $('#about_timeline_country_select').on('change', function() {
            var country = $(this).val();
            $('.country-content').removeClass('active').hide();
            $('.country-content[data-country="' + country + '"]').addClass('active').show();
        });
        var init = $('#about_timeline_country_select').val();
        $('.country-content[data-country="' + init + '"]').show();

        // Add new item
        $(document).on('click', '.about_timeline_add', function(e){
            e.preventDefault();
            var country = $(this).data('country');
            var tpl = '<div class="about_timeline_item" style="border:1px solid #eee; padding:12px; margin-bottom:10px;">' +
                      '<div style="display:flex; gap:10px; align-items:flex-start;">' +
                        '<div style="flex:0 0 100px;">' +
                          '<label><strong>Year</strong></label><br>' +
                          '<input type="text" name="about_timeline_year_' + country + '[]" value="" style="width:100%;">' +
                        '</div>' +
                        '<div style="flex:1;">' +
                          '<label><strong>Headline</strong></label><br>' +
                          '<input type="text" name="about_timeline_headline_' + country + '[]" value="" style="width:100%;">' +
                          '<label style="margin-top:8px; display:block;"><strong>Description</strong></label>' +
                          '<textarea name="about_timeline_description_' + country + '[]" rows="4" style="width:100%;"></textarea>' +
                        '</div>' +
                        '<div style="flex:0 0 85px; text-align:right;">' +
                          '<button type="button" class="button about_timeline_remove">Remove</button>' +
                        '</div>' +
                      '</div>' +
                    '</div>';
            $('#about_timeline_wrap_' + country).append(tpl);
        });

        // Remove item
        $(document).on('click', '.about_timeline_remove', function(e){
            e.preventDefault();
            $(this).closest('.about_timeline_item').remove();
        });

    })(jQuery);
    </script>

    <?php
}

/* Save timeline meta */
add_action( 'save_post', 'about_timeline_save_meta' );
function about_timeline_save_meta( $post_id ) {
    // nonce check
    if ( ! isset( $_POST['about_timeline_nonce'] ) || ! wp_verify_nonce( $_POST['about_timeline_nonce'], 'about_timeline_nonce_action' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    // Save country-specific values
//     $countries = array( 'usa', 'au' );
   $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post_id) : array('countries' => array('au' => array('slug' => 'au'), 'usa' => array('slug' => 'usa')));
    $countries = array_keys($country_data['countries']);
    
    foreach ( $countries as $code ) {
        $years = isset( $_POST['about_timeline_year_' . $code] ) ? array_map( 'sanitize_text_field', wp_unslash( (array) $_POST['about_timeline_year_' . $code] ) ) : [];
        $heads = isset( $_POST['about_timeline_headline_' . $code] ) ? array_map( 'sanitize_text_field', wp_unslash( (array) $_POST['about_timeline_headline_' . $code] ) ) : [];
        $descs = isset( $_POST['about_timeline_description_' . $code] ) ? array_map( 'wp_kses_post', wp_unslash( (array) $_POST['about_timeline_description_' . $code] ) ) : [];

        $items = array();
        $count = max( count( $years ), count( $heads ), count( $descs ) );
        for ( $i = 0; $i < $count; $i++ ) {
            $y = $years[$i] ?? '';
            $h = $heads[$i] ?? '';
            $d = $descs[$i] ?? '';
            if ( $y === '' && $h === '' && $d === '' ) continue;
            $items[] = array( 'year' => $y, 'headline' => $h, 'description' => $d );
        }

        if ( ! empty( $items ) ) {
            update_post_meta( $post_id, '_about_timeline_items_' . $code, $items );
        } else {
            delete_post_meta( $post_id, '_about_timeline_items_' . $code );
        }
    }
}