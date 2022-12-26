<?php
namespace App;

/**
 * Frontend Pages Handler
 */
class Frontend {

    public function __construct() {
        /**
         * Crate a shortcode to render quiz questions
         */
        add_shortcode( 'quiz-app', [ $this, 'render_frontend' ] );
        
        /**
         * Handle Quiz Ajax
         */
        add_action( 'wp_ajax_my_action', [ $this, 'my_action' ] );
        add_action( 'wp_ajax_nopriv_my_action',  [ $this, 'my_action' ] );
    }

    /**
     * Ajax call back
     *
     * @return void
     */
    public function my_action() {

    }

    /**
     * Render frontend app
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_frontend( $atts, $content = '' ) {
        wp_enqueue_style( 'mcqplugin-frontend' );
        wp_enqueue_script( 'mcqplugin-quiz' );

        wp_localize_script( 'mcqplugin-quiz', 'wpstarter', [ 'ajaxurl' => admin_url( 'admin-ajax.php' )] );

        // $content .= '<div id="vue-quiz-app"></div>';
        return  "Hello World";

        return $content;
    }
}
