<?php
/**
	ReduxFramework YouTube Channel File
**/

if ( !class_exists( "ReduxFramework" ) ) {
	return;
} 

if ( !class_exists( "Redux_Framework_YouTube_Channel" ) ) {
	class Redux_Framework_YouTube_Channel {

		public $args = array();
		public $sections = array();
		// public $theme;
		public $ReduxFramework;

		public function __construct( ) {

			// Set the default arguments
			$this->setArguments();

			// Set a few help tabs so you can see how it's done
			// $this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();

			if ( !isset( $this->args['opt_name'] ) ) { // No errors please
				return;
			}

			// If Redux is running as a plugin, this will remove the demo notice and links
			add_action( 'redux/plugin/hooks', array( $this, 'remove_demo' ) );
			
			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);

		}			
		
		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo() {
			
			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if ( class_exists('ReduxFrameworkPlugin') ) {
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2 );
			}

			// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
			remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );	

		}

		public function setSections() {
			global $WPAU_YOUTUBE_CHANNEL;
			// ACTUAL DECLARATION OF SECTIONS

			$this->sections[] = array(
				'title'  => __('General', 'ppc'),
				'icon'   => 'el-icon-home',
				'fields' => array(
					array(
						'id'      => 'channel',
						'type'    => 'text',
						'title'   => __('YouTube Channel ID', 'ppc'),
						'desc'    => __('Enter your YouTube channel ID (channel name, not full URL to channel)', 'ppc'),
						'default' => $WPAU_YOUTUBE_CHANNEL->channel_id
					),
					array(
						'id'      => 'playlist',
						'type'    => 'text',
						'title'   => __('Default Playlist ID', 'ppc'),
						'desc'    => __('Enter default playlist ID (not playlist name)', 'ppc'),
						'default' => $WPAU_YOUTUBE_CHANNEL->playlist_id
					),
					array(
						'id'      => 'use_res',
						'type'    => 'select',
						'title'   => __('Resource to use', 'ppc'),
						'desc'    => __('What to use as resource for feeds', 'ppc'),
						'options' => array(
							'0' => __('Channel', 'ppc'),
							'1' => __('Favorites', 'ppc'),
							'2' => __('Playlist', 'ppc'),
						),
						'default' => '0'
					),
                    array(
                        'id'        => 'only_pl',
                        'type'      => 'checkbox',
                        'title'     => __('Embed standard playlist', 'ppc'),
                        'desc'      => __('Enable this option to embed whole playlist instead single video from playlist when you chose playlist as resource', 'ppc'),
                        'default'   => '0'// 1 = on | 0 = off
                    ),
					array(
						'id'      => 'cache_time',
						'type'    => 'select',
						'title'   => __('Cache Timeout', 'ppc'),
						'desc' => __('Define caching timeout for YouTube feeds, in seconds', 'ppc'),

						'options' => array(
							'0'       => __('Do not chache', 'ppc'),
							'60'      => __('1 minute', 'ppc'),
							'300'     => __('5 minutes', 'ppc'),
							'900'     => __('15 minutes', 'ppc'),
							'1800'    => __('30 minutes', 'ppc'),
							'3600'    => __('1 hour', 'ppc'),
							'7200'    => __('2 hours', 'ppc'),
							'18000'   => __('5 hours', 'ppc'),
							'36000'   => __('10 hours', 'ppc'),
							'43200'   => __('12 hours', 'ppc'),
							'64800'   => __('18 hours', 'ppc'),
							'86400'   => __('1 day', 'ppc'),
							'172800'  => __('2 days', 'ppc'),
							'259200'  => __('3 days', 'ppc'),
							'345600'  => __('4 days', 'ppc'),
							'432000'  => __('5 days', 'ppc'),
							'518400'  => __('6 days', 'ppc'),
							'604800'  => __('1 week', 'ppc'),
							'1209600' => __('2 weeks', 'ppc'),
							'1814400' => __('3 weeks', 'ppc'),
							'2419200' => __('1 month', 'ppc')
						),
						'default' => '0'
					),
					array(
						'id'      =>'maxrnd',
						'type'    => 'spinner',
						'title'   => __('Fetch', 'ppc'), 
						'desc' => __('Number of videos that will be used for random pick (min 2, max 50, default 25)', 'ppc'),
						'default' => 25,
						'min'     => 2,
						'max'     => 50,
						'step'    => 1
					),
					array(
						'id'      =>'vidqty',
						'type'    => 'spinner',
						'title'   => __('Show', 'ppc'), 
						'desc' => __('Number of videos to display', 'ppc'),
						'default' => 1,
						'min'     => 1,
						'max'     => 50,
						'step'    => 1
					),
					array(
						'id'       => 'enhprivacy',
						'type'     => 'checkbox',
						'title'    => __('Use Enhanced privacy', 'ppc'), 
						'desc'     => __(sprintf('Enable this option to protect your visitors <a href="%s" target="_blank">privacy</a>.', 'http://support.google.com/youtube/bin/answer.py?hl=en-GB&answer=171780'), 'ppc'),
						'default'  => 0
					),
					array(
						'id'       => 'fixnoitem',
						'type'     => 'checkbox',
						'title'    => __('Fix <em>No items</em> error/Respect playlist order', 'ppc'), 
						'desc'     => __('Enable this option if you get error No Item', 'ppc'),
						'default'  => 0
					),
					array(
						'id'       => 'getrnd',
						'type'     => 'checkbox',
						'title'    => __('Show random video', 'ppc'), 
						'desc'     => __('Get random videos of all fetched from channel or playlist', 'ppc'),
						'default'  => 0
					),

				)
			);

			$this->sections[] = array(
				'icon'   => 'el-icon-youtube',
				'title'  => __('Video', 'ppc'),
				'fields' => array(

					array(
						'id'      => 'ratio',
						'type'    => 'select',
						'title'   => __('Aspect Ratio', 'ppc'),
						'desc'    => __('Select aspect ratio for displayed video', 'ppc'),
						
						'options' => array(
							'3' => __('16:9', 'ppc'),
							'2' => __('16:10', 'ppc'),
							'1' => __('4:3', 'ppc')
						),
						'default' => '3'
					),
					array(
						'id'      => 'width',
						'type'    => 'spinner',
						'title'   => __('Video Width', 'ppc'), 
						'desc'    => __('Set default width for displayed video, in pixels', 'ppc'), 
						'default' => 306,
						'min'     => 50,
						'max'     => 1980,
						'step'    => 1
					),
					array(
						'id'      => 'to_show',
						'type'    => 'select',
						'title'   => __('What to show?', 'ppc'),
						'desc'    => __('Set what will be shown by default', 'ppc'),
						
						'options' => array(
							'thumbnail'  => __('Thumbnail', 'ppc'),
							'object'     => __('Flash (object)', 'ppc'),
							'iframe'     => __('HTML5 (iframe)', 'ppc'),
							'iframe2'    => __('HTML5 (iframe) Async', 'ppc'),
							'chromeless' => __('Chromeless', 'ppc')
						),
						'default' => 'thumbnail'
					),
					array(
						'id'       => 'themelight',
						'type'     => 'checkbox',
						'title'    => __('Use light theme', 'ppc'), 
						'desc'     => __('Enable this option to use light theme for playback controls instead dark', 'ppc'),
						'default'  => 0
					),
					array(
						'id'       => 'controls',
						'type'     => 'checkbox',
						'title'    => __('Hide player controls', 'ppc'), 
						'desc'     => __('Enable this option to hide playback controls', 'ppc'),
						'default'  => 0
					),
					array(
						'id'       => 'fixyt',
						'type'     => 'checkbox',
						'title'    => __('Fix video height', 'ppc'), 
						'desc'     => __('Enable this option to fix video height when playback controls are not hidden', 'ppc'),
						'default'  => 0
					),
					array(
						'id'       => 'autoplay',
						'type'     => 'checkbox',
						'title'    => __('Autoplay video or playlist', 'ppc'), 
						'desc'     => __('Enable this option to start video playback right after block is rendered', 'ppc'),
						'default'  => 0
					),
					array(
						'id'       => 'autoplay_mute',
						'type'     => 'checkbox',
						'title'    => __('Mute video on autoplay', 'ppc'), 
						'desc'     => __('Enable this option to mute video when start autoplay', 'ppc'),
						'default'  => 0
					),
					array(
						'id'       => 'norel',
						'type'     => 'checkbox',
						'title'    => __('Hide related videos', 'ppc'), 
						'desc'     => __('Enable this option to hide related videos after finished playback', 'ppc'),
						'default'  => 0
					),

				)
			);

			$this->sections[] = array(
				'icon'   => 'el-icon-view-mode',
				'title'  => __('Content', 'ppc'),
				'fields' => array(

					array(
						'id'       => 'showtitle',
						'type'     => 'checkbox',
						'title'    => __('Show video title', 'ppc'), 
						'desc'     => __('Enable this option to display title of video', 'ppc'),
						'default'  => 0
					),
					array(
						'id'       => 'showvidesc',
						'type'     => 'checkbox',
						'title'    => __('Show video description', 'ppc'), 
						'desc'     => __('Enable this option to display description for video', 'ppc'),
						'default'  => 0
					),
					array(
						'id'      =>'videsclen',
						'type'    => 'spinner',
						'title'   => __('Description length', 'ppc'), 
						'desc'    => __('Enter length for video description in characters (0 for full length)', 'ppc'), 
						'default' => 0,
						'min'     => 0,
						'max'     => 2500,
						'step'    => 1
					),
					array(
						'id'      => 'descappend',
						'type'    => 'text',
						'title'   => __('Et cetera string', 'ppc'), 
						'desc'    => __('Indicator for shortened video description (default: …)', 'ppc'),
						'default' => __('...', 'ppc')
					),
					array(
						'id'       => 'hideanno',
						'type'     => 'checkbox',
						'title'    => __('Hide annotations from video', 'ppc'), 
						'desc'     => __('Enable this option to hide video annotations (custom text set by uploader over video during playback)', 'ppc'),
						'default'  => 0
					),
					array(
						'id'       => 'hideinfo',
						'type'     => 'checkbox',
						'title'    => __('Hide video info', 'ppc'), 
						'desc'     => __('Enable this option to hide informations about video before play start (video title and uploader in overlay)', 'ppc'),
						'default'  => 0
					),

				)
			);

			$this->sections[] = array(
				'icon'   => 'el-icon-link',
				'title'  => __('Link to Channel', 'ppc'),
				'fields' => array(

					array(
						'id'      => 'goto_txt',
						'type'    => 'text',
						'title'   => __('Visit YouTube Channel text', 'ppc'), 
						'desc'    => __('Use placeholder %channel% to insert channel name', 'ppc'),
						'default' => __('Visit my channel %channel%', 'ppc')
					),
					array(
						'id'       => 'showgoto',
						'type'     => 'checkbox',
						'title'    => __('Show link to channel', 'ppc'), 
						'desc'     => __('Enable this option to show customized link to channel at the bottom of YTC block', 'ppc'),
						'default'  => 0
					),
					array(
						'id'      => 'popup_goto',
						'type'    => 'select',
						'title'   => __('Open YouTube channel page', 'ppc'),
						'desc'    => __('Set what will be shown by default', 'ppc'),
						
						'options' => array(
							'0' => __('in same window', 'ppc'),
							'1' => __('in new window (JavaScript)', 'ppc'),
							'2' => __('in new window (Target)', 'ppc')
						),
						'default' => '0'
					),
					array(
						'id'       => 'userchan',
						'type'     => 'checkbox',
						'title'    => __('Link to channel instead to user', 'ppc'), 
						'desc'     => __('Enable this option if link to your channel have <code>/channel/</code> instead <code>/user/</code> part in URL', 'ppc'),
						'default'  => 0
					),

				)
			);

			$this->sections[] = array(
				'icon'   => 'el-icon-magic',
				'title'  => __('Tools', 'ppc'),
				'fields' => array(
                    array(
                        'id'        => 'recache',
                        'type'      => 'raw',
                        'markdown'  => true,
                        'content'   => file_get_contents(dirname(__FILE__) . '/settings_tools.php')
                    ),
				)
			);

			$this->sections[] = array(
				'type' => 'divide',
			);

			$this->sections[] = array(
				'icon'   => 'el-icon-question-sign',
				'title'  => __('Usage', 'ppc'),
				'fields' => array(
					array(
						'id'      => 'implementation',
						'title'   => 'How to use '.$WPAU_YOUTUBE_CHANNEL->plugin_name,
						'type'    => 'raw',
						'content' => file_get_contents(dirname(__FILE__) . '/settings_usage.php')
					),
					array(
						'id'          => 'shortcode',
						'title'       => 'How to use shortcode',
						'subtitle'    => 'Shortcode parameters with default values',
						'type'        => 'raw',
						// 'raw_html' => true,
						'content'     => file_get_contents(dirname(__FILE__) . '/settings_usage_shortcode.php')
					)
				)
			);

			$this->sections[] = array(
				'icon'   => 'el-icon-group',
				'title'  => __('Support', 'ppc'),
				'fields' => array(
					array(
						'id' => 'support',
						'type' => 'raw',
						// 'raw_html' => true,
						'content' => file_get_contents(dirname(__FILE__) . '/settings_support.php')
					),

					array(
						'id'      => 'moretxt',
						'type'    => 'text',
						'title'   => __('test', 'ppc'), 
						'desc'    => __('test', 'ppc'),
						'default' => $WPAU_YOUTUBE_CHANNEL->plugin_name
					),
				)
			);


		}	

		/**
			All the possible arguments for Redux.
			For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

		 **/
		public function setArguments() {
			global $WPAU_YOUTUBE_CHANNEL;
			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
	            
	            // TYPICAL -> Change these values as you need/desire
				'opt_name'          	=> $WPAU_YOUTUBE_CHANNEL->plugin_option, // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'			=> $WPAU_YOUTUBE_CHANNEL->plugin_name, // Name that appears at the top of your panel
				'display_version'		=> $WPAU_YOUTUBE_CHANNEL->plugin_version, // Version that appears at the top of your panel
				'menu_type'          	=> 'submenu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'     	=> true, // Show the sections below the admin menu item or not
				'menu_title'			=> __( $WPAU_YOUTUBE_CHANNEL->plugin_name, 'ppc' ),
	            'page'		 	 		=> __( $WPAU_YOUTUBE_CHANNEL->plugin_name.' Options', 'ppc' ),
	            'google_api_key'   	 	=> '', // Must be defined to add google fonts to the typography module
	            'global_variable'    	=> '', // Set a different name for your global variable other than the opt_name
	            'dev_mode'           	=> false, // Show the time the page took to load, etc
	            'customizer'         	=> true, // Enable basic customizer support

	            // OPTIONAL -> Give you extra features
	            'page_priority'      	=> null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	            'page_parent'        	=> 'options-general.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	            'page_permissions'   	=> 'manage_options', // Permissions needed to access the options panel.
	            'menu_icon'          	=> '', // Specify a custom URL to an icon
	            'last_tab'           	=> '', // Force your panel to always open to a specific tab (by id)
	            'page_icon'          	=> 'icon-settings', // Icon displayed in the admin panel next to your menu_title
	            'page_slug'          	=> $WPAU_YOUTUBE_CHANNEL->plugin_slug, // Page slug used to denote the panel
	            'save_defaults'      	=> true, // On load save the defaults to DB before user clicks save or not
	            'default_show'       	=> false, // If true, shows the default value next to each field that is not the default value.
	            'default_mark'       	=> '', // What to print by the field's title if the value shown is default. Suggested: *


	            // CAREFUL -> These options are for advanced use only
	            'transient_time' 	 	=> 60 * MINUTE_IN_SECONDS,
	            'output'            	=> true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	            'output_tag'            => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	            //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
	            //'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
	            

	            // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	            'database'           	=> '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	            
	        
	            'show_import_export' 	=> true, // REMOVE
	            'system_info'        	=> false, // REMOVE
	            
	            'help_tabs'          	=> array(),
	            'help_sidebar'       	=> '', // __( '', $this->args['domain'] );            
				);


			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.		
			$this->args['share_icons'][] = array(
			    'url' => 'https://www.facebook.com/urosevic',
			    'title' => 'Author on Facebook', 
			    'icon' => 'el-icon-facebook'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://twitter.com/urosevic',
			    'title' => 'Add me on Twitter', 
			    'icon' => 'el-icon-twitter'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://rs.linkedin.com/in/aurosevic',
			    'title' => 'Find me on LinkedIn', 
			    'icon' => 'el-icon-linkedin'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://youtube.com/user/urkekg',
			    'title' => 'Subscribe to my YouTube', 
			    'icon' => 'el-icon-youtube'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://urosevic.net/wordpress/plugins/youtube-channel/',
			    'title' => 'Visit official plugin site', 
			    'icon' => 'el-icon-home-alt'
			);

			// Panel Intro text -> before the form
			if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false ) {
				if (!empty($this->args['global_variable'])) {
					$v = $this->args['global_variable'];
				} else {
					$v = str_replace("-", "_", $this->args['opt_name']);
				}
				$this->args['intro_text'] = __('<p>Easy embed playable videos from YouTube.</p><p>Here you can set default options that will be used as defaults for new widgets, and for shortcode.</p>', 'ppc' );
			} else {
				// $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'ppc');
			}

			// Add content after the form.
			// $this->args['footer_text'] = sprintf( __('<p>Developed by <a href="%s">Aleksandar Urosevic</a></p>', 'ppc'), "http://urosevic.net/");

		}
	}
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_YouTube_Channel();
}

/** 

	Custom function for the callback referenced above

 */
if ( !function_exists( 'redux_my_custom_field' ) ):
	function redux_my_custom_field($field, $value) {
	    print_r($field);
	    print_r($value);
	}
endif;

/**
 
	Custom function for the callback validation referenced above

**/
if ( !function_exists( 'redux_validate_callback_function' ) ):
	function redux_validate_callback_function($field, $value, $existing_value) {
	    $error = false;
	    $value =  'just testing';
	    /*
	    do your validation
	    
	    if(something) {
	        $value = $value;
	    } elseif(something else) {
	        $error = true;
	        $value = $existing_value;
	        $field['msg'] = 'your custom error message';
	    }
	    */
	    
	    $return['value'] = $value;
	    if($error == true) {
	        $return['error'] = $field;
	    }
	    return $return;
	}
endif;
