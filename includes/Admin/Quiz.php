<?php
namespace App\Admin;

/**
 * The class handle custom post type
 */
class Quiz {
    /**
     * Class Constructor
     */
    public function __construct() {
        add_action( 'init', [ $this, 'register_quiz_posttype' ] );
        add_action( 'add_meta_boxes', [ $this, 'quiz_add_custom_box' ] );
        add_action( 'save_post', [ $this, 'quiz_save_postdata' ] );
    }

    /**
     * Register Custom Post type
     *
     * @return void
     */
    public function register_quiz_posttype() {
        register_post_type( 'quiz',
            // CPT Options
            array(
                'labels' => array(
                    'name' => __( 'Take Quizzes' ),
                    'singular_name' => __( 'quiz' )
                ),
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'quiz'),
                'show_in_rest' => true,
                'supports'    => array( 'title'),
                'menu_icon'             => 'dashicons-welcome-learn-more',
            )
        );
    }

    /**
     * Register custom meta box
     *
     * @return void
     */
    public function quiz_add_custom_box() {
        add_meta_box(
            'quiz_box_id',                 // Unique ID
            'Advanced Quiz Options Box',      // Box title
            [ $this, 'quiz_meta_boxes_render' ],  // Content callback, must be of type callable
            'quiz'                            // Post type
        );
    }

    /**
     * Render Quiz Options
     *
     * @param object $post
     *
     * @return void
     */
    public function quiz_meta_boxes_render( $post ) {
        require_once __DIR__ . '/views/quiz_meta_box.php';
    }

    /**
     * Save custom posts meta
     *
     * @param int $post_id
     *
     * @return void
     */
    public function quiz_save_postdata( $post_id ) {
        for( $i = 1 ; $i < 6; $i++ ) {
            $data = isset( $_POST[ 'quiz_options_'.$i ] ) ? sanitize_text_field( $_POST[ 'quiz_options_'.$i ] ) : '';
            update_post_meta( $post_id, 'quiz_options_'.$i, $data );
        }
    }
}