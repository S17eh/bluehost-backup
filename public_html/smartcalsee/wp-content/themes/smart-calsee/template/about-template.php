<?php
/**
 * Template Name: About us Page
 */

get_header();

// Get current page meta.
$post_id = get_the_ID();

// Use country-specific meta function if available
$smart_about_title       = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_smart_about_title' ) : get_post_meta( $post_id, '_smart_about_title', true );
$smart_about_description = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_smart_about_description' ) : get_post_meta( $post_id, '_smart_about_description', true );
$smart_about_stats       = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_smart_about_stats' ) : get_post_meta( $post_id, '_smart_about_stats', true );
$smart_about_buttons     = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_smart_about_buttons' ) : get_post_meta( $post_id, '_smart_about_buttons', true );

// Vision meta (country-specific).
$vision_title       = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_about_vision_title' ) : get_post_meta( $post_id, '_about_vision_title', true );
$vision_content     = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_about_vision_content' ) : get_post_meta( $post_id, '_about_vision_content', true );
$vision_img_id      = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_about_vision_image_id' ) : get_post_meta( $post_id, '_about_vision_image_id', true );
$vision_person_name = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_about_vision_person_name' ) : get_post_meta( $post_id, '_about_vision_person_name', true );
$vision_person_role = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_about_vision_person_role' ) : get_post_meta( $post_id, '_about_vision_person_role', true );

// Second Vision meta (Our Vision).
$our_vision_title = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_about_our_vision_title') : get_post_meta($post_id, '_about_our_vision_title', true);
$our_vision_subtitle = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_about_our_vision_subtitle') : get_post_meta($post_id, '_about_our_vision_subtitle', true);
$our_vision_content = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_about_our_vision_content') : get_post_meta($post_id, '_about_our_vision_content', true);
$our_vision_img_id = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_about_our_vision_image_id') : get_post_meta($post_id, '_about_our_vision_image_id', true);
$our_vision_person_name = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_about_our_vision_person_name') : get_post_meta($post_id, '_about_our_vision_person_name', true);
$our_vision_person_role = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_about_our_vision_person_role') : get_post_meta($post_id, '_about_our_vision_person_role', true);


// Image URL (fallback image if empty).
$vision_img_url = $vision_img_id ? wp_get_attachment_image_url( $vision_img_id, 'large' ) : '';

// About contact section (country-specific).
$about_home_title          = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_about_contact_title' ) : get_post_meta( $post_id, '_about_contact_title', true );
$about_conatct_description = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_about_contact_description' ) : get_post_meta( $post_id, '_about_contact_description', true );
$about_button_text         = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_about_contact_button_text' ) : get_post_meta( $post_id, '_about_contact_button_text', true );
$about_button_link         = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_about_contact_button_link' ) : get_post_meta( $post_id, '_about_contact_button_link', true );

// Process section (country-specific).
$easy_title = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_easy_process_title' ) : get_post_meta( $post_id, '_easy_process_title', true );
$easy_desc  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_easy_process_description' ) : get_post_meta( $post_id, '_easy_process_description', true );
$easy_steps = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_easy_process_steps' ) : get_post_meta( $post_id, '_easy_process_steps', true );

if ( ! is_array( $smart_about_stats ) ) {
	$smart_about_stats = array();
}
if ( ! is_array( $smart_about_buttons ) ) {
	$smart_about_buttons = array();
}

?>
<div class="container mb-4">
    <div class="why-choose-about-section px-lg-0 px-md-3 px-3 smart-banner-hero-section">
        <div class="row">
            <div class="col-12 details-container-wrapper about-section-container">
                <h1 class="about-title">
                    <?php echo esc_html($smart_about_title); ?>
                </h1>
                <p class="about-description"><?php echo nl2br(esc_html($smart_about_description)); ?></p>


            </div>
        </div>

        <!-- Statistics Blocks -->
        <div class="row">
            <div class="col-12">
                <div class="stats-about-container">

                    <?php foreach ($smart_about_stats as $stat) :
                        $num   = $stat['num'] ?? '';
                        $label = $stat['label'] ?? '';
                        if ($num === '' && $label === '') continue;
                    ?>
                        <div class="stat-about-block">
                            <div class="stat-about-number"><?php echo esc_html($num); ?></div>
                            <div class="stat-about-label"><?php echo nl2br(esc_html($label)); ?></div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-12">
                <div class="buttons-about-container">

                    <?php foreach ($smart_about_buttons as $btn) :
                        $text = $btn['text'] ?? '';
                        $link = $btn['link'] ?? '';
                        if ($text === '') continue;
                    ?>
                        <a class="oval-about-button" href="<?php echo esc_url($link); ?>">
                            <?php echo esc_html($text); ?>
                        </a>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($our_vision_title) || !empty($our_vision_content)): ?>
