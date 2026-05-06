<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'sc-splash-page' ); ?>>
<?php wp_body_open(); ?>

<main class="sc-splash">
    <h1 class="sc-splash__title"><?php bloginfo( 'name' ); ?></h1>

    <?php $tagline = get_option( 'sc_splash_tagline' ); ?>
    <?php if ( $tagline ) : ?>
        <p class="sc-splash__tagline"><?php echo esc_html( $tagline ); ?></p>
    <?php endif; ?>

    <hr class="sc-splash__rule">

    <nav aria-label="<?php esc_attr_e( 'Main navigation', 'sidestand-chronicles' ); ?>">
        <ul class="sc-splash__nav">
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
    </nav>
</main>

<?php wp_footer(); ?>
</body>
</html>
