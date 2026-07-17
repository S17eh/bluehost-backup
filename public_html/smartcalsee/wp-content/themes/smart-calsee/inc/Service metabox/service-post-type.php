<?php
/**
 * Register Services CPT + taxonomies
 */

add_action( 'init', 'smart_register_services_cpt', 0 );
function smart_register_services_cpt() {

    //  Services CPT 
    $labels = array(
        'name'                  => _x( 'Services', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Service', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Services', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Service', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Service', 'textdomain' ),
        'new_item'              => __( 'New Service', 'textdomain' ),
        'edit_item'             => __( 'Edit Service', 'textdomain' ),
        'view_item'             => __( 'View Service', 'textdomain' ),
        'all_items'             => __( 'All Services', 'textdomain' ),
        'search_items'          => __( 'Search Services', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Services:', 'textdomain' ),
        'not_found'             => __( 'No services found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No services found in Trash.', 'textdomain' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_menu'       => true,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-hammer', 
        'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes' ),
        'has_archive'        => false,
        'rewrite'            => array( 'slug' => 'services' ),
        'show_in_rest'       => true, 
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'publicly_queryable' => true,
    );

    register_post_type( 'services', $args );

    // service_category
    $cat_labels = array(
        'name' => _x( 'Service Categories', 'taxonomy general name', 'textdomain' ),
        'singular_name' => _x( 'Service Category', 'taxonomy singular name', 'textdomain' ),
        'search_items' => __( 'Search Categories', 'textdomain' ),
        'all_items' => __( 'All Categories', 'textdomain' ),
        'parent_item' => __( 'Parent Category', 'textdomain' ),
        'parent_item_colon' => __( 'Parent Category:', 'textdomain' ),
        'edit_item' => __( 'Edit Category', 'textdomain' ),
        'update_item' => __( 'Update Category', 'textdomain' ),
        'add_new_item' => __( 'Add New Category', 'textdomain' ),
        'new_item_name' => __( 'New Category Name', 'textdomain' ),
        'menu_name' => __( 'Categories', 'textdomain' ),
    );

    register_taxonomy( 'service_category', array( 'services' ), array(
        'hierarchical' => true,
        'labels' => $cat_labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'service-category' ),
    ) );

    // service_tag
    $tag_labels = array(
        'name' => _x( 'Service Tags', 'taxonomy general name', 'textdomain' ),
        'singular_name' => _x( 'Service Tag', 'taxonomy singular name', 'textdomain' ),
    );

    register_taxonomy( 'service_tag', 'services', array(
        'hierarchical' => false,
        'labels' => $tag_labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'service-tag' ),
    ) );
}

// === Category image upload for service_category ===
add_action( 'service_category_add_form_fields', 'simple_service_cat_add_field' );
add_action( 'service_category_edit_form_fields', 'simple_service_cat_edit_field', 10, 2 );

function simple_service_cat_add_field( $taxonomy ) {
    ?>
    <div class="form-field term-group">
        <label for="service-cat-image-id"><?php esc_html_e( 'Category image', 'smart-calsee' ); ?></label>
        <input type="hidden" id="service-cat-image-id" name="service_cat_image_id" value="">
        <div id="service-cat-image-preview" style="margin-top:8px;"></div>
        <p>
            <button class="button sc-upload-image"><?php esc_html_e( 'Upload/Add image', 'smart-calsee' ); ?></button>
            <button class="button sc-remove-image" style="display:none;"><?php esc_html_e( 'Remove image', 'smart-calsee' ); ?></button>
        </p>
    </div>
    <?php
}

function simple_service_cat_edit_field( $term, $taxonomy ) {
    $image_id = get_term_meta( $term->term_id, '_service_cat_image_id', true );
    $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : '';
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label><?php esc_html_e( 'Category image', 'smart-calsee' ); ?></label></th>
        <td>
            <input type="hidden" id="service-cat-image-id" name="service_cat_image_id" value="<?php echo esc_attr( $image_id ); ?>">
            <div id="service-cat-image-preview" style="margin-top:8px;">
                <?php if ( $image_url ) : ?>
                    <img src="<?php echo esc_url( $image_url ); ?>" style="max-width:120px;height:auto;">
                <?php endif; ?>
            </div>
            <p>
                <button class="button sc-upload-image"><?php esc_html_e( 'Upload/Add image', 'smart-calsee' ); ?></button>
                <button class="button sc-remove-image" <?php echo $image_url ? '' : 'style="display:none;"'; ?>><?php esc_html_e( 'Remove image', 'smart-calsee' ); ?></button>
            </p>
        </td>
    </tr>
    <?php
}

add_action( 'created_service_category', 'simple_service_cat_save' );
add_action( 'edited_service_category', 'simple_service_cat_save' );
function simple_service_cat_save( $term_id ) {
    if ( isset( $_POST['service_cat_image_id'] ) ) {
        $id = intval( $_POST['service_cat_image_id'] );
        if ( $id ) {
            update_term_meta( $term_id, '_service_cat_image_id', $id );
        } else {
            delete_term_meta( $term_id, '_service_cat_image_id' );
        }
    }
}

add_action( 'admin_enqueue_scripts', 'simple_service_cat_admin_scripts' );
function simple_service_cat_admin_scripts( $hook ) {
    if ( ! in_array( $hook, array( 'edit-tags.php', 'term.php' ), true ) ) return;

    $taxonomy = isset( $_GET['taxonomy'] ) ? sanitize_text_field( wp_unslash( $_GET['taxonomy'] ) ) : '';
    if ( 'service_category' !== $taxonomy ) return;

    wp_enqueue_media();
    wp_enqueue_script( 'jquery' );

    $js = <<<JS
jQuery(function($){
    var frame;
    $(document).on('click', '.sc-upload-image', function(e){
        e.preventDefault();
        var \$wrap = $(this).closest('tr, .form-field');
        var \$input = \$wrap.find('#service-cat-image-id');
        var \$preview = \$wrap.find('#service-cat-image-preview');
        var \$remove = \$wrap.find('.sc-remove-image');

        if ( frame ) { frame.open(); return; }

        frame = wp.media({
            title: 'Select or Upload Category Image',
            button: { text: 'Use this image' },
            library: { type: 'image' },
            multiple: false
        });

        frame.on('select', function(){
            var attach = frame.state().get('selection').first().toJSON();
            \$input.val(attach.id);
            var thumb = (attach.sizes && attach.sizes.thumbnail) ? attach.sizes.thumbnail.url : attach.url;
            \$preview.html('<img src="'+thumb+'" style="max-width:120px;height:auto;" />');
            \$remove.show();
        });

        frame.open();
    });

    $(document).on('click', '.sc-remove-image', function(e){
        e.preventDefault();
        var \$wrap = $(this).closest('tr, .form-field');
        \$wrap.find('#service-cat-image-id').val('');
        \$wrap.find('#service-cat-image-preview').html('');
        $(this).hide();
    });
});
JS;
    wp_add_inline_script( 'jquery', $js );
}

