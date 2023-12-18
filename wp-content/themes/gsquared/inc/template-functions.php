<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package gsquared
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function gsquared_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter( 'body_class', 'gsquared_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function gsquared_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'gsquared_pingback_header' );

function enqueueThemeStylesheets()
{
    wp_enqueue_style( 'montserrat', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap', [], true );
    wp_enqueue_style( 'lora', 'https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap', [], true );
    wp_enqueue_style( 'tailwindcss', get_template_directory_uri() . '/src/style.css', array(), rand(0, 9999999) );

    wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', ['jquery'], rand(0, 9999999), true );
}

add_action( 'wp_enqueue_scripts', 'enqueueThemeStylesheets' );

function handleFormSubmission()
{
    // Check for nonce for security
    $nonce_value = isset($_POST['nonce_field']) ? $_POST['nonce_field'] : '';

    if (! wp_verify_nonce($nonce_value, 'donate_nonce')) {
        // Handle the case where the nonce was not valid
        die('Security check');
    }

    $payment_method = sanitize_text_field($_POST['payment_method']);
    $donation_amount = wp_strip_all_tags(sanitize_text_field($_POST['donation_amount']));
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_text_field($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);

    // Insert the post
    $donation_id = wp_insert_post(array(
        'post_type' => 'donation',
        'post_title' => wp_strip_all_tags($first_name . ' ' . $last_name) . ": " . number_format($donation_amount, 2),
        'post_status' => 'publish',
    ));

    if ($donation_id) {
        // Add custom fields
        update_post_meta($donation_id, 'payment_method', $payment_method);
        update_post_meta($donation_id, 'donation_amount', $donation_amount);
        update_post_meta($donation_id, 'first_name', $first_name);
        update_post_meta($donation_id, 'last_name', $last_name);
        update_post_meta($donation_id, 'email', $email);
        update_post_meta($donation_id, 'phone', $phone);

        // Redirect with success message
        wp_redirect(esc_url(home_url('/?donate=success')));
        exit;
    }

    // Redirect with success message
    wp_redirect(esc_url( home_url('/?donate=failed')));
    exit;
}

add_action('admin_post_nopriv_donate', 'handleFormSubmission'); // For non-logged-in users
add_action('admin_post_donate', 'handleFormSubmission'); // For logged-in users

function calculateTotalDonations()
{
    global $wpdb;

    $query = "
        SELECT SUM(meta_value) as total
        FROM $wpdb->postmeta pm
        LEFT JOIN $wpdb->posts p ON pm.post_id = p.ID
        WHERE pm.meta_key = 'donation_amount'
        AND p.post_type = 'donation'
        AND p.post_status = 'publish'
    ";

    $result = $wpdb->get_row($query);

    return $result->total ? $result->total : 0;
}