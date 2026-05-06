<?php
$date    = get_post_meta( get_the_ID(), 'sc_entry_date',    true );
$mileage = get_post_meta( get_the_ID(), 'sc_entry_mileage', true );
$type    = get_post_meta( get_the_ID(), 'sc_entry_type',    true );
$notes   = get_post_meta( get_the_ID(), 'sc_entry_notes',   true );

$type_label = '';
if ( $type === 'maintenance' ) {
    $type_label = __( 'Maintenance', 'sidestand-chronicles' );
} elseif ( $type === 'modification' ) {
    $type_label = __( 'Modification', 'sidestand-chronicles' );
}

$ts             = $date ? strtotime( $date ) : false;
$formatted_date = $ts ? date_i18n( 'j M Y', $ts ) : '';
?>
<li class="sc-timeline-entry">
    <p class="sc-timeline-entry__meta">
        <?php if ( $formatted_date ) : ?>
            <time datetime="<?php echo esc_attr( $date ); ?>"><?php echo esc_html( $formatted_date ); ?></time>
        <?php endif; ?>
        <?php if ( $mileage ) : ?>
            <?php if ( $formatted_date ) : ?>&nbsp;&middot;&nbsp;<?php endif; ?>
            <?php echo esc_html( number_format( $mileage ) ); ?>&thinsp;km
        <?php endif; ?>
    </p>

    <h3 class="sc-timeline-entry__title"><?php echo esc_html( get_the_title() ); ?></h3>

    <?php if ( $type_label ) : ?>
        <span class="sc-timeline-entry__type"><?php echo esc_html( $type_label ); ?></span>
    <?php endif; ?>

    <?php if ( $notes ) : ?>
        <p class="sc-timeline-entry__notes"><?php echo esc_html( $notes ); ?></p>
    <?php endif; ?>
</li>
