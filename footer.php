<footer class="sc-footer">
    <div class="sc-footer__inner">
        <p class="sc-footer__follow-label">
            <?php esc_html_e( 'Follow the road', 'sidestand-chronicles' ); ?>
        </p>

        <div class="sc-footer__columns">
            <div class="sc-footer__subscribe">
                <?php
                if ( shortcode_exists( 'jetpack_subscription_form' ) ) {
                    echo do_shortcode( '[jetpack_subscription_form subscribe_text="" show_subscribers_total="false"]' );
                } else {
                    echo '<p style="font-size:0.8rem;font-style:italic;color:var(--muted)">'
                        . esc_html__( 'Email subscriptions powered by Jetpack — install and activate Jetpack, then enable the Subscriptions module.', 'sidestand-chronicles' )
                        . '</p>';
                }
                ?>
            </div>

            <?php
            $instagram = get_option( 'sc_instagram_url' );
            $youtube   = get_option( 'sc_youtube_url' );
            if ( $instagram || $youtube ) :
            ?>
                <div class="sc-footer__socials">
                    <ul class="sc-footer__social-links">
                        <?php if ( $instagram ) : ?>
                            <li>
                                <a href="<?php echo esc_url( $instagram ); ?>"
                                   target="_blank" rel="noopener noreferrer">
                                    <?php esc_html_e( 'Instagram', 'sidestand-chronicles' ); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( $youtube ) : ?>
                            <li>
                                <a href="<?php echo esc_url( $youtube ); ?>"
                                   target="_blank" rel="noopener noreferrer">
                                    <?php esc_html_e( 'YouTube', 'sidestand-chronicles' ); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <p class="sc-footer__copy">
            &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
            <?php bloginfo( 'name' ); ?>
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
