<?php
/**
 * Service Single Metaboxes - Without Country Tabs
 * Backup your original file before replacing
 */

add_action('add_meta_boxes', 'sc_service_add_metaboxes');
function sc_service_add_metaboxes()
{
    $post_type = 'services';
    add_meta_box('sc_hero_section', 'Hero Section', 'sc_hero_section_html', $post_type, 'normal', 'high');
    add_meta_box('sc_about_section', 'About Service Section', 'sc_about_section_html', $post_type, 'normal', 'high');
    add_meta_box('sc_solutions_section', 'Solutions Section (Accordion)', 'sc_solutions_section_html', $post_type, 'normal', 'high');
    add_meta_box('sc_industry_section', 'Industry Expertise Section', 'sc_industry_section_html', 'services', 'normal', 'high');
    add_meta_box('sc_outsource_section', 'Why Outsource Section', 'sc_outsource_section_html', $post_type, 'normal', 'high');
	    add_meta_box('sc_other_desc_section', 'Other Description Section', 'sc_other_desc_section_html', $post_type, 'normal', 'high');
    add_meta_box('sc_faq_section', 'FAQs Section', 'sc_faq_section_html', $post_type, 'normal', 'high');
}

function sc_hero_section_html($post)
{
    wp_nonce_field('sc_hero_nonce_action', 'sc_hero_nonce');
    
    $hero_title = get_post_meta($post->ID, '_sc_hero_title', true);
    $hero_desc  = get_post_meta($post->ID, '_sc_hero_desc', true);
    ?>
    <p>
        <label><strong>Hero Heading</strong></label><br>
        <input type="text" name="sc_hero_title" style="width:100%;" value="<?php echo esc_attr($hero_title); ?>">
    </p>
    <p>
        <label><strong>Hero Description</strong></label><br>
        <?php wp_editor($hero_desc, 'sc_hero_desc_editor', ['textarea_name' => 'sc_hero_desc', 'textarea_rows' => 5, 'media_buttons' => true]); ?>
    </p>
<?php
}
function sc_other_desc_section_html($post)
{
    wp_nonce_field('sc_other_desc_nonce_action', 'sc_other_desc_nonce');
    
    $other_title = get_post_meta($post->ID, '_sc_other_title', true);
    $other_desc = get_post_meta($post->ID, '_sc_other_desc', true);
    ?>
    <p>
        <label><strong>Section Title</strong></label><br>
        <input type="text" name="sc_other_title" style="width:100%;" value="<?php echo esc_attr($other_title); ?>">
    </p>
    <p>
        <label><strong>Description</strong></label><br>
        <?php wp_editor($other_desc, 'sc_other_desc_editor', ['textarea_name' => 'sc_other_desc', 'textarea_rows' => 8, 'media_buttons' => true]); ?>
    </p>
<?php
}
function sc_about_section_html($post)
{
    wp_nonce_field('sc_about_nonce_action', 'sc_about_nonce');
    
    $about_title = get_post_meta($post->ID, '_sc_about_title', true);
    $about_sub   = get_post_meta($post->ID, '_sc_about_sub', true);
    $about_text  = get_post_meta($post->ID, '_sc_about_text', true);
    ?>
    <p>
        <label><strong>Section Title</strong></label><br>
        <input type="text" name="sc_about_title" style="width:100%;" value="<?php echo esc_attr($about_title); ?>">
    </p>
    <p>
        <label><strong>Short Subtitle</strong></label><br>
        <input type="text" name="sc_about_sub" style="width:100%;" value="<?php echo esc_attr($about_sub); ?>">
    </p>
    <p>
        <label><strong>Description</strong></label><br>
        <?php wp_editor($about_text, 'sc_about_text_editor', ['textarea_name' => 'sc_about_text', 'textarea_rows' => 8, 'media_buttons' => true]); ?>
    </p>
<?php
}

