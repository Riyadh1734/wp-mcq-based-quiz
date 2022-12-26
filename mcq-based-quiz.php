<?php
/**
 * Plugin Name: Mcq Based Quiz
 * Description: Mcq Based quiz using vue.js starter plugin
 * Plugin URI: https://github.com/Riyadh1734/wp-mcq-based-quiz
 * Author: Riyadh Ahmed
 * Author URI: http://sajuahmed.epizy.com/
 * Version: 1.0.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) || exit;
/**
 * Mcq_Plugin class
 *
 * @class Mcq_Plugin The class that holds the entire Mcq_Plugin plugin
 */
final class Mcq_Plugin {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Holds various class instances
     *
     * @var array
     */
    private $container = array();

    /**
     * Constructor for the Mcq_Plugin class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    public function __construct() {

        $this->define_constants();

        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
    }

    /**
     * Initializes the Mcq_Plugin() class
     *
     * Checks for an existing Mcq_Plugin() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Mcq_Plugin();
        }

        return $instance;
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }

        return $this->{$prop};
    }

    /**
     * Magic isset to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __isset( $prop ) {
        return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
    }

    /**
     * Define the constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'MCQPLUGIN_VERSION', $this->version );
        define( 'MCQPLUGIN_FILE', __FILE__ );
        define( 'MCQPLUGIN_PATH', dirname( MCQPLUGIN_FILE ) );
        define( 'MCQPLUGIN_INCLUDES', MCQPLUGIN_PATH . '/includes' );
        define( 'MCQPLUGIN_URL', plugins_url( '', MCQPLUGIN_FILE ) );
        define( 'MCQPLUGIN_ASSETS', MCQPLUGIN_URL . '/assets' );
    }

    /**
     * Load the plugin after all plugis are loaded
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     */
    public function activate() {

        $installed = get_option( 'mcqplugin_installed' );

        if ( ! $installed ) {
            update_option( 'mcqplugin_installed', time() );
        }

        update_option( 'mcqplugin_version', MCQPLUGIN_VERSION );
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {

    }

    /**
     * Include the required files
     *
     * @return void
     */
    public function includes() {

        require_once MCQPLUGIN_INCLUDES . '/Assets.php';

        if ( $this->is_request( 'admin' ) ) {
            require_once MCQPLUGIN_INCLUDES . '/Admin.php';
        }

        if ( $this->is_request( 'frontend' ) ) {
            require_once MCQPLUGIN_INCLUDES . '/Frontend.php';
        }

        if ( $this->is_request( 'ajax' ) ) {
            // require_once MCQPLUGIN_INCLUDES . '/class-ajax.php';
        }

        require_once MCQPLUGIN_INCLUDES . '/Api.php';
        
        require_once MCQPLUGIN_INCLUDES . '/Admin/Quiz.php';
        $this->container['quiz'] = new App\Admin\Quiz();

        require_once MCQPLUGIN_INCLUDES . '/Frontend/Shortcode.php';
        $this->container['shortcode'] = new App\Frontend\Shortcode();
        
    }

    /**
     * Initialize the hooks
     *
     * @return void
     */
    public function init_hooks() {

        add_action( 'init', array( $this, 'init_classes' ) );

        // Localize our plugin
        add_action( 'init', array( $this, 'localization_setup' ) );
    }

    /**
     * Instantiate the required classes
     *
     * @return void
     */
    public function init_classes() {

        if ( $this->is_request( 'admin' ) ) {
            $this->container['admin'] = new App\Admin();
        }

        if ( $this->is_request( 'frontend' ) ) {
            $this->container['frontend'] = new App\Frontend();
        }

        if ( $this->is_request( 'ajax' ) ) {
            // $this->container['ajax'] =  new App\Ajax();
        }
        
        $this->container['api'] = new App\Api();
        $this->container['assets'] = new App\Assets();
    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'mcqplugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * What type of request is this?
     *
     * @param  string $type admin, ajax, cron or frontend.
     *
     * @return bool
     */
    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();

            case 'ajax' :
                return defined( 'DOING_AJAX' );

            case 'rest' :
                return defined( 'REST_REQUEST' );

            case 'cron' :
                return defined( 'DOING_CRON' );

            case 'frontend' :
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
        }
    }

} // Mcq_Plugin

$mcqplugin = Mcq_Plugin::init();