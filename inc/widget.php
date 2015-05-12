<?php

/* youtube widget */
class WPAU_YOUTUBE_CHANNEL_Widget extends WP_Widget {

	public function __construct() {
		global $WPAU_YOUTUBE_CHANNEL;
		// Initialize Widget
		parent::__construct(
			$WPAU_YOUTUBE_CHANNEL->plugin_slug,
			__( 'Youtube Channel' , 'youtube-channel' ),
			array( 'description' => __( 'Serve YouTube videos from channel or playlist right to widget area', 'youtube-channel' ) )
		);
	}

	public function widget($args, $instance) {
		global $WPAU_YOUTUBE_CHANNEL;
		// outputs the content of the widget
		extract( $args );

		$title   = apply_filters('widget_title', $instance['title']);

		$output = array();
		$output[] = $before_widget;
		if ( $title ) $output[] = $before_title . $title . $after_title;
		$output[] = implode($WPAU_YOUTUBE_CHANNEL->output($instance));
		$output[] = $after_widget;

		echo implode('', array_values($output));
	}

	public function form($instance) {
		global $WPAU_YOUTUBE_CHANNEL;
		$defaults = get_option('youtube_channel_defaults');

		// outputs the options form for widget settings
		// General Options
		$title          = (!empty($instance['title'])) ? esc_attr($instance['title']) : '';
		$class          = (!empty($instance['class'])) ? esc_attr($instance['class']) : '';
		$vanity         = ( ! empty($instance['vanity']) ) ? esc_attr($instance['vanity']) : trim($defaults['vanity']);
		$channel        = (!empty($instance['channel'])) ? esc_attr($instance['channel']) : trim($defaults['channel']);
		$username       = (!empty($instance['username'])) ? esc_attr($instance['username']) : trim($defaults['username']);
		$playlist       = (!empty($instance['playlist'])) ? esc_attr($instance['playlist']) : trim($defaults['playlist']);

		$resource        = (!empty($instance['resource'])) ? esc_attr($instance['resource']) : 0; // resource to use: channel, favorites, playlist
		$only_pl        = (!empty($instance['only_pl'])) ? esc_attr($instance['only_pl']) : '';

		$cache     = (!empty($instance['cache'])) ? esc_attr($instance['cache']) : trim($defaults['cache']);

		$fetch         = (!empty($instance['fetch'])) ? esc_attr($instance['fetch']) : trim($defaults['fetch']); // items to fetch
		$num         = (!empty($instance['num'])) ? esc_attr($instance['num']) : trim($defaults['num']); // number of items to show

		$privacy     = (!empty($instance['privacy'])) ? esc_attr($instance['privacy']) : 0;
		$random         = (!empty($instance['random'])) ? esc_attr($instance['random']) : 0;

		// Video Settings
		$ratio          = (!empty($instance['ratio'])) ? esc_attr($instance['ratio']) : trim($defaults['ratio']);
		$width          = (!empty($instance['width'])) ? esc_attr($instance['width']) : trim($defaults['width']);
		$responsive     = (!empty($instance['responsive'])) ? esc_attr($instance['responsive']) : 0;

		$display        = (!empty($instance['display'])) ? esc_attr($instance['display']) : trim($defaults['display']);
		$no_thumb_title = (!empty($instance['no_thumb_title'])) ? esc_attr($instance['no_thumb_title']) : 0;

		$themelight     = (!empty($instance['themelight'])) ? esc_attr($instance['themelight']) : '';
		$controls       = (!empty($instance['controls'])) ? esc_attr($instance['controls']) : '';
		$autoplay       = (!empty($instance['autoplay'])) ? esc_attr($instance['autoplay']) : '';
		$autoplay_mute  = (!empty($instance['autoplay_mute'])) ? esc_attr($instance['autoplay_mute']) : '';
		$norel          = (!empty($instance['norel'])) ? esc_attr($instance['norel']) : '';

		// Content Layout
		$showtitle      = (!empty($instance['showtitle'])) ? esc_attr($instance['showtitle']) : '';
		$showdesc       = (!empty($instance['showdesc'])) ? esc_attr($instance['showdesc']) : '';
		$modestbranding = (!empty($instance['modestbranding'])) ? esc_attr($instance['modestbranding']) : '';
		$desclen        = (!empty($instance['desclen'])) ? esc_attr($instance['desclen']) : 0;
		$descappend     = (!empty($instance['descappend'])) ? esc_attr($instance['descappend']) : '&hellip;';

		$hideanno       = (!empty($instance['hideanno'])) ? esc_attr($instance['hideanno']) : '';
		$hideinfo       = (!empty($instance['hideinfo'])) ? esc_attr($instance['hideinfo']) : '';

		// Link to Channel
		$goto_txt       = (!empty($instance['goto_txt'])) ? esc_attr($instance['goto_txt']) : '';
		$showgoto       = (!empty($instance['showgoto'])) ? esc_attr($instance['showgoto']) : '';
		$popup_goto     = (!empty($instance['popup_goto'])) ? esc_attr($instance['popup_goto']) : '';
		$link_to        = (!empty($instance['link_to'])) ? esc_attr($instance['link_to']) : '';
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'youtube-channel'); ?>:
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" title="<?php _e('Title for widget', 'youtube-channel'); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Custom CSS Class', 'youtube-channel'); ?>:
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" value="<?php echo $class; ?>" title="<?php _e('Enter custom class for YTC block, if you wish to target block styling', 'youtube-channel'); ?>" />
			</label>
		</p>
		<p>Get your Channel ID and Custom ID from <a href="https://www.youtube.com/account_advanced" target="_blank">here</a>.</p>
		<p class="half left glue-top">
			<label for="<?php echo $this->get_field_id('vanity'); ?>"><?php _e('Vanity/Custom ID', 'youtube-channel'); ?>:
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('vanity'); ?>" name="<?php echo $this->get_field_name('vanity'); ?>" value="<?php echo $vanity; ?>" title="<?php _e('YouTube Vanity/Custom ID from URL (part after /c/)', 'youtube-channel'); ?>" />
			</label>
		</p>
		<p class="half right glue-top">
			<label for="<?php echo $this->get_field_id('channel'); ?>"><?php _e('Channel ID', 'youtube-channel'); ?>:
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('channel'); ?>" name="<?php echo $this->get_field_name('channel'); ?>" value="<?php echo $channel; ?>" title="<?php _e('Find Channel ID behind My Channel menu item in YouTube (ID have UC at the beginning)', 'youtube-channel'); ?>" />
			</label>
		</p>
		<p class="half left glue-top">
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Legacy Username', 'youtube-channel'); ?>:
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo $username; ?>" title="<?php _e('Legacy YouTube username located behind /user/ part of channel URL (available only on old YouTube accounts)', 'youtube-channel'); ?>" />
			</label>
		</p>
		<p class="half right glue-top">
			<label for="<?php echo $this->get_field_id('playlist'); ?>"><?php _e('Playlist ID', 'youtube-channel'); ?>:
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('playlist'); ?>" name="<?php echo $this->get_field_name('playlist'); ?>" value="<?php echo $playlist; ?>" title="<?php _e('Find Playlist ID in your playlists (ID have PL at the beginning)', 'youtube-channel'); ?>" />
			</label>
		</p>
		<p class="half left glue-top">
			<label for="<?php echo $this->get_field_id('resource'); ?>"><?php _e('Resource to use', 'youtube-channel'); ?>:</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'resource' ); ?>" name="<?php echo $this->get_field_name( 'resource' ); ?>">
				<option value="0"<?php selected( $resource, 0 ); ?>><?php _e('Channel', 'youtube-channel'); ?></option>
				<option value="1"<?php selected( $resource, 1 ); ?>><?php _e('Favourites', 'youtube-channel'); ?></option>
				<option value="3"<?php selected( $resource, 3 ); ?>><?php _e('Liked Videos', 'youtube-channel'); ?></option>
				<option value="2"<?php selected( $resource, 2 ); ?>><?php _e('Playlist', 'youtube-channel'); ?></option>
			</select>
		</p>
		<p class="half right glue-top">
			<label for="<?php echo $this->get_field_id('cache'); ?>"><?php _e('Cache feed', 'youtube-channel'); ?>:</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'cache' ); ?>" name="<?php echo $this->get_field_name( 'cache' ); ?>">
				<option value="0"<?php selected( $cache, 0 ); ?>><?php _e('Do not cache', 'youtube-channel'); ?></option>
				<?php echo $WPAU_YOUTUBE_CHANNEL->cache_time($cache); ?>
			</select>
		</p>

		<p class="playlist-only <?php echo $this->get_field_id('resource'); ?> glue-top">
			<label for="<?php echo $this->get_field_id( 'only_pl' ); ?>" id="<?php echo $this->get_field_id( 'only_pl' ); ?>_label"><input class="checkbox" type="checkbox" <?php checked( (bool) $only_pl, true );	?> id="<?php echo $this->get_field_id( 'only_pl' ); ?>" name="<?php echo $this->get_field_name( 'only_pl' ); ?>" title="<?php _e('Enable this option to embed YouTube playlist instead single video from playlist.', 'youtube-channel'); ?>" /> <?php _e('Embed standard playlist<br /><small>(Please note <em>What to show?</em> have no effect for embedded playlist)</small>', 'youtube-channel'); ?></label>
		</p>

		<p class="half left glue-top">
			<label for="<?php echo $this->get_field_id('fetch'); ?>"><?php _e('Fetch', 'youtube-channel'); ?>: <input class="small-text" id="<?php echo $this->get_field_id('fetch'); ?>" name="<?php echo $this->get_field_name('fetch'); ?>" type="number" min="2" value="<?php echo $fetch; ?>" title="<?php _e('Number of videos that will be used for random pick (min 2, max 50, default 25)', 'youtube-channel'); ?>" /> <?php _e('video(s)', 'youtube-channel'); ?></label>
		</p>
		<p class="half right glue-top">
			<label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Show', 'youtube-channel'); ?>:</label> <input class="small-text" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="number" min="1" value="<?php echo ( $num ) ? $num : '1'; ?>" title="<?php _e('Number of videos to display', 'youtube-channel'); ?>" /> <?php _e('video(s)', 'youtube-channel'); ?>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $privacy, true ); ?> id="<?php echo $this->get_field_id( 'privacy' ); ?>" name="<?php echo $this->get_field_name( 'privacy' ); ?>" title="<?php _e('Enable this option to protect your visitors privacy', 'youtube-channel'); ?>" /> <label for="<?php echo $this->get_field_id( 'privacy' ); ?>"><?php printf(__('Use <a href="%s" target="_blank">Enhanced Privacy</a>', 'youtube-channel'), 'http://support.google.com/youtube/bin/answer.py?hl=en-GB&answer=171780'); ?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $random, true ); ?> id="<?php echo $this->get_field_id( 'random' ); ?>" name="<?php echo $this->get_field_name( 'random' ); ?>" title="<?php _e('Get random videos of all fetched from channel or playlist', 'youtube-channel'); ?>" /> <label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e('Show random video', 'youtube-channel'); ?></label>
		</p>

		<h4><?php _e('Video Settings', 'youtube-channel'); ?></h4>
		<p><label for="<?php echo $this->get_field_id('ratio'); ?>"><?php _e('Aspect ratio', 'youtube-channel'); ?>:</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'ratio' ); ?>" name="<?php echo $this->get_field_name( 'ratio' ); ?>">
				<option value="3"<?php selected( $ratio, 3 ); ?>>16:9</option>
				<?php /* <option value="2"<?php selected( $ratio, 2 ); ?>>16:10</option> */ ?>
				<option value="1"<?php selected( $ratio, 1 ); ?>>4:3</option>
			</select><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $responsive, true ); ?> id="<?php echo $this->get_field_id( 'responsive' ); ?>" name="<?php echo $this->get_field_name( 'responsive' ); ?>" /> <label for="<?php echo $this->get_field_id( 'responsive' ); ?>"><?php _e('Responsive video (distribute one full width video per row)', 'youtube-channel'); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width', 'youtube-channel'); ?>:</label> <input class="small-text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="number" min="32" value="<?php echo $width; ?>" title="<?php _e('Set video width in pixels', 'youtube-channel'); ?>" /> px (<?php _e('default', 'youtube-channel'); ?> 306)
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('display'); ?>"><?php _e('What to show?', 'youtube-channel'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>">
				<option value="thumbnail"<?php selected( $display, 'thumbnail' ); ?>><?php _e('Thumbnail', 'youtube-channel'); ?></option>
				<option value="iframe"<?php selected( $display, 'iframe' ); ?>><?php _e('HTML5 (iframe)', 'youtube-channel'); ?></option>
				<option value="iframe2"<?php selected( $display, 'iframe2' ); ?>><?php _e('HTML5 (iframe) Asynchronous', 'youtube-channel'); ?></option>
			</select>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $no_thumb_title, true ); ?> id="<?php echo $this->get_field_id( 'no_thumb_title' ); ?>" name="<?php echo $this->get_field_name( 'no_thumb_title' ); ?>" /> <label for="<?php echo $this->get_field_id( 'no_thumb_title' ); ?>"><?php _e('Hide thumbnail tooltip', 'youtube-channel'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $themelight, true ); ?> id="<?php echo $this->get_field_id( 'themelight' ); ?>" name="<?php echo $this->get_field_name( 'themelight' ); ?>" /> <label for="<?php echo $this->get_field_id( 'themelight' ); ?>"><?php _e('Use light theme (default is dark)', 'youtube-channel'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $controls, true ); ?> id="<?php echo $this->get_field_id( 'controls' ); ?>" name="<?php echo $this->get_field_name( 'controls' ); ?>" /> <label for="<?php echo $this->get_field_id( 'controls' ); ?>"><?php _e('Hide player controls', 'youtube-channel'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $autoplay, true ); ?> id="<?php echo $this->get_field_id( 'autoplay' ); ?>" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" /> <label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php _e('Autoplay video or playlist', 'youtube-channel'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $autoplay_mute, true ); ?> id="<?php echo $this->get_field_id( 'autoplay_mute' ); ?>" name="<?php echo $this->get_field_name( 'autoplay_mute' ); ?>" /> <label for="<?php echo $this->get_field_id( 'autoplay_mute' ); ?>"><?php _e('Mute video on autoplay', 'youtube-channel'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $norel, true ); ?> id="<?php echo $this->get_field_id( 'norel' ); ?>" name="<?php echo $this->get_field_name( 'norel' ); ?>" /> <label for="<?php echo $this->get_field_id( 'norel' ); ?>"><?php _e('Hide related videos', 'youtube-channel'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $modestbranding, true ); ?> id="<?php echo $this->get_field_id( 'modestbranding' ); ?>" name="<?php echo $this->get_field_name( 'modestbranding' ); ?>" /> <label for="<?php echo $this->get_field_id( 'modestbranding' ); ?>"><?php _e('Hide YT Logo (does not work for all videos)', 'youtube-channel'); ?></label><br />
		</p>

		<h4><?php _e('Content Layout', 'youtube-channel'); ?></h4>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $showtitle, true ); ?> id="<?php echo $this->get_field_id( 'showtitle' ); ?>" name="<?php echo $this->get_field_name( 'showtitle' ); ?>" /> <label for="<?php echo $this->get_field_id( 'showtitle' ); ?>"><?php _e('Show video title', 'youtube-channel'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $showdesc, true ); ?> id="<?php echo $this->get_field_id( 'showdesc' ); ?>" name="<?php echo $this->get_field_name( 'showdesc' ); ?>" /> <label for="<?php echo $this->get_field_id( 'showdesc' ); ?>"><?php _e('Show video description', 'youtube-channel'); ?></label><br />
			<label for="<?php echo $this->get_field_id('desclen'); ?>"><?php _e('Description length', 'youtube-channel'); ?>: <input class="small-text" id="<?php echo $this->get_field_id('desclen'); ?>" name="<?php echo $this->get_field_name('desclen'); ?>" type="number" value="<?php echo $desclen; ?>" title="<?php _e('Set number of characters to cut down video description to (0 means full length)', 'youtube-channel');?>" /> (0 = full)</label><br />
			<label for="<?php echo $this->get_field_id('descappend'); ?>"><?php _e('Et cetera string', 'youtube-channel'); ?> <input class="small-text" id="<?php echo $this->get_field_id('descappend'); ?>" name="<?php echo $this->get_field_name('descappend'); ?>" type="text" value="<?php echo $descappend; ?>" title="<?php _e('Default: &amp;hellip;', 'youtube-channel'); ?>"/></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $hideanno, true ); ?> id="<?php echo $this->get_field_id( 'hideanno' ); ?>" name="<?php echo $this->get_field_name( 'hideanno' ); ?>" /> <label for="<?php echo $this->get_field_id( 'hideanno' ); ?>"><?php _e('Hide annotations from video', 'youtube-channel'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $hideinfo, true ); ?> id="<?php echo $this->get_field_id( 'hideinfo' ); ?>" name="<?php echo $this->get_field_name( 'hideinfo' ); ?>" /> <label for="<?php echo $this->get_field_id( 'hideinfo' ); ?>"><?php _e('Hide video info', 'youtube-channel'); ?></label>
		</p>

		<h4><?php _e('Link to Channel', 'youtube-channel'); ?></h4>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $showgoto, true ); ?> id="<?php echo $this->get_field_id( 'showgoto' ); ?>" name="<?php echo $this->get_field_name( 'showgoto' ); ?>" /> <label for="<?php echo $this->get_field_id( 'showgoto' ); ?>"><?php _e('Show link to channel below videos', 'youtube-channel'); ?></label>
		</p>
		<p class="glue-top <?php echo $this->get_field_id('showgoto'); ?>">
			<input class="widefat" id="<?php echo $this->get_field_id('goto_txt'); ?>" name="<?php echo $this->get_field_name('goto_txt'); ?>" type="text" value="<?php echo $goto_txt; ?>" title="<?php _e('Default: Visit our YouTube channel. You can use placeholders %vanity%, %channel% and %username%.', 'youtube-channel'); ?>" placeholder="<?php _e('Visit our YouTube channel', 'youtube-channel'); ?>" />
		</p>
		<p class="half left glue-top <?php echo $this->get_field_id( 'showgoto' ); ?>">
			<select class="widefat" id="<?php echo $this->get_field_id( 'link_to' ); ?>" name="<?php echo $this->get_field_name( 'link_to' ); ?>">
				<option value="2"<?php selected( $link_to, 2 ); ?>><?php _e('Link to Vanity customized URL', 'youtube-channel'); ?></option>
				<option value="1"<?php selected( $link_to, 1 ); ?>><?php _e('Link to Channel page URL', 'youtube-channel'); ?></option>
				<option value="0"<?php selected( $link_to, 0 ); ?>><?php _e('Link to Legacy username page', 'youtube-channel'); ?></option>
			</select>
		</p>
		<p class="half right glue-top <?php echo $this->get_field_id( 'showgoto' ); ?>">
			<select class="widefat" id="<?php echo $this->get_field_id( 'popup_goto' ); ?>" name="<?php echo $this->get_field_name( 'popup_goto' ); ?>">
				<option value="0"<?php selected( $popup_goto, 0 ); ?>><?php _e('Open link in same window', 'youtube-channel'); ?></option>
				<option value="1"<?php selected( $popup_goto, 1 ); ?>><?php _e('Open link in new window (JavaScript)', 'youtube-channel'); ?></option>
				<option value="2"<?php selected( $popup_goto, 2 ); ?>><?php _e('Open link in new window (target="blank")', 'youtube-channel'); ?></option>
			</select>
		</p>

		<h4><?php _e('Does not work? Contact support!', 'youtube-channel'); ?></h4>
		<p><small><a href="?ytc_debug_json_for=<?php echo $this->id; ?>" target="_blank"><?php _e('Get JSON file', 'youtube-channel'); ?></a> <?php printf(__('and send it to <a href="%s" target="_support">support forum</a> with other details noted in <a href="%s" target=_blank">this article</a>.', 'youtube-channel'), 'http://wordpress.org/support/plugin/youtube-channel', 'https://wordpress.org/support/topic/ytc3-read-before-you-post-support-question-or-report-bug'); ?></small>
		</p>

