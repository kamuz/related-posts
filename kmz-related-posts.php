<?php
/**
 * Plugin Name: KMZ Related Posts
 * Description: Show related posts after content on single post
 * Author: Vladimir Kamuz
 * Plugin URL: https://kamuz.pro
 */

add_filter('the_content', 'kmz_related_posts');

function kmz_related_posts($content){
    $id = get_the_ID();
    $categories = get_the_category($id);
    foreach($categories as $category){
        $cats_id[] = $category->cat_ID;
    }

    $related_posts = new WP_Query(
        array(
            'posts_per_page' => 5,
            'category__in' => $cats_id,
            'orderby' => 'rand',
            'post__not_in' => array($id)
        )
    );

    if($related_posts->have_posts()){
        $content .= '<div class="related-posts"><h3>Maybe you interested:</h3>';
        while($related_posts->have_posts()){
            $related_posts->the_post();
            $content .= '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a><br>';
        }
        $content .= '</div>';
    }

    return $content;
}