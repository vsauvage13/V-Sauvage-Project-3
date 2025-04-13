<?php
/**
 * Functions for My Block Theme
 */

/* Enqueue the main stylesheet */
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/**
 * Project 3 Issues CPT Plugin
 *
 * This is my hand-coded plugin that registers the "Issues" custom post type 
 * for the Project 3 website, as required by the assignment.
 *
 * Author: Vienna May Sauvage
 * Version: 1.0
 */

/* Register Custom Post Type: Issues */
function ws_register_issues_cpt() {

    $labels = array(
        'name'                  => _x( 'Issues', 'Post Type General Name', 'myblocktheme' ),
        'singular_name'         => _x( 'Issue', 'Post Type Singular Name', 'myblocktheme' ),
        'menu_name'             => __( 'Issues', 'myblocktheme' ),
        'name_admin_bar'        => __( 'Issue', 'myblocktheme' ),
        'archives'              => __( 'Issue Archives', 'myblocktheme' ),
        'attributes'            => __( 'Issue Attributes', 'myblocktheme' ),
        'parent_item_colon'     => __( 'Parent Issue:', 'myblocktheme' ),
        'all_items'             => __( 'All Issues', 'myblocktheme' ),
        'add_new_item'          => __( 'Add New Issue', 'myblocktheme' ),
        'add_new'               => __( 'Add New', 'myblocktheme' ),
        'new_item'              => __( 'New Issue', 'myblocktheme' ),
        'edit_item'             => __( 'Edit Issue', 'myblocktheme' ),
        'update_item'           => __( 'Update Issue', 'myblocktheme' ),
        'view_item'             => __( 'View Issue', 'myblocktheme' ),
        'view_items'            => __( 'View Issues', 'myblocktheme' ),
        'search_items'          => __( 'Search Issue', 'myblocktheme' ),
        'not_found'             => __( 'Not found', 'myblocktheme' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'myblocktheme' ),
        'featured_image'        => __( 'Featured Image', 'myblocktheme' ),
        'set_featured_image'    => __( 'Set featured image', 'myblocktheme' ),
        'remove_featured_image' => __( 'Remove featured image', 'myblocktheme' ),
        'use_featured_image'    => __( 'Use as featured image', 'myblocktheme' ),
        'insert_into_item'      => __( 'Insert into issue', 'myblocktheme' ),
        'uploaded_to_this_item' => __( 'Uploaded to this issue', 'myblocktheme' ),
        'items_list'            => __( 'Issues list', 'myblocktheme' ),
        'items_list_navigation' => __( 'Issues list navigation', 'myblocktheme' ),
        'filter_items_list'     => __( 'Filter issues list', 'myblocktheme' ),
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => true,               // Makes it publicly available.
        'publicly_queryable' => true,               // Allows queries on front end.
        'show_ui'            => true,               // Displays in admin.
        'show_in_menu'       => true,               // Shows in admin menu.
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'issues' ), // URL structure.
        'capability_type'    => 'post',
        'has_archive'        => true,               // Enables archive page.
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'show_in_rest'       => true,               // Enables Gutenberg editor compatibility.
    );
    
    register_post_type( 'issues', $args );
}
add_action( 'init', 'ws_register_issues_cpt' );

// Shortcode to display Issue custom fields (ACF fields)
function ws_issue_details_shortcode() {
    ob_start();
    // Check if the ACF function exists to avoid errors if ACF is inactive.
    if ( function_exists('get_field') ) {
        // Display Issue Date if available
        if ( get_field('issue_date') ) {
            echo '<time class="single-issue__date" datetime="' . esc_attr( get_field('issue_date') ) . '">';
            echo esc_html( get_field('issue_date') );
            echo '</time>';
        }
        // Display PDF Download Link if available
        if ( get_field('pdf_download_link') ) {
            echo '<p class="single-issue__pdf"><a href="' . esc_url( get_field('pdf_download_link') ) . '" target="_blank">Download Issue PDF</a></p>';
        }
    }
    return ob_get_clean();
}
add_shortcode( 'issue_details', 'ws_issue_details_shortcode' );

