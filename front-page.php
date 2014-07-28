<?php get_header(); ?>

    <div class="container welcometext">
        <div class="col-md-4">
            <div class="iconbox">
                <i class="fa fa-thumbs-o-up fa-2x"></i>
            </div>
            <?php
            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Sidebar')) :
                if ( ! dynamic_sidebar('Frontpage Left') ) :

                endif;
            endif;
            ?>
        </div>
        <div class="col-md-4">
            <div class="iconbox">
                <i class="fa fa-star-o fa-2x"></i>
            </div>
            <?php
            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Sidebar')) :
                if ( ! dynamic_sidebar('Frontpage Middle') ) :

                endif;
            endif;
            ?>
        </div>
        <div class="col-md-4">
            <div class="iconbox">
                <i class="fa fa-rocket fa-2x"></i>
            </div>
            <?php
            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Sidebar')) :
                if ( ! dynamic_sidebar('Frontpage Right') ) :

                endif;
            endif;
            ?>
        </div>

    </div>

    <!--LATEST NEWS-->
    <div class="container full latestnews">
        <?php
        $args = array(
            'posts_per_page'   => 6,
            'offset'           => 0,
            'category'         => '',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'post',
            'post_mime_type'   => '',
            'post_parent'      => '',
            'post_status'      => 'publish',
            'suppress_filters' => true );

        $myposts = get_posts( $args );
        foreach ( $myposts as $post ) : setup_postdata( $post );
            if(has_post_thumbnail()) {
                $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            }else{
                $url = "http://localhost/EdgeNew/_Site/wp-content/uploads/2014/07/img21.jpg";
            }
            echo '<div class="recentpostscontainer col-sm-4" style="background-image: url('.$url.');">';
            echo '  <div class="newsinfo"><h3>'.get_the_title().'</h3>';
            echo '  <p>'.get_the_excerpt().'</p></div>';
            echo '</div>';
        endforeach;
        wp_reset_postdata();?>
    </div>
<?php get_footer(); ?>