<?php
	}

	public function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance                   = $old_instance;
		$instance['title']          = strip_tags($new_instance['title']);
		$instance['class']          = strip_tags($new_instance['class']);
		$instance['channel']        = strip_tags($new_instance['channel']);
		$instance['username']       = strip_tags($new_instance['username']);
		$instance['playlist']       = strip_tags($new_instance['playlist']);
		$instance['vanity']         = strip_tags($new_instance['vanity']);
		$instance['num']         = $new_instance['num'];
		$instance['resource']        = $new_instance['resource'];
		$instance['cache']     = $new_instance['cache'];
		$instance['only_pl']        = (isset($new_instance['only_pl'])) ? $new_instance['only_pl'] : false;
		$instance['random']         = (isset($new_instance['random'])) ? $new_instance['random'] : false;
		$instance['fetch']         = $new_instance['fetch'];

		$instance['showgoto']       = (isset($new_instance['showgoto'])) ? $new_instance['showgoto'] : false;
		$instance['goto_txt']       = strip_tags($new_instance['goto_txt']);
		$instance['popup_goto']     = $new_instance['popup_goto'];
		$instance['link_to']        = $new_instance['link_to'];

		$instance['showtitle']      = (isset($new_instance['showtitle'])) ? $new_instance['showtitle'] : false;
		$instance['showdesc']     = (isset($new_instance['showdesc'])) ? $new_instance['showdesc'] : false;
		$instance['descappend']     = strip_tags($new_instance['descappend']);
		$instance['desclen']      = strip_tags($new_instance['desclen']);
		$instance['width']          = strip_tags($new_instance['width']);
		$instance['responsive']     = (isset($new_instance['responsive'])) ? $new_instance['responsive'] : '';

		$instance['display']        = strip_tags($new_instance['display']);
		$instance['no_thumb_title'] = (isset($new_instance['no_thumb_title'])) ? $new_instance['no_thumb_title'] : false;
		$instance['autoplay']       = (isset($new_instance['autoplay'])) ? $new_instance['autoplay'] : false;
		$instance['autoplay_mute']  = (isset($new_instance['autoplay_mute'])) ? $new_instance['autoplay_mute'] : false;
		$instance['norel']          = (isset($new_instance['norel'])) ? $new_instance['norel'] : false;
		$instance['modestbranding'] = (isset($new_instance['modestbranding'])) ? $new_instance['modestbranding'] : false;

		$instance['controls']       = (isset($new_instance['controls'])) ? $new_instance['controls'] : false;
		$instance['ratio']          = strip_tags($new_instance['ratio']);
		$instance['hideinfo']       = (isset($new_instance['hideinfo'])) ? $new_instance['hideinfo'] : '';
		$instance['hideanno']       = (isset($new_instance['hideanno'])) ? $new_instance['hideanno'] : '';
		$instance['themelight']     = (isset($new_instance['themelight'])) ? $new_instance['themelight'] : '';
		$instance['privacy']     = (isset($new_instance['privacy'])) ? $new_instance['privacy'] : '';

		return $instance;
	}

} // end class WPAU_YOUTUBE_CHANNEL_Widget()


// register Foo_Widget widget
function wpau_register_youtube_channel_widget() {
	register_widget( 'WPAU_YOUTUBE_CHANNEL_Widget' );
}
add_action( 'widgets_init', 'wpau_register_youtube_channel_widget' );
