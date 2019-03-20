<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    RTS
 * @subpackage RTS/public
 * @author     Marcell Purham
 * @since      1.0.0
 *
 */

class RTS_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since   1.0.0
     * @param   string    $plugin_name   The name of the plugin.
     * @param   string    $version       The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action('wp_footer', array($this,'add_hljs_head'), 100);
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in RTS_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The RTS_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( $this->plugin_name, plugin_dir_url(__FILE__) . 'css/radar-shortcodes.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name .'hljs-dark', plugin_dir_url(__FILE__) . 'css/hljs/atom-one-dark.css', array(), $this->version, 'all' );
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in RTS_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The RTS_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script( $this->plugin_name, plugin_dir_url(__FILE__) .'js/radar-shortcodes.js', array('jquery'), $this->version, true );
        wp_enqueue_script( $this->plugin_name . '-plugins', plugin_dir_url(__FILE__) .'js/radar-shortcodes-plugins.js', false, $this->version, true );
    }

    /**
     * Init hljs plugin
     *
     * @since 1.0.0
     */
    public function add_hljs_head()
    {
        printf('%s', '<script>hljs.initHighlightingOnLoad();</script>');
    }



}
