<?php
/**
 * Sidestand Chronicles — comments.php
 *
 * Minimal comments template styled to match the theme typography.
 */
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="sc-comments">

    <?php if ( have_comments() ) : ?>
        <h2 class="sc-comments__title">
            <?php
            printf(
                esc_html( _nx( 'One response', '%1$s responses', get_comments_number(), 'comments title', 'sidestand-chronicles' ) ),
                number_format_i18n( get_comments_number() )
            );
            ?>
        </h2>

        <ol class="sc-comments__list">
            <?php
            wp_list_comments( [
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 40,
            ] );
            ?>
        </ol>

        <?php the_comments_navigation(); ?>

    <?php endif; ?>

    <?php
    if ( comments_open() ) {
        comment_form( [
            'class_form' => 'sc-comments__form',
        ] );
    }
    ?>

</div>
