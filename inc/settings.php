<?php

if ( ! class_exists('WPAU_YOUTUBE_CHANNEL_SETTINGS') ) {

	class WPAU_YOUTUBE_CHANNEL_SETTINGS {

		private $option_name;
		private $defaults;
		private $slug;

		/**
		 * Construct the plugin object
		 */
		public function __construct() {

			global $WPAU_YOUTUBE_CHANNEL;

			// get default values
			$this->slug = $WPAU_YOUTUBE_CHANNEL->plugin_slug;
			$this->option_name = $WPAU_YOUTUBE_CHANNEL->plugin_option;
			$this->defaults = get_option( $this->option_name );

			// register actions
			add_action( 'admin_init', array(&$this, 'register_settings') );
			add_action( 'admin_menu', array(&$this, 'add_menu') );

		} // END public function __construct

		/**
		 * hook into WP's register_settings action hook
		 */
		public function register_settings() {

			// =========================== General ===========================
			// --- Add settings section General so we can add fields to it ---
			add_settings_section(
				'ytc_general', // Section Name
				__('General', 'wpsk'), // Section Title
				array(&$this, 'settings_general_section_description'), // Section Callback Function
				$this->slug . '_general' // Page Name
			);
			// --- Add Fields to General section ---
			// YouTube Data API Key
			add_settings_field(
				$this->option_name . 'apikey', // Setting Slug
				__('YouTube Data API Key', 'wpsk'), // Title
				array(&$this, 'settings_field_input_password'), // Callback
				$this->slug . '_general', // Page Name
				'ytc_general', // Section Name
				array(
					'field'       => $this->option_name . '[apikey]',
					'description' => __('Your YouTube Data API Key', 'wpsk'),
					'class'       => 'regular-text password',
					'value'       => $this->defaults['apikey'],
				) // args
			);
			// Channel ID
			add_settings_field(
				$this->option_name . 'channel', // Setting Slug
				__('YouTube Channel ID', 'wpsk'), // Title
				array(&$this, 'settings_field_input_text'), // Callback
				$this->slug . '_general', // Page Name
				'ytc_general', // Section Name
				array(
					'field'       => $this->option_name . '[channel]',
					'description' => __('Your YouTube Channel ID (ID only starting with UC, not full URL)', 'wpsk'),
					'class'       => 'regular-text',
					'value'       => $this->defaults['channel'],
				) // args
			);
			// Vanity
			add_settings_field(
				$this->option_name . 'vanity', // id
				__('YouTube Vanity Name', 'wpsk'), // Title
				array(&$this, 'settings_field_input_text'), // Callback
				$this->slug . '_general', // Page
				'ytc_general', // section
				array(
					'field'       => $this->option_name . "[vanity]",
					'description' => __('Your YouTube Custom Name (only part after www.youtube.com/c/ instead whole URL)', 'wpsk'),
					'class'       => 'regular-text',
					'value'       => $this->defaults['vanity'],
				) // args
			);
			// Username
			add_settings_field(
				$this->option_name . 'username', // id
				__('Legacy YouTube Username', 'wpsk'), // Title
				array(&$this, 'settings_field_input_text'), // Callback
				$this->slug . '_general', // Page
				'ytc_general', // section
				array(
					'field'       => $this->option_name . "[username]",
					'description' => __('Your YouTube legacy username', 'wpsk'),
					'class'       => 'regular-text',
					'value'       => $this->defaults['username'],
				) // args
			);
			// Default Playlist
			add_settings_field(
				$this->option_name . 'playlist', // id
				__('Default Playlist ID', 'wpsk'), // Title
				array(&$this, 'settings_field_input_text'), // Callback
				$this->slug . '_general', // Page
				'ytc_general', // section
				array(
					'field'       => $this->option_name . "[playlist]",
					'description' => __('Enter default playlist ID (not playlist name)', 'wpsk'),
					'class'       => 'regular-text',
					'value'       => $this->defaults['playlist'],
				) // args
			);
			// Resource
			add_settings_field(
				$this->option_name . 'resource', // id
				__('Resource to use', 'wpsk'), // Title
				array(&$this, 'settings_field_select'), // Callback
				$this->slug . '_general', // Page
				'ytc_general', // section
				array(
					'field'       => $this->option_name . "[resource]",
					'label' => __('Resource:', 'wpsk'),
					'description' => __('What to use as resource for feeds', 'wpsk'),
					'class'       => 'regular-text',
					'value'       => $this->defaults['resource'],
					'items'       => array(
						'0' => 'Channel',
						'1' => 'Favourites',
						'3' => 'Linked Video',
						'2' => 'Playlist'
					)
				) // args
			);
			// Playlist Only
			/*
			add_settings_field(
				$this->option_name . 'only_pl', // id
				__('Embed standard playlist', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_general', // Page
				'ytc_general', // section
				array(
					'field'       => $this->option_name . "[only_pl]",
					'description' => __("Enable this option to embed whole playlist instead single video from playlist when you chose playlist as resource", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['only_pl'],
				) // args
			);
			*/
			// Cache
			add_settings_field(
				$this->option_name . 'cache', // id
				__('Cache Timeout','wpsk'),
				array(&$this, 'settings_field_select'),
				$this->slug . '_general',
				'ytc_general',
				array(
					'field'       => $this->option_name . "[cache]",
					'description' => __('Define caching timeout for YouTube feeds, in seconds', 'wpsk'),
					'class'       => 'wide-text',
					'value'       => $this->defaults['cache'],
					'items'       => array(
						'0'       => __('Do not chache', 'youtube-channel'),
						'60'      => __('1 minute', 'youtube-channel'),
						'300'     => __('5 minutes', 'youtube-channel'),
						'900'     => __('15 minutes', 'youtube-channel'),
						'1800'    => __('30 minutes', 'youtube-channel'),
						'3600'    => __('1 hour', 'youtube-channel'),
						'7200'    => __('2 hours', 'youtube-channel'),
						'18000'   => __('5 hours', 'youtube-channel'),
						'36000'   => __('10 hours', 'youtube-channel'),
						'43200'   => __('12 hours', 'youtube-channel'),
						'64800'   => __('18 hours', 'youtube-channel'),
						'86400'   => __('1 day', 'youtube-channel'),
						'172800'  => __('2 days', 'youtube-channel'),
						'259200'  => __('3 days', 'youtube-channel'),
						'345600'  => __('4 days', 'youtube-channel'),
						'432000'  => __('5 days', 'youtube-channel'),
						'518400'  => __('6 days', 'youtube-channel'),
						'604800'  => __('1 week', 'youtube-channel'),
						'1209600' => __('2 weeks', 'youtube-channel'),
						'1814400' => __('3 weeks', 'youtube-channel'),
						'2419200' => __('1 month', 'youtube-channel')
					)
				)
			);
			// Fetch
			add_settings_field(
				$this->option_name . 'fetch', // id
				__('Fetch', 'wpsk'), // Title
				array(&$this, 'settings_field_input_number'), // Callback
				$this->slug . '_general', // Page
				'ytc_general', // section
				array(
					'field'       => $this->option_name . "[fetch]",
					'description' => __('Number of videos that will be used for random pick (min 2, max 50, default 25)', 'wpsk'),
					'class'       => 'num',
					'value'       => $this->defaults['fetch'],
					'min'         => 1,
					'max'         => 50,
					'std'         => 25
				) // args
			);
			// Show
			add_settings_field(
				$this->option_name . 'num', // id
				__('Show', 'wpsk'), // Title
				array(&$this, 'settings_field_input_number'), // Callback
				$this->slug . '_general', // Page
				'ytc_general', // section
				array(
					'field'       => $this->option_name . "[num]",
					'description' => __('Number of videos to display', 'wpsk'),
					'class'       => 'num',
					'value'       => $this->defaults['num'],
					'min'         => 1,
					'max'         => 50,
					'std'         => 1
				) // args
			);
			// Enhanced privacy
			add_settings_field(
				$this->option_name . 'privacy', // id
				__('Use Enhanced privacy', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_general', // Page
				'ytc_general', // section
				array(
					'field'       => $this->option_name . "[privacy]",
					'description' => __(sprintf('Enable this option to protect your visitors privacy. <a href="%s" target="_blank">Learn more here</a>', 'http://support.google.com/youtube/bin/answer.py?hl=en-GB&answer=171780'), 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['privacy'],
				) // args
			);
			// Random video
			/*
			add_settings_field(
				$this->option_name . 'random', // id
				__('Show random video', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_general', // Page
				'ytc_general', // section
				array(
					'field'       => $this->option_name . "[random]",
					'description' => __("Get random videos of all fetched from channel or playlist", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['random'],
				) // args
			);
			*/
			// --- Register setting General so $_POST handling is done ---
			register_setting(
				'ytc_general', // Setting group
				$this->option_name, // option name
				array($this, 'sanitize_options')
			);

			// =========================== VIDEO ===========================
			// --- Add settings section Video so we can add fields to it ---
			add_settings_section(
				'ytc_video', // Section Name
				__('Video Tweaks', 'wpsk'), // Section Title
				array(&$this, 'settings_video_section_description'), // Section Callback Function
				$this->slug . '_video' // Page Name
			);
			// --- Add Fields to video section ---
			// Width
			add_settings_field(
				$this->option_name . 'width', // id
				__('Width', 'wpsk'), // Title
				array(&$this, 'settings_field_input_number'), // Callback
				$this->slug . '_video', // Page
				'ytc_video', // section
				array(
					'field'       => $this->option_name . "[width]",
					'description' => __('Set default width for displayed video, in pixels', 'wpsk'),
					'class'       => 'num',
					'value'       => $this->defaults['width'],
					'min'         => 120,
					'max'         => 1980,
					'std'         => 306
				) // args
			);
			// Aspect Ratio
			add_settings_field(
				$this->option_name . 'ratio', // id
				__('Aspect ratio', 'wpsk'), // Title
				array(&$this, 'settings_field_select'), // Callback
				$this->slug . '_video', // Page
				'ytc_video', // section
				array(
					'field'       => $this->option_name . "[ratio]",
					// 'label' => __('Ratio:', 'wpsk'),
					'description' => __('Select aspect ratio for displayed video', 'wpsk'),
					'class'       => 'regular-text',
					'value'       => $this->defaults['ratio'],
					'items'       => array(
						'3' => '16:9',
						'1' => '4:3'
					)
				) // args
			);
			// Responsive
			add_settings_field(
				$this->option_name . 'responsive', // id
				__('Responsive video', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_video', // Page
				'ytc_video', // section
				array(
					'field'       => $this->option_name . "[responsive]",
					'description' => __("Enable this option to make all YTC videos responsive. Please note, this option will set all videos full width relative to parent container, and disable more than one video per row.", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['responsive'],
				) // args
			);
			// Display
			add_settings_field(
				$this->option_name . 'display', // id
				__('What to show?', 'wpsk'), // Title
				array(&$this, 'settings_field_select'), // Callback
				$this->slug . '_video', // Page
				'ytc_video', // section
				array(
					'field'       => $this->option_name . "[display]",
					// 'label' => __('Ratio:', 'wpsk'),
					'description' => __('Select aspect ratio for displayed video', 'wpsk'),
					'class'       => 'regular-text',
					'value'       => $this->defaults['display'],
					'items'       => array(
						'thumbnail' => 'Thumbnail',
						'iframe'    => 'HTML5 (iframe)',
						'iframe2'   => 'HTML5 (iframe) Asynchronous'
					)
				) // args
			);
			// Light Theme
			add_settings_field(
				$this->option_name . 'themelight', // id
				__('Light Theme', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_video', // Page
				'ytc_video', // section
				array(
					'field'       => $this->option_name . "[themelight]",
					'description' => __("Enable this option to use light theme for playback controls instead dark.", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['themelight'],
				) // args
			);
			// No Player Controls
			add_settings_field(
				$this->option_name . 'controls', // id
				__('Hide Player Controls', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_video', // Page
				'ytc_video', // section
				array(
					'field'       => $this->option_name . "[controls]",
					'description' => __("Enable this option to hide playback controls", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['controls'],
				) // args
			);
			// Fix Height (deprecated?)
			// Autoplay
			add_settings_field(
				$this->option_name . 'autoplay', // id
				__('Autoplay video or playlist', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_video', // Page
				'ytc_video', // section
				array(
					'field'       => $this->option_name . "[autoplay]",
					'description' => __("Enable this option to start video playback right after block is rendered", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['autoplay'],
				) // args
			);
			// Mute on autoplay
			add_settings_field(
				$this->option_name . 'autoplay_mute', // id
				__('Mute video on autoplay', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_video', // Page
				'ytc_video', // section
				array(
					'field'       => $this->option_name . "[autoplay_mute]",
					'description' => __("Enable this option to mute video when start autoplay", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['autoplay_mute'],
				) // args
			);
			// No related videos
			add_settings_field(
				$this->option_name . 'norel', // id
				__('Hide related videos', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_video', // Page
				'ytc_video', // section
				array(
					'field'       => $this->option_name . "[norel]",
					'description' => __("Enable this option to hide related videos after finished playback", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['norel'],
				) // args
			);
			// Hide YT logo
			add_settings_field(
				$this->option_name . 'modestbranding', // id
				__('Hide YT logo', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_video', // Page
				'ytc_video', // section
				array(
					'field'       => $this->option_name . "[modestbranding]",
					'description' => __("Enable this option to hide YouTube logo from playback control bar. Does not work for all videos.
", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['modestbranding'],
				) // args
			);
			// --- Register setting Video so $_POST handling is done ---
			register_setting(
				'ytc_video', // Setting group
				$this->option_name, // option name
				array($this, 'sanitize_options')
			);

			// =========================== CONTENT ===========================
			// --- Add settings section Content so we can add fields to it ---
			add_settings_section(
				'ytc_content', // Section Name
				__('Content Tweaks', 'wpsk'), // Section Title
				array(&$this, 'settings_content_section_description'), // Section Callback Function
				$this->slug . '_content' // Page Name
			);
			// --- Add Fields to video section ---
			// Video Title
			add_settings_field(
				$this->option_name . 'showtitle', // id
				__('Show video title', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_content', // Page
				'ytc_content', // section
				array(
					'field'       => $this->option_name . "[showtitle]",
					'description' => __("Enable this option to display title of video", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['showtitle'],
				) // args
			);
			// Video Description
			add_settings_field(
				$this->option_name . 'showdesc', // id
				__('Show video description', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_content', // Page
				'ytc_content', // section
				array(
					'field'       => $this->option_name . "[showdesc]",
					'description' => __("Enable this option to display description for video", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['showdesc'],
				) // args
			);
			// Description length
			add_settings_field(
				$this->option_name . 'desclen', // id
				__('Description length', 'wpsk'), // Title
				array(&$this, 'settings_field_input_number'), // Callback
				$this->slug . '_content', // Page
				'ytc_content', // section
				array(
					'field'       => $this->option_name . "[desclen]",
					'description' => __('Enter length for video description in characters (0 for full length)', 'wpsk'),
					'class'       => 'num',
					'value'       => $this->defaults['desclen'],
					'min'         => 0,
					'max'         => 2500,
					'std'         => 0
				) // args
			);
			// Et cetera string
			add_settings_field(
				$this->option_name . 'descappend', // id
				__('Et cetera string', 'wpsk'), // Title
				array(&$this, 'settings_field_input_text'), // Callback
				$this->slug . '_content', // Page
				'ytc_content', // section
				array(
					'field'       => $this->option_name . "[descappend]",
					'description' => __('Indicator for shortened video description (default: …)', 'wpsk'),
					'class'       => 'small-text',
					'value'       => $this->defaults['descappend'],
				) // args
			);
			// Hide Annotations
			add_settings_field(
				$this->option_name . 'hideanno', // id
				__('Hide video annotations', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_content', // Page
				'ytc_content', // section
				array(
					'field'       => $this->option_name . "[hideanno]",
					'description' => __("Enable this option to hide video annotations (custom text set by uploader over video during playback)", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['hideanno'],
				) // args
			);
			// Hide Video Info
			add_settings_field(
				$this->option_name . 'hideinfo', // id
				__('Hide video info', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_content', // Page
				'ytc_content', // section
				array(
					'field'       => $this->option_name . "[hideinfo]",
					'description' => __("Enable this option to hide informations about video before play start (video title and uploader in overlay)", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['hideinfo'],
				) // args
			);

			// --- Register setting Content so $_POST handling is done ---
			register_setting(
				'ytc_content', // Setting group
				$this->option_name, // option name
				array($this, 'sanitize_options')
			);

			// =========================== LINK ===========================
			// --- Add settings section Link to Channel so we can add fields to it ---
			add_settings_section(
				'ytc_link', // Section Name
				__('Link to Channel', 'wpsk'), // Section Title
				array(&$this, 'settings_link_section_description'), // Section Callback Function
				$this->slug . '_link' // Page Name
			);
			// --- Add Fields to video section ---
			// Show link to channel
			add_settings_field(
				$this->option_name . 'showgoto', // id
				__('Show link to channel', 'wpsk'), // Title
				array(&$this, 'settings_field_checkbox'), // Callback
				$this->slug . '_link', // Page
				'ytc_link', // section
				array(
					'field'       => $this->option_name . "[showgoto]",
					'description' => __("Enable this option to show customized link to channel at the bottom of YTC block", 'wpsk'),
					'class'       => 'checkbox',
					'value'       => $this->defaults['showgoto'],
				) // args
			);
			// Visit channel text
			add_settings_field(
				$this->option_name . 'goto_txt', // id
				__('Text for Visit channel link', 'wpsk'), // Title
				array(&$this, 'settings_field_input_text'), // Callback
				$this->slug . '_link', // Page
				'ytc_link', // section
				array(
					'field'       => $this->option_name . "[goto_txt]",
					'description' => __('Use placeholder %channel% or %vanity% to insert channel/nice name', 'wpsk'),
					'class'       => 'regular-text',
					'value'       => $this->defaults['goto_txt'],
				) // args
			);
			// Open in...
			add_settings_field(
				$this->option_name . 'popup_goto', // id
				__('Open link in...', 'wpsk'), // Title
				array(&$this, 'settings_field_select'), // Callback
				$this->slug . '_link', // Page
				'ytc_link', // section
				array(
					'field'       => $this->option_name . "[popup_goto]",
					// 'label' => __('Ratio:', 'wpsk'),
					'description' => __('Set where link will be opened', 'wpsk'),
					'class'       => 'regular-text',
					'value'       => $this->defaults['popup_goto'],
					'items'       => array(
						'0' => 'same window',
						'1' => 'new window (JavaScript)',
						'2' => 'new window (target="_blank")'
					)
				) // args
			);
			// Link to...
			add_settings_field(
				$this->option_name . 'link_to', // id
				__('Link to...', 'wpsk'), // Title
				array(&$this, 'settings_field_select'), // Callback
				$this->slug . '_link', // Page
				'ytc_link', // section
				array(
					'field'       => $this->option_name . "[link_to]",
					// 'label' => __('Ratio:', 'wpsk'),
					'description' => __('Set where link will lead visitors', 'wpsk'),
					'class'       => 'regular-text',
					'value'       => $this->defaults['link_to'],
					'items'       => array(
						'2' => 'Vanity custom URL',
						'1' => 'Channel page URL',
						'0' => 'Legacy username page'
					)
				) // args
			);
			// --- Register setting Content so $_POST handling is done ---
			register_setting(
				'ytc_link', // Setting group
				$this->option_name, // option name
				array($this, 'sanitize_options')
			);

		} // eom register_settings()

		/**
		 * Add settings menu
		 */
		public function add_menu() {

			// Add a page to manage this plugin's settings
			add_options_page(
				__('YouTube Channel', 'wpsk'),
				__('YouTube Channel','wpsk'),
				'manage_options',
				$this->slug,
				array(&$this, 'plugin_settings_page')
			);

		} // eom add_menu()

		// ===================== HELPERS ==========================

		// --- Section desciptions ---
		public function settings_general_section_description() {
		?>
			<p>Configure general defaults for YouTube Channel used as fallback options in widget or shortcodes. To get Channel ID and Vanity/Custom URL visit <a href="https://www.youtube.com/account_advanced" target="_blank">YouTube Account Overview</a>.</p>
		<?php
		} // eom settings_general_section_description()
		public function settings_video_section_description() {
		?>
			<p>Configure video specific defaults for YouTube Channel used as fallback options in widget or shortcodes.</p>
		<?php
		} // eom settings_video_section_description() {
		public function settings_content_section_description() {
		?>
			<p>Configure defaults of content around and over videos for YouTube Channel used as fallback options in widget or shortcodes.</p>
		<?php
		} // eom settings_content_section_description() {
		public function settings_link_section_description() {
		?>
		<p>Configure defaults for link to channel below YouTube Channel block used as fallback options in widget or shortcodes.</p>
		<?php
		} // eom settings_link_section_description() {

		/**
		 * This function provides separator for settings fields
		 */
		public function settings_field_separator($args=null) {
			echo '<hr>';
		} // eom settings_field_input_text()

		/**
		 * This function provides text inputs for settings fields
		 */
		public function settings_field_input_text($args) {

			extract( $args );

			echo sprintf('<input type="text" name="%s" id="%s" value="%s" class="%s" /><p class="description">%s</p>', $field, $field, $value, $class, $description);

		} // eom settings_field_input_text()

		/**
		 * This function provides password inputs for settings fields
		 */
		public function settings_field_input_password($args) {

			extract( $args );

			echo sprintf('<input type="password" name="%s" id="%s" value="%s" class="%s" /><p class="description">%s</p>', $field, $field, $value, $class, $description);

		} // eom settings_field_input_text()

		/**
		 * This function provides number inputs for settings fields
		 */
		public function settings_field_input_number($args) {

			extract( $args );

			echo sprintf('<input type="number" name="%s" id="%s" value="%s" min="%s" max="%s" class="%s" /><p class="description">%s</p>', $field, $field, $value, $min, $max, $class, $description);

		} // eom settings_field_input_text()

		/**
		 * This function provides select for settings fields
		 */
		public function settings_field_select($args) {

			extract( $args );

			$html = '';
			// $html .= sprintf('<label for="%s">%s</label><br>', $field, $label);
			$html .= sprintf('<select id="%s" name="%s">', $field, $field);
			foreach ($items as $key=>$val)
			{
				$selected = ($value==$key) ? 'selected="selected"' : '';
				$html .= sprintf('<option %s value="%s">%s</option>',$selected,$key,$val);
			}
			$html .= sprintf('</select><p class="description">%s</p>',$description);

			echo $html;

		} // eom settings_field_select()

		/**
		 * This function provides checkbox for settings fields
		 */
		public function settings_field_checkbox($args) {

			extract( $args );

			$checked = ( !empty($args['value']) ) ? 'checked="checked"' : '';
			echo sprintf('<label for="%s"><input type="checkbox" name="%s" id="%s" value="1" class="%s" %s />%s</label>', $field, $field, $field, $class, $checked, $description);

		} // eom settings_field_checkbox()

		/**
		 * This function provides checkbox groupfor settings fields
		 */
		public function settings_field_checkbox_group($args) {

			extract( $args );

			// items
			$out = '<fieldset>';

			foreach ( $items as $key => $label ) {

				$checked = '';
				if ( ! empty($value) ) {
					$checked = ( in_array($key, $value) ) ? 'checked="checked"' : '';
				}

				$out .= sprintf(
					'<label for="%s_%s"><input type="checkbox" name="%s[]" id="%s_%s" value="%s" class="%s" %s />%s</label><br>',
					$field,
					$key,

					$field,

					$field,
					$key,

					$key,

					$class,
					$checked,
					$label
				);
			}

			$out .= '</fieldset>';
			$out .= sprintf('<p class="description">%s</p>' , $description);

			echo $out;

		} // eom settings_field_checkbox()

		/**
		 * This function provides radio buttons for settings fields
		 */
		public function settings_field_radio($args) {

			extract( $args );

			$html = '';

			if ( ! empty($prescription) )
				$html .= sprintf('<p class="prescription">%s</p>', $prescription);

			foreach ($items as $key=>$val) {

				$checked = ($value==$key) ? 'checked="checked"' : '';
				$html .= sprintf(
					'<label for="%s_%s"><input type="radio" name="%s" id="%s_%s" value="%s" %s>%s</label><br />',
					$field, $key,
					$field,
					$field, $key,
					$key,
					$checked,
					$val
				);

			} // foreach $items

			$html .= sprintf('<p class="description">%s</p>',$description);

			echo $html;

		} // eom settings_field_checkbox()

		/**
		 * Menu Callback
		 */
		public function plugin_settings_page() {

			if ( ! current_user_can('manage_options') ) {
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}

			// Render the settings template
			require_once('settings_template.php');

		} // eom plugin_settings_page()

		/**
		 * process options before update
		 *
		 */
		public function sanitize_options($options) {

			$sanitized = get_option( $this->option_name );

			switch ( $_POST['option_page'] ) {

				// --- General ---
				case 'ytc_general':
					$apikey = ( defined('YOUTUBE_DATA_API_KEY') ) ? YOUTUBE_DATA_API_KEY : '';
					$sanitized['apikey']  = ( ! empty($options['apikey']) ) ? trim($options['apikey']) : $apikey;
					$sanitized['channel']  = ( ! empty($options['channel']) ) ? trim($options['channel']) : $this->defaults['channel'];
					$sanitized['vanity']   = ( ! empty($options['vanity']) ) ? trim($options['vanity']) : $this->defaults['vanity'];
					$sanitized['username'] = ( ! empty($options['username']) ) ? trim($options['username']) : $this->defaults['username'];
					$sanitized['playlist'] = ( ! empty($options['playlist']) ) ? trim($options['playlist']) : $this->defaults['playlist'];
					$sanitized['resource'] = ( isset($options['resource']) ) ? intval($options['resource']) : $this->defaults['resource'];
					// $sanitized['only_pl']  = ( ! empty($options['only_pl']) && $options['only_pl'] ) ? 1 : 0;
					$sanitized['cache']    = ( isset($options['cache']) ) ? intval($options['cache']) : $this->defaults['cache'];
					$sanitized['fetch']    = ( ! empty($options['fetch']) ) ? intval($options['fetch']) : $this->defaults['fetch'];
					$sanitized['num']      = ( ! empty($options['num']) ) ? intval($options['num']) : $this->defaults['num'];
					$sanitized['privacy']  = ( ! empty($options['privacy']) && $options['privacy'] ) ? 1 : 0;
					// $sanitized['random']   = ( ! empty($options['random']) && $options['random'] ) ? 1 : 0;
				break; // General

				// --- Video ---
				case 'ytc_video':
					$sanitized['width']          = ( ! empty($options['width']) ) ? intval($options['width']) : $this->defaults['width'];
					$sanitized['ratio']          = ( isset($options['ratio']) ) ? intval($options['ratio']) : $this->defaults['ratio'];
					$sanitized['responsive']     = ( ! empty($options['responsive']) && $options['responsive'] ) ? 1 : 0;
					$sanitized['display']        = ( ! empty($options['display']) ) ? trim($options['display']) : $this->defaults['display'];
					$sanitized['themelight']     = ( ! empty($options['themelight']) && $options['themelight'] ) ? 1 : 0;
					$sanitized['controls']       = ( ! empty($options['controls']) && $options['controls'] ) ? 1 : 0;
					$sanitized['autoplay']       = ( ! empty($options['autoplay']) && $options['autoplay'] ) ? 1 : 0;
					$sanitized['autoplay_mute']  = ( ! empty($options['autoplay_mute']) && $options['autoplay_mute'] ) ? 1 : 0;
					$sanitized['norel']          = ( ! empty($options['norel']) && $options['norel'] ) ? 1 : 0;
					$sanitized['modestbranding'] = ( ! empty($options['modestbranding']) && $options['modestbranding'] ) ? 1 : 0;
				break; // Video

				// --- Content ---
				case 'ytc_content':
					$sanitized['showtitle']  = ( ! empty($options['showtitle']) && $options['showtitle'] ) ? 1 : 0;
					$sanitized['showdesc']   = ( ! empty($options['showdesc']) && $options['showdesc'] ) ? 1 : 0;
					$sanitized['desclen']    = ( ! empty($options['desclen']) ) ? intval($options['desclen']) : $this->defaults['desclen'];
					$sanitized['descappend'] = ( ! empty($options['descappend']) ) ? $options['descappend'] : $this->defaults['descappend'];
					$sanitized['hideanno']   = ( ! empty($options['hideanno']) && $options['hideanno'] ) ? 1 : 0;
					$sanitized['hideinfo']   = ( ! empty($options['hideinfo']) && $options['hideinfo'] ) ? 1 : 0;
				break; // Content

				// --- Link to Channel ---
				case 'ytc_link':
					$sanitized['showgoto']  = ( ! empty($options['showgoto']) && $options['showgoto'] ) ? 1 : 0;
					$sanitized['goto_txt'] = ( ! empty($options['goto_txt']) ) ? $options['goto_txt'] : $this->defaults['goto_txt'];
					$sanitized['popup_goto']    = ( isset($options['popup_goto']) ) ? intval($options['popup_goto']) : $this->defaults['popup_goto'];
					$sanitized['link_to']    = ( isset($options['link_to']) ) ? intval($options['link_to']) : $this->defaults['link_to'];
				break; // Link to Channel

			} // switch

			// --- Update ---
			// now return sanitized options to be written to database
			return $sanitized;

		} // eom sanitize_options()

	} // eo class WPAU_YOUTUBE_CHANNEL_SETTINGS

} // eo class_exists WPAU_YOUTUBE_CHANNEL_SETTINGS
