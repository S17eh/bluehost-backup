<?php

/**
 * Dynamic footer.php
 */
?>
<footer id="colophon" class="site-footer">
    <div class="site-footer" aria-label="Site footer">
        <div class="footer-card container">
            <div class="row g-4 footer-card-col">

                <div class="col-12 col-lg-6">
                    <div class="footer-brand mb-2">
                        <?php
                        if (function_exists('the_custom_logo') && has_custom_logo()) {
                            the_custom_logo();
                        } else {
                            echo '<a class="site-title" href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>';
                        }
                        ?>
                    </div>

                    <p class="footer-desc mb-3">
                        <?php
                        echo wp_kses_post(get_theme_mod('footer_text', 'Smart Calsee offers cost-effective solutions with expert precision, ensuring hassle-free processes and accurate results. Partner with us for unmatched service quality and competitive pricing.'));
                        ?>
                    </p>

                    <div class="footer-social d-flex gap-2">
                        <?php
                        // if (is_active_sidebar('footer-social-link')) {
                        //     dynamic_sidebar('footer-social-link');
                        // }
                        ?>
                        <a aria-label="Facebook" href="#" class="social-btn" target="_blank" rel="noopener">
                            <img
                                src="<?php echo esc_url(content_url('/uploads/2025/11/facebook-logo.svg')); ?>"
                                width="24"
                                height="24"
                                alt="Facebook">
                        </a>
                        <a aria-label="Instagram" href="#" class="social-btn" target="_blank" rel="noopener">
                            <img
                                src="<?php echo esc_url(content_url('/uploads/2025/11/instagram-logo.svg')); ?>"
                                width="24"
                                height="24"
                                alt="Instagram"> </a>
                        <a aria-label="LinkedIn" href="#" class="social-btn" target="_blank" rel="noopener">
                            <img
                                src="<?php echo esc_url(content_url('/uploads/2025/11/linkdin-logo.svg')); ?>"
                                width="24"
                                height="24"
                                alt="LinkedIn"> </a>
                        <a aria-label="X" href="#" class="social-btn" target="_blank" rel="noopener">
                            <img
                                src="<?php echo esc_url(content_url('/uploads/2025/11/twitter-logo.svg')); ?>"
                                width="24"
                                height="24"
                                alt="X"> </a>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="footer-right d-flex flex-row flex-wrap gap-3">
                        <div class="footer-section">
                            <nav class="footer-menu" aria-label="Quick Links">
                                <h4 class="menu-title">Quick Links</h4>
                                <?php
                                if (has_nav_menu('footer')) {
                                    wp_nav_menu(array(
                                        'theme_location' => 'footer',
                                        'container'      => false,
                                        'menu_class'     => 'menu-list',
                                        'items_wrap'     => '<ul class="menu-list">%3$s</ul>',
                                        'depth'          => 1,
                                        'fallback_cb'    => false,
                                    ));
                                }
                                ?>
                            </nav>
                        </div>

                        <div class="footer-section">
                            <nav class="footer-menu" aria-label="Legal Links">
                                <h4 class="menu-title">Legal</h4>
                                <?php
                                if (has_nav_menu('legal')) {
                                    wp_nav_menu(array(
                                        'theme_location' => 'legal',
                                        'container'      => false,
                                        'menu_class'     => 'menu-list',
                                        'items_wrap'     => '<ul class="menu-list">%3$s</ul>',
                                        'depth'          => 1,
                                        'fallback_cb'    => false,
                                    ));
                                }
                                ?>
                            </nav>
                        </div>

                        <div class="footer-section">
                            <div class="footer-menu" aria-label="Contact Info">
                                <h4 class="menu-title">Contact Info</h4>
                                <?php
                                if (is_active_sidebar('footer-contact')) {
                                    dynamic_sidebar('footer-contact');
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="footer-bottom d-flex align-items-center justify-content-between mt-3">
                <?php
                if (is_active_sidebar('footer-copyright')) {
                    dynamic_sidebar('footer-copyright');
                }
                ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>

</html>