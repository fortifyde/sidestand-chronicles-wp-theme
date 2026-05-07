<?php
/**
 * Sidestand Chronicles — functions.php
 *
 * Sections:
 *  1. Theme Setup
 *  2. Asset Enqueue
 *  3. Timeline CPT + Meta Boxes
 *  4. Post Mileage Meta Box
 *  5. Options Page
 *  6. Nav Fallback Helper
 */

// =============================================================================
// 1. Theme Setup
// =============================================================================

function sc_theme_setup() {
    load_theme_textdomain( 'sidestand-chronicles', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'site-icon' );
    add_theme_support( 'custom-logo', [
        'height'      => 100,
        'width'       => 350,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    add_theme_support( 'custom-background', [
        'default-color' => 'faf6ef',
    ] );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    ] );
    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'sidestand-chronicles' ),
    ] );
}
add_action( 'after_setup_theme', 'sc_theme_setup' );

/**
 * Add sc-splash-page body class on the front page.
 */
function sc_splash_body_class( $classes ) {
    if ( is_front_page() ) {
        $classes[] = 'sc-splash-page';
    }
    return $classes;
}
add_filter( 'body_class', 'sc_splash_body_class' );

// =============================================================================
// 2. Asset Enqueue
// =============================================================================

function sc_enqueue_assets() {
    $dir = get_template_directory();
    $uri = get_template_directory_uri();

    wp_enqueue_style(  'sc-main',   $uri . '/assets/css/main.css', [],           filemtime( $dir . '/assets/css/main.css' ) );
    wp_enqueue_script( 'sc-nav',    $uri . '/assets/js/nav.js',    [],           filemtime( $dir . '/assets/js/nav.js' ), true );
    wp_enqueue_script( 'sc-search', $uri . '/assets/js/search.js', [ 'sc-nav' ], filemtime( $dir . '/assets/js/search.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'sc_enqueue_assets' );

// =============================================================================
// 3. Timeline CPT + Meta Boxes
// =============================================================================

function sc_register_timeline_cpt() {
    register_post_type( 'sc_timeline_entry', [
        'labels'        => [
            'name'          => __( 'Timeline',       'sidestand-chronicles' ),
            'singular_name' => __( 'Timeline Entry', 'sidestand-chronicles' ),
            'add_new_item'  => __( 'Add New Entry',  'sidestand-chronicles' ),
            'edit_item'     => __( 'Edit Entry',     'sidestand-chronicles' ),
            'all_items'     => __( 'All Entries',    'sidestand-chronicles' ),
            'menu_name'     => __( 'Timeline',       'sidestand-chronicles' ),
        ],
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'supports'      => [ 'title' ],
        'menu_icon'     => 'dashicons-admin-tools',
        'rewrite'       => false,
    ] );
}
add_action( 'init', 'sc_register_timeline_cpt' );

function sc_add_timeline_meta_box() {
    add_meta_box(
        'sc_timeline_details',
        __( 'Entry Details', 'sidestand-chronicles' ),
        'sc_timeline_meta_box_html',
        'sc_timeline_entry',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'sc_add_timeline_meta_box' );

function sc_timeline_meta_box_html( $post ) {
    wp_nonce_field( 'sc_save_timeline_meta', 'sc_timeline_nonce' );
    $date    = get_post_meta( $post->ID, 'sc_entry_date',    true );
    $mileage = get_post_meta( $post->ID, 'sc_entry_mileage', true );
    $type    = get_post_meta( $post->ID, 'sc_entry_type',    true );
    $notes   = get_post_meta( $post->ID, 'sc_entry_notes',   true );
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="sc_entry_date"><?php esc_html_e( 'Date', 'sidestand-chronicles' ); ?></label>
            </th>
            <td>
                <input type="date" id="sc_entry_date" name="sc_entry_date"
                       value="<?php echo esc_attr( $date ); ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="sc_entry_mileage"><?php esc_html_e( 'Mileage (km)', 'sidestand-chronicles' ); ?></label>
            </th>
            <td>
                <input type="number" id="sc_entry_mileage" name="sc_entry_mileage"
                       value="<?php echo esc_attr( $mileage ); ?>" min="0">
            </td>
        </tr>
        <tr>
            <th scope="row"><?php esc_html_e( 'Type', 'sidestand-chronicles' ); ?></th>
            <td>
                <label>
                    <input type="radio" name="sc_entry_type" value="modification"
                           <?php checked( $type, 'modification' ); ?>>
                    <?php esc_html_e( 'Modification', 'sidestand-chronicles' ); ?>
                </label>
                &nbsp;&nbsp;
                <label>
                    <input type="radio" name="sc_entry_type" value="maintenance"
                           <?php checked( $type, 'maintenance' ); ?>>
                    <?php esc_html_e( 'Maintenance', 'sidestand-chronicles' ); ?>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="sc_entry_notes"><?php esc_html_e( 'Notes', 'sidestand-chronicles' ); ?></label>
            </th>
            <td>
                <textarea id="sc_entry_notes" name="sc_entry_notes"
                          rows="4" style="width:100%"><?php echo esc_textarea( $notes ); ?></textarea>
            </td>
        </tr>
    </table>
    <?php
}

function sc_save_timeline_meta( $post_id ) {
    if ( ! isset( $_POST['sc_timeline_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['sc_timeline_nonce'], 'sc_save_timeline_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['sc_entry_date'] ) ) {
        update_post_meta( $post_id, 'sc_entry_date', sanitize_text_field( $_POST['sc_entry_date'] ) );
    }
    if ( isset( $_POST['sc_entry_mileage'] ) ) {
        update_post_meta( $post_id, 'sc_entry_mileage', absint( $_POST['sc_entry_mileage'] ) );
    }
    if ( isset( $_POST['sc_entry_type'] ) ) {
        $allowed = [ 'modification', 'maintenance' ];
        $type    = sanitize_key( $_POST['sc_entry_type'] );
        update_post_meta( $post_id, 'sc_entry_type', in_array( $type, $allowed, true ) ? $type : '' );
    }
    if ( isset( $_POST['sc_entry_notes'] ) ) {
        update_post_meta( $post_id, 'sc_entry_notes', sanitize_textarea_field( $_POST['sc_entry_notes'] ) );
    }
}
add_action( 'save_post_sc_timeline_entry', 'sc_save_timeline_meta' );

// =============================================================================
// 4. Post Mileage Meta Box
// =============================================================================

function sc_add_post_mileage_meta_box() {
    add_meta_box(
        'sc_post_mileage',
        __( 'Odometer Reading', 'sidestand-chronicles' ),
        'sc_post_mileage_meta_box_html',
        'post',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'sc_add_post_mileage_meta_box' );

function sc_post_mileage_meta_box_html( $post ) {
    wp_nonce_field( 'sc_save_post_mileage', 'sc_post_mileage_nonce' );
    $mileage = get_post_meta( $post->ID, 'sc_post_mileage', true );
    ?>
    <p>
        <label for="sc_post_mileage">
            <?php esc_html_e( 'Odometer at time of writing (km)', 'sidestand-chronicles' ); ?>
        </label><br>
        <input type="number" id="sc_post_mileage" name="sc_post_mileage"
               value="<?php echo esc_attr( $mileage ); ?>" min="0" style="width:100%;margin-top:4px">
    </p>
    <?php
}

function sc_save_post_mileage( $post_id ) {
    if ( ! isset( $_POST['sc_post_mileage_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['sc_post_mileage_nonce'], 'sc_save_post_mileage' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['sc_post_mileage'] ) ) {
        update_post_meta( $post_id, 'sc_post_mileage', absint( $_POST['sc_post_mileage'] ) );
    }
}
add_action( 'save_post_post', 'sc_save_post_mileage' );

// =============================================================================
// 5. Options Page (Settings > Sidestand Chronicles)
// =============================================================================

function sc_register_settings() {
    $text_fields = [
        'sc_splash_tagline',
        'sc_bike_acquisition',
        'sc_bike_build_year',
        'sc_bike_mileage',
    ];
    foreach ( $text_fields as $key ) {
        register_setting( 'sc_options_group', $key, [ 'sanitize_callback' => 'sanitize_text_field' ] );
    }
    foreach ( [ 'sc_instagram_url', 'sc_youtube_url' ] as $key ) {
        register_setting( 'sc_options_group', $key, [ 'sanitize_callback' => 'esc_url_raw' ] );
    }
    register_setting( 'sc_options_group', 'sc_bike_intro', [
        'sanitize_callback' => 'sanitize_textarea_field',
    ] );
}
add_action( 'admin_init', 'sc_register_settings' );

function sc_add_options_page() {
    add_options_page(
        __( 'Sidestand Chronicles', 'sidestand-chronicles' ),
        __( 'Sidestand Chronicles', 'sidestand-chronicles' ),
        'manage_options',
        'sidestand-chronicles',
        'sc_options_page_html'
    );
}
add_action( 'admin_menu', 'sc_add_options_page' );

function sc_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Sidestand Chronicles Settings', 'sidestand-chronicles' ); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'sc_options_group' ); ?>

            <h2><?php esc_html_e( 'Splash Page', 'sidestand-chronicles' ); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="sc_splash_tagline"><?php esc_html_e( 'Tagline', 'sidestand-chronicles' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="sc_splash_tagline" name="sc_splash_tagline"
                               value="<?php echo esc_attr( get_option( 'sc_splash_tagline' ) ); ?>"
                               class="regular-text">
                        <p class="description">
                            <?php esc_html_e( 'Short italic line displayed under the site title on the home page.', 'sidestand-chronicles' ); ?>
                        </p>
                    </td>
                </tr>
            </table>

            <h2><?php esc_html_e( 'Social Links', 'sidestand-chronicles' ); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="sc_instagram_url"><?php esc_html_e( 'Instagram URL', 'sidestand-chronicles' ); ?></label>
                    </th>
                    <td>
                        <input type="url" id="sc_instagram_url" name="sc_instagram_url"
                               value="<?php echo esc_url( get_option( 'sc_instagram_url' ) ); ?>"
                               class="regular-text" placeholder="https://instagram.com/yourhandle">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="sc_youtube_url"><?php esc_html_e( 'YouTube URL', 'sidestand-chronicles' ); ?></label>
                    </th>
                    <td>
                        <input type="url" id="sc_youtube_url" name="sc_youtube_url"
                               value="<?php echo esc_url( get_option( 'sc_youtube_url' ) ); ?>"
                               class="regular-text" placeholder="https://youtube.com/@yourchannel">
                    </td>
                </tr>
            </table>

            <h2><?php esc_html_e( 'The Bike', 'sidestand-chronicles' ); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="sc_bike_build_year"><?php esc_html_e( 'Build Year', 'sidestand-chronicles' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="sc_bike_build_year" name="sc_bike_build_year"
                               value="<?php echo esc_attr( get_option( 'sc_bike_build_year' ) ); ?>"
                               class="small-text" placeholder="2015">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="sc_bike_mileage"><?php esc_html_e( 'Current Mileage (km)', 'sidestand-chronicles' ); ?></label>
                    </th>
                    <td>
                        <input type="number" id="sc_bike_mileage" name="sc_bike_mileage"
                               value="<?php echo esc_attr( get_option( 'sc_bike_mileage' ) ); ?>"
                               class="small-text" min="0">
                        <p class="description">
                            <?php esc_html_e( 'Update this manually whenever the bike page needs refreshing.', 'sidestand-chronicles' ); ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="sc_bike_acquisition"><?php esc_html_e( 'Acquisition Note', 'sidestand-chronicles' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="sc_bike_acquisition" name="sc_bike_acquisition"
                               value="<?php echo esc_attr( get_option( 'sc_bike_acquisition' ) ); ?>"
                               class="regular-text" placeholder="Purchased second-hand in São Paulo, March 2024">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="sc_bike_intro"><?php esc_html_e( 'Bike Intro Text', 'sidestand-chronicles' ); ?></label>
                    </th>
                    <td>
                        <textarea id="sc_bike_intro" name="sc_bike_intro"
                                  rows="6" class="large-text"><?php echo esc_textarea( get_option( 'sc_bike_intro' ) ); ?></textarea>
                        <p class="description">
                            <?php esc_html_e( 'Intro paragraph displayed at the top of The Bike page, above the timeline.', 'sidestand-chronicles' ); ?>
                        </p>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// =============================================================================
// 6. Nav Fallback Helper
// =============================================================================

/**
 * Fallback used by wp_nav_menu() when no menu is assigned to 'primary'.
 * Outputs <li> items only (no <ul> wrapper) to match our header template.
 */
function sc_nav_fallback() {
    $rider = get_page_by_path( 'the-rider' );
    $bike  = get_page_by_path( 'the-bike' );
    $road  = get_option( 'page_for_posts' );

    if ( $rider ) printf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink( $rider ) ), esc_html__( 'The Rider', 'sidestand-chronicles' ) );
    if ( $bike )  printf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink( $bike ) ),  esc_html__( 'The Bike',  'sidestand-chronicles' ) );
    if ( $road )  printf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink( $road ) ),  esc_html__( 'The Road',  'sidestand-chronicles' ) );
}

// =============================================================================
// 7. Open Graph + Meta Description
// =============================================================================

function sc_add_meta_tags() {
    $site_name = get_bloginfo( 'name' );
    $url       = esc_url( home_url( add_query_arg( [], $_SERVER['REQUEST_URI'] ?? '/' ) ) );
    $image     = '';
    $desc      = '';
    $title     = '';
    $type      = 'website';

    if ( is_singular() ) {
        global $post;
        $title = get_the_title();
        $type  = 'article';

        // Description: manual excerpt → auto-excerpt → site tagline
        if ( has_excerpt() ) {
            $desc = wp_trim_words( get_the_excerpt(), 30, '' );
        } elseif ( ! empty( $post->post_content ) ) {
            $desc = wp_trim_words( wp_strip_all_tags( $post->post_content ), 30, '' );
        }

        // Image: featured image → site icon
        if ( has_post_thumbnail() ) {
            $img_id = get_post_thumbnail_id();
            $image  = wp_get_attachment_image_url( $img_id, 'large' );
        }
    } elseif ( is_front_page() ) {
        $title = $site_name;
        $desc  = get_bloginfo( 'description' );
    } elseif ( is_archive() ) {
        $title = get_the_archive_title();
        $desc  = get_bloginfo( 'description' );
    }

    if ( empty( $desc ) ) {
        $desc = get_bloginfo( 'description' );
    }

    if ( empty( $image ) && has_site_icon() ) {
        $image = get_site_icon_url( 512 );
    }

    $desc  = esc_attr( wp_strip_all_tags( $desc ) );
    $title = esc_attr( wp_strip_all_tags( $title ?: $site_name ) );
    ?>
    <meta name="description" content="<?php echo $desc; // phpcs:ignore WordPress.Security.EscapeOutput ?>">
    <meta property="og:title" content="<?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput ?>">
    <meta property="og:description" content="<?php echo $desc; // phpcs:ignore WordPress.Security.EscapeOutput ?>">
    <meta property="og:url" content="<?php echo esc_url( $url ); ?>">
    <meta property="og:type" content="<?php echo esc_attr( $type ); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>">
    <?php if ( $image ) : ?>
        <meta property="og:image" content="<?php echo esc_url( $image ); ?>">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="<?php echo esc_url( $image ); ?>">
    <?php else : ?>
        <meta name="twitter:card" content="summary">
    <?php endif; ?>
    <meta name="twitter:title" content="<?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput ?>">
    <meta name="twitter:description" content="<?php echo $desc; // phpcs:ignore WordPress.Security.EscapeOutput ?>">
    <?php
}
add_action( 'wp_head', 'sc_add_meta_tags' );
