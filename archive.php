<?php get_header(); ?>

<main class="sc-main">
    <div class="sc-container">
        <header class="sc-archive__heading">
            <h1>
                <?php
                if ( is_category() ) {
                    echo esc_html__( 'Country: ', 'sidestand-chronicles' );
                    echo '<mark>' . esc_html( single_cat_title( '', false ) ) . '</mark>';
                } elseif ( is_tag() ) {
                    echo esc_html__( 'Tag: ', 'sidestand-chronicles' );
                    echo '<mark>' . esc_html( single_tag_title( '', false ) ) . '</mark>';
                } else {
                    echo esc_html( get_the_archive_title() );
                }
                ?>
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
                <nav class="sc-pagination" aria-label="<?php esc_attr_e( 'Archive pagination', 'sidestand-chronicles' ); ?>">
                    <?php echo $pagination; // phpcs:ignore WordPress.Security.EscapeOutput ?>
                </nav>
            <?php endif; ?>

        <?php else : ?>
            <p class="sc-no-results">
                <?php esc_html_e( 'No posts found.', 'sidestand-chronicles' ); ?>
            </p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