function sc_solutions_section_html($post)
{
    wp_nonce_field('sc_solutions_nonce_action', 'sc_solutions_nonce');
    
    $section_title = get_post_meta($post->ID, '_sc_solutions_title', true);
    $section_intro = get_post_meta($post->ID, '_sc_solutions_intro', true);
    $solutions     = get_post_meta($post->ID, '_sc_solutions', true);
    
    if (! is_array($solutions)) $solutions = [];
    if (empty($solutions)) $solutions[] = ['title' => '', 'content' => ''];
    ?>
    <p>
        <label><strong>Section Title</strong></label><br>
        <input type="text" name="sc_solutions_title" style="width:100%;" value="<?php echo esc_attr($section_title); ?>">
    </p>
    <p>
        <label><strong>Intro Text (optional)</strong></label><br>
        <?php wp_editor($section_intro, 'sc_solutions_intro_editor', ['textarea_name' => 'sc_solutions_intro', 'textarea_rows' => 5, 'media_buttons' => true]); ?>
    </p>
    <hr>
    <h4>Accordion Items</h4>
    <div id="sc-solutions-wrapper">
        <?php foreach ($solutions as $index => $item) : ?>
            <div class="sc-solution-item" data-index="<?php echo esc_attr($index); ?>" style="border:1px solid #ddd;margin-bottom:10px;padding:10px;">
                <p>
                    <label><strong>Item Title</strong></label><br>
                    <input type="text" style="width:100%;" name="sc_solutions[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($item['title'] ?? ''); ?>">
                </p>
                <p>
                    <label><strong>Item Content</strong></label><br>
                    <?php wp_editor($item['content'] ?? '', 'sc_solutions_content_' . $index, ['textarea_name' => "sc_solutions[{$index}][content]", 'textarea_rows' => 5, 'media_buttons' => true]); ?>
                </p>
                <button type="button" class="button sc-remove-solution">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>
    <p><button type="button" class="button button-primary sc-add-solution">+ Add Item</button></p>
    <script>
    jQuery(document).ready(function($) {
        var solutionIndex = $('#sc-solutions-wrapper .sc-solution-item').length;
        $(document).on('click', '.sc-add-solution', function() {
            var html = '<div class="sc-solution-item" data-index="' + solutionIndex + '" style="border:1px solid #ddd;margin-bottom:10px;padding:10px;">' +
                '<p><label><strong>Item Title</strong></label><br><input type="text" style="width:100%;" name="sc_solutions[' + solutionIndex + '][title]" value=""></p>' +
                '<p><label><strong>Item Content</strong></label><br><textarea id="sc_solutions_content_' + solutionIndex + '" style="width:100%;height:80px;" name="sc_solutions[' + solutionIndex + '][content]"></textarea></p>' +
                '<button type="button" class="button sc-remove-solution">Remove</button></div>';
            $('#sc-solutions-wrapper').append(html);
            if (typeof wp !== 'undefined' && wp.editor) {
                wp.editor.initialize('sc_solutions_content_' + solutionIndex, {tinymce: {wpautop: true}, quicktags: true, mediaButtons: true});
            }
            solutionIndex++;
        });
        $(document).on('click', '.sc-remove-solution', function() {
            $(this).closest('.sc-solution-item').remove();
        });
    });
    </script>
<?php
}

function sc_industry_section_html($post)
{
    wp_nonce_field('sc_industry_nonce_action', 'sc_industry_nonce');
    
    $section_title = get_post_meta($post->ID, '_sc_industry_title', true);
    $industry_desc = get_post_meta($post->ID, '_sc_industry_desc', true);
    $items = get_post_meta($post->ID, '_sc_industry_items', true);
    
    if (! is_array($items)) $items = [];
    if (empty($items)) $items[] = ['icon' => '', 'title' => '', 'desc' => ''];
    ?>
    <p>
        <label><strong>Section Title</strong></label><br>
        <input type="text" name="sc_industry_title" style="width:100%;" value="<?php echo esc_attr($section_title); ?>">
    </p>
    <p>
        <label><strong>Industry Description</strong></label><br>
        <?php wp_editor($industry_desc, 'sc_industry_desc_editor', ['textarea_name' => 'sc_industry_desc', 'textarea_rows' => 5, 'media_buttons' => true]); ?>
    </p>
    <hr>
    <h4>Industry Cards</h4>
    <div id="sc-industry-wrapper">
        <?php foreach ($items as $index => $item) : 
            $icon_url = $item['icon'] ?? '';
            $has_icon = !empty($icon_url);
        ?>
            <div class="sc-industry-item" style="border:1px solid #ddd;margin-bottom:10px;padding:10px;">
                <p>
                    <label><strong>Icon</strong></label><br>
                    <img src="<?php echo esc_url($icon_url); ?>" class="industry-preview" style="max-width:60px;<?php echo $has_icon ? '' : 'display:none;'; ?>">
                    <input type="hidden" name="sc_industry_items[<?php echo esc_attr($index); ?>][icon]" class="industry-input" value="<?php echo esc_attr($icon_url); ?>">
                    <button type="button" class="button industry-upload-btn">Upload Icon</button>
                    <button type="button" class="button industry-remove-btn" style="<?php echo $has_icon ? '' : 'display:none;'; ?>">Remove</button>
                </p>
                <p>
                    <label><strong>Industry Title</strong></label><br>
                    <input type="text" style="width:100%;" name="sc_industry_items[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($item['title'] ?? ''); ?>">
                </p>
                <p>
                    <label><strong>Short Description</strong></label><br>
                    <textarea style="width:100%;height:60px;" name="sc_industry_items[<?php echo esc_attr($index); ?>][desc]"><?php echo esc_textarea($item['desc'] ?? ''); ?></textarea>
                </p>
                <button type="button" class="button sc-remove-industry">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>
    <p><button type="button" class="button button-primary sc-add-industry">+ Add Industry</button></p>
    <script>
    jQuery(document).ready(function($) {
        var industryIndex = $('#sc-industry-wrapper .sc-industry-item').length;
        $(document).on('click', '.sc-add-industry', function() {
            var html = '<div class="sc-industry-item" style="border:1px solid #ddd;margin-bottom:10px;padding:10px;">' +
                '<p><label><strong>Icon</strong></label><br><img src="" class="industry-preview" style="max-width:60px;display:none;">' +
                '<input type="hidden" name="sc_industry_items[' + industryIndex + '][icon]" class="industry-input" value="">' +
                '<button type="button" class="button industry-upload-btn">Upload Icon</button>' +
                '<button type="button" class="button industry-remove-btn" style="display:none;">Remove</button></p>' +
                '<p><label><strong>Industry Title</strong></label><br><input type="text" style="width:100%;" name="sc_industry_items[' + industryIndex + '][title]" value=""></p>' +
                '<p><label><strong>Short Description</strong></label><br><textarea style="width:100%;height:60px;" name="sc_industry_items[' + industryIndex + '][desc]"></textarea></p>' +
                '<button type="button" class="button sc-remove-industry">Remove</button></div>';
            $('#sc-industry-wrapper').append(html);
            industryIndex++;
        });
        $(document).on('click', '.sc-remove-industry', function() {
            $(this).closest('.sc-industry-item').remove();
        });
        $(document).on('click', '.industry-upload-btn', function(e) {
            e.preventDefault();
            var $btn = $(this), $wrapper = $btn.closest('p'), frame = wp.media({title: 'Select Icon', button: {text: 'Use this icon'}, multiple: false});
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $wrapper.find('.industry-input').val(attachment.url);
                $wrapper.find('.industry-preview').attr('src', attachment.url).show();
                $wrapper.find('.industry-remove-btn').show();
            });
            frame.open();
        });
        $(document).on('click', '.industry-remove-btn', function(e) {
            e.preventDefault();
            var $wrapper = $(this).closest('p');
            $wrapper.find('.industry-input').val('');
            $wrapper.find('.industry-preview').attr('src', '').hide();
            $(this).hide();
        });
    });
    </script>
<?php
}

function sc_outsource_section_html($post)
{
    wp_nonce_field('sc_out_nonce_action', 'sc_out_nonce');
    
    $out_title = get_post_meta($post->ID, '_sc_out_title', true);
	$out_desc  = get_post_meta($post->ID, '_sc_out_desc', true);
    $out_left  = get_post_meta($post->ID, '_sc_out_left', true);
    $out_right = get_post_meta($post->ID, '_sc_out_right', true);
    ?>
    <p>
        <label><strong>Section Title</strong></label><br>
        <input type="text" name="sc_out_title" style="width:100%;" value="<?php echo esc_attr($out_title); ?>">
    </p>
	 <p>
        <label><strong>Section Description</strong></label><br>
        <?php wp_editor($out_desc, 'sc_out_desc_editor', ['textarea_name' => 'sc_out_desc', 'textarea_rows' => 5, 'media_buttons' => true]); ?>
    </p>
    <p>
        <label><strong>Left Column Points</strong></label><br>
        <?php wp_editor($out_left, 'sc_out_left_editor', ['textarea_name' => 'sc_out_left', 'textarea_rows' => 8, 'media_buttons' => true]); ?>
    </p>
    <p>
        <label><strong>Right Column Points</strong></label><br>
        <?php wp_editor($out_right, 'sc_out_right_editor', ['textarea_name' => 'sc_out_right', 'textarea_rows' => 8, 'media_buttons' => true]); ?>
    </p>
<?php
}

