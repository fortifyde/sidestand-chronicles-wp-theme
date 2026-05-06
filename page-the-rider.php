<?php get_header(); ?>

<main class="sc-main">
    <div class="sc-container">
        <header class="sc-page-header">
            <h1 class="sc-page-header__label">
                <?php esc_html_e( 'The Rider', 'sidestand-chronicles' ); ?>
            </h1>
        </header>

        <div class="sc-rider__content">
            <?php
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
            ?>
        </div>

    </div>
</main>

<?php get_footer(); ?>
