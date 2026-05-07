<?php
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
                'avatar_size' => 48,
            ] );
            ?>
        </ol>

        <?php the_comments_navigation(); ?>

    <?php endif; ?>

    <?php
    if ( comments_open() ) {
        $commenter = wp_get_current_commenter();
        comment_form( [
            'class_form'         => 'sc-comments__form',
            'title_reply'        => '',
            'title_reply_to'     => esc_html__( 'Replying to %s', 'sidestand-chronicles' ),
            'title_reply_before' => '<h2 class="sc-comments__form-title">',
            'title_reply_after'  => '</h2>',
            'label_submit'       => esc_html__( 'Post comment', 'sidestand-chronicles' ),
            'class_submit'       => 'sc-comments__submit',
            'fields'             => [
                'cookies' => '',
                'author' => '<p class="comment-form-author">'
                    . '<label for="author">' . esc_html__( 'Name', 'sidestand-chronicles' ) . ' <span class="required">*</span></label>'
                    . '<input id="author" name="author" type="text" value="' . esc_attr( isset( $commenter['comment_author'] ) ? $commenter['comment_author'] : '' ) . '" size="30" maxlength="245" autocomplete="name" required />'
                    . '</p>',
                'email'  => '<p class="comment-form-email">'
                    . '<label for="email">' . esc_html__( 'Email', 'sidestand-chronicles' ) . '</label>'
                    . '<input id="email" name="email" type="email" value="' . esc_attr( isset( $commenter['comment_author_email'] ) ? $commenter['comment_author_email'] : '' ) . '" size="30" maxlength="100" autocomplete="email" />'
                    . '<span class="comment-form-email__note">' . esc_html__( 'Optional. Not published. You\'ll be notified of new comments on this post.', 'sidestand-chronicles' ) . '</span>'
                    . '</p>',
            ],
            'comment_field'      => '<p class="comment-form-comment">'
                . '<label for="comment">' . esc_html__( 'Comment', 'sidestand-chronicles' ) . ' <span class="required">*</span></label>'
                . '<textarea id="comment" name="comment" cols="45" rows="6" maxlength="65525" required></textarea>'
                . '</p>',
            'comment_notes_before' => '',
            'comment_notes_after'  => '<input type="hidden" name="subscribe_comments" value="subscribe" />',
        ] );
    }
    ?>

</div>
