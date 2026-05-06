<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="sc-header">
    <div class="sc-header__inner">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sc-header__logo">
            <?php bloginfo( 'name' ); ?>
        </a>

        <button class="sc-nav__hamburger"
                aria-label="<?php esc_attr_e( 'Open menu', 'sidestand-chronicles' ); ?>"
                aria-expanded="false"
                aria-controls="sc-nav-mobile">
            &#9776;
        </button>

        <nav aria-label="<?php esc_attr_e( 'Primary navigation', 'sidestand-chronicles' ); ?>">
            <ul class="sc-nav" role="list">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'fallback_cb'    => 'sc_nav_fallback',
                ] );
                ?>
                <li>
                    <button class="sc-nav__search-btn"
                            aria-label="<?php esc_attr_e( 'Open search', 'sidestand-chronicles' ); ?>"
                            aria-expanded="false"
                            aria-controls="sc-search-overlay">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                             stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <circle cx="6.5" cy="6.5" r="4.5"/>
                            <line x1="10" y1="10" x2="14" y2="14"/>
                        </svg>
                        <span class="sr-only"><?php esc_html_e( 'Search', 'sidestand-chronicles' ); ?></span>
                    </button>
                </li>
            </ul>
        </nav>
    </div>

    <nav id="sc-nav-mobile" class="sc-nav--mobile" aria-label="<?php esc_attr_e( 'Mobile navigation', 'sidestand-chronicles' ); ?>">
        <ul>
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'fallback_cb'    => 'sc_nav_fallback',
            ] );
            ?>
            <li>
                <button class="sc-nav__search-btn"
                        aria-label="<?php esc_attr_e( 'Open search', 'sidestand-chronicles' ); ?>"
                        aria-expanded="false"
                        aria-controls="sc-search-overlay">
                    <?php esc_html_e( 'Search', 'sidestand-chronicles' ); ?>
                </button>
            </li>
        </ul>
    </nav>
</header>

<?php get_template_part( 'template-parts/search-overlay' ); ?>
