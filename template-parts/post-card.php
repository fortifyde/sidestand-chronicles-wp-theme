<?php
$categories = get_the_category();
$category   = $categories ? $categories[0] : null;
$mileage    = get_post_meta( get_the_ID(), 'sc_post_mileage', true );
?>
<li class="sc-post-card">
    <h2 class="sc-post-card__title">
        <a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
    </h2>

    <?php if ( $category ) : ?>
        <a class="sc-post-card__category"
           href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
            <?php echo esc_html( $category->name ); ?>
        </a>
    <?php endif; ?>

    <p class="sc-post-card__meta">
        <time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
            <?php echo esc_html( get_the_date( 'j M Y' ) ); ?>
        </time>
        <?php if ( $mileage ) : ?>
            &nbsp;&middot;&nbsp;<?php echo esc_html( number_format( $mileage ) ); ?>&thinsp;km
        <?php endif; ?>
    </p>
</li>
