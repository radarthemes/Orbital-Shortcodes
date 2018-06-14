<?php
/**
* Plugin Name:  Orbital Shortcodes
* Description:  Lightweight shortcodes plugin for WordPress.
* Version:      1.0.0
* Author:       Marcell Purham
* Author URI:   http://marcell.me
* License:      GPL2
* License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) or die( 'Signal Error! Please try again.' );

// Lower priority of auto paragraph insertion.
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);

class RadarThemesShortcodes
{

	private static $_instance = null; // Only single instance of plugin

	private $plugin_version = '1.0.0'; // Current plugin version

	public function __construct()
	{

		add_shortcode('button', array($this,'trooper_button'));

		add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in widgets
		add_shortcode('highlight', array($this,'highlight_shortcode')); // Text Highlighting

		add_shortcode('tab', array($this,'tab_func'));
		add_shortcode('tabs', array($this,'tabs_func'));

		add_shortcode('accordion', array($this,'accordion_func'));
		add_shortcode('accordions', array($this,'accordions_func'));

		add_shortcode( 'code', array($this,'code_syntax_highlight'));

		add_action( 'wp_enqueue_scripts', array($this,'enqueue_style'));
		add_action( 'wp_enqueue_scripts', array($this,'enqueue_script'));

		add_action('wp_footer', array($this,'add_hljs_head'), 100);

	}

	/**
	 * Init hljs plugin
	 */
	public function add_hljs_head()
	{
		echo "<script>hljs.initHighlightingOnLoad();</script>";
	}

	/**
	 * Add css scripts
	 */
	public function enqueue_style()
	{
		wp_enqueue_style( 'orbitial-shortcodes', plugins_url( '/assets/css/orbital-shortcodes.css', __FILE__), false );
		wp_enqueue_style( 'orbital-shortcodes-hljs-dark', plugins_url( '/assets/css/hljs/atom-one-dark.css', __FILE__), false );
//		wp_enqueue_style( 'orbital-shortcodes-hljs-light', plugins_url( '/assets/css/hljs/github.css', __FILE__), false );
	}

	/**
	 * Add js scripts
	 */
	public function enqueue_script()
	{
		wp_enqueue_script( 'orbitial-shortcodes', plugins_url('/assets/js/orbital-shortcodes.js',__FILE__), false, $this->plugin_version,true );
		wp_enqueue_script( 'orbital-shortcodes-plugins', plugins_url('/assets/js/orbital-shortcodes-plugins.js',__FILE__), false, $this->plugin_version,true );
	}

	/**
     * Prints the accordion JavaScript in the footer
     * This includes both the accordion jQuery plugin file registered by
     * 'register_script()' and the accordion settings JavaScript variable.
     */
	public function print_script()
	{
        wp_enqueue_script('orbitial-shortcodes');
        // Output accordions settings JavaScript variable
        wp_localize_script('orbitial-shortcodes', 'radarShortcodesSettings', $this->script_data);
	}


	/**
	 * @param $atts
	 * @param null $content
	 *
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

		switch($color)
		{

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
		foreach ($single_tab_array as $tab => $tab_attr_array)
		{
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
		foreach ($single_accordion_array as $accordion => $accordion_attr_array)
		{
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
	 * @return string
	 */
	public function code_syntax_highlight( $atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'language' => '',
					'theme' => '',
				), $atts));

		$syntax_output = '<pre>';
		$syntax_output .= '<code class="hljs '. $atts['language'] .'">';
		$syntax_output .= strip_tags(wp_specialchars_decode(preg_replace('/^\s*[\r\n]+/', '', $content)));
		$syntax_output .= '</code>';
		$syntax_output .= '</pre>';

		return $syntax_output;
	}

	/**
	 * Only single instance
	 */
	public static function instance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new self();
		}
	}

}

RadarThemesShortcodes::instance();

?>