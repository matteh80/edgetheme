<?php
//Include klasser metabox
require_once "/includes/klasser-metabox.php";

// Register Portfolio custom post type

function create_portfolio_post_type() {
    register_post_type( 'klasser',
        array(
            'labels' => array(
                'name' => _x( 'Klasser', 'Klasser post type general name' ),
                'singular_name' => _x( 'Portfolio Item', 'Portfolio post type singular name' ),
                'add_new' => _x( 'Lägg till klass', 'Portfolio post type' ),
                'add_new_item' => __( 'Lägg till klass'),
                'edit_item' => __( 'Redigera klass'),
                'new_item' => __( 'Ny klass'),
                'view_item' => __( 'Visa klass'),
                'search_items' => __( 'Sök klass'),
                'not_found' =>  __( 'Inga klasser'),
                'not_found_in_trash' => __( 'No portfolio items found in Trash'),
                'parent_item_colon' => '',
                'menu_name' => _x( 'Klasser', 'Portfolio menu name'),
                'taxonomies' => array('category', 'post_tag')
            ),
            'public' => true,
            'exclude_from_search' => true,
            'has_archive' => false,
            'supports' => array( 'title'),
            'rewrite' => array( 'slug' => 'klasser' ),
            'menu_icon'=> 'dashicons-welcome-learn-more'
        )
    );
    register_taxonomy( 'dansstil', 'klasser',
        array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x( 'Dansstil', 'Portfolio taxonomy general name'),
                'singular_name' => _x( 'Dansstil', 'Portfolio taxonomy singular name'),
                'search_items' =>  __( 'Sök dansstil'),
                'popular_items' => __( 'Populära dansstilar'),
                'all_items' => __( 'All dansstilar'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __( 'Redigera dansstil'),
                'update_item' => __( 'Uppdatera'),
                'add_new_item' => __( 'Lägg till dansstil'),
                'new_item_name' => __( 'Ny dansstil'),
                'separate_items_with_commas' => __( 'Separera dansstil med komma'),
                'add_or_remove_items' => __( 'Lägg till eller ta bort'),
                'choose_from_most_used' => __( 'Välj bland de mest använda dansstilarna'),
                'not_found' => __( 'No categories found.'),
                'menu_name' => __( 'Dansstilar'),
            ),
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => true,
        )
    );
}
add_action( 'init', 'create_portfolio_post_type' );
// END Register Portfolio custom post type

add_filter('manage_klasser_posts_columns', 'add_new_klasser_columns');
function add_new_klasser_columns( $defaults ) {
    $defaults['active'] = 'Aktiv';
    $defaults['dansstil'] = 'Dansstil';
    $defaults['dag'] = 'Veckodag';
    $defaults['time'] = 'Tid';
    $defaults['length'] = 'Längd';
    $defaults['sal'] = 'Sal';
    $defaults['price'] = 'Pris';
    unset($defaults['date']);
    return $defaults;
}

add_action( 'manage_posts_custom_column' , 'custom_klasser_columns', 10, 2 );

function custom_klasser_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'active' :
            $terms = get_post_meta($post_id, 'klasser_active', true);
            if ( is_string( $terms ) )
                echo $terms;
            else
                _e( 'No type is set', 'your_text_domain' );
            break;
        case 'dansstil' :
            $terms = wp_get_post_terms( $post_id, "dansstil");
            if ( !empty( $terms ) && !is_wp_error( $terms ) ){
                foreach ( $terms as $term ) {
                    echo $term->name;

                }
            }
            break;
        case 'dag' :
            $dag = get_post_meta($post_id, 'klasser_dag', true);
            echo $dag;
            break;
        case 'time' :
            $starttime = get_post_meta($post_id, 'klasser_starttime', true);
            $endtime = get_post_meta($post_id, 'klasser_endtime', true);
            $time = $starttime . " - " . $endtime;
            echo $time;
            break;
        case 'length' :
            $starttime = get_post_meta($post_id, 'klasser_starttime', true);
            $endtime = get_post_meta($post_id, 'klasser_endtime', true);
            $to_time = strtotime($endtime);
            $from_time = strtotime($starttime);
            $time = round(abs($to_time - $from_time) / 60,2). " minuter";
            echo $time;
            break;
        case 'sal' :
            $sal = get_post_meta($post_id, 'klasser_sal', true);
            echo $sal;
            break;
        case 'price' :
            $price = get_post_meta($post_id, 'klasser_price', true);
            echo $price;
            break;
    }
}

function get_tag_ID($tag_name) {
    $tag = get_term_by('name', $tag_name, 'dansstil');
    if ($tag) {
        return $tag->term_id;
    } else {
        return 0;
    }
}
?>