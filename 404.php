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
    </div>
</main>

<?php get_footer(); ?>
