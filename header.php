<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( ! is_front_page() ) : ?>
<header class="sc-header">
    <div class="sc-header__inner">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sc-header__logo">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <?php bloginfo( 'name' ); ?>
            <?php endif; ?>
        </a>

        <button class="sc-nav__hamburger"
                aria-label="<?php esc_attr_e( 'Open menu', 'sidestand-chronicles' ); ?>"
                aria-expanded="false"
                aria-controls="sc-nav-mobile">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
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
<?php endif; ?>
