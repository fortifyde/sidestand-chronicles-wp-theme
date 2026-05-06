<?php get_header(); ?>

<main class="sc-main">
    <div class="sc-container">
        <header class="sc-page-header">
            <h1 class="sc-page-header__label">
                <?php esc_html_e( 'The Road', 'sidestand-chronicles' ); ?>
            </h1>
        </header>

        <?php if ( have_posts() ) : ?>
            <ul class="sc-post-list">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/post-card' ); ?>
                <?php endwhile; ?>
            </ul>

            <?php
            $pagination = get_the_posts_pagination( [
                'prev_text' => __( '&larr; Earlier', 'sidestand-chronicles' ),
                'next_text' => __( 'Later &rarr;', 'sidestand-chronicles' ),
                'mid_size'  => 1,
            ] );
            if ( $pagination ) :
            ?>
                <nav class="sc-pagination" aria-label="<?php esc_attr_e( 'Posts pagination', 'sidestand-chronicles' ); ?>">
                    <?php echo $pagination; // phpcs:ignore WordPress.Security.EscapeOutput ?>
                </nav>
            <?php endif; ?>

        <?php else : ?>
            <p class="sc-no-results">
                <?php esc_html_e( 'No posts yet. The road is still ahead.', 'sidestand-chronicles' ); ?>
            </p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
