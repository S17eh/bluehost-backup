<?php

/* Add meta box */
add_action( 'add_meta_boxes', 'team_meta_add_metabox' );
function team_meta_add_metabox() {
    $screen = get_current_screen();
    if ( ! $screen || $screen->id !== 'page' ) return;

    // Optional: restrict to a page with slug "team"
    $team_post = get_page_by_path( 'expert-team' ); // uncomment & change slug if needed
    if ( ! $team_post ) return;
    if ( ! isset( $_GET['post'] ) || intval( $_GET['post'] ) !== intval( $team_post->ID ) ) return;

    add_meta_box(
        'team_members_box',
        'Team Members',
        'team_meta_render_box',
        'page',
        'normal',
        'high'
    );
}

/* 3) Render meta box */
function team_meta_render_box( $post ) {
    wp_nonce_field( 'team_meta_nonce_action', 'team_meta_nonce' );

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
        <label for="team_country_select">Select Country:</label>
        <select id="team_country_select" name="team_country_select" class="smart-country-selector">
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
        $members = get_post_meta( $post->ID, '_team_members_' . $code, true );
        $team_description = get_post_meta( $post->ID, '_team_description_' . $code, true );
        
        // Fallback to default values if country-specific not set
        if ( empty( $members ) ) $members = get_post_meta( $post->ID, '_team_members', true );
        if ( empty( $team_description ) ) $team_description = get_post_meta( $post->ID, '_team_description', true );
        
        if ( ! is_array( $members ) || empty( $members ) ) {
            $members = array( array( 'image_id' => '', 'name' => '', 'designation' => '' ) );
        }
    ?>
    <div class="country-content team-content <?php echo $code === $selected_country ? 'active' : ''; ?>" data-country="<?php echo esc_attr( $code ); ?>">
        <h3 style="margin-top: 0;"><?php echo esc_html( $name ); ?> Team Section</h3>
        <p>
            <label for="team-description-<?php echo esc_attr( $code ); ?>"><strong>Team Description</strong></label><br>
            <?php
            $editor_id = 'team-description-' . $code;
            $settings = array(
                'textarea_name' => 'team_description_' . $code,
                'media_buttons' => true,
                'textarea_rows' => 6,
                'teeny' => false,
            );
            wp_editor( $team_description, $editor_id, $settings );
            ?>
        </p>
        <label for="team-description-<?php echo esc_attr( $code ); ?>"><strong>Team Details</strong></label><br>
        <div id="team_members_wrap_<?php echo esc_attr( $code ); ?>">
            <?php foreach ( $members as $m ) :
                $img_id = ! empty( $m['image_id'] ) ? intval( $m['image_id'] ) : '';
                $img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'thumbnail' ) : '';
                $name = isset( $m['name'] ) ? $m['name'] : '';
                $designation = isset( $m['designation'] ) ? $m['designation'] : '';
            ?>
            <div class="team_member_row" style="display:flex; gap:12px; align-items:center; border:1px solid #eee; padding:10px; margin:10px 0px;">
                <input type="hidden" name="team_image_id_<?php echo esc_attr( $code ); ?>[]" class="team_image_id" value="<?php echo esc_attr( $img_id ); ?>">

                <div style="width:110px; text-align:center;">
                    <img class="team_image_preview" src="<?php echo esc_url( $img_url ); ?>" style="max-width:90px; display:<?php echo $img_url ? 'block' : 'none'; ?>; margin-bottom:6px; border-radius:6px;">
                    <div>
                        <button type="button" class="button team_image_upload"><?php echo $img_url ? 'Change' : 'Upload'; ?></button>
                        <button type="button" class="button team_image_remove" style="display:<?php echo $img_url ? 'inline-block' : 'none'; ?>;">Remove</button>
                    </div>
                </div>

                <div style="flex:1; display:flex; gap:8px;">
                    <input type="text" name="team_member_name_<?php echo esc_attr( $code ); ?>[]" placeholder="Full name" value="<?php echo esc_attr( $name ); ?>" style="flex:0 0 40%; min-width:0;">
                    <input type="text" name="team_member_designation_<?php echo esc_attr( $code ); ?>[]" placeholder="Designation (e.g. Chartered Accountant)" value="<?php echo esc_attr( $designation ); ?>" style="flex:1; min-width:0;">
                </div>

                <div style="flex:0 0 110px; text-align:right;">
                    <button type="button" class="button team_member_remove">Remove</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <p><button type="button" class="button team_member_add" data-country="<?php echo esc_attr( $code ); ?>">Add Member</button></p>
    </div>
    <?php endforeach; ?>

    <script type="text/javascript">
    (function($){
        // Country dropdown switching
        $('.smart-country-selector').on('change', function() {
            var country = $(this).val();
            $('.team-content').removeClass('active').hide();
            $('.team-content[data-country="' + country + '"]').addClass('active').show();
        });
        
        var initialCountry = $('.smart-country-selector').val();
        $('.team-content').removeClass('active').hide();
        $('.team-content[data-country="' + initialCountry + '"]').addClass('active').show();

        var frames = {};

        function team_member_template(country) {
            return '<div class="team_member_row" style="display:flex; gap:12px; align-items:center; border:1px solid #eee; padding:10px; margin-bottom:10px;">' +
                    '<input type="hidden" name="team_image_id_' + country + '[]" class="team_image_id" value="">' +
                    '<div style="width:110px; text-align:center;">' +
                      '<img class="team_image_preview" src="" style="max-width:90px; display:none; margin-bottom:6px; border-radius:6px;">' +
                      '<div>' +
                        '<button type="button" class="button team_image_upload">Upload</button> ' +
                        '<button type="button" class="button team_image_remove" style="display:none;">Remove</button>' +
                      '</div>' +
                    '</div>' +
                    '<div style="flex:1; display:flex; gap:8px;">' +
                      '<input type="text" name="team_member_name_' + country + '[]" placeholder="Full name" value="" style="flex:0 0 40%; min-width:0;">' +
                      '<input type="text" name="team_member_designation_' + country + '[]" placeholder="Designation (e.g. Chartered Accountant)" value="" style="flex:1; min-width:0;">' +
                    '</div>' +
                    '<div style="flex:0 0 110px; text-align:right;">' +
                      '<button type="button" class="button team_member_remove">Remove</button>' +
                    '</div>' +
                   '</div>';
        }

        // add
        $(document).on('click', '.team_member_add', function(e){
            e.preventDefault();
            var country = $(this).data('country');
            $('#team_members_wrap_' + country).append(team_member_template(country));
        });

        // remove row
        $(document).on('click', '.team_member_remove', function(e){
            e.preventDefault();
            $(this).closest('.team_member_row').remove();
        });

        // upload image
        $(document).on('click', '.team_image_upload', function(e){
            e.preventDefault();
            var $btn = $(this);
            var $row = $btn.closest('.team_member_row');

            if (!frames['team']) {
                frames['team'] = wp.media({
                    title: 'Select Portrait',
                    button: { text: 'Use this image' },
                    multiple: false
                });

                frames['team'].on('select', function(){
                    var attachment = frames['team'].state().get('selection').first().toJSON();
                    if ( attachment ) {
                        $row.find('.team_image_id').val( attachment.id );
                        var src = (attachment.sizes && attachment.sizes.thumbnail) ? attachment.sizes.thumbnail.url : attachment.url;
                        $row.find('.team_image_preview').attr('src', src).show();
                        $row.find('.team_image_remove').show();
                        $btn.text('Change');
                    }
                });
            }

            frames['team'].open();
        });

        // remove image
        $(document).on('click', '.team_image_remove', function(e){
            e.preventDefault();
            var $row = $(this).closest('.team_member_row');
            $row.find('.team_image_id').val('');
            $row.find('.team_image_preview').hide().attr('src','');
            $(this).hide();
            $row.find('.team_image_upload').text('Upload');
        });

    })(jQuery);
    </script>

    <style>
        .team_member_row input[type="text"] { box-sizing:border-box; }
    </style>

    <?php
}

