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
    echo '<pre>';
    print_r($categories);
    echo '</pre>';
    return $content;
}