<?php
/**
 * Plugin Name: KMZ Related Posts
 * Description: Show related posts after content on single post
 * Author: Vladimir Kamuz
 * Plugin URL: https://kamuz.pro
 */

add_filter('the_content', 'kmz_related_posts');

function kmz_related_posts($content){
    return $content . "!!!";
}