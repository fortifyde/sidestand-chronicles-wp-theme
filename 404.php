<?php get_header(); ?>

<main class="sc-main">
    <div class="sc-container">
        <header class="sc-archive__heading">
            <h1>
                <?php esc_html_e( 'Page not found', 'sidestand-chronicles' ); ?>
            </h1>
        </header>

        <p class="sc-no-results">
            <?php esc_html_e( 'The page you&#8217;re looking for doesn&#8217;t exist or has been moved.', 'sidestand-chronicles' ); ?>
        </p>

        <ul class="sc-splash__nav" style="margin-top:2rem">
            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php esc_html_e( 'Home', 'sidestand-chronicles' ); ?>
            </a></li>
            <?php
            $rider = get_page_by_path( 'the-rider' );
            $bike  = get_page_by_path( 'the-bike' );
            $road  = get_option( 'page_for_posts' );
            ?>
            <?php if ( $rider ) : ?>
                <li><a href="<?php echo esc_url( get_permalink( $rider ) ); ?>">
                    <?php esc_html_e( 'The Rider', 'sidestand-chronicles' ); ?>
                </a></li>
            <?php endif; ?>
            <?php if ( $bike ) : ?>
                <li><a href="<?php echo esc_url( get_permalink( $bike ) ); ?>">
                    <?php esc_html_e( 'The Bike', 'sidestand-chronicles' ); ?>
                </a></li>
            <?php endif; ?>
            <?php if ( $road ) : ?>
                <li><a href="<?php echo esc_url( get_permalink( $road ) ); ?>">
                    <?php esc_html_e( 'The Road', 'sidestand-chronicles' ); ?>
                </a></li>
            <?php endif; ?>
        </ul>
    </div>
</main>

<?php get_footer(); ?>
