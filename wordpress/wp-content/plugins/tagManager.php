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

function register_taxonomy_served() {
    if (current_user_can('manage_options')) {
        $canUseTaxonomy= array('');
    } else {
        $canUseTaxonomy = array(     
            'edit_terms' => 'publish_guides',
            'delete_terms' => 'cant see any differencs',
            'manage_terms' => 'manage_categories');
    }
    $labels = array(
        'name'              => _( 'Available pages'),
        'singular_name'     => _( 'Page'),
        'search_items'      => __( 'Search Pages' ),
        'all_items'         => __( 'All Pages' ),
        'parent_item'       => __( 'Parent Page' ),
        'parent_item_colon' => __( 'Parent Page:' ),
        'edit_item'         => __( 'Edit Page' ),
        'update_item'       => __( 'Update Page' ),
        'add_new_item'      => __( 'Add New Page' ),
        'new_item_name'     => __( 'New Page Name' ),
        'menu_name'         => __( 'Available pages' ),
    );
    $args   = array(
        'hierarchical'      => true, 
        'labels'            => $labels,
        'show_ui'           => true,
        // 'all_item'          => 'boobies',
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => [ 'slug' => 'Available pages' ],
        'capabilities' => $canUseTaxonomy
    );
    register_taxonomy( 'Available pages', [ 'NPharmaPlatfInteg' ], $args );
}
// Adding taxonomy to init hook 
add_action( 'init', 'register_taxonomy_served' );
// Registering the custom post type
function register_post_NPharmaPlatfInteg()
{
    //weryfikacja uprawnień za pomocą zmiennej
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
            'has_archive'  => true,
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

//Set custom taxonomy entries as a list of pages

$pages = get_posts(array('post_type' => 'page', 'numberposts' => -1));
$pagesTitles = array('Main page');
for ($x = 0; $x < sizeof($pages); $x++) {
    array_push($pagesTitles, get_the_title($pages[$x]));
}

// function update_list_of_Available_pages() {
//     $terms = get_terms(
//         array(
//             'taxonomy' => 'Available pages',
//             'hide_empty' => false,
//         )
//     );
//     $termsNames = array();
//     $pages = get_posts(array('post_type' => 'page', 'numberposts' => -1));
//     $pagesTitles = array('Main page');
 
//     //  for ($x = 0; $x < sizeof($terms); $x++) {
//     //     wp_delete_term( intval($terms[$x]->term_id),'Available pages', array('force_default'=> true));    
//     // }


//     for ($x = 0; $x < sizeof($pages); $x++) {
       
//         wp_insert_term(get_the_title($pages[$x]), 'Available pages');
//     }
 

//     // $result = array_diff($pagesTitles, $termsNames);
 
 
 
 
//     // for ($x = 0; $x < sizeof($pages); $x++) {
//     //     array_push($pagesTitles, get_the_title($pages[$x]));
//     // }
//     // for ($x = 0; $x < sizeof($terms); $x++) {
//     //     array_push($termsNames, $terms[$x]->name);    
//     // }

//     // $result = array_diff($pagesTitles, $termsNames);
    
// //    var_dump($result[0]);

//     // for ($x = 0; $x < sizeof($result[1]); $x++) {
//     //     wp_insert_term($result[$x], 'Available pages');
//     //     // array_push($termsNames, $terms[$x]->term_id);
//     //         // wp_delete_term( intval($terms[$x]->term_id),'Available pages', array('force_default'=> true));
//     //         print_r($result);

//     // }
  

//     // for ($x = 0; $x < sizeof($pages); $x++) {
//     //     for ($y = 0; $y < sizeof($terms); $y++) {
//     //         $match=false;
//     //         if ($pagesTitles[$x]=$termsNames[$y])
//     //             {$match=true};
//     //     }
//     // };
    
    
   
//     // array_push($termsNames, $terms[$x]->term_id);
//     // wp_delete_term( intval($terms[$x]->term_id),'Available pages', array('force_default'=> true));

    
//     // var_dump($termsNames);

//     //$taxonomies = get_taxonomies();
   
//     // wp_insert_term('Nowa stronaB', 'Available pages');

//     // wp_delete_term( 'Nowa stronaB','Available pages', array('force_default'=> true));
    
// }
// add_action('wp_loaded','update_list_of_Available_pages');
//Displaying posts on the footer

function showTags()
{
    $pageTitle = get_the_title($post->post_parent); 
    $args = array(
        'post_type' => 'NPharmaPlatfInteg',
        'posts_per_page' => -1,
        'Available pages' => array($pageTitle)
       
    //     'tax_query' => array(
    //         array(
    //             'taxonomy' => array( 'Available pages' ), // <-- NO! Does not work.
    //             'field'    => 'name',
    //             'terms'    => array( 'Sample Page' )
    // ))
    )
    ;
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()):
        while ($the_query->have_posts()):
            $the_query->the_post();
            // get_the_terms(the_post(), 'Available pages');
            // var_dump(get_the_terms(the_post(), 'Available pages'));
            //jezęli w tablicy przypisnaych terms do tego jest nazwa strony to printnij się
            print the_content() . ", ";
        endwhile;
        wp_reset_postdata();
    endif;
}
add_action('wp_footer', 'showTags');
?>
<?php
//adding admin menu - just the other way for manage the snippets and sites <<that was bad direction>>
// function Custom_HTML_settings()
// {
//     add_options_page(
//         'Custom HTML settings',
//         'Custom HTMLs settings',
//         'manage_options',
//         'Custom HTML settings',
//         'my_callback'
//     );
// }
// //doing settings ui
// function my_callback()
// {
//     include 'adminpages/configuration.php';
// }
// add_action('admin_menu', 'Custom_HTML_settings');

?>