/* 4) Save meta */
add_action( 'save_post', 'team_meta_save' );
function team_meta_save( $post_id ) {
    if ( ! isset( $_POST['team_meta_nonce'] ) ) {
        // if no nonce present bail (prevents accidental save)
    } else {
        if ( ! wp_verify_nonce( $_POST['team_meta_nonce'], 'team_meta_nonce_action' ) ) return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    // Save country-specific values
    $country_data = function_exists('smart_get_page_countries') ? smart_get_page_countries($post_id) : array('countries' => array('au' => array('name' => 'Australia'), 'usa' => array('name' => 'USA')));
    $countries = array_keys($country_data['countries']);
    
    foreach ( $countries as $code ) {
        if ( isset( $_POST['team_description_' . $code] ) ) {
            $desc = wp_kses_post( wp_unslash( $_POST['team_description_' . $code] ) );
            update_post_meta( $post_id, '_team_description_' . $code, $desc );
        } else {
            delete_post_meta( $post_id, '_team_description_' . $code );
        }

        $images = isset( $_POST['team_image_id_' . $code] ) ? array_map( 'intval', wp_unslash( (array) $_POST['team_image_id_' . $code] ) ) : array();
        $names  = isset( $_POST['team_member_name_' . $code] ) ? array_map( 'sanitize_text_field', wp_unslash( (array) $_POST['team_member_name_' . $code] ) ) : array();
        $design = isset( $_POST['team_member_designation_' . $code] ) ? array_map( 'sanitize_text_field', wp_unslash( (array) $_POST['team_member_designation_' . $code] ) ) : array();

        $members = array();
        $count = max( count( $images ), count( $names ), count( $design ) );
        for ( $i = 0; $i < $count; $i++ ) {
            $img = $images[$i] ?? '';
            $nm  = $names[$i] ?? '';
            $ds  = $design[$i] ?? '';
            if ( $img === '' && $nm === '' && $ds === '' ) continue;
            $members[] = array( 'image_id' => $img ? intval( $img ) : '', 'name' => $nm, 'designation' => $ds );
        }

        if ( ! empty( $members ) ) {
            update_post_meta( $post_id, '_team_members_' . $code, $members );
        } else {
            delete_post_meta( $post_id, '_team_members_' . $code );
        }
    }
}
