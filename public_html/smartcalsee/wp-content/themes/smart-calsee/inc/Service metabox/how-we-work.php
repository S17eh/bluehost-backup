<?php

function hs_add_requirements_metabox() {   
    $screen = get_current_screen();
    if ( ! $screen || $screen->id !== 'page' ) {
        return;
    }

    if ( ! isset( $_GET['post'] ) ) {
        return;
    }

    // Get the page being edited
    $current_post_id = intval( $_GET['post'] );

    // Get the how-we-work page
    $target_page = get_page_by_path( 'how-we-work' );
    if ( ! $target_page ) {
        return;
    }

    // Show only when editing the how-we-work page
    if ( $current_post_id !== $target_page->ID ) {
        return;
    }

    // Add your meta boxes
    add_meta_box(
        'hs_requirements_metabox',
        __('Understanding Your Requirements Section', 'textdomain'),
        'hs_requirements_metabox_cb',
        'page',
        'normal',
        'high'
    );

    add_meta_box(
        'hs_onboarding_metabox',
        __('Onboarding & Setup Section', 'textdomain'),
        'hs_onboarding_metabox_cb',
        'page',
        'normal',
        'high'
    );

    add_meta_box(
        'hs_security_metabox',
        __('Data Security & Compliance Section', 'textdomain'),
        'hs_security_metabox_cb',
        'page',
        'normal',
        'high'
    );
	  add_meta_box(
        'hs_new_section_metabox',
        __('New Section', 'textdomain'),
        'hs_new_section_metabox_cb',
        'page',
        'normal',
        'high'
    );
    add_meta_box(
        'hs_reporting_metabox',
        __('Reporting & Delivery Section', 'textdomain'),
        'hs_reporting_metabox_cb',
        'page',
        'normal',
        'high'
    );

    add_meta_box(
        'hs_support_metabox',
        __('Ongoing Support & Process Improvement', 'textdomain'),
        'hs_support_metabox_cb',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'hs_add_requirements_metabox');


/*-------------------------------------
 * Section 1: Understanding Your Requirements
 *------------------------------------*/
function hs_requirements_metabox_cb($post)
{
    wp_nonce_field('hs_requirements_metabox_nonce', 'hs_requirements_metabox_nonce_field');
    wp_enqueue_media();

    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post->ID) : array('countries' => array('au' => array('name' => 'Australia', 'slug' => 'au'), 'usa' => array('name' => 'USA', 'slug' => 'usa')), 'selected' => 'au');
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
        <label for="hs_req_country_select">Select Country:</label>
        <select id="hs_req_country_select" name="hs_req_country_select" class="smart-country-selector">
            <?php foreach ($countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ( $countries as $code => $country ) : 
        $title = get_post_meta($post->ID, '_hs_req_title_' . $code, true);
        $content = get_post_meta($post->ID, '_hs_req_content_' . $code, true);
        $points = get_post_meta($post->ID, '_hs_req_points_' . $code, true);
        $image_id = get_post_meta($post->ID, '_hs_req_image_id_' . $code, true);
        
        if ( empty( $title ) ) $title = get_post_meta($post->ID, '_hs_req_title', true);
        if ( empty( $content ) ) $content = get_post_meta($post->ID, '_hs_req_content', true);
        if ( empty( $points ) ) $points = get_post_meta($post->ID, '_hs_req_points', true);
        if ( empty( $image_id ) ) $image_id = get_post_meta($post->ID, '_hs_req_image_id', true);
        
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';
    ?>
    <div class="country-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Requirements Section</h3>
        <div class="hs-req-wrap">
            <div class="hs-req-left">
                <div class="hs-field">
                    <label for="hs_req_title_<?php echo esc_attr( $code ); ?>">Section Title</label>
                    <input type="text" id="hs_req_title_<?php echo esc_attr( $code ); ?>" name="hs_req_title_<?php echo esc_attr( $code ); ?>" class="widefat"
                        value="<?php echo esc_attr($title); ?>">
                </div>

                <div class="hs-field">
                    <label for="hs_req_content_<?php echo esc_attr( $code ); ?>">Short Description</label>
                    <?php
                    $editor_id = 'hs_req_content_editor_' . $code;
                    wp_editor(
                        $content,
                        $editor_id,
                        array(
                            'textarea_name' => 'hs_req_content_' . $code,
                            'textarea_rows' => 5,
                            'media_buttons' => false,
                        )
                    );
                    ?>
                </div>

                <div class="hs-field">
                    <label for="hs_req_points_<?php echo esc_attr( $code ); ?>">Bullet Points (use list button)</label>
                    <?php
                    $editor_id = 'hs_req_points_editor_' . $code;
                    wp_editor(
                        $points,
                        $editor_id,
                        array(
                            'textarea_name' => 'hs_req_points_' . $code,
                            'textarea_rows' => 5,
                            'media_buttons' => false,
                        )
                    );
                    ?>
                </div>
            </div>

            <div class="hs-req-right">
                <label>Section Image</label>
                <div class="hs-req-image-preview">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="">
                    <?php endif; ?>
                </div>
                <input type="hidden" id="hs_req_image_id_<?php echo esc_attr( $code ); ?>" name="hs_req_image_id_<?php echo esc_attr( $code ); ?>"
                    value="<?php echo esc_attr($image_id); ?>">
                <div class="hs-req-image-buttons">
                    <button type="button" class="button hs-upload-req" data-country="<?php echo esc_attr( $code ); ?>">Upload / Choose Image</button>
                    <button type="button" class="button hs-remove-req" data-country="<?php echo esc_attr( $code ); ?>">Remove Image</button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

   <script>
jQuery(function($){
    $('#hs_req_country_select').on('change', function() {
        var country = $(this).val();
        $('.country-content').removeClass('active').hide();
        $('.country-content[data-country="' + country + '"]').addClass('active').show();
    });
    
    var initialCountry = $('#hs_req_country_select').val();
    $('.country-content').removeClass('active').hide();
    $('.country-content[data-country="' + initialCountry + '"]').addClass('active').show();

    var frames = {};

    $(document).on('click', '.hs-upload-req', function(e){
        e.preventDefault();
        var country = $(this).data('country');
        const $wrap = $(this).closest('.hs-req-wrap');

        if (!frames['req_' + country]) {
            frames['req_' + country] = wp.media({
                title: 'Select or Upload Image',
                button: { text: 'Use this image' },
                multiple: false
            });

            frames['req_' + country].on('select', function(){
                const attachment = frames['req_' + country].state().get('selection').first().toJSON();
                $wrap.find('#hs_req_image_id_' + country).val(attachment.id);
                $wrap.find('.hs-req-image-preview').html('<img src="'+attachment.url+'" />');
            });
        }

        frames['req_' + country].open();
    });

    $(document).on('click', '.hs-remove-req', function(){
        var country = $(this).data('country');
        const $wrap = $(this).closest('.hs-req-wrap');
        $wrap.find('#hs_req_image_id_' + country).val('');
        $wrap.find('.hs-req-image-preview').html('');
    });
});
</script>
<?php
}


/*-------------------------------------
 * Section 2: Onboarding & Setup
 *------------------------------------*/
function hs_onboarding_metabox_cb($post)
{
    wp_nonce_field('hs_onboarding_metabox_nonce', 'hs_onboarding_metabox_nonce_field');
    wp_enqueue_media();

    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post->ID) : array('countries' => array('au' => array('name' => 'Australia', 'slug' => 'au'), 'usa' => array('name' => 'USA', 'slug' => 'usa')), 'selected' => 'au');
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
        <label for="hs_onboarding_country_select">Select Country:</label>
        <select id="hs_onboarding_country_select" name="hs_onboarding_country_select" class="smart-country-selector">
            <?php foreach ($countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ( $countries as $code => $country ) : 
        $title = get_post_meta($post->ID, '_hs_onboarding_title_' . $code, true);
        $content = get_post_meta($post->ID, '_hs_onboarding_content_' . $code, true);
        $points = get_post_meta($post->ID, '_hs_onboarding_points_' . $code, true);
        $image_id = get_post_meta($post->ID, '_hs_onboarding_image_id_' . $code, true);
        
        if ( empty( $title ) ) $title = get_post_meta($post->ID, '_hs_onboarding_title', true);
        if ( empty( $content ) ) $content = get_post_meta($post->ID, '_hs_onboarding_content', true);
        if ( empty( $points ) ) $points = get_post_meta($post->ID, '_hs_onboarding_points', true);
        if ( empty( $image_id ) ) $image_id = get_post_meta($post->ID, '_hs_onboarding_image_id', true);
        
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';
    ?>
    <div class="country-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Onboarding Section</h3>
        <div class="hs-req-wrap">

        <div class="hs-req-left">

            <div class="hs-field">
                <label>Section Title</label>
                <input type="text" class="widefat" name="hs_onboarding_title_<?php echo esc_attr( $code ); ?>"
                    value="<?php echo esc_attr($title); ?>">
            </div>

            <div class="hs-field">
                <label>Short Description</label>
                <?php
                $editor_id = 'hs_onboarding_desc_editor_' . $code;
                wp_editor($content, $editor_id, [
                    'textarea_name' => 'hs_onboarding_content_' . $code,
                    'textarea_rows' => 5,
                    'media_buttons' => false
                ]);
                ?>
            </div>

            <div class="hs-field">
                <label>Bullet Points (use list formatting)</label>
                <?php
                $editor_id = 'hs_onboarding_points_editor_' . $code;
                wp_editor($points, $editor_id, [
                    'textarea_name' => 'hs_onboarding_points_' . $code,
                    'textarea_rows' => 5,
                    'media_buttons' => false
                ]);
                ?>
            </div>

        </div>

        <div class="hs-req-right">
            <label>Section Image</label>

            <div class="hs-req-image-preview">
                <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="">
                <?php endif; ?>
            </div>

            <input type="hidden" id="hs_onboarding_image_id_<?php echo esc_attr( $code ); ?>" name="hs_onboarding_image_id_<?php echo esc_attr( $code ); ?>"
                value="<?php echo esc_attr($image_id); ?>">

            <div class="hs-req-image-buttons">
                <button type="button" class="button hs-upload-onboarding" data-country="<?php echo esc_attr( $code ); ?>">Upload / Choose Image</button>
                <button type="button" class="button hs-remove-onboarding" data-country="<?php echo esc_attr( $code ); ?>">Remove Image</button>
            </div>
        </div>

    </div>
    </div>
    <?php endforeach; ?>

    <script>
jQuery(function($){
    $('#hs_onboarding_country_select').on('change', function() {
        var country = $(this).val();
        $('.country-content').removeClass('active').hide();
        $('.country-content[data-country="' + country + '"]').addClass('active').show();
    });
    
    var initialCountry = $('#hs_onboarding_country_select').val();
    $('.country-content').removeClass('active').hide();
    $('.country-content[data-country="' + initialCountry + '"]').addClass('active').show();

    var frames = {};

    $(document).on('click', '.hs-upload-onboarding', function(e){
        e.preventDefault();
        var country = $(this).data('country');
        const $wrap = $(this).closest('.hs-req-wrap');

        if (!frames['onboarding_' + country]) {
            frames['onboarding_' + country] = wp.media({
                title: 'Select or Upload Image',
                button: { text: 'Use this image' },
                multiple: false
            });

            frames['onboarding_' + country].on('select', function(){
                const attachment = frames['onboarding_' + country].state().get('selection').first().toJSON();
                $wrap.find('#hs_onboarding_image_id_' + country).val(attachment.id);
                $wrap.find('.hs-req-image-preview').html('<img src="'+attachment.url+'" />');
            });
        }

        frames['onboarding_' + country].open();
    });

    $(document).on('click', '.hs-remove-onboarding', function(){
        var country = $(this).data('country');
        const $wrap = $(this).closest('.hs-req-wrap');
        $wrap.find('#hs_onboarding_image_id_' + country).val('');
        $wrap.find('.hs-req-image-preview').html('');
    });
});
</script>

<?php
}


/*-------------------------------------
 * Section 3: Data Security & Compliance (repeater)
 *------------------------------------*/
function hs_security_metabox_cb($post)
{
    wp_nonce_field('hs_security_metabox_nonce', 'hs_security_metabox_nonce_field');
    wp_enqueue_media();

    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post->ID) : array('countries' => array('au' => array('name' => 'Australia', 'slug' => 'au'), 'usa' => array('name' => 'USA', 'slug' => 'usa')), 'selected' => 'au');
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
        <label for="hs_security_country_select">Select Country:</label>
        <select id="hs_security_country_select" name="hs_security_country_select" class="smart-country-selector">
            <?php foreach ($countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ( $countries as $code => $country ) : 
        // main fields
        $title = get_post_meta($post->ID, '_hs_sec_title_' . $code, true);
        $sub_title = get_post_meta($post->ID, '_hs_sec_sub_title_' . $code, true);
        $intro = get_post_meta($post->ID, '_hs_sec_intro_' . $code, true);
        $image_id = get_post_meta($post->ID, '_hs_sec_image_id_' . $code, true);
        
        if ( empty( $title ) ) $title = get_post_meta($post->ID, '_hs_sec_title', true);
        if ( empty( $sub_title ) ) $sub_title = get_post_meta($post->ID, '_hs_sec_sub_title', true);
        if ( empty( $intro ) ) $intro = get_post_meta($post->ID, '_hs_sec_intro', true);
        if ( empty( $image_id ) ) $image_id = get_post_meta($post->ID, '_hs_sec_image_id', true);
        
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';

        // repeater array
        $features = get_post_meta($post->ID, '_hs_security_features_' . $code, true);
        if ( empty( $features ) ) $features = get_post_meta($post->ID, '_hs_security_features', true);
        if (!is_array($features)) {
            $features = [];
        }
    ?>
    <div class="country-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Data Security & Compliance Section</h3>
        <div class="hs-sec-wrap">

        <div class="hs-sec-main">

            <div class="hs-field">
                <label>Section Title</label>
                <input type="text" class="widefat"
                    name="hs_sec_title_<?php echo esc_attr( $code ); ?>"
                    value="<?php echo esc_attr($title); ?>"
                    placeholder="Data Security & Compliance Protocols">
            </div>

            <div class="hs-field">
                <label>Sub Heading (green text)</label>
                <input type="text" class="widefat"
                    name="hs_sec_sub_title_<?php echo esc_attr( $code ); ?>"
                    value="<?php echo esc_attr($sub_title); ?>"
                    placeholder="Your Data, Protected Like a Vault — Every Second of the Day">
            </div>

            <div class="hs-field">
                <label>Intro Description</label>
                <?php
                $editor_id = 'hs_sec_intro_editor_' . $code;
                wp_editor(
                    $intro,
                    $editor_id,
                    [
                        'textarea_name' => 'hs_sec_intro_' . $code,
                        'textarea_rows' => 5,
                        'media_buttons' => false,
                    ]
                );
                ?>
            </div>

            <hr />

            <h3 style="margin-top:10px;">Feature Boxes</h3>
            <p style="margin-top:-5px;">Use "Add Feature Box" to add more items.</p>

            <div id="hs-feature-wrapper-<?php echo esc_attr( $code ); ?>">
                <?php foreach ($features as $index => $feature) : ?>
                    <div class="hs-feature-item">
                        <span class="hs-remove-feature" onclick="this.parentNode.remove()">✖</span>

                        <div class="hs-field">
                            <label>Feature Title</label>
                            <input type="text" class="widefat"
                                name="hs_security_features_<?php echo esc_attr( $code ); ?>[<?php echo esc_attr($index); ?>][title]"
                                value="<?php echo esc_attr($feature['title'] ?? ''); ?>">
                        </div>

                        <div class="hs-field">
                            <label>Bullet Points (use list in editor)</label>
                            <?php
                            $editor_id = 'hs_security_features_' . $code . '_' . $index;
                            wp_editor(
                                $feature['content'] ?? '',
                                $editor_id,
                                [
                                    'textarea_name' => 'hs_security_features_' . $code . '[' . $index . '][content]',
                                    'textarea_rows' => 4,
                                    'media_buttons' => false,
                                ]
                            );
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="button" class="button hs-add-feature-btn" data-country="<?php echo esc_attr( $code ); ?>">+ Add Feature Box</button>

        </div>

        <div class="hs-sec-image">
            <div class="hs-field">
                <label>Section Image</label>
                <div class="hs-req-image-preview">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="">
                    <?php endif; ?>
                </div>

                <input type="hidden" id="hs_sec_image_id_<?php echo esc_attr( $code ); ?>" name="hs_sec_image_id_<?php echo esc_attr( $code ); ?>"
                    value="<?php echo esc_attr($image_id); ?>">

                <div style="margin-top:10px;">
                    <button type="button" class="button hs-upload-security" data-country="<?php echo esc_attr( $code ); ?>">Upload / Choose Image</button>
                    <button type="button" class="button hs-remove-security" data-country="<?php echo esc_attr( $code ); ?>">Remove Image</button>
                </div>
            </div>
        </div>

    </div><!-- /.hs-sec-wrap -->
    </div>
    <?php endforeach; ?>

    <script>
        jQuery(function($) {
            $('#hs_security_country_select').on('change', function() {
                var country = $(this).val();
                $('.country-content').removeClass('active').hide();
                $('.country-content[data-country="' + country + '"]').addClass('active').show();
            });
            
            var initialCountry = $('#hs_security_country_select').val();
            $('.country-content').removeClass('active').hide();
            $('.country-content[data-country="' + initialCountry + '"]').addClass('active').show();

            var frames = {};
            var featureIndices = {};

            // media uploader for security image
            $(document).on('click', '.hs-upload-security', function(e) {
                e.preventDefault();
                var country = $(this).data('country');
                const $wrap = $(this).closest('.hs-sec-wrap');

                if (!frames['security_' + country]) {
                    frames['security_' + country] = wp.media({
                        title: 'Select or Upload Image',
                        button: {
                            text: 'Use this image'
                        },
                        multiple: false
                    });

                    frames['security_' + country].on('select', function() {
                        const attachment = frames['security_' + country].state().get('selection').first().toJSON();
                        $wrap.find('#hs_sec_image_id_' + country).val(attachment.id);
                        $wrap.find('.hs-req-image-preview').html('<img src="' + attachment.url + '" />');
                    });
                }

                frames['security_' + country].open();
            });

            $(document).on('click', '.hs-remove-security', function() {
                var country = $(this).data('country');
                const $wrap = $(this).closest('.hs-sec-wrap');
                $wrap.find('#hs_sec_image_id_' + country).val('');
                $wrap.find('.hs-req-image-preview').html('');
            });

            // repeater: add new feature box
            $(document).on('click', '.hs-add-feature-btn', function() {
                var country = $(this).data('country');
                if (!featureIndices[country]) {
                    featureIndices[country] = $('#hs-feature-wrapper-' + country + ' .hs-feature-item').length;
                }
                var index = featureIndices[country];
                const wrapper = $('#hs-feature-wrapper-' + country);

                const html = '<div class="hs-feature-item">' +
                    '<span class="hs-remove-feature" onclick="this.parentNode.remove()">✖</span>' +
                    '<div class="hs-field">' +
                    '<label>Feature Title</label>' +
                    '<input type="text" class="widefat" name="hs_security_features_' + country + '[' + index + '][title]">' +
                    '</div>' +
                    '<div class="hs-field">' +
                    '<label>Bullet Points (use list in editor)</label>' +
                    '<textarea id="hs_security_features_' + country + '_' + index + '" class="widefat" rows="4" name="hs_security_features_' + country + '[' + index + '][content]"></textarea>' +
                    '</div>' +
                    '</div>';

                wrapper.append(html);
                
                // Initialize wp_editor for the new textarea
                if (typeof wp !== 'undefined' && wp.editor) {
                    var editorId = 'hs_security_features_' + country + '_' + index;
                    wp.editor.initialize(editorId, {
                        tinymce: {
                            wpautop: true,
                            toolbar1: 'bold,italic,bullist,numlist,link,unlink,undo,redo',
                        },
                        quicktags: true,
                        mediaButtons: false
                    });
                }
                
                featureIndices[country]++;
            });
        });
    </script>

<?php
}
/*-------------------------------------
 * New Section (same design as Onboarding)
 *------------------------------------*/
function hs_new_section_metabox_cb($post)
{
    wp_nonce_field('hs_new_section_metabox_nonce', 'hs_new_section_metabox_nonce_field');
    wp_enqueue_media();

    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post->ID) : array('countries' => array('au' => array('name' => 'Australia', 'slug' => 'au'), 'usa' => array('name' => 'USA', 'slug' => 'usa')), 'selected' => 'au');
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
        <label for="hs_new_section_country_select">Select Country:</label>
        <select id="hs_new_section_country_select" name="hs_new_section_country_select" class="smart-country-selector">
            <?php foreach ($countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ( $countries as $code => $country ) : 
        $title = get_post_meta($post->ID, '_hs_new_section_title_' . $code, true);
        $content = get_post_meta($post->ID, '_hs_new_section_content_' . $code, true);
        $points = get_post_meta($post->ID, '_hs_new_section_points_' . $code, true);
        $image_id = get_post_meta($post->ID, '_hs_new_section_image_id_' . $code, true);
        
        if ( empty( $title ) ) $title = get_post_meta($post->ID, '_hs_new_section_title', true);
        if ( empty( $content ) ) $content = get_post_meta($post->ID, '_hs_new_section_content', true);
        if ( empty( $points ) ) $points = get_post_meta($post->ID, '_hs_new_section_points', true);
        if ( empty( $image_id ) ) $image_id = get_post_meta($post->ID, '_hs_new_section_image_id', true);
        
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';
    ?>
    <div class="country-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> New Section</h3>
        <div class="hs-req-wrap">

        <div class="hs-req-left">

            <div class="hs-field">
                <label>Section Title</label>
                <input type="text" class="widefat" name="hs_new_section_title_<?php echo esc_attr( $code ); ?>"
                    value="<?php echo esc_attr($title); ?>">
            </div>

            <div class="hs-field">
                <label>Short Description</label>
                <?php
                $editor_id = 'hs_new_section_desc_editor_' . $code;
                wp_editor($content, $editor_id, [
                    'textarea_name' => 'hs_new_section_content_' . $code,
                    'textarea_rows' => 5,
                    'media_buttons' => false
                ]);
                ?>
            </div>

            <div class="hs-field">
                <label>Bullet Points (use list formatting)</label>
                <?php
                $editor_id = 'hs_new_section_points_editor_' . $code;
                wp_editor($points, $editor_id, [
                    'textarea_name' => 'hs_new_section_points_' . $code,
                    'textarea_rows' => 5,
                    'media_buttons' => false
                ]);
                ?>
            </div>

        </div>

        <div class="hs-req-right">
            <label>Section Image</label>

            <div class="hs-req-image-preview">
                <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="">
                <?php endif; ?>
            </div>

            <input type="hidden" id="hs_new_section_image_id_<?php echo esc_attr( $code ); ?>" name="hs_new_section_image_id_<?php echo esc_attr( $code ); ?>"
                value="<?php echo esc_attr($image_id); ?>">

            <div class="hs-req-image-buttons">
                <button type="button" class="button hs-upload-new-section" data-country="<?php echo esc_attr( $code ); ?>">Upload / Choose Image</button>
                <button type="button" class="button hs-remove-new-section" data-country="<?php echo esc_attr( $code ); ?>">Remove Image</button>
            </div>
        </div>

    </div>
    </div>
    <?php endforeach; ?>

    <script>
jQuery(function($){
    $('#hs_new_section_country_select').on('change', function() {
        var country = $(this).val();
        $('.country-content').removeClass('active').hide();
        $('.country-content[data-country="' + country + '"]').addClass('active').show();
    });
    
    var initialCountry = $('#hs_new_section_country_select').val();
    $('.country-content').removeClass('active').hide();
    $('.country-content[data-country="' + initialCountry + '"]').addClass('active').show();

    var frames = {};

    $(document).on('click', '.hs-upload-new-section', function(e){
        e.preventDefault();
        var country = $(this).data('country');
        const $wrap = $(this).closest('.hs-req-wrap');

        if (!frames['new_section_' + country]) {
            frames['new_section_' + country] = wp.media({
                title: 'Select or Upload Image',
                button: { text: 'Use this image' },
                multiple: false
            });

            frames['new_section_' + country].on('select', function(){
                const attachment = frames['new_section_' + country].state().get('selection').first().toJSON();
                $wrap.find('#hs_new_section_image_id_' + country).val(attachment.id);
                $wrap.find('.hs-req-image-preview').html('<img src="'+attachment.url+'" />');
            });
        }

        frames['new_section_' + country].open();
    });

    $(document).on('click', '.hs-remove-new-section', function(){
        var country = $(this).data('country');
        const $wrap = $(this).closest('.hs-req-wrap');
        $wrap.find('#hs_new_section_image_id_' + country).val('');
        $wrap.find('.hs-req-image-preview').html('');
    });
});
</script>

<?php
}

function hs_reporting_metabox_cb($post)
{
    wp_nonce_field('hs_reporting_metabox_nonce', 'hs_reporting_metabox_nonce_field');
    wp_enqueue_media();

    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post->ID) : array('countries' => array('au' => array('name' => 'Australia', 'slug' => 'au'), 'usa' => array('name' => 'USA', 'slug' => 'usa')), 'selected' => 'au');
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
        <label for="hs_reporting_country_select">Select Country:</label>
        <select id="hs_reporting_country_select" name="hs_reporting_country_select" class="smart-country-selector">
            <?php foreach ($countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ( $countries as $code => $country ) : 
        $title = get_post_meta($post->ID, '_hs_reporting_title_' . $code, true);
        $content = get_post_meta($post->ID, '_hs_reporting_content_' . $code, true);
        $points = get_post_meta($post->ID, '_hs_reporting_points_' . $code, true);
        $image_id = get_post_meta($post->ID, '_hs_reporting_image_id_' . $code, true);
        
        if ( empty( $title ) ) $title = get_post_meta($post->ID, '_hs_reporting_title', true);
        if ( empty( $content ) ) $content = get_post_meta($post->ID, '_hs_reporting_content', true);
        if ( empty( $points ) ) $points = get_post_meta($post->ID, '_hs_reporting_points', true);
        if ( empty( $image_id ) ) $image_id = get_post_meta($post->ID, '_hs_reporting_image_id', true);
        
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';
    ?>
    <div class="country-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Reporting Section</h3>
    <div class="hs-req-wrap">

        <div class="hs-req-right">
            <label>Section Image</label>

            <div class="hs-req-image-preview">
                <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="">
                <?php endif; ?>
            </div>

            <input type="hidden" id="hs_reporting_image_id_<?php echo esc_attr( $code ); ?>" name="hs_reporting_image_id_<?php echo esc_attr( $code ); ?>"
                value="<?php echo esc_attr($image_id); ?>">

            <div class="hs-req-image-buttons">
                <button type="button" class="button hs-upload-reporting" data-country="<?php echo esc_attr( $code ); ?>">Upload / Choose Image</button>
                <button type="button" class="button hs-remove-reporting" data-country="<?php echo esc_attr( $code ); ?>">Remove Image</button>
            </div>
        </div>

        <div class="hs-req-left">

            <div class="hs-field">
                <label>Section Title</label>
                <input type="text" class="widefat" name="hs_reporting_title_<?php echo esc_attr( $code ); ?>"
                    value="<?php echo esc_attr($title); ?>"
                    placeholder="Reporting & Delivery">
            </div>

            <div class="hs-field">
                <label>Short Description</label>
                <?php
                $editor_id = 'hs_reporting_desc_editor_' . $code;
                wp_editor(
                    $content,
                    $editor_id,
                    [
                        'textarea_name' => 'hs_reporting_content_' . $code,
                        'textarea_rows' => 5,
                        'media_buttons' => false,
                    ]
                );
                ?>
            </div>

            <div class="hs-field">
                <label>Bullet Points (use list icon)</label>
                <?php
                $editor_id = 'hs_reporting_points_editor_' . $code;
                wp_editor(
                    $points,
                    $editor_id,
                    [
                        'textarea_name' => 'hs_reporting_points_' . $code,
                        'textarea_rows' => 4,
                        'media_buttons' => false,
                    ]
                );
                ?>
            </div>

        </div>

    </div>
    </div>
    <?php endforeach; ?>

  <script>
jQuery(function($){
    $('#hs_reporting_country_select').on('change', function() {
        var country = $(this).val();
        $('.country-content').removeClass('active').hide();
        $('.country-content[data-country="' + country + '"]').addClass('active').show();
    });
    
    var initialCountry = $('#hs_reporting_country_select').val();
    $('.country-content').removeClass('active').hide();
    $('.country-content[data-country="' + initialCountry + '"]').addClass('active').show();

    var frames = {};

    $(document).on('click', '.hs-upload-reporting', function(e){
        e.preventDefault();
        var country = $(this).data('country');
        const $wrap = $(this).closest('.hs-req-wrap');

        if (!frames['reporting_' + country]) {
            frames['reporting_' + country] = wp.media({
                title: 'Select or Upload Image',
                button: { text: 'Use this image' },
                multiple: false
            });

            frames['reporting_' + country].on('select', function(){
                const attachment = frames['reporting_' + country].state().get('selection').first().toJSON();
                $wrap.find('#hs_reporting_image_id_' + country).val(attachment.id);
                $wrap.find('.hs-req-image-preview').html('<img src="'+attachment.url+'" />');
            });
        }

        frames['reporting_' + country].open();
    });

    $(document).on('click', '.hs-remove-reporting', function(){
        var country = $(this).data('country');
        const $wrap = $(this).closest('.hs-req-wrap');
        $wrap.find('#hs_reporting_image_id_' + country).val('');
        $wrap.find('.hs-req-image-preview').html('');
    });

});
</script>

<?php
}

function hs_support_metabox_cb( $post ) {
    wp_nonce_field( 'hs_support_metabox_nonce', 'hs_support_metabox_nonce_field' );
    wp_enqueue_media();

    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post->ID) : array('countries' => array('au' => array('name' => 'Australia', 'slug' => 'au'), 'usa' => array('name' => 'USA', 'slug' => 'usa')), 'selected' => 'au');
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
        <label for="hs_support_country_select">Select Country:</label>
        <select id="hs_support_country_select" name="hs_support_country_select" class="smart-country-selector">
            <?php foreach ($countries as $code => $country) : ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach ( $countries as $code => $country ) : 
        $title = get_post_meta($post->ID, '_hs_support_title_' . $code, true);
        $content = get_post_meta($post->ID, '_hs_support_content_' . $code, true);
        $points = get_post_meta($post->ID, '_hs_support_points_' . $code, true);
        $image_id = get_post_meta($post->ID, '_hs_support_image_id_' . $code, true);
        
        if ( empty( $title ) ) $title = get_post_meta($post->ID, '_hs_support_title', true);
        if ( empty( $content ) ) $content = get_post_meta($post->ID, '_hs_support_content', true);
        if ( empty( $points ) ) $points = get_post_meta($post->ID, '_hs_support_points', true);
        if ( empty( $image_id ) ) $image_id = get_post_meta($post->ID, '_hs_support_image_id', true);
        
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';
    ?>
    <div class="country-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $country['name'] ); ?> Support Section</h3>
    <div class="hs-req-wrap">

        <div class="hs-req-left">

            <div class="hs-field">
                <label>Section Title</label>
                <input type="text" class="widefat" name="hs_support_title_<?php echo esc_attr( $code ); ?>"
                       value="<?php echo esc_attr( $title ); ?>"
                       placeholder="Ongoing Support & Process Improvement">
            </div>

            <div class="hs-field">
                <label>Short Description</label>
                <?php
                $editor_id = 'hs_support_content_editor_' . $code;
                wp_editor(
                    $content,
                    $editor_id,
                    [
                        'textarea_name' => 'hs_support_content_' . $code,
                        'textarea_rows' => 5,
                        'media_buttons' => false,
                    ]
                );
                ?>
            </div>

            <div class="hs-field">
                <label>Bullet Points (use list button)</label>
                <?php
                $editor_id = 'hs_support_points_editor_' . $code;
                wp_editor(
                    $points,
                    $editor_id,
                    [
                        'textarea_name' => 'hs_support_points_' . $code,
                        'textarea_rows' => 4,
                        'media_buttons' => false,
                    ]
                );
                ?>
            </div>

        </div>

        <div class="hs-req-right">
            <label>Section Image</label>

            <div class="hs-req-image-preview">
                <?php if ( $image_url ) : ?>
                    <img src="<?php echo esc_url( $image_url ); ?>" alt="">
                <?php endif; ?>
            </div>

            <input type="hidden" id="hs_support_image_id_<?php echo esc_attr( $code ); ?>" name="hs_support_image_id_<?php echo esc_attr( $code ); ?>"
                   value="<?php echo esc_attr( $image_id ); ?>">

            <div class="hs-req-image-buttons">
                <button type="button" class="button hs-upload-support" data-country="<?php echo esc_attr( $code ); ?>">Upload / Choose Image</button>
                <button type="button" class="button hs-remove-support" data-country="<?php echo esc_attr( $code ); ?>">Remove Image</button>
            </div>
        </div>

    </div>
    </div>
    <?php endforeach; ?>

  <script>
jQuery(function($){
    $('#hs_support_country_select').on('change', function() {
        var country = $(this).val();
        $('.country-content').removeClass('active').hide();
        $('.country-content[data-country="' + country + '"]').addClass('active').show();
    });
    
    var initialCountry = $('#hs_support_country_select').val();
    $('.country-content').removeClass('active').hide();
    $('.country-content[data-country="' + initialCountry + '"]').addClass('active').show();

    var frames = {};

    $(document).on('click', '.hs-upload-support', function(e){
        e.preventDefault();
        var country = $(this).data('country');
        const $wrap = $(this).closest('.hs-req-wrap');

        if (!frames['support_' + country]) {
            frames['support_' + country] = wp.media({
                title: 'Select or Upload Image',
                button: { text: 'Use this image' },
                multiple: false
            });

            frames['support_' + country].on('select', function(){
                const attachment = frames['support_' + country].state().get('selection').first().toJSON();
                $wrap.find('#hs_support_image_id_' + country).val(attachment.id);
                $wrap.find('.hs-req-image-preview').html('<img src="'+attachment.url+'" />');
            });
        }

        frames['support_' + country].open();
    });

    $(document).on('click', '.hs-remove-support', function(){
        var country = $(this).data('country');
        const $wrap = $(this).closest('.hs-req-wrap');
        $wrap.find('#hs_support_image_id_' + country).val('');
        $wrap.find('.hs-req-image-preview').html('');
    });
});
</script>

    <?php
}

