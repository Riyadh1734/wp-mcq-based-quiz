<?php
namespace App\Frontend;

/**
 * The Class Handle Shortcodes
 */
class Shortcode {
    /**
     * Class Constrcutor
     */
    public function __construct() {
        add_shortcode( 'quiz_app', [ $this, 'render_quiz_shortcode' ] );
    }

    /**
     * Render HTML Content Shortcode
     *
     * @param array $atts
     * @param string $content
     *
     * @return string
     */
    public function render_quiz_shortcode( $atts, $content = '' ) {
        //enqueue scripts
        wp_enqueue_style( 'mcqplugin-quiz-tailwind' );
        wp_enqueue_script( 'mcqplugin-quiz' );
        
        //localize scripts
        wp_localize_script( 'mcqplugin-quiz', 'wpstarter', [ 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'quiz' => $this->get_quiz_questions(), ] );

        // render shortcode content form vue component
        $content .= '<div id="vue-quiz-app"> <quiz></quiz> </div>';

        return $content;
    }

    /**
     * Get all quiz question
     *
     * @return void
     */
    public function get_quiz_questions() {
        $args = array( 
            'post_type'   => 'quiz', 
            'post_status' => 'publish',
            'numberposts' => -1,
        );

        $posts = get_posts( $args );

        if ( empty( $posts ) ) {
            return;
        }

        $data = [];

        // prepare quiz question, options and answer data
        foreach( $posts as $post ) {
            $data[] = [
                'question'      => $post->post_title,
                'answers'       => $this->get_question_options( $post->ID ),
                'correctAnswer' => $this->get_correct_answer( $post->ID ),
            ];
        }

        return $data;
    }

    /**
     * Get qll question options
     *
     * @param int $post_id
     * 
     * @return array $answer
     */
    public function get_question_options( $post_id ) {
        $answer = [];
        $options = [ 'a', 'b', 'c', 'd' ];

        for ( $i = 0; $i < 4; $i++ ) {
            $answer[ $options[ $i ] ] = get_post_meta( $post_id, 'quiz_options_'. ($i+1), true ) ? esc_html( get_post_meta( $post_id, 'quiz_options_'. ($i+1), true ) ) : '';
        }

        return $answer;
    }

    /**
     * Get Correct Answer
     * 
     * @param int $post_id
     *
     * @return string
     */
    public function get_correct_answer( $post_id ) {
        $answer = get_post_meta( $post_id, 'quiz_options_5', true ) ? esc_html( get_post_meta( $post_id, 'quiz_options_5', true ) ) : '';

        if ( empty( $answer ) ) {
            return '';
        }

        switch( $answer ) {
            case 1 :
                return 'a';
                break;
            case 2 :
                return 'b';
                break;
            case 3 :
                return 'c';
                break;
            case 4 : 
                return 'd';
                break;
            default :
                return '';
        }
    }
}