function sc_faq_section_html($post)
{
    wp_nonce_field('sc_faq_nonce_action', 'sc_faq_nonce');
    
    $faq_title = get_post_meta($post->ID, '_sc_faq_title', true);
    $faq_desc = get_post_meta($post->ID, '_sc_faq_desc', true);
    $faqs = get_post_meta($post->ID, '_sc_faqs', true);
    
    if (! is_array($faqs)) $faqs = [];
    if (empty($faqs)) $faqs[] = ['question' => '', 'answer' => ''];
    ?>
    <p>
        <label><strong>Section Title</strong></label><br>
        <input type="text" name="sc_faq_title" style="width:100%;" value="<?php echo esc_attr($faq_title); ?>">
    </p>
     <p>
        <label><strong>FAQ Description</strong></label><br>
        <?php wp_editor($faq_desc, 'sc_faq_desc_editor', ['textarea_name' => 'sc_faq_desc', 'textarea_rows' => 5, 'media_buttons' => true]); ?>
    </p>
    <hr>
    <h4>FAQ Items</h4>
    <div id="sc-faq-wrapper">
        <?php foreach ($faqs as $index => $faq) : ?>
            <div class="sc-faq-item" data-index="<?php echo esc_attr($index); ?>" style="border:1px solid #ddd;margin-bottom:10px;padding:10px;">
                <p>
                    <label><strong>Question</strong></label><br>
                    <input type="text" style="width:100%;" name="sc_faqs[<?php echo esc_attr($index); ?>][question]" value="<?php echo esc_attr($faq['question'] ?? ''); ?>">
                </p>
                <p>
                    <label><strong>Answer</strong></label><br>
                    <?php wp_editor($faq['answer'] ?? '', 'sc_faq_answer_' . $index, ['textarea_name' => "sc_faqs[{$index}][answer]", 'textarea_rows' => 5, 'media_buttons' => true]); ?>
                </p>
                <button type="button" class="button sc-remove-faq">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>
    <p><button type="button" class="button button-primary sc-add-faq">+ Add FAQ</button></p>
    <script>
    jQuery(document).ready(function($) {
        var faqIndex = $('#sc-faq-wrapper .sc-faq-item').length;
        $(document).on('click', '.sc-add-faq', function() {
            var html = '<div class="sc-faq-item" data-index="' + faqIndex + '" style="border:1px solid #ddd;margin-bottom:10px;padding:10px;">' +
                '<p><label><strong>Question</strong></label><br><input type="text" style="width:100%;" name="sc_faqs[' + faqIndex + '][question]" value=""></p>' +
                '<p><label><strong>Answer</strong></label><br><textarea id="sc_faq_answer_' + faqIndex + '" style="width:100%;height:80px;" name="sc_faqs[' + faqIndex + '][answer]"></textarea></p>' +
                '<button type="button" class="button sc-remove-faq">Remove</button></div>';
            $('#sc-faq-wrapper').append(html);
            if (typeof wp !== 'undefined' && wp.editor) {
                wp.editor.initialize('sc_faq_answer_' + faqIndex, {tinymce: {wpautop: true}, quicktags: true, mediaButtons: true});
            }
            faqIndex++;
        });
        $(document).on('click', '.sc-remove-faq', function() {
            $(this).closest('.sc-faq-item').remove();
        });
    });
    </script>
<?php
}