/*-------------------------------------
 * Save all meta box data
 *------------------------------------*/
function hs_save_requirements_metabox($post_id)
{

    // At least one valid nonce must be present
    $valid_nonce = false;

    if (
        isset($_POST['hs_requirements_metabox_nonce_field']) &&
        wp_verify_nonce($_POST['hs_requirements_metabox_nonce_field'], 'hs_requirements_metabox_nonce')
    ) {
        $valid_nonce = true;
    }

    if (
        isset($_POST['hs_onboarding_metabox_nonce_field']) &&
        wp_verify_nonce($_POST['hs_onboarding_metabox_nonce_field'], 'hs_onboarding_metabox_nonce')
    ) {
        $valid_nonce = true;
    }

    if (
        isset($_POST['hs_security_metabox_nonce_field']) &&
        wp_verify_nonce($_POST['hs_security_metabox_nonce_field'], 'hs_security_metabox_nonce')
    ) {
        $valid_nonce = true;
    }
     if (
        isset($_POST['hs_new_section_metabox_nonce_field']) &&
        wp_verify_nonce($_POST['hs_new_section_metabox_nonce_field'], 'hs_new_section_metabox_nonce')
    ) {
        $valid_nonce = true;
    }
    if (
        isset($_POST['hs_reporting_metabox_nonce_field']) &&
        wp_verify_nonce($_POST['hs_reporting_metabox_nonce_field'], 'hs_reporting_metabox_nonce')
    ) {
        $valid_nonce = true;
    }
    if ( isset($_POST['hs_support_metabox_nonce_field']) &&
     wp_verify_nonce($_POST['hs_support_metabox_nonce_field'], 'hs_support_metabox_nonce') ) {
    $valid_nonce = true;
}    

    if (!$valid_nonce) {
        return;
    }

    // Autosave check
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Permissions
    if (isset($_POST['post_type']) && 'page' === $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    // Save country-specific values for all sections
    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post_id) : array('countries' => array('au' => array('slug' => 'au'), 'usa' => array('slug' => 'usa')));
    $countries = array_keys($country_data['countries']);
    
    foreach ( $countries as $code ) {
        /*--------- Section 1: Requirements ---------*/
        if (isset($_POST['hs_req_title_' . $code])) {
            update_post_meta($post_id, '_hs_req_title_' . $code, sanitize_text_field($_POST['hs_req_title_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_req_title_' . $code);
        }
        if (isset($_POST['hs_req_content_' . $code])) {
            update_post_meta($post_id, '_hs_req_content_' . $code, wp_kses_post($_POST['hs_req_content_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_req_content_' . $code);
        }
        if (isset($_POST['hs_req_points_' . $code])) {
            update_post_meta($post_id, '_hs_req_points_' . $code, wp_kses_post($_POST['hs_req_points_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_req_points_' . $code);
        }
        if (isset($_POST['hs_req_image_id_' . $code])) {
            update_post_meta($post_id, '_hs_req_image_id_' . $code, intval($_POST['hs_req_image_id_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_req_image_id_' . $code);
        }

        /*--------- Section 2: Onboarding ---------*/
        if (isset($_POST['hs_onboarding_title_' . $code])) {
            update_post_meta($post_id, '_hs_onboarding_title_' . $code, sanitize_text_field($_POST['hs_onboarding_title_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_onboarding_title_' . $code);
        }
        if (isset($_POST['hs_onboarding_content_' . $code])) {
            update_post_meta($post_id, '_hs_onboarding_content_' . $code, wp_kses_post($_POST['hs_onboarding_content_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_onboarding_content_' . $code);
        }
        if (isset($_POST['hs_onboarding_points_' . $code])) {
            update_post_meta($post_id, '_hs_onboarding_points_' . $code, wp_kses_post($_POST['hs_onboarding_points_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_onboarding_points_' . $code);
        }
        if (isset($_POST['hs_onboarding_image_id_' . $code])) {
            update_post_meta($post_id, '_hs_onboarding_image_id_' . $code, intval($_POST['hs_onboarding_image_id_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_onboarding_image_id_' . $code);
        }

        /*--------- Section 3: Security ---------*/
        $sec_title = isset($_POST['hs_sec_title_' . $code]) ? sanitize_text_field($_POST['hs_sec_title_' . $code]) : '';
        $sec_sub_title = isset($_POST['hs_sec_sub_title_' . $code]) ? sanitize_text_field($_POST['hs_sec_sub_title_' . $code]) : '';
        $sec_intro = isset($_POST['hs_sec_intro_' . $code]) ? wp_kses_post($_POST['hs_sec_intro_' . $code]) : '';
        $sec_image_id = isset($_POST['hs_sec_image_id_' . $code]) ? intval($_POST['hs_sec_image_id_' . $code]) : '';

        if ( ! empty( $sec_title ) || ! empty( $sec_sub_title ) || ! empty( $sec_intro ) || ! empty( $sec_image_id ) ) {
            update_post_meta($post_id, '_hs_sec_title_' . $code, $sec_title);
            update_post_meta($post_id, '_hs_sec_sub_title_' . $code, $sec_sub_title);
            update_post_meta($post_id, '_hs_sec_intro_' . $code, $sec_intro);
            update_post_meta($post_id, '_hs_sec_image_id_' . $code, $sec_image_id);
        } else {
            delete_post_meta($post_id, '_hs_sec_title_' . $code);
            delete_post_meta($post_id, '_hs_sec_sub_title_' . $code);
            delete_post_meta($post_id, '_hs_sec_intro_' . $code);
            delete_post_meta($post_id, '_hs_sec_image_id_' . $code);
        }

        /*--------- Section 3 repeater: Security Features ---------*/
        if (isset($_POST['hs_security_features_' . $code]) && is_array($_POST['hs_security_features_' . $code])) {
            $clean = [];
            foreach ($_POST['hs_security_features_' . $code] as $feature) {
                if (empty($feature['title']) && empty($feature['content'])) {
                    continue;
                }
                $clean[] = [
                    'title'   => sanitize_text_field($feature['title'] ?? ''),
                    'content' => wp_kses_post($feature['content'] ?? ''),
                ];
            }
            if ( ! empty( $clean ) ) {
                update_post_meta($post_id, '_hs_security_features_' . $code, $clean);
            } else {
                delete_post_meta($post_id, '_hs_security_features_' . $code);
            }
        } else {
            delete_post_meta($post_id, '_hs_security_features_' . $code);
        }
        
          /*--------- New Section ---------*/
        if (isset($_POST['hs_new_section_title_' . $code])) {
            update_post_meta($post_id, '_hs_new_section_title_' . $code, sanitize_text_field($_POST['hs_new_section_title_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_new_section_title_' . $code);
        }
        if (isset($_POST['hs_new_section_content_' . $code])) {
            update_post_meta($post_id, '_hs_new_section_content_' . $code, wp_kses_post($_POST['hs_new_section_content_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_new_section_content_' . $code);
        }
        if (isset($_POST['hs_new_section_points_' . $code])) {
            update_post_meta($post_id, '_hs_new_section_points_' . $code, wp_kses_post($_POST['hs_new_section_points_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_new_section_points_' . $code);
        }
        if (isset($_POST['hs_new_section_image_id_' . $code])) {
            update_post_meta($post_id, '_hs_new_section_image_id_' . $code, intval($_POST['hs_new_section_image_id_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_new_section_image_id_' . $code);
        }

        /*--------- Section 4: Reporting ---------*/
        if (isset($_POST['hs_reporting_title_' . $code])) {
            update_post_meta($post_id, '_hs_reporting_title_' . $code, sanitize_text_field($_POST['hs_reporting_title_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_reporting_title_' . $code);
        }
        if (isset($_POST['hs_reporting_content_' . $code])) {
            update_post_meta($post_id, '_hs_reporting_content_' . $code, wp_kses_post($_POST['hs_reporting_content_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_reporting_content_' . $code);
        }
        if (isset($_POST['hs_reporting_points_' . $code])) {
            update_post_meta($post_id, '_hs_reporting_points_' . $code, wp_kses_post($_POST['hs_reporting_points_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_reporting_points_' . $code);
        }
        if (isset($_POST['hs_reporting_image_id_' . $code])) {
            update_post_meta($post_id, '_hs_reporting_image_id_' . $code, intval($_POST['hs_reporting_image_id_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_reporting_image_id_' . $code);
        }

        /*--------- Section 5: Support ---------*/
        if (isset($_POST['hs_support_title_' . $code])) {
            update_post_meta($post_id, '_hs_support_title_' . $code, sanitize_text_field($_POST['hs_support_title_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_support_title_' . $code);
        }
        if (isset($_POST['hs_support_content_' . $code])) {
            update_post_meta($post_id, '_hs_support_content_' . $code, wp_kses_post($_POST['hs_support_content_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_support_content_' . $code);
        }
        if (isset($_POST['hs_support_points_' . $code])) {
            update_post_meta($post_id, '_hs_support_points_' . $code, wp_kses_post($_POST['hs_support_points_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_support_points_' . $code);
        }
        if (isset($_POST['hs_support_image_id_' . $code])) {
            update_post_meta($post_id, '_hs_support_image_id_' . $code, intval($_POST['hs_support_image_id_' . $code]));
        } else {
            delete_post_meta($post_id, '_hs_support_image_id_' . $code);
        }
    }
}

add_action('save_post', 'hs_save_requirements_metabox');