<section class="vision-section py-5 second-vision-section">
    <div class="container">
        <div class="row align-items-center g-4">

            <div class="col-12">

                <!-- Title -->
                <?php if (!empty($our_vision_title)): ?>
                    <h2 class="vision-title text-center" style="font-size: 38px;">
                        <?php echo esc_html($our_vision_title); ?>
                    </h2>
                <?php endif; ?>

                <!-- Subtitle -->
                <?php if (!empty($our_vision_subtitle)): ?>
                    <h3 class="vision-subtitle text-center"
                        style="font-size: clamp(20px, 4vw, 32px); color: #7CB342; margin-bottom: 15px;">
                        <?php echo esc_html($our_vision_subtitle); ?>
                    </h3>
                <?php endif; ?>

                <!-- Content with Read More -->
                <?php if (!empty($our_vision_content)): ?>
                    <div class="vision-copy text-center">

                        <div class="vision-text collapsed" id="visionText">
                            <?php echo wp_kses_post(wpautop($our_vision_content)); ?>
                        </div>

                        <button class="read-more-btn" id="readMoreBtn">
                            Read More
                        </button>

                    </div>
                <?php endif; ?>

            </div>

        </div>
    </div>
</section>
<?php endif; ?>


<section class="easy-process-section">
    <div class="container">

        <?php if ($easy_title) : ?>
            <h2 class="easy-process-title">
                <?php echo esc_html($easy_title); ?>
            </h2>
        <?php endif; ?>

        <?php if ($easy_desc) : ?>
            <p class="easy-process-subtitle">
                <?php echo nl2br(esc_html($easy_desc)); ?>
            </p>
        <?php endif; ?>

        <?php if (! empty($easy_steps)) : ?>
            <div class="easy-process-flow">
                <?php
                $total = count($easy_steps);
                $i     = 0;

                foreach ($easy_steps as $step) :
                    $i++;
                    $icon_id    = ! empty($step['icon_id']) ? intval($step['icon_id']) : 0;
                    $icon_url   = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';
                    $step_title = isset($step['title']) ? $step['title'] : '';

                    // skip empty rows
                    if (! $icon_url && $step_title === '') {
                        continue;
                    }
                ?>
                    <div class="easy-process-step">
                        <div class="easy-process-pill">
                            <?php if ($icon_url) : ?>
                                <span class="easy-step-icon">
                                    <img src="<?php echo esc_url($icon_url); ?>"
                                        alt="<?php echo esc_attr($step_title ?: 'Step icon'); ?>">
                                </span>
                            <?php endif; ?>

                            <?php if ($step_title) : ?>
                                <span class="easy-step-text">
                                    <?php echo esc_html($step_title); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($i < $total) : ?>
                        <div class="easy-process-arrow">
                            <img class="easy-arrow-img"
                                src="/wp-content/uploads/2025/11/Arrow.svg"
                                alt="process step arrow">
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<div class="container mb-4">
<div class="globe-section row px-lg-0 px-md-2 px-2 globe-about">
    <div class="col-12 col-lg-6">
        <div class="globel-about-container">
            <!-- <div id="chartdiv"></div> -->
        </div>
    </div>
    <div class="col-12 col-lg-6 details-container-wrapper">
        <div class="details-container">
            <h2 class="details-title"><?php echo esc_html($about_home_title); ?></h2>
            <p class="details-description"><?php echo nl2br(esc_html($about_conatct_description)); ?></p>
            <button class="contact-button"><a href="<?php echo esc_html($about_button_link); ?>" class="contact-btn-home"><?php echo esc_html($about_button_text); ?></a></button>
        </div>
    </div>
</div>
</div>

<?php get_footer(); ?>