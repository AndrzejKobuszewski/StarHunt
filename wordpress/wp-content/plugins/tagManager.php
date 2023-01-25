<?php
/** 
 * Plugin Name: tagManager
 * Plugin URI: http://wordpress.org/plugins/tagManager/
 * Description: This is a plugin for adding own HTML tags for the website. 
 * Author: Andrzej Kobuszewski
 * Version: 1.0.0
 * Author URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
//Registering taxonomy
function register_taxonomy_served()
{
    //Update of available webpages list is done also only by role administrator.    
    if (current_user_can('manage_options')) {
        $canUseTaxonomy = array('');
    } else {
        $canUseTaxonomy = array(
            'edit_terms' => 'publish_guides',
            'delete_terms' => 'no matters what its written in those fields',
            'manage_terms' => 'manage_categories'
        );
    }

    $labels = array(
        'name' => _('Available pages'),
        'singular_name' => _('Page'),
        'search_items' => __('Search Pages'),
        'all_items' => __('All Pages'),
        'parent_item' => __('Parent Page'),
        'parent_item_colon' => __('Parent Page:'),
        'edit_item' => __('Edit Page'),
        'update_item' => __('Update Page'),
        'add_new_item' => __('Add New Page'),
        'new_item_name' => __('New Page Name'),
        'menu_name' => __('Available pages'),
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'Available pages'],
        'capabilities' => $canUseTaxonomy
    );
    register_taxonomy('Available pages', ['NPharmaPlatfInteg'], $args);
}
// Adding taxonomy to init hook 
add_action('init', 'register_taxonomy_served');
// Registering the custom post type
function register_post_NPharmaPlatfInteg()
{
    //veryifying admin authorisation for using code editor
    if (current_user_can('manage_options')) {
        $isAdministrator = 'editor';
    } else {
        $isAdministrator = '';
    }
    register_post_type(
        'NPharmaPlatfInteg',
        array(
            'labels' => array(
                'name' => __('Custom HTMLs'),
                'singular_name' => __('Custom HTML'),
                'add_new' => 'New custom HTML',
                'edit_item' => 'Edit HTML',
                'search_items' => 'Find Html',
            ),
            'menu_name' => 'Custom HTML',
            'menu_position' => 65,
            'show_in_rest' => true,
            'has_archive' => true,
            'public' => true,
            'show_ui' => true,
            'supports' => array('title', $isAdministrator),
            'taxonomies' => array('Available pages'),
            'template' => array(
                array('core/code')
            ),
        )
    );
}
add_action('init', 'register_post_NPharmaPlatfInteg');
// Displaying posts on the footer
function showTags()
{
    $pageTitle = get_the_title($post->post_parent);
    $args = array(
        'post_type' => 'NPharmaPlatfInteg',
        'posts_per_page' => -1,
        'Available pages' => array($pageTitle, '_Wildcard_all_pages')
    );
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()):
        while ($the_query->have_posts()):
            $the_query->the_post();
            print the_content() . ", ";
        endwhile;
        wp_reset_postdata();
    endif;
}
add_action('wp_footer', 'showTags')
    ?>