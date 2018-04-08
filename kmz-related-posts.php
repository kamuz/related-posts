<?php
/**
 * Plugin Name: KMZ Related Posts
 * Description: Show related posts after content on single post
 * Author: Vladimir Kamuz
 * Plugin URL: https://kamuz.pro
 */

function kmz_related_enqueue_style() {
    wp_enqueue_style( 'kmz-related-style', plugins_url( 'css/', __FILE__ ).'main.css', false ); 
}

function kmz_related_enqueue_script() {
    wp_enqueue_script( 'kmz-related-tooltips',  plugins_url( 'js/', __FILE__ ).'jquery.tools.min.js', array('jquery') );
    wp_enqueue_script( 'kmz-related-script',  plugins_url( 'js/', __FILE__ ).'main.js', false );
}

add_action( 'wp_enqueue_scripts', 'kmz_related_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'kmz_related_enqueue_script' );

add_filter('the_content', 'kmz_related_posts');

function kmz_related_posts($content){

    if(!is_single()) return $content;

    $id = get_the_ID();
    $categories = get_the_category($id);
    foreach($categories as $category){
        $cats_id[] = $category->cat_ID;
    }

    $related_posts = new WP_Query(
        array(
            'posts_per_page' => 4,
            'category__in' => $cats_id,
            'orderby' => 'rand',
            'post__not_in' => array($id)
        )
    );

    if($related_posts->have_posts()){
        $content .= '<div class="related-posts"><h3>Maybe you interested:</h3>';
        while($related_posts->have_posts()){
            $related_posts->the_post();
            if(has_post_thumbnail()){
                $img = get_the_post_thumbnail( get_the_ID(), array(100, 100), array( 'title' => get_the_title(), 'alt' => get_the_title() ) );
            }else{
                $img = '<img src="' . plugins_url('img/no_img.jpg', __FILE__) . '" alt="' . get_the_title() . '" title="' . get_the_title() . '" width="100" height="100">';
            }
            $content .= '<a href="' . get_the_permalink() . '">' . $img . '</a>';
        }
        $content .= '</div>';
        wp_reset_query();
    }

    return $content;
}