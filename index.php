<?php
/*
Plugin Name: JJVA Instagram Feed
Plugin URI: https://jordicuevas.website
Description: A plugin to display an instagram feed in a WordPress Site
Author: Jordi Cuevas
Author URI: https://jordicuevas.website
version: 1.00
*/
// IMPORTAMOS LA CLASE DE INSTAGRAM
// INICIALIZAMOS LA CLASE
add_action('wp_enqueue_scripts','jjva_instagram');
function jjva_instagram() {
    wp_enqueue_style( 'jjva_lightcase', plugins_url( '/assets/js/lightcase/src/css/lightcase.css', __FILE__ ));
    wp_enqueue_style( 'jjva_instagram_main', plugins_url( '/assets/css/jjva_instagram.css', __FILE__ ));
    wp_enqueue_script( 'jjva_instagram_lightcase', plugins_url( '/assets/js/lightcase/src/js/lightcase.js', __FILE__ ));
    wp_enqueue_script( 'jjva_instagram_main_js', plugins_url( '/assets/js/lightcase/src/js/main.js', __FILE__ ));

}
require('class_jjva_instagram.php');

?>