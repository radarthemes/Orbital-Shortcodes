<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @package    RTS
 * @subpackage Radar_Shortcodes/includes
 * @author     Marcell Purham
 * @since 1.0.0
 *
 */


defined( 'ABSPATH' ) or die( 'Signal Error! Please try again.' );

class RTS_Shortcodes {
    
    /**
     * The current name of the plugin
     *
     * @var string
     * @since 1.0.0
     */
    protected $Radar_Shortcodes;

    /**
     * The current version of the plugin
     *
     * @var string
     * @since 1.0.0
     */
    private $version = '1.0.0';

    /**
     *
    * @since 1.0.0
    */
    public function __construct() 
    {
        if ( defined( 'RADAR_SHORTCODES_VERSION' ) ) {
            $this->version = RADAR_SHORTCODES_VERSION;
        }

        $this->Radar_Shortcodes = 'Radar Shortcodes';
        $this->init();
    }
    
    /**
    * Initialize shortcode scripts and elements
    *
     * TODO: Extract shortcodes into classes
     *
    * @since 1.0.0
    */
    protected function init() 
    {
        add_shortcode('button', array($this,'trooper_button'));

        add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in widgets
        add_shortcode('highlight', array($this,'highlight_shortcode')); // Text Highlighting

        add_shortcode('tab', array($this,'tab_func'));
        add_shortcode('tabs', array($this,'tabs_func'));

        add_shortcode('accordion', array($this,'accordion_func'));
        add_shortcode('accordions', array($this,'accordions_func'));

        add_shortcode( 'code', array($this,'code_syntax_highlight'));


        $this->load_dependencies();
        $this->set_locale();
        $this->define_public_hooks();
    }


    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - RTS_Loader. Orchestrates the hooks of the plugin.
     * - RTS_i18n. Defines internationalization functionality.
     * - RTS_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-radar-shortcodes-loader.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-radar-shortcodes-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-radar-shortcodes-public.php';

        $this->loader = new RTS_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the RTS_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {
        $plugin_i18n = new RTS_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {
        $plugin_public = new RTS_Public( $this->get_Radar_Shortcodes(), $this->get_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
    }
    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }
    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_Radar_Shortcodes() {
        return $this->Radar_Shortcodes;
    }
    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Radar_Shortcodes_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }
    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

    /**
    * @param $atts
    * @param null $content
    *
    * @since 1.0.0
    * @return string
    */
    public function trooper_button( $atts, $content = null )
    {
        $button = shortcode_atts(array(
            'link'	=> '#',
            'target'=> '',
            'style' => '',
            'type'	=> '', // basic, rounded,simple,circle,square
            'size'	=> '',
            'align'	=> '',
            'fa'    => '',
        ), $atts);

        $out = '<a' . $button['target'] . ' class="button color_'. $button['style'] .' btn-' . $button['type'] . '" href="' .$button['link']. '">';
        $out .= ($button['fa'] == '')? '' : '<i class="fa fa-'. $button['fa'] .'"></i>';
        $out .= do_shortcode($content);
        $out .= '</a>';

        return $out;
    }

    /**
    * @param $atts
    * @param null $content
    *
    * @since 1.0.0
    * @return string
    */
    public function highlight_shortcode($atts, $content = null)
    {
        extract(
            shortcode_atts(
                array(
                    'color' => 'light'
            ), $atts)
        );

        switch($color) {

            case 'blue':
                $class = 'highlight-blue';
            break;

            case 'orange':
                $class = 'highlight-orange';
            break;

            case 'green':
                $class = 'highlight-green';
            break;

            case 'purple':
                $class = 'highlight-purple';
            break;

            case 'pink':
                $class = 'highlight-pink';
            break;

            case 'red':
                $class = 'highlight-red';
            break;

            case 'grey':
                $class = 'highlight-grey';
            break;

            case 'light':
                $class = 'highlight-light';
            break;

            case 'black':
                $class = 'highlight-black';
            break;

            case 'yellow':
                $class = 'highlight-yellow';
            break;

            default:

        }

        return '<span class="highlight '.$class.'">'.do_shortcode($content).'</span>';
    }

    /**
    * @param $atts
    * @param null $content
    *
    * @since 1.0.0
    * @return mixed|string|void
    */
    public function tab_func( $atts, $content = null ) 
    {
        extract(
            shortcode_atts(
                array(
                    'title'      => '',
        ), $atts));

        global $single_tab_array;
        $single_tab_array[] = array('title' => $title, 'content' => trim(do_shortcode($content)));

        return json_encode($single_tab_array);
    }

    /**
    * @param $atts
    * @param null $content
    *
    * @since 1.0.0
    * @return string
    */
    public function tabs_func( $atts, $content = null )
    {
        global $single_tab_array;
        $single_tab_array = array(); // clear the array
        $tabs_content = '';
        $tabs_output = '';

        $tabs_nav = '<div class="clear"></div>';
        $tabs_nav .= '<div class="tabs-wrapper">';
        $tabs_nav .= '<ul class="tabs" style="margin:0;">';
        do_shortcode($content); // execute the '[tab]' shortcode first to get the title and content

        foreach ($single_tab_array as $tab => $tab_attr_array) {
            $random_id = rand(1000,2000);
            $default = ( $tab == 0 ) ? ' class="defaulttab"' : '';
            $tabs_nav .= '<li><a href="javascript:void(0)"'.$default.' rel="tab'.$random_id.'"><span>'.$tab_attr_array['title'].'</span></a></li>';
            $tabs_content .= '<div class="tab-content" id="tab'.$random_id.'">' . strip_tags($tab_attr_array['content'], '') . '</div>';
        }
        $tabs_nav .= '</ul>';
        $tabs_output .= $tabs_nav . $tabs_content;
        $tabs_output .= '</div><!-- tabs-wrapper end -->';
        $tabs_output .= '<div class="clear"></div>';

        return $tabs_output;
    }

    /**
    * Shortcode: toggle_content
    *
    * @param $atts
    * @param null $content
    *
    * @since 1.0.0
    * @return serialize string
    */
    public function accordion_func( $atts, $content = null )
    {
        extract(
            shortcode_atts(
                array(
                    'title' => '',
        ), $atts));

        global $single_accordion_array;
        $single_accordion_array[] = array('title' => $title, 'content' => trim(do_shortcode($content)));

        return json_encode($single_accordion_array);
    }

    /**
    * @param $atts
    * @param null $content
    *
    * @return string
    */
    public function accordions_func( $atts, $content = null ) 
    {
        global $single_accordion_array;
        $single_accordion_array = array(); // clear the array
        $accordions_output = '';

        $accordions_nav = '<div class="clear"></div>';
        $accordions_nav .= '<ul class="accordion">';
        do_shortcode($content); // execute the '[tab]' shortcode first to get the title and content

        foreach ($single_accordion_array as $accordion => $accordion_attr_array) {
            $accordions_nav .= '<li><a class="toggle" href="javascript:void(0);">'.$accordion_attr_array['title'].'</a>';
            $accordions_nav .= '<ul class="accordion-content"><li>' . strip_tags($accordion_attr_array['content'], '') . '</li></ul>';
            $accordions_nav .= '</li>';
        }

        $accordions_nav .= '</ul>';
        $accordions_output .= $accordions_nav;
        $accordions_output .= '<div class="clear"></div>';

        return $accordions_output;
    }

    /**
    * @param $atts
    * @param null $content
    *
    * @since 1.0.0
    * @return string
    */
    public function code_syntax_highlight( $atts, $content = null)
    {
        extract(
            shortcode_atts(
                array(
                    'language' => '',
                    'theme' => '',
                ), $atts)
        );

        $syntax_output = '<pre>';
        $syntax_output .= '<code class="hljs '. $atts['language'] .'">';
        $syntax_output .= strip_tags(wp_specialchars_decode($content));
        $syntax_output .= '</code>';
        $syntax_output .= '</pre>';

        return $syntax_output;
    }

}

