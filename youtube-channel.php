<?php
/*
Plugin Name: YouTube Channel
Plugin URI: http://urosevic.net/wordpress/plugins/youtube-channel/
Description: <a href="widgets.php">Widget</a> that display latest video thumbnail or iframe (HTML5) video from YouTube Channel, Liked Videos, Favourites or Playlist.
Author: Aleksandar Urošević
Version: 3.0.6
Author URI: http://urosevic.net/
*/
// @TODO make FitVideo optional

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists('WPAU_YOUTUBE_CHANNEL') )
{
	class WPAU_YOUTUBE_CHANNEL
	{

		const DB_VER = 4;
		const VER = '3.0.6';

		public $plugin_name   = "YouTube Channel";
		public $plugin_slug   = "youtube-channel";

		public $plugin_option = "youtube_channel_defaults";

		public $vanity_id     = "AleksandarUrosevic";
		public $username_id   = "urkekg";
		public $channel_id    = "UCRPqmcpGcJ_gFtTmN_a4aVA"; // user channel UC; favourites list FL; liked list LL
		public $playlist_id   = "PLEC850BE962234400";
		public $plugin_url;

		/**
		 * Construct class
		 */
		function __construct() {

			$this->plugin_url = plugin_dir_url(__FILE__);
			load_plugin_textdomain( $this->plugin_slug, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

			// debug JSON
			if ( ! empty($_GET['ytc_debug_json_for']) )
				$this->generate_debug_json();

			// Activation hook and maybe update trigger
			register_activation_hook( __FILE__, array($this, 'activate') );
			add_action( 'plugins_loaded', array($this, 'maybe_update') );

			$this->defaults = self::defaults();

			if ( is_admin() ) {

				// Initialize Plugin Settings Magic
				add_action( 'init', array($this, 'admin_init') );

				// Add various Dashboard notices (if needed)
				add_action( 'admin_notices', array($this, 'admin_notices') );

				// Enqueue scripts and styles for Widgets page
				add_action('admin_enqueue_scripts', array($this, 'widget_scripts'));

			} else { // ELSE if ( is_admin() )

				// Enqueue frontend scripts
				add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts') );
				add_action( 'wp_footer', array($this, 'footer_scripts') );

			} // END if ( is_admin() )

			// Load widget
			require_once('inc/widget.php');

			// Register shortcodes `youtube_channel` and `ytc`
			add_shortcode( 'youtube_channel', array($this, 'shortcode') );
			add_shortcode( 'ytc', array($this, 'shortcode') );

		} // END function __construct()

		/**
		 * Activate the plugin
		 * Credits: http://solislab.com/blog/plugin-activation-checklist/#update-routines
		 */
		public static function activate() {

			global $WPAU_YOUTUBE_CHANNEL;
			$WPAU_YOUTUBE_CHANNEL->init_options();
			$WPAU_YOUTUBE_CHANNEL->maybe_update();

		} // end function activate

		/**
		 * Return initial options
		 * @return array Global defaults for current plugin version
		 */
		public function init_options() {

			$init = array(
				'vanity'         => $this->vanity_id,
				'channel'        => $this->channel_id,
				'username'       => $this->username_id,
				'playlist'       => $this->playlist_id,
				'resource'       => 0, // ex use_res
				// 'only_pl'        => 0,
				'cache'          => 300, // 5 minutes // ex cache_time
				'fetch'          => 25, // ex maxrnd
				'num'            => 1, // ex vidqty
				'privacy'        => 0,
				// 'random'         => 0, // ex getrnd

				'ratio'          => 3, // 3 - 16:9, 1 - 4:3 (deprecated: 2 - 16:10)
				'width'          => 306,
				'responsive'     => true,
				'display'        => 'thumbnail', // thumbnail, iframe, iframe2 (deprecated: chromeless, object)
				'themelight'     => 0,
				'controls'       => 0,
				'autoplay'       => 0,
				'autoplay_mute'  => 0,
				'norel'          => 0,

				'showtitle'      => 0,
				'showdesc'       => 0,
				'desclen'        => 0,
				'descappend'     => '&hellip;',
				'modestbranding' => 0,
				'hideanno'       => 0,
				'hideinfo'       => 0,

				'goto_txt'       => 'Visit our channel',
				'showgoto'       => 0,
				'popup_goto'     => 0, // 0 same window, 1 new window JS, 2 new window target
				'link_to'        => 0 // 0 legacy username, 1 channel, 2 vanity
			);

			add_option('youtube_channel_version', self::VER, '', 'no');
			add_option('youtube_channel_db_ver', self::DB_VER, '', 'no');
			add_option($this->plugin_option, $init, '', 'no');

		} // END public function init_options()

		/**
		 * Check do we need to migrate options
		 */
		public function maybe_update() {

			// bail if this plugin data doesn't need updating
			if ( get_option( 'youtube_channel_db_ver' ) >= self::DB_VER ) {
				return;
			}

			require_once( dirname(__FILE__) . '/update.php' );
			au_youtube_channel_update();

		} // END public function maybe_update()

		/**
		 * Initialize Settings link for Plugins page and create Settings page
		 */
		function admin_init() {

			add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settings_link') );

			require_once( 'inc/settings.php' );

			global $WPAU_YOUTUBE_CHANNEL_SETTINGS;
			if ( empty($WPAU_YOUTUBE_CHANNEL_SETTINGS) )
				$WPAU_YOUTUBE_CHANNEL_SETTINGS = new WPAU_YOUTUBE_CHANNEL_SETTINGS();

		} // END function admin_init_settings()

		/**
		 * Append Settings link for Plugins page
		 * @param array $links array of links on plugins page
		 */
		function add_settings_link($links) {

			$settings_title = __('Settings');
			$settings_link = "<a href=\"options-general.php?page={$this->plugin_slug}\">{$settings_title}</a>";
			array_unshift( $links, $settings_link );

			// Free some memory
			unset($settings_title, $settings_link);

			// Return updated array of links
			return $links;

		} // END function add_settings_link()

		/**
		 * Enqueue admin scripts and styles for widget customization
		 */
		function widget_scripts() {

			global $pagenow;

			// Enqueue only on widget page
			if( $pagenow !== 'widgets.php' && $pagenow !== 'customize.php' ) return;

			wp_enqueue_script(
				$this->plugin_slug . '-admin',
				plugins_url( 'assets/js/admin.min.js', __FILE__ ),
				array('jquery'),
				self::VER
			);
			wp_enqueue_style(
				$this->plugin_slug . '-admin',
				plugins_url( 'assets/css/admin.css', __FILE__ ),
				array(),
				self::VER
			);

		} // END function widget_scripts()

		/**
		 * Print dashboard notice
		 * @return string Formatted notice with usefull explanation
		 */
		function admin_notices() {

			// Get array of dismissed notices
			$dismissed_notices = get_option('youtube_channel_dismissed_notices');

			// Dismiss notices if requested and then update option in DB
			if ( ! empty($_GET['ytc_dismiss_notice_old_php']) ) {
				$dismissed_notices['old_php'] = 1;
				update_option('youtube_channel_dismissed_notices', $dismissed_notices);
			}
			if ( ! empty($_GET['ytc_dismiss_notice_apikey_wpconfig']) ) {
				$dismissed_notices['apikey_wpconfig'] = 1;
				update_option('youtube_channel_dismissed_notices', $dismissed_notices);
			}
			if ( ! empty($_GET['ytc_dismiss_notice_vanity_option']) ) {
				$dismissed_notices['vanity_option'] = 1;
				update_option('youtube_channel_dismissed_notices', $dismissed_notices);
			}

			// Prepare vars for notices
			$settings_page = 'options-general.php?page=youtube-channel';
			$notice = array(
				'error'   => '',
				'warning' => '',
				'info'    => ''
			);

			// Inform if PHP version is lower than 5.3
			if ( version_compare(PHP_VERSION, "5.3", "<") && ( empty($dismissed_notices) || ( ! empty($dismissed_notices) && empty($dismissed_notices['old_php']) ) ) ) {
				$notice['info'] .= sprintf(
					__('<p>Your website running on web server with PHP version %s. Please note that <strong>%s</strong> requires PHP at least 5.3 or newer to work properly. <a href="%s" class="dismiss">Dismiss</a></p>', 'youtube-channel'),
					PHP_VERSION,
					$this->plugin_name,
					'?ytc_dismiss_notice_old_php=1'
				);
			}

			// Inform if YOUTUBE_DATA_API_KEY is still in wp-config.php
			if ( defined('YOUTUBE_DATA_API_KEY') && empty($dismissed_notices['apikey_wpconfig']) ) {
				$notice['info'] .= sprintf(
					__('<p>Since <strong>%s</strong> v3.0.6 we store <strong>YouTube Data API Key</strong> in plugin settings. So, you can safely remove %s define line from your <strong>wp-config.php</strong> file. <a href="%s" class="dismiss">Dismiss</a></p>', 'youtube-channel'),
					$this->plugin_name,
					'YOUTUBE_DATA_API_KEY',
					'?ytc_dismiss_notice_apikey_wpconfig=1'
				);
			}

			// No YouTube DATA Api Key?
			if ( empty($this->defaults['apikey']) ) {
				$notice['error'] .= sprintf(
					__('<p>Please note, to make <strong>%s</strong> plugin v3+ work, generate <strong>YouTube Data API Key</strong> as explained <a href="%s" target="_blank">here</a> and add it at <a href="%s">General plugin settings tab</a>.<br><br>If you have any issue with new version of plugin, please ask for help on official <a href="%s" target="_blank">support forum</a>.<br>This notice will disappear when you add missing key as mentioned above!</p>', 'youtube-channel'),
					$this->plugin_name,
					'http://urosevic.net/wordpress/plugins/youtube-channel/#youtube_data_api_key',
					'options-general.php?page=youtube-channel&tab=general',
					'https://wordpress.org/support/plugin/youtube-channel'
				);
			}

			if ( empty($dismissed_notices) || ( ! empty($dismissed_notices) && empty($dismissed_notices['vanity_option']) ) ) {
				$notice['warning'] .= sprintf(
					__('<p><strong>%s</strong> since version 2.4 supports linking to channel through <em>Vanity/Custom</em> URL. Please review <a href="%s">global</a> and <a href="%s">widgets</a> settings. <a href="%s" class="dismiss">Dismiss</a>', 'youtube-channel'),
					$this->plugin_name,
					$settings_page,
					'widgets.php',
					'?ytc_dismiss_notice_vanity_option=1'
				 );
			}

			foreach ( $notice as $type => $message ) {
				if ( ! empty($message) ) {
					echo "<div class=\"notice notice-{$type}\">{$message}</div>";
				}
			}

		} // END function admin_notices()

		/**
		 * Get default options from DB
		 * @return array Latest global defaults
		 */
		public function defaults() {

			$defaults = get_option($this->plugin_option);
			if ( empty($defaults) ) {
				$this->init_options();
			}

			return $defaults;

		}

		function enqueue_scripts() {
			wp_enqueue_style( 'youtube-channel', plugins_url('assets/css/youtube-channel.min.css', __FILE__), array(), self::VER );

			// enqueue fitVids
			wp_enqueue_script( 'fitvids', plugins_url('assets/js/jquery.fitvids.min.js', __FILE__), array('jquery'), self::VER, true );

			// enqueue magnific-popup
			wp_enqueue_script( 'magnific-popup-au', plugins_url('assets/lib/magnific-popup/jquery.magnific-popup.min.js', __FILE__), array('jquery'), self::VER, true );
			wp_enqueue_style( 'magnific-popup-au', plugins_url('assets/lib/magnific-popup/magnific-popup.min.css', __FILE__), array(), self::VER );
			wp_enqueue_script( 'youtube-channel', plugins_url('assets/js/youtube-channel.min.js', __FILE__), array(), self::VER, true );
		} // end function enqueue_scripts

		function footer_scripts() {
			// Print JS only if we have set YTC array
			if ( ! empty($_SESSION['ytc_html5_js']) )
			{
				?>
<!-- YouTube Channel v<?php echo self::VER; ?> -->
<script type="text/javascript">
var tag = document.createElement('script');
tag.src = "//www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
function onYouTubeIframeAPIReady() {
<?php echo $_SESSION['ytc_html5_js']; ?>
}
function ytc_mute(event){
	event.target.mute();
}
</script>
<?php
			}

		} // eof footer_scripts

		public function shortcode($atts) {

			// get general default settings
			$instance = $this->defaults();

			// extract shortcode parameters
			extract(
				shortcode_atts(
					array(
						'vanity'     => $instance['vanity'],
						'channel'    => $instance['channel'],
						'username'   => $instance['username'],
						'playlist'   => $instance['playlist'],
						'res'        => '', // (deprecated, but leave for back compatibility) ex res
						'use_res'    => '', // (deprecated, but leave for back compatibility) ex use_res
						'resource'   => $instance['resource'], // ex use_res
						'only_pl'    => 0, // disabled by default (was: $instance['only_pl'],)
						'cache'      => $instance['cache'], // ex cache_time
						'privacy'    => $instance['privacy'], // ex showvidesc
						'fetch'      => $instance['fetch'], // ex maxrnd
						'num'        => $instance['num'], // ex vidqty

						'random'     => $instance['random'], // ex getrnd

						'ratio'      => $instance['ratio'],
						'width'      => $instance['width'],
						'responsive' => ( ! empty($instance['responsive']) ) ? $instance['responsive'] : '0',

						'show'       => $instance['display'], // (deprecated, but keep for back compatibility) ex to_show
						'display'    => $instance['display'],
						'no_thumb_title' => 0,
						'themelight' => $instance['themelight'],
						'controls'   => $instance['controls'],
						'autoplay'   => $instance['autoplay'],
						'mute'       => $instance['autoplay_mute'],
						'norel'      => $instance['norel'],

						'showtitle'  => $instance['showtitle'],
						'titlebelow'  => 0, // move title below video
						'showdesc'   => $instance['showdesc'], // ex showvidesc
						'nobrand'    => ( ! empty($instance['modestbranding']) ) ? $instance['modestbranding'] : '0',
						'desclen'    => $instance['desclen'], // ex videsclen
						'noinfo'     => $instance['hideinfo'],
						'noanno'     => $instance['hideanno'],

						'goto'       => $instance['showgoto'],
						'goto_txt'   => $instance['goto_txt'],
						'popup'      => $instance['popup_goto'],
						'link_to'    => $instance['link_to'],

						'class'      => ( ! empty($instance['class']) ) ? $instance['class'] : ''
						),
					$atts
				)
			);

			// backward compatibility for show -> display shortcode parameter
			if ( $show !== $display && $show !== $instance['display'] ) {
				$display = $show;
			}
			// backward compatibility for use_res -> resource shortcode parameter
			if ( ! empty($use_res) ) {
				$resource = $use_res;
			} else if ( ! empty($res) ) {
				$resource = $res;
			}

			// prepare instance for output
			$instance['vanity']         = $vanity;
			$instance['channel']        = $channel;
			$instance['username']       = $username;
			$instance['playlist']       = $playlist;
			$instance['resource']       = $resource; // resource: 0 channel, 1 favorites, 2 playlist
			$instance['only_pl']        = $only_pl; // use embedded playlist - false by default
			$instance['cache']          = $cache; // in seconds, def 5min - settings?
			$instance['privacy']        = $privacy; // enhanced privacy

			$instance['fetch']          = $fetch;
			$instance['num']            = $num; // num: 1

			$instance['random']         = $random; // use embedded playlist - false by default

			// Video Settings
			$instance['ratio']          = $ratio; // aspect ratio: 3 - 16:9, 2 - 16:10, 1 - 4:3
			$instance['width']          = $width; // 306
			$instance['responsive']     = $responsive; // enable responsivenes?
			$instance['display']        = $display; // thumbnail, iframe, iframe2
			$instance['no_thumb_title'] = $no_thumb_title; // hide tooltip for thumbnails

			$instance['themelight']     = $themelight; // use light theme, dark by default
			$instance['controls']       = $controls; // hide controls, false by default
			$instance['autoplay']       = $autoplay; // autoplay disabled by default
			$instance['autoplay_mute']  = $mute; // mute sound on autoplay - disabled by default
			$instance['norel']          = $norel; // hide related videos

			// Content Layout
			$instance['showtitle']      = $showtitle; // show video title, disabled by default
			$instance['titlebelow']      = $titlebelow; // show video title, disabled by default
			$instance['showdesc']       = $showdesc; // show video description, disabled by default
			$instance['modestbranding'] = $nobrand; // hide YT logo
			$instance['desclen']        = $desclen; // cut video description, number of characters
			$instance['hideinfo']       = $noinfo; // hide info by default
			$instance['hideanno']       = $noanno; // hide annotations, false by default

			// Link to Channel
			$instance['showgoto']       = $goto; // show goto link, disabled by default
			$instance['goto_txt']       = $goto_txt; // text for goto link - use settings
			$instance['popup_goto']     = $popup; // open channel in: 0 same window, 1 javascript new, 2 target new
			$instance['link_to']        = $link_to; // open channel in: 0 same window, 1 javascript new, 2 target new

			// Customization
			$instance['class']          = $class; // custom additional class for container

			return implode(array_values($this->output($instance)));
		} // END public function shortcode()

		// Print out YTC block
		public function output($instance) {

			// print info about API key to admins
			// and "Coming soon..." for visitors
			if ( empty($this->defaults['apikey']) ) {
				if ( current_user_can('manage_options') ) {
					$output[] = sprintf(
						__('<strong>%s</strong> version 3+ requires <strong>YouTube DATA API Key</strong> to work. <a href="%s" target="_blank">Learn more here</a>.', 'youtube-channel'),
						$this->plugin_name,
						'http://urosevic.net/wordpress/plugins/youtube-channel/#youtube_data_api_key'
					);

				} else {
					$output[] = "Coming soon...";
				}
				return $output;
			}

			// 1) Get resource from widget/shortcode
			// 2) If not set, get global default
			// 3) if no global, get plugin's default
			$resource = intval($instance['resource']);
			if ( empty($resource) && $resource !== 0 ) {
				$resource = intval($this->defaults['resource']);
				if ( empty($resource) ) {
					$resource = 0;
				}
			}

			// Get Channel or Playlist ID based on requested resource
			switch ($resource) {

				// Playlist
				case '2':
					// 1) Get Playlist from shortcode/widget
					// 2) If not set, use global default
					// 3) If no global, use plugin's default
					if ( ! empty($instance['playlist']) ) {
						$playlist = trim($instance['playlist']);
					} else {
						$playlist = trim($this->defaults['playlist']);
						if ( $playlist == "" ) {
							$playlist = trim($this->playlist_id);
						}
					}
					break;

				// Channel, Favourites, Liked
				default:
					/* Channel */
					// 1) Get channel from shortcode/widget
					// 2) If not set, use global default
					// 3) If no global, use plugin's default
					if ( ! empty($instance['channel']) ) {
						$channel = trim($instance['channel']);
					} else {
						$channel = trim($this->defaults['channel']);
						if ( empty($channel) ) {
							$channel = trim($this->channel_id);
						}
					}

			} // END switch ($resource)

			// Set custom class and responsive if needed
			$class = $instance['class'] ? $instance['class'] : 'default';
			if ( ! empty($instance['responsive']) ) {
				$class .= ' responsive';
			}

			switch ($resource) {
				case 1: // Favourites
					$resource_name = 'favourites';
					$resource_id = preg_replace('/^UC/', 'FL', $channel);
					break;
				case 2: // Playlist
					$resource_name = 'playlist';
					$resource_id = $playlist;
					break;
				case 3: // Liked
					$resource_name = 'liked';
					$resource_id = preg_replace('/^UC/', 'LL', $channel);
					break;
				default: // Channel
					$resource_name = 'channel';
					$resource_id = preg_replace('/^UC/', 'UU', $channel); //$channel;
			}

			// Start output array
			$output = array();

			$output[] = "<div class=\"youtube_channel {$class}\">";

			if ( $instance['only_pl'] ) { // print standard playlist

				$output = array_merge($output, self::embed_playlist($resource_id, $instance));

			} else { // videos from channel, favourites, liked or playlist

				// get max items for random video
				$fetch = $instance['fetch'];
				if ( $fetch < 1 ) { $fetch = 10; } // default 10
				elseif ( $fetch > 50 ) { $fetch = 50; } // max 50

				$resource_key = "{$resource_id}_{$fetch}";

				// Do we need cache? let we define cache fallback key
				$cache_key_fallback = 'ytc_' . md5($resource_key) . '_fallback';

				// Do cache magic
				if ( $instance['cache'] > 0 ) {

					// generate feed cache key for caching time
					$cache_key = 'ytc_'.md5($resource_key).'_'.$instance['cache'];

					if ( ! empty($_GET['ytc_force_recache']) )
						delete_transient($cache_key);

					// get/set transient cache
					if ( false === ($json = get_transient($cache_key)) || empty($json) ) {

						// no cached JSON, get new
						$json = $this->fetch_youtube_feed($resource_id, $fetch);

						// set decoded JSON to transient cache_key
						set_transient($cache_key, base64_encode($json), $instance['cache']);

					} else {

						// we already have cached feed JSON, get it encoded
						$json = base64_decode($json);

					}

				} else {

					// just get fresh feed if cache disabled
					$json = $this->fetch_youtube_feed($resource_id, $fetch);

				}

				// free some memory
				unset( $response );

				// decode JSON data
				$json_output = json_decode($json);

				// if current feed is messed up, try to get it from fallback cache
				if ( is_wp_error($json_output) && ! is_object($json_output) && empty($json_output->items) ) {
					error_log("[YTC] Get fallback feed for $feed_url");
					// do we have fallback cache?!
					if ( true === ( $json_fallback = get_transient( $cache_key_fallback ) ) && ! empty($json_fallback) ) {
						$json_output = json_decode( base64_decode($json_fallback) );
						// and free memory
						unset( $json_fallback );
					}
				}

				// Predefine `max_items` to prevent undefined notices
				$max_items = 0;
				if ( ! is_wp_error($json_output) && is_object($json_output) && !empty($json_output->items) ) {
					// Sort by date uploaded
					$json_entry = $json_output->items;

					$num = $instance['num'];
					if ( $num > $fetch ) { $fetch = $num; }
					$max_items = ( $fetch > sizeof($json_entry) ) ? sizeof($json_entry) : $fetch;

					if ( ! empty($instance['random']) ) {
						$items = array_slice($json_entry, 0, $max_items);
					} else {
						if ( ! $num ) $num = 1;
						$items = array_slice($json_entry, 0, $num);
					}
				}

				if ($max_items == 0) {

					// is this WP error?
					if ( is_wp_error($json_output) ) {
						$error_string = $json_output->get_error_message();
						$output[] = $error_string;
						unset($error_string);
					} else {
						$output[] = __("Ups, something went wrong.", 'youtube-channel');
						// append YouTube DATA API error reason as comment
						if ( ! empty($json_output) && is_object($json_output) && !empty($json_output->error->errors) ) {
							$output[] = "<!-- YTC ERROR:\n";
							$output[] = 'domain: ' . $json_output->error->errors[0]->domain . "\n";
							$output[] = 'reason: ' . $json_output->error->errors[0]->reason . "\n";
							$output[] = 'message: ' . $json_output->error->errors[0]->message . "\n";

							if ( $json_output->error->errors[0]->reason == 'playlistNotFound' ) {
								if ( $resource_name == 'playlist' ) {
									$output[] = "tip: Please check did you set existing Playlist ID. We should display videos from {$resource_name} videos, but YouTube does not recognize {$resource_id} as existing and public playlist.\n";
								} else {
									$output[] = "tip: Please check did you set proper Channel ID. We should display videos from {$resource_name} videos, but YouTube does not recognize your channel ID {$channel} as existing and public resource.\n";
								}
							}
							elseif ( $json_output->error->errors[0]->reason == 'keyInvalid' ) {
								$output[] = "tip: Double check YouTube Data API Key on General plugin tab and make sure it`s correct. Check https://wordpress.org/plugins/youtube-channel/installation/\n";
							}
							elseif ( $json_output->error->errors[0]->reason == 'ipRefererBlocked' ) {
								$output[] = "tip: Check YouTube Data API Key restrictions, empty cache if enabled and append in browser address bar parameter ?ytc_force_recache=1\n";
							}
							elseif ( $json_output->error->errors[0]->reason == 'invalidChannelId' ) {
								$output[] = "tip: You have set wrong Channel ID. Fix that in General plugin settings, Widget and/or shortcode. Check https://wordpress.org/plugins/youtube-channel/faq/\n";
							}
							$output[] = "-->\n";
						}
					}

				} else { // ELSE if ($max_items == 0)

					// looks that feed is OK, let we update fallback that never expire
					set_transient($cache_key_fallback, base64_encode($json), 0);

					// and now free some memory
					unset ( $json, $json_output, $json_entry );

					// set array for unique random item
					if ( ! empty($instance['random']) ) {
						$random_used = array();
					}

					/* AU:20141230 reduce number of videos if requested > available */
					if ( $num > sizeof($items) ) {
						$num = sizeof($items);
					}

					for ($y = 1; $y <= $num; ++$y) {
						if ( ! empty($instance['random']) ) {

							$random_item = mt_rand( 0, (count($items)-1) );
							while ( $y > 1 && in_array($random_item, $random_used) ) {
								$random_item = mt_rand(0, (count($items)-1));
							}
							$random_used[] = $random_item;
							$item = $items[ $random_item ];
						} else {
							$item = $items[ $y - 1 ];
						}

						// print single video block
						$output = array_merge( $output, $this->ytc_print_video($item, $instance, $y) );
					}
					// Free some memory
					unset($random_used, $random_item, $json);

				} // END if ($max_items == 0)

			} // single playlist or ytc way

			if ( ! empty($instance['showgoto']) ) {
				$output = array_merge( $output, $this->ytc_channel_link($instance) ); // insert link to channel on bootom of widget
			}

			$output[] = '</div><!-- .youtube_channel -->';

			// fix overflow on crappy themes
			$output[] = '<div class="clearfix"></div>';

			return $output;

		} // END public function output($instance)

		// --- HELPER FUNCTIONS ---

		/**
		 * Download YouTube video feed through API 3.0
		 * @param  string $id       ID of resource
		 * @param  integer $items   Number of items to fetch (min 2, max 50)
		 * @return array            JSON with videos
		 */
		function fetch_youtube_feed($resource_id, $items) {

			$feed_url = 'https://www.googleapis.com/youtube/v3/playlistItems?';
			$feed_url .= 'part=snippet';
			$feed_url .= "&playlistId={$resource_id}";
			$feed_url .= '&fields=items(snippet(title%2Cdescription%2CpublishedAt%2CresourceId(videoId)))';
			$feed_url .= "&maxResults={$items}";
			$feed_url .= "&key={$this->defaults['apikey']}";

			$wprga = array(
				'timeout' => 5 // five seconds only
			);
			$response = wp_remote_get($feed_url, $wprga);
			$json = wp_remote_retrieve_body( $response );

			// free some memory
			unset($response);

			return $json;

		} // END function fetch_youtube_feed($resource_id, $items)

		// function to calculate height by width and ratio
		function height_ratio($width=306, $ratio) {

			switch ($ratio)
			{
				case 1:
					$height = round(($width / 4 ) * 3);
					break;
				case 2:
				case 3:
				default:
					$height = round(($width / 16 ) * 9);
			}
			return $height;
		} // END function height_ratio($width=306, $ratio)

		/**
		 * Generate link to YouTUbe channel/user
		 * @param  array $instance widget or shortcode settings
		 * @return array           components prepared for output
		 */
		function ytc_channel_link($instance) {

			// initialize array
			$output = array();

			// do we need to show goto link?
			if ( $instance['showgoto'] ) {

				$link_to  = $instance['link_to'];

				$channel  = trim($instance['channel']);
				if ( empty( $channel ) )
					$channel = $this->channel_id;

				$username = trim($instance['username']);
				if ( empty( $username ) )
					$username = $this->username_id;

				// sanity vanity content (strip all in front of last slash to cleanup vanity ID only)
				$vanity   = trim($instance['vanity']);
				if ( ! empty( $vanity ) && strpos($vanity, 'youtube.com') !== false )
					$vanity = preg_replace('/^.*\//', '', $vanity);

				// if $vanity is empty, use default
				if ( empty( $vanity ) )
					$vanity = $this->vanity_id;

				$goto_txt = trim($instance['goto_txt']);

				if ( $goto_txt == "" )
					$goto_txt = __('Visit our YouTube channel', 'youtube-channel');

				$goto_txt = str_replace('%username%', $username, $goto_txt);
				$goto_txt = str_replace('%channel%', $channel, $goto_txt);
				$goto_txt = str_replace('%vanity%', $vanity, $goto_txt);

				$output[] = '<div class="clearfix"></div>';
				$output[] = '<div class="ytc_link">';

				$goto_url = "https://www.youtube.com/";
				if ( $link_to == '2' ) { // vanity
					$goto_url .= "c/$vanity";
				} else if ( $link_to == '0') { // legacy username
					$goto_url .= "user/$username";
				} else { // channel (default)
					$goto_url .= "channel/$channel";
				}

				$newtab = __("in new window/tab", 'youtube-channel');

				$output[] = '<p>';
				switch ( $instance['popup_goto'] ) {
					case 1:
						$output[] = "<a href=\"javascript: window.open('{$goto_url}'); void 0;\" title=\"{$goto_txt} {$newtab}\">{$goto_txt}</a>";
						break;
					case 2:
						$output[] = "<a href=\"{$goto_url}\" target=\"_blank\" title=\"{$goto_txt} {$newtab}\">{$goto_txt}</a>";
						break;
					default:
						$output[] = "<a href=\"{$goto_url}\" title=\"{$goto_txt}\">$goto_txt</a>";
				} // switch popup_goto
				$output[] = '</p>';
				$output[] = '</div>';

			} // showgoto

			return $output;
		} // end function ytc_channel_link

		/* function to print video block */
		function ytc_print_video($item, $instance, $y) {

			// get hideinfo, autoplay and controls settings
			// where this is used?
			$hideinfo       = $instance['hideinfo'];
			$autoplay       = $instance['autoplay'];
			$autoplay_mute  = $instance['autoplay_mute'];
			$controls       = $instance['controls'];
			$norel          = $instance['norel'];
			$class          = $instance['class'];
			$modestbranding = $instance['modestbranding'];

			// set width and height
			$width  = ( empty($instance['width']) ) ? 306 : $instance['width'];
			$height = $this->height_ratio($width, $instance['ratio']);

			// calculate image height based on width for 4:3 thumbnail
			$imgfixedheight = $width / 4 * 3;

			// which type to show
			$display    = (empty($instance['display'])) ? 'object' : $instance['display'];
			$hideanno   = $instance['hideanno'];
			$themelight = $instance['themelight'];
			/* end of video settings */

			// Prepare Video ID from Resource
			$yt_id = $item->snippet->resourceId->videoId;
			$yt_url    = "v/$yt_id";
			$yt_thumb  = "//img.youtube.com/vi/$yt_id/0.jpg"; // zero for HD thumb
			$yt_video  = "//www.youtube.com/watch?v=" . $yt_id;

			$yt_title  = $item->snippet->title;
			$yt_date   = $item->snippet->publishedAt;

			switch ($y) {
				case 1:
					$vnumclass = 'first';
					break;
				case $instance['num']:
					$autoplay = false;
					$vnumclass = 'last';
					break;
				default:
					$vnumclass = 'mid';
					$autoplay = false;
					break;
			}

			// set proper class for responsive thumbs per selected aspect ratio
			switch ($instance['ratio'])
			{
				case 1: $arclass = 'ar4_3'; break;
				default: $arclass = 'ar16_9';
			}
			$output[] = "<div class=\"ytc_video_container ytc_video_{$y} ytc_video_{$vnumclass} ${arclass}\" style=\"width:{$width}px\">";

			// show video title above video?
			if ( ! empty($instance['showtitle']) && empty($instance['titlebelow']) ) {
				$output[] = "<h3 class=\"ytc_title\">{$yt_title}</h3>";
			}

			// Define object ID
			$ytc_vid = "ytc_{$yt_id}";

			// Enhanced privacy?
			$youtube_domain = $this->youtube_domain($instance);

			// Print out video
			if ( $display == "iframe" ) {
				if ( empty($usepl) ) {
					$yt_url = $yt_id;
				}

				// Start wrapper for responsive item
				if ( $instance['responsive'] ) {
					$output[] = '<div class="fluid-width-video-wrapper">';
				}

				$output[] = "<iframe title=\"YouTube Video Player\" width=\"{$width}\" height=\"{$height}\" src=\"//{$youtube_domain}/embed/{$yt_url}?wmode=opaque";
				if ( $controls ) $output[] = "&amp;controls=0";
				if ( $hideinfo ) $output[] = "&amp;showinfo=0";
				if ( $autoplay ) $output[] = "&amp;autoplay=1";
				if ( $hideanno ) $output[] = "&amp;iv_load_policy=3";
				if ( $themelight ) $output[] = "&amp;theme=light";
				if ( $modestbranding ) $output[] = "&amp;modestbranding=1";
				// disable related videos
				if ( $norel ) $output[] = "&amp;rel=0";

				$output[] = "\" style=\"border:0;\" allowfullscreen id=\"{$ytc_vid}\"></iframe>";

				// Close wrapper for responsive item
				if ( $instance['responsive'] ) {
					$output[] = '</div>';
				}

			} else if ( $display == "iframe2" ) {

				// youtube API async
				if ( empty($usepl) ) $yt_url = $yt_id;

				$js_rel            = ( $norel ) ? "rel: 0," : '';
				$js_controls       = ( $controls ) ? "controls: 0," : '';
				$js_showinfo       = ( $hideinfo ) ? "showinfo: 0," : '';
				$js_iv_load_policy = ( $hideanno ) ? "iv_load_policy: 3," : '';
				$js_theme          = ( $themelight ) ? "theme: 'light'," : '';
				$js_autoplay       = ( $autoplay ) ? "autoplay: 1," : '';
				$js_modestbranding = ( $modestbranding ) ? "modestbranding: 1," : '';
				$js_autoplay_mute  = ( $autoplay && $autoplay_mute ) ? "events: {'onReady': ytc_mute}" : '';
				$js_player_id      = str_replace('-', '_', $yt_url);

				// Start wrapper for responsive item
				if ( $instance['responsive'] ) {
					$output[] = '<div class="fluid-width-video-wrapper">';
				}

				$output[] = '<div id="ytc_player_'.$js_player_id.'"></div>';

				// Close wrapper for responsive item
				if ( $instance['responsive'] ) {
					$output[] = '</div>';
				}

				$site_domain = $_SERVER['HTTP_HOST'];
				$ytc_html5_js = <<<JS
					var ytc_player_$js_player_id;
					ytc_player_$js_player_id = new YT.Player('ytc_player_$js_player_id', {
						height: '$height',
						width: '$width',
						videoId: '$yt_url',
						enablejsapi: 1,
						playerVars: {
							$js_autoplay $js_showinfo $js_controls $js_theme $js_rel $js_modestbranding wmmode: 'opaque'
						},
						origin: '$site_domain',
						$js_iv_load_policy $js_autoplay_mute
					});
JS;

			// prepare JS for footer
			if ( empty($_SESSION['ytc_html5_js']) )
				$_SESSION['ytc_html5_js'] = $ytc_html5_js;
			else
				$_SESSION['ytc_html5_js'] .= $ytc_html5_js;

			} else { // default is thumbnail

				// set proper class for responsive thumbs per selected aspect ratio
				switch ($instance['ratio']) {
					case 1:
						$arclass = 'ar4_3';
						break;
					default:
						$arclass = 'ar16_9';
				}

				// Do we need tooltip for thumbnail?
				if ( empty($instance['no_thumb_title']) ) {
					$title = sprintf( __('Watch video %1$s published on %2$s', 'youtube-channel' ), $yt_title, $yt_date );
				}

				$p = '';
				if ( $norel ) $p .= '&amp;rel=0';
				if ( $modestbranding ) $p .= "&amp;modestbranding=1";
				if ( $controls ) $p .= "&amp;controls=0";

				// Do we need thumbnail w/ or w/o tooltip
				if ( empty($instance['no_thumb_title']) ) {
					$output[] = "<a href=\"${yt_video}${p}\" title=\"{$yt_title}\" class=\"ytc_thumb ytc-lightbox {$arclass}\"><span style=\"background-image: url({$yt_thumb});\" title=\"{$title}\" id=\"{$ytc_vid}\"></span></a>";
				} else {
					$output[] = "<a href=\"${yt_video}${p}\" class=\"ytc_thumb ytc-lightbox {$arclass}\"><span style=\"background-image: url({$yt_thumb});\" id=\"{$ytc_vid}\"></span></a>";
				}

			} // what to show conditions

			// show video title below video?
			if ( ! empty($instance['showtitle']) && ! empty($instance['titlebelow']) ) {
				$output[] = "<h3 class=\"ytc_title\">{$yt_title}</h3>";
			}

			// do we need to show video description?
			if ( $instance['showdesc'] ) {

				$video_description = $item->snippet->description;
				$etcetera = '';
				if ( $instance['desclen'] > 0 ) {
					if ( strlen($video_description) > $instance['desclen'] ) {
						$video_description = substr($video_description, 0, $instance['desclen']);
						if ( $instance['descappend'] ) {
							$etcetera = $instance['descappend'];
						} else {
							$etcetera = '&hellip;';
						}
					}
				}

				if ( ! empty($video_description) ) {
					$output[] = "<p class=\"ytc_description\">{$video_description}{$etcetera}</p>";
				}

			}

			$output[] = '</div><!-- .ytc_video_container -->';

			return $output;
		} // end function ytc_print_video

		/* function to print standard playlist embed code */
		function embed_playlist($resource_id, $instance) {

			$width = ( empty($instance['width']) ) ? 306 : $instance['width'];
			$height = self::height_ratio($width, $instance['ratio']);
			$autoplay = (empty($instance['autoplay'])) ? '' : '&autoplay=1';
			$theme = (empty($instance['themelight'])) ? '' : '&theme=light';
			$modestbranding = (empty($instance['modestbranding'])) ? '' : '&modestbranding=1';
			$rel = (empty($instance['norel'])) ? '' : '&rel=0';

			// enhanced privacy
			$youtube_domain = $this->youtube_domain($instance);

			$output[] = "<div class=\"ytc_video_container ytc_video_1 ytc_video_single ytc_playlist_only\">";
			$output[] = "<iframe src=\"//{$youtube_domain}/embed/videoseries?list={$resource_id}{$autoplay}{$theme}{$modestbranding}{$rel}\"";
			$output[] = " width=\"{$width}\" height=\"{$height}\" frameborder=\"0\"></iframe></div>";

			return $output;

		} // END function embed_playlist($resource_id, $instance)

		// Helper function cache_time()
		function cache_time($cache_time)
		{
			$times = array(
				'minute' => array(
					1  => __("1 minute", 'youtube-channel'),
					5  => __("5 minutes", 'youtube-channel'),
					15 => __("15 minutes", 'youtube-channel'),
					30 => __("30 minutes", 'youtube-channel')
				),
				'hour' => array(
					1  => __("1 hour", 'youtube-channel'),
					2  => __("2 hours", 'youtube-channel'),
					5  => __("5 hours", 'youtube-channel'),
					10 => __("10 hours", 'youtube-channel'),
					12 => __("12 hours", 'youtube-channel'),
					18 => __("18 hours", 'youtube-channel')
				),
				'day' => array(
					1 => __("1 day", 'youtube-channel'),
					2 => __("2 days", 'youtube-channel'),
					3 => __("3 days", 'youtube-channel'),
					4 => __("4 days", 'youtube-channel'),
					5 => __("5 days", 'youtube-channel'),
					6 => __("6 days", 'youtube-channel')
				),
				'week' => array(
					1 => __("1 week", 'youtube-channel'),
					2 => __("2 weeks", 'youtube-channel'),
					3 => __("3 weeks", 'youtube-channel'),
					4 => __("1 month", 'youtube-channel')
				)
			);

			$out = "";
			foreach ($times as $period => $timeset)
			{
				switch ($period)
				{
					case 'minute':
						$sc = MINUTE_IN_SECONDS;
						break;
					case 'hour':
						$sc = HOUR_IN_SECONDS;
						break;
					case 'day':
						$sc = DAY_IN_SECONDS;
						break;
					case 'week':
						$sc = WEEK_IN_SECONDS;
						break;
				}

				foreach ($timeset as $n => $s)
				{
					$sec = $sc * $n;
					$out .='<option value="'.$sec.'" '. selected( $cache_time, $sec, 0 ).'>'.__($s, $this->plugin_slug).'</option>';
					unset($sec);
				}
			}
			return $out;
		} // end function cache_time

		function youtube_domain($instance) {
			$youtube_domain = ( !empty($instance['privacy']) ) ? 'www.youtube-nocookie.com' : 'www.youtube.com';
			return $youtube_domain;
		} // end function youtube_domain

		function clean_playlist_id($playlist) {
			if ( substr($playlist,0,4) == "http" ) {
				// if URL provided, extract playlist ID
				$playlist = preg_replace('/.*list=PL([A-Za-z0-9\-\_]*).*/','$1', $playlist);
			} else if ( substr($playlist,0,2) == 'PL' ) {
				$playlist = substr($playlist,2);
			}
			return $playlist;
		} // end function clean_playlist_id

		function generate_debug_json()
		{
			global $wp_version;

			// get widget ID from parameter
			$for = $_GET['ytc_debug_json_for'];

			if ( $for == 'global' ) {
				// global settings
				$options = get_option('youtube_channel_defaults');

				if ( ! is_array($options) )
					return;

				// remove YouTube Data API Key from config JSON
				unset($options['apikey']);

			} else {
				// for widget
				// prepare option name and widget ID
				$option_name = "widget_".substr($for,0,strrpos($for,"-"));
				$widget_id = substr($for,strrpos($for,"-")+1);

				// get YTC widgets options
				$widget_options = get_option($option_name);

				if ( ! is_array($widget_options[$widget_id]) )
					return;

				$options = $widget_options[$widget_id];
				unset ($widget_options);
			}

			// prepare debug data with settings of current widget
			$data = array_merge(
				array(
					'date'      => date("r"),
					'server'    => $_SERVER["SERVER_SOFTWARE"],
					'php'       => PHP_VERSION,
					'wp'        => $wp_version,
					'ytc'       => self::VER,
					'url'       => get_site_url(),
					'for' => $for
				),
				$options
			);

			// return JSON file
			header('Content-disposition: attachment; filename='.$for.'.json');
			header('Content-Type: application/json');
			echo json_encode($data);

			// destroy vars
			unset($data,$options,$widget_id,$option_name,$for);

			// exit now, because we need only debug data in JSON file, not settings or any other page
			exit;
		}
	} // end class
} // end class check

// add_action('plugins_loaded', create_function( '', '$WPAU_YOUTUBE_CHANNEL = new WPAU_YOUTUBE_CHANNEL();' ) );

global $WPAU_YOUTUBE_CHANNEL;
if ( empty($WPAU_YOUTUBE_CHANNEL) )
	$WPAU_YOUTUBE_CHANNEL = new WPAU_YOUTUBE_CHANNEL();
