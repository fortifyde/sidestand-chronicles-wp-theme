<?php get_header(); ?>

<main class="sc-main">
    <div class="sc-container">
        <header class="sc-page-header">
            <h1 class="sc-page-header__label">
                <?php esc_html_e( 'The Bike', 'sidestand-chronicles' ); ?>
            </h1>
        </header>

        <section class="sc-bike__intro">
            <?php
            $intro       = get_option( 'sc_bike_intro' );
            $build_year  = get_option( 'sc_bike_build_year' );
            $mileage     = get_option( 'sc_bike_mileage' );
            $acquisition = get_option( 'sc_bike_acquisition' );
            ?>

            <?php if ( $intro ) : ?>
                <div class="sc-bike__intro-text">
                    <?php echo wp_kses( wpautop( $intro ), [ 'p' => [], 'br' => [] ] ); ?>
                </div>
            <?php endif; ?>

            <?php if ( $build_year || $mileage || $acquisition ) : ?>
                <dl class="sc-bike__specs">
                    <?php if ( $build_year ) : ?>
                        <div class="sc-bike__spec">
                            <dt class="sc-bike__spec-label"><?php esc_html_e( 'Year', 'sidestand-chronicles' ); ?></dt>
                            <dd class="sc-bike__spec-value"><?php echo esc_html( $build_year ); ?></dd>
                        </div>
                    <?php endif; ?>
                    <?php if ( $mileage ) : ?>
                        <div class="sc-bike__spec">
                            <dt class="sc-bike__spec-label"><?php esc_html_e( 'Current mileage', 'sidestand-chronicles' ); ?></dt>
                            <dd class="sc-bike__spec-value"><?php echo esc_html( number_format( $mileage ) ); ?>&thinsp;km</dd>
                        </div>
                    <?php endif; ?>
                    <?php if ( $acquisition ) : ?>
                        <div class="sc-bike__spec">
                            <dt class="sc-bike__spec-label"><?php esc_html_e( 'Acquired', 'sidestand-chronicles' ); ?></dt>
                            <dd class="sc-bike__spec-value"><?php echo esc_html( $acquisition ); ?></dd>
                        </div>
                    <?php endif; ?>
                </dl>
            <?php endif; ?>
        </section>

        <h2 class="sc-timeline__heading">
            <?php esc_html_e( 'Modifications &amp; Maintenance', 'sidestand-chronicles' ); ?>
        </h2>

        <?php
        $timeline_query = new WP_Query( [
            'post_type'      => 'sc_timeline_entry',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'meta_value',
            'meta_key'       => 'sc_entry_date',
            'order'          => 'DESC',
        ] );
        ?>

        <?php if ( $timeline_query->have_posts() ) : ?>
            <ul class="sc-timeline">
                <?php while ( $timeline_query->have_posts() ) : $timeline_query->the_post(); ?>
                    <?php get_template_part( 'template-parts/timeline-entry' ); ?>
                <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <p class="sc-no-results">
                <?php esc_html_e( 'No timeline entries yet. Add the first one in Timeline → Add New Entry.', 'sidestand-chronicles' ); ?>
            </p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</main>

<?php get_footer(); ?>