add_action('save_post', 'sc_service_save_all_sections');
function sc_service_save_all_sections($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (! isset($_POST['post_type']) || $_POST['post_type'] !== 'services') return;
    if (! current_user_can('edit_post', $post_id)) return;

    // Hero
    if (isset($_POST['sc_hero_nonce']) && wp_verify_nonce($_POST['sc_hero_nonce'], 'sc_hero_nonce_action')) {
        update_post_meta($post_id, '_sc_hero_title', sanitize_text_field($_POST['sc_hero_title'] ?? ''));
        update_post_meta($post_id, '_sc_hero_desc', wp_kses_post($_POST['sc_hero_desc'] ?? ''));
    }
	
	// Other Description
    if (isset($_POST['sc_other_desc_nonce']) && wp_verify_nonce($_POST['sc_other_desc_nonce'], 'sc_other_desc_nonce_action')) {
        update_post_meta($post_id, '_sc_other_title', sanitize_text_field($_POST['sc_other_title'] ?? ''));
        update_post_meta($post_id, '_sc_other_desc', wp_kses_post($_POST['sc_other_desc'] ?? ''));
    }

    // About
    if (isset($_POST['sc_about_nonce']) && wp_verify_nonce($_POST['sc_about_nonce'], 'sc_about_nonce_action')) {
        update_post_meta($post_id, '_sc_about_title', sanitize_text_field($_POST['sc_about_title'] ?? ''));
        update_post_meta($post_id, '_sc_about_sub', sanitize_text_field($_POST['sc_about_sub'] ?? ''));
        update_post_meta($post_id, '_sc_about_text', wp_kses_post($_POST['sc_about_text'] ?? ''));
    }

    // Solutions
    if (isset($_POST['sc_solutions_nonce']) && wp_verify_nonce($_POST['sc_solutions_nonce'], 'sc_solutions_nonce_action')) {
        update_post_meta($post_id, '_sc_solutions_title', sanitize_text_field($_POST['sc_solutions_title'] ?? ''));
        update_post_meta($post_id, '_sc_solutions_intro', wp_kses_post($_POST['sc_solutions_intro'] ?? ''));
        
        $clean_solutions = [];
        if (isset($_POST['sc_solutions']) && is_array($_POST['sc_solutions'])) {
            foreach ($_POST['sc_solutions'] as $item) {
                if (!empty($item['title']) || !empty($item['content'])) {
                    $clean_solutions[] = ['title' => sanitize_text_field($item['title']), 'content' => wp_kses_post($item['content'])];
                }
            }
        }
        update_post_meta($post_id, '_sc_solutions', $clean_solutions);
    }

    // Industry
    if (isset($_POST['sc_industry_nonce']) && wp_verify_nonce($_POST['sc_industry_nonce'], 'sc_industry_nonce_action')) {
        update_post_meta($post_id, '_sc_industry_title', sanitize_text_field($_POST['sc_industry_title'] ?? ''));
        update_post_meta($post_id, '_sc_industry_desc', wp_kses_post($_POST['sc_industry_desc'] ?? ''));
        
        $clean_items = [];
        if (isset($_POST['sc_industry_items']) && is_array($_POST['sc_industry_items'])) {
            foreach ($_POST['sc_industry_items'] as $item) {
                if (!empty($item['icon']) || !empty($item['title']) || !empty($item['desc'])) {
                    $clean_items[] = ['icon' => esc_url_raw($item['icon']), 'title' => sanitize_text_field($item['title']), 'desc' => sanitize_textarea_field($item['desc'])];
                }
            }
        }
        update_post_meta($post_id, '_sc_industry_items', $clean_items);
    }

    // Outsource
    if (isset($_POST['sc_out_nonce']) && wp_verify_nonce($_POST['sc_out_nonce'], 'sc_out_nonce_action')) {
        update_post_meta($post_id, '_sc_out_title', sanitize_text_field($_POST['sc_out_title'] ?? ''));
		update_post_meta($post_id, '_sc_out_desc', wp_kses_post($_POST['sc_out_desc'] ?? ''));
        update_post_meta($post_id, '_sc_out_left', wp_kses_post($_POST['sc_out_left'] ?? ''));
        update_post_meta($post_id, '_sc_out_right', wp_kses_post($_POST['sc_out_right'] ?? ''));
    }

    // FAQ
    if (isset($_POST['sc_faq_nonce']) && wp_verify_nonce($_POST['sc_faq_nonce'], 'sc_faq_nonce_action')) {
        update_post_meta($post_id, '_sc_faq_title', sanitize_text_field($_POST['sc_faq_title'] ?? ''));
                update_post_meta($post_id, '_sc_faq_desc', wp_kses_post($_POST['sc_faq_desc'] ?? ''));

        
        $clean_faqs = [];
        if (isset($_POST['sc_faqs']) && is_array($_POST['sc_faqs'])) {
            foreach ($_POST['sc_faqs'] as $faq) {
                if (!empty($faq['question']) || !empty($faq['answer'])) {
                    $clean_faqs[] = ['question' => sanitize_text_field($faq['question']), 'answer' => wp_kses_post($faq['answer'])];
                }
            }
        }
        update_post_meta($post_id, '_sc_faqs', $clean_faqs);
    }
}