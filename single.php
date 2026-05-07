<?php get_header(); ?>

<main class="sc-main">
    <div class="sc-container">
        <?php while ( have_posts() ) : the_post(); ?>

            <article <?php post_class( 'sc-single' ); ?>>
                <header class="sc-single__header">
                    <?php
                    $categories = get_the_category();
                    $category   = $categories ? $categories[0] : null;
                    ?>
                    <?php if ( $category ) : ?>
                        <a class="sc-single__category"
                           href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
                            <?php echo esc_html( $category->name ); ?>
                        </a>
                    <?php endif; ?>

                    <h1 class="sc-single__title"><?php echo esc_html( get_the_title() ); ?></h1>

                    <?php
                    $mileage = get_post_meta( get_the_ID(), 'sc_post_mileage', true );
                    ?>
                    <p class="sc-single__meta">
                        <time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
                            <?php echo esc_html( get_the_date( 'j F Y' ) ); ?>
                        </time>
                        <?php if ( $mileage ) : ?>
                            &nbsp;&middot;&nbsp;<?php echo esc_html( number_format( $mileage ) ); ?>&thinsp;km
                        <?php endif; ?>
                    </p>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="sc-single__featured-image">
                        <?php the_post_thumbnail( 'full' ); ?>
                    </div>
                <?php endif; ?>

                <div class="sc-single__content">
                    <?php the_content(); ?>
                </div>

                <?php
                $tags = get_the_tags();
                if ( $tags ) :
                    $tag_links = array_map( function ( $tag ) {
                        return '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">'
                            . esc_html( $tag->name ) . '</a>';
                    }, $tags );
                ?>
                    <footer class="sc-single__tags">
                        <?php esc_html_e( 'Tags:', 'sidestand-chronicles' ); ?>
                        <?php echo implode( ', ', $tag_links ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                    </footer>
                <?php endif; ?>
            </article>

            <?php if ( comments_open() || get_comments_number() ) : ?>
                <?php comments_template(); ?>
            <?php endif; ?>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
