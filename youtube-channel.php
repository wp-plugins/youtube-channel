<?php
/*
Plugin Name: YouTube Channel
Plugin URI: http://blog.urosevic.net/wordpress/youtube-channel/
Description: <a href="widgets.php">Widget</a> that display latest video thumbnail, iframe (HTML5 video), object (Flash video) or chromeless video from YouTube Channel or Playlist.
Author: Aleksandar Urošević
Version: 1.4.0
Author URI: http://urosevic.net/
*/

define( 'YOUTUBE_CHANNEL_URL', plugin_dir_url(__FILE__) );

/* Load plugin's textdomain */
function youtube_channel_init() {
	load_plugin_textdomain( 'youtube-channel', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'youtube_channel_init' );

/* youtube widget */
class YouTube_Channel_Widget extends WP_Widget {
	function YouTube_Channel_Widget() {
		// widget actual processes
		parent::WP_Widget( false, $name = __( 'YouTube Channel' , 'youtube-channel' ) );
	}

	function form($instance) {
		// outputs the options form on admin
		$title      = esc_attr($instance['title']);
		$channel    = esc_attr($instance['channel']);
		$vidqty     = esc_attr($instance['vidqty']);
		$playlist   = esc_attr($instance['playlist']);
		$usepl      = esc_attr($instance['usepl']);
		$only_pl    = esc_attr($instance['only_pl']);
		$getrnd     = esc_attr($instance['getrnd']);
		$maxrnd     = esc_attr($instance['maxrnd']);
		$goto_txt   = esc_attr($instance['goto_txt']);
		$showgoto   = esc_attr($instance['showgoto']);
		$popupgoto  = esc_attr($instance['popupgoto']);
		$target     = esc_attr($instance['target']);
		$showtitle  = esc_attr($instance['showtitle']);
		$showvidesc = esc_attr($instance['showvidesc']);
		$videsclen  = esc_attr($instance['videsclen']);
		$descappend = esc_attr($instance['descappend']);
		$width      = esc_attr($instance['width']);
		$height     = esc_attr($instance['height']);
		$to_show    = esc_attr($instance['to_show']);
		$lightbox   = esc_attr($instance['lightbox']);
		$autoplay   = esc_attr($instance['autoplay']);
		$controls   = esc_attr($instance['controls']);
		$fixnoitem  = esc_attr($instance['fixnoitem']);
		$ratio      = esc_attr($instance['ratio']);
		$fixyt      = esc_attr($instance['fixyt']);
		$hideinfo   = esc_attr($instance['hideinfo']);
		$hideanno   = esc_attr($instance['hideanno']);
		$themelight = esc_attr($instance['themelight']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:', 'youtube-channel'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('channel'); ?>"><?php _e('Channel:', 'youtube-channel'); ?> <input class="widefat" id="<?php echo $this->get_field_id('channel'); ?>" name="<?php echo $this->get_field_name('channel'); ?>" type="text" value="<?php echo $channel; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('playlist'); ?>"><?php _e('Playlist:', 'youtube-channel'); ?> <input class="widefat" id="<?php echo $this->get_field_id('playlist'); ?>" name="<?php echo $this->get_field_name('playlist'); ?>" type="text" value="<?php echo $playlist; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('maxrnd'); ?>"><?php _e('Fetch latest:', 'youtube-channel'); ?> <input class="small-text" id="<?php echo $this->get_field_id('maxrnd'); ?>" name="<?php echo $this->get_field_name('maxrnd'); ?>" type="number" min="2" value="<?php echo $maxrnd; ?>" /> (min 2, max 50)</label></p>
		<p><label for="<?php echo $this->get_field_id('vidqty'); ?>"><?php _e('Show:', 'youtube-channel'); ?></label> <input class="small-text" id="<?php echo $this->get_field_id('vidqty'); ?>" name="<?php echo $this->get_field_name('vidqty'); ?>" type="number" min="1" value="<?php echo $vidqty; ?>" /> videos</p>
		<p><input class="checkbox" type="checkbox" <?php checked( (bool) $instance['fixnoitem'], true ); ?> id="<?php echo $this->get_field_id( 'fixnoitem' ); ?>" name="<?php echo $this->get_field_name( 'fixnoitem' ); ?>" /> <label for="<?php echo $this->get_field_id( 'fixnoitem' ); ?>"><?php _e('Try to fix `No items` error', 'youtube-channel'); ?></label><br />
		<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['usepl'], true ); ?> id="<?php echo $this->get_field_id( 'usepl' ); ?>" name="<?php echo $this->get_field_name( 'usepl' ); ?>" /> <label for="<?php echo $this->get_field_id( 'usepl' ); ?>"><?php _e('Use the playlist instead of channel', 'youtube-channel'); ?></label><br />
		<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['getrnd'], true ); ?> id="<?php echo $this->get_field_id( 'getrnd' ); ?>" name="<?php echo $this->get_field_name( 'getrnd' ); ?>" /> <label for="<?php echo $this->get_field_id( 'getrnd' ); ?>"><?php _e('Show random video', 'youtube-channel'); ?></label><br />
		<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['only_pl'], true ); ?> id="<?php echo $this->get_field_id( 'only_pl' ); ?>" name="<?php echo $this->get_field_name( 'only_pl' ); ?>" /> <label for="<?php echo $this->get_field_id( 'only_pl' ); ?>"><?php _e('Embed only standard playlist', 'youtube-channel'); ?></label></p>
		
<h4><?php _e('Video property', 'youtube-channel'); ?></h4>
		<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width', 'youtube-channel'); ?> (<?php _e('default', 'youtube-channel'); ?> 220):</label> <input class="small-text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="number" min="32" value="<?php echo $width; ?>" /> px</p>
		<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height', 'youtube-channel'); ?> (<?php _e('default', 'youtube-channel'); ?> 165):</label> <input class="small-text" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="number" min="32" value="<?php echo $height; ?>" /> px</p>
		<p><label for="<?php echo $this->get_field_id('to_show'); ?>"><?php _e('Aspect ratio (relative to width):', 'youtube-channel'); ?>
			<select class="widefat" id="<?php echo $this->get_field_id( 'ratio' ); ?>" name="<?php echo $this->get_field_name( 'ratio' ); ?>">
				<option value="0"<?php selected( $instance['ratio'], 0 ); ?>><?php _e('custom', 'youtube-channel'); ?></option>
				<option value="1"<?php selected( $instance['ratio'], 1 ); ?>>4:3</option>
				<option value="2"<?php selected( $instance['ratio'], 2 ); ?>>16:10</option>
				<option value="3"<?php selected( $instance['ratio'], 3 ); ?>>16:9</option>
			</select>
		</p>
		<p><label for="<?php echo $this->get_field_id('to_show'); ?>"><?php _e('What to show?', 'youtube-channel'); ?>
			<select class="widefat" id="<?php echo $this->get_field_id( 'to_show' ); ?>" name="<?php echo $this->get_field_name( 'to_show' ); ?>">
				<option value="thumbnail"<?php selected( $instance['to_show'], 'thumbnail' ); ?>><?php _e('thumbnail', 'youtube-channel'); ?></option>
				<option value="object"<?php selected( $instance['to_show'], 'object' ); ?>><?php _e('object (flash player)', 'youtube-channel'); ?></option>
				<option value="iframe"<?php selected( $instance['to_show'], 'iframe' ); ?>><?php _e('iframe (HTML5 player)', 'youtube-channel'); ?></option>
				<option value="chromeless"<?php selected( $instance['to_show'], 'chromeless' ); ?>><?php _e('chromeless video', 'youtube-channel'); ?></option>
			</select>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['themelight'], true ); ?> id="<?php echo $this->get_field_id( 'themelight' ); ?>" name="<?php echo $this->get_field_name( 'themelight' ); ?>" /> <label for="<?php echo $this->get_field_id( 'themelight' ); ?>"><?php _e('Use light theme (default is dark)', 'youtube-channel'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['controls'], true ); ?> id="<?php echo $this->get_field_id( 'controls' ); ?>" name="<?php echo $this->get_field_name( 'controls' ); ?>" /> <label for="<?php echo $this->get_field_id( 'controls' ); ?>"><?php _e('Hide player controls', 'youtube-channel'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['fixyt'], true ); ?> id="<?php echo $this->get_field_id( 'fixyt' ); ?>" name="<?php echo $this->get_field_name( 'fixyt' ); ?>" /> <label for="<?php echo $this->get_field_id( 'fixyt' ); ?>"><?php _e('Fix height taken by controls', 'youtube-channel'); ?></label><br />
<?php /*			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['lightbox'], true ); ?> id="<?php echo $this->get_field_id( 'lightbox' ); ?>" name="<?php echo $this->get_field_name( 'lightbox' ); ?>" /> <label for="<?php echo $this->get_field_id( 'lightbox' ); ?>"><?php _e('Open thumbnail video in lightbox', 'youtube-channel'); ?></label><br /> */ ?>
<?php /*if ( $instance['to_show'] == 'thumbnail' && $instance['lightbox'] && !is_plugin_active('wp-video-lightbox/wp-video-lightbox.php') ){ echo '<p>To load videos in lightbox please install and activate <a href="http://wordpress.org/extend/plugins/wp-video-lightbox/">WP Video Lightbox</a> plugin by Ruhul Amin.</p>'; } */?>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['autoplay'], true ); ?> id="<?php echo $this->get_field_id( 'autoplay' ); ?>" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" /> <label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php _e('Autoplay video', 'youtube-channel'); ?></label></p>
<h4><?php _e('Layout behaviour', 'youtube-channel'); ?></h4>
			<p><input class="checkbox" type="checkbox" <?php checked( (bool) $instance['showtitle'], true ); ?> id="<?php echo $this->get_field_id( 'showtitle' ); ?>" name="<?php echo $this->get_field_name( 'showtitle' ); ?>" /> <label for="<?php echo $this->get_field_id( 'showtitle' ); ?>"><?php _e('Show video title', 'youtube-channel'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['showvidesc'], true ); ?> id="<?php echo $this->get_field_id( 'showvidesc' ); ?>" name="<?php echo $this->get_field_name( 'showvidesc' ); ?>" /> <label for="<?php echo $this->get_field_id( 'showvidesc' ); ?>"><?php _e('Show video description', 'youtube-channel'); ?></label><br />
			<label for="<?php echo $this->get_field_id('videsclen'); ?>"><?php _e('Description length', 'youtube-channel'); ?>: <input class="small-text" id="<?php echo $this->get_field_id('videsclen'); ?>" name="<?php echo $this->get_field_name('videsclen'); ?>" type="number" value="<?php echo $videsclen; ?>" /> (0 = full)</label><br />
			<label for="descappend">Et cetera string <input class="small-text" id="<?php echo $this->get_field_id('descappend'); ?>" name="<?php echo $this->get_field_name('descappend'); ?>" type="text" value="<?php echo $descappend; ?>" /> default &amp;hellip;</label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['hideanno'], true ); ?> id="<?php echo $this->get_field_id( 'hideanno' ); ?>" name="<?php echo $this->get_field_name( 'hideanno' ); ?>" /> <label for="<?php echo $this->get_field_id( 'hideanno' ); ?>"><?php _e('Hide annotations from video', 'youtube-channel'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['hideinfo'], true ); ?> id="<?php echo $this->get_field_id( 'hideinfo' ); ?>" name="<?php echo $this->get_field_name( 'hideinfo' ); ?>" /> <label for="<?php echo $this->get_field_id( 'hideinfo' ); ?>"><?php _e('Hide video info', 'youtube-channel'); ?></label></p>
		</p>
<h4><?php _e('Link to channel', 'youtube-channel'); ?></h4>
		<p><label for="<?php echo $this->get_field_id('goto_txt'); ?>"><?php _e('Visit YouTube Channel text:', 'youtube-channel'); ?> <input class="widefat" id="<?php echo $this->get_field_id('goto_txt'); ?>" name="<?php echo $this->get_field_name('goto_txt'); ?>" type="text" value="<?php echo $goto_txt; ?>" /></label>
		<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['showgoto'], true ); ?> id="<?php echo $this->get_field_id( 'showgoto' ); ?>" name="<?php echo $this->get_field_name( 'showgoto' ); ?>" /> <label for="<?php echo $this->get_field_id( 'showgoto' ); ?>"><?php _e('Show link to channel', 'youtube-channel'); ?></label><br />
		<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['popupgoto'], true ); ?> id="<?php echo $this->get_field_id( 'popupgoto' ); ?>" name="<?php echo $this->get_field_name( 'popupgoto' ); ?>" /> <label for="<?php echo $this->get_field_id( 'popupgoto' ); ?>"><?php _e('Open channel in new window/tab', 'youtube-channel'); ?></label><br />
		<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['target'], true ); ?> id="<?php echo $this->get_field_id( 'target' ); ?>" name="<?php echo $this->get_field_name( 'target' ); ?>" /> <label for="<?php echo $this->get_field_id( 'target' ); ?>"><?php _e('Use target="_blank" (invalid XHTML)', 'youtube-channel'); ?></label></p>
		<p><input type="button" value="Support YTC / Donate via PayPal" onclick="window.location='https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Q6Q762MQ97XJ6'" class="button-secondary"></p>
		<?php
	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = $old_instance;
		$instance['title']      = strip_tags($new_instance['title']);
		$instance['channel']    = strip_tags($new_instance['channel']);
		$instance['vidqty']     = $new_instance['vidqty'];
		$instance['playlist']   = strip_tags($new_instance['playlist']);
		$instance['usepl']      = $new_instance['usepl'];
		$instance['only_pl']    = $new_instance['only_pl'];
		$instance['getrnd']     = $new_instance['getrnd'];
		$instance['maxrnd']     = $new_instance['maxrnd'];
		$instance['goto_txt']   = strip_tags($new_instance['goto_txt']);
		$instance['showgoto']   = $new_instance['showgoto'];
		$instance['popupgoto']  = $new_instance['popupgoto'];
		$instance['target']     = $new_instance['target'];
		$instance['showtitle']  = $new_instance['showtitle'];
		$instance['showvidesc'] = $new_instance['showvidesc'];
		$instance['descappend'] = strip_tags($new_instance['descappend']);
		$instance['videsclen']  = strip_tags($new_instance['videsclen']);
		$instance['width']      = strip_tags($new_instance['width']);
		$instance['height']     = strip_tags($new_instance['height']);
		$instance['to_show']    = strip_tags($new_instance['to_show']);
		$instance['autoplay']   = $new_instance['autoplay'];
		$instance['lightbox']   = $new_instance['lightbox'];
		$instance['controls']   = $new_instance['controls'];
		$instance['fixnoitem']  = $new_instance['fixnoitem'];
		$instance['ratio']      = strip_tags($new_instance['ratio']);
		$instance['fixyt']      = $new_instance['fixyt'];
		$instance['hideinfo']   = $new_instance['hideinfo'];
		$instance['hideanno']   = $new_instance['hideanno'];
		$instance['themelight'] = $new_instance['themelight'];

		return $instance;
	}

	function widget($args, $instance) {
		// outputs the content of the widget
		extract( $args );
		$title   = apply_filters('widget_title', $instance['title']);

		// set default channel if nothing predefined
		$channel = $instance['channel'];
		if ( $channel == "" ) { $channel = "urkekg"; }

		// set playlist id
		$playlist = $instance['playlist'];
		if ( $playlist == "" ) { $playlist = "PLEC850BE962234400"; }
		// trim PL in front of playlist ID
		$playlist = preg_replace('/^PL/', '', $playlist);
		$usepl = $instance['usepl'];

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		?>

	<div class="youtube_channel">

		<?php
		if ( $instance['only_pl'] ) { // print standard playlist
			ytc_only_pl($instance);
		} else { // channel or playlist single videos
		
			// get max items for random video
			$maxrnd = $instance['maxrnd'];
			if ( $maxrnd < 1 ) { $maxrnd = 10; } // default 10
			elseif ( $maxrnd > 50 ) { $maxrnd = 50; } // max 50

			include_once(ABSPATH . WPINC . '/rss.php');
			$rss_settings = '?alt=rss&v=2';
			if ( !$instance['fixnoitem'] ) {
				$rss_settings .= '&orderby=published';
			}
			
			#$vidqty = $instance['vidqty'];
			#if ( $maxrnd > $vidqty ) {}
			$rss_settings .= '&rel=0&max-results='.$maxrnd;
			if ( $usepl ) {
				// check what is set: full URL or playlist ID
				$playlist = ytc_clean_playlist_id($playlist);
		
				$rss_url = 'http://gdata.youtube.com/feeds/api/playlists/'.$playlist.$rss_settings;
			} else {
				$rss_url = 'http://gdata.youtube.com/feeds/base/users/'.$channel.'/uploads'.$rss_settings;
			}

			$rss = fetch_feed($rss_url);
			if ( !is_wp_error($rss) ) {
				$getrnd = $instance['getrnd'];
				$vidqty = $instance['vidqty'];
				if ( $vidqty > $maxrnd ) { $maxrnd = $vidqty; }
				$maxitems = $rss->get_item_quantity($maxrnd); // max items in widget settings

				if ( $getrnd ) {
					$items = $rss->get_items(0, $maxitems);
				} else {
					if ( !$vidqty ) { $vidqty = 1; }
					$items = $rss->get_items(0, $vidqty); // set 0, 2 for next video
				}
			}
	
			if ($maxitems == 0) {
				echo __( 'No items' , 'youtube-channel' );
			} else {
				if ( $getrnd ) { $rnd_used = array(); } // set array for unique random item
				for ($y = 1; $y <= $vidqty; $y++) {

					if ( $getrnd ) {
						$rnd_item = mt_rand(0, (count($items)-1));
						while ( $y > 1 && in_array($rnd_item, $rnd_used) ) {
							$rnd_item = mt_rand(0, (count($items)-1));
						}
						$rnd_used[] = $rnd_item;
						$item = $items[$rnd_item];
					} else {
						$item = $items[$y-1];
						//$next_item = $items[1];
					}
					
					// print single video block
					ytc_print_video($item, $instance, $y);
				}
			}
		} // single playlist or ytc way

		ytc_channel_link($instance); // insert link to channel on bootom of widget
?>

	</div><!-- .youtube_channel -->
<?php
		echo $after_widget;
	}

}

/* function to print standard playlist embed code */
function ytc_only_pl($instance) {
		$width = $instance['width'];
		$height = height_ratio($width, $instance['ratio']) + 25;
		$playlist = ytc_clean_playlist_id($instance['playlist']);
		print '
			<div class="ytc_video_container ytc_video_1 ytc_video_single">
<iframe src="http://www.youtube.com/embed/videoseries?list=PL'.$playlist.'" 
width="'.$width.'" height="'.$height.'" frameborder="0"></iframe>
			</div>
			';
}

/* function to print video in widget */
function ytc_print_video($item, $instance, $y) {
	/* video settings */

	// get hideinfo, autoplay and controls settings
	// where this is used?
	$hideinfo = $instance['hideinfo'];
	$autoplay = $instance['autoplay'];
	$controls = $instance['controls'];

	// set width and height
	$width    = $instance['width'];
	$height   = height_ratio($width, $instance['ratio']);

	// calculate image height based on width for 4:3 thumbnail
	$imgfixedheight = $width / 4 * 3;

	// which type to show
	$to_show = $instance['to_show'];
	if ( $to_show == "" ) { $to_show = "object"; }

	// if not thumbnail, increase video height for 25px taken by video controls
	if ( $to_show != 'thumbnail' && !$controls && $instance['fixyt'] ) {
		$height += 25;
	}

	$hideanno = $instance['hideanno'];
	$themelight = $instance['themelight'];
	/* end of video settings */
	
	if ( $instance['usepl'] )  {
		$yt_id = $item->get_link();
		$yt_id = preg_replace('/^.*=(.*)&.*$/', '${1}', $yt_id);
			
		#if ( $getrnd ) {
			$yt_url = "v/$yt_id";
		#} else {
		#	$yt_url = "p/$playlist";
		#}
	} else {
		$yt_id = split(":", $item->get_id());
		$yt_id = $yt_id[3];
		$yt_url = "v/$yt_id";
	}

	$yt_thumb = "http://img.youtube.com/vi/$yt_id/0.jpg"; // zero for HD thumb
	$yt_video = $item->get_permalink();
	$yt_title = esc_html( $item->get_title() );
	$yt_date  = $item->get_date('j F Y | g:i a');
	// $next_id = split(":", $next_item->get_id());
	// $next_id = $yt_id[3];

	switch ($y) {
		case 1:
			$vnumclass = 'first';
			break;
		case $instance['vidqty']:
			$vnumclass = 'last';
			break;
		default:
			$vnumclass = 'mid';
			break;
	}

	echo '<div class="ytc_video_container ytc_video_'.$y.' ytc_video_'.$vnumclass.'">';

	// show video title?
	if ( $instance['showtitle'] ) {
		echo '<h3 class="ytc_title">'.$yt_title.'</h3>';
	}
		
	// define object ID
	$ytc_vid = 'ytc_' . $yt_id;

	// print out video
	if ( $to_show == "thumbnail" ) {
		$title = sprintf( __( 'Watch video %1$s published on %2$s' , 'youtube-channel' ), $yt_title, $yt_date );
		/* if ( $instance['lightbox'] ) { $in_lightbox = 'rel="ytc-lightbox"'; } else { $in_lightbox = ''; } */
echo <<<EOF
		<a href="$yt_video" title="$title"><div style="width: ${width}px; height: ${height}px; overflow: hidden; background: url($yt_thumb) 50% 50% no-repeat; background-size: ${width}px ${imgfixedheight}px;" title="$yt_title" id="$ytc_vid"></div></a>
EOF;
	} else if ( $to_show == "chromeless" ) {
?>
	<object type="application/x-shockwave-flash" data="<?php echo YOUTUBE_CHANNEL_URL . 'chromeless.swf'; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" id="<?php echo $ytc_vid; ?>">
		<param name="flashVars" value="video_source=<?php echo $yt_id; ?>&video_width=<?php echo $width; ?>&video_height=<?php echo $height; ?><?php if ( $autoplay ) { echo "&autoplay=Yes"; } if ( !$controls ) { echo "&youtube_controls=Yes"; } if ( $hideanno ) { echo "&iv_load_policy=3"; } if ( $themelight ) { echo "&theme=light"; } ?>" />
		<param name="quality" value="high" />
		<param name="wmode" value="opaque" />
		<param name="swfversion" value="6.0.65.0" />
		<param name="movie" value="<?php echo YOUTUBE_CHANNEL_URL . 'chromeless.swf'; ?>" />
	</object>	
<?php
	} else if ( $to_show == "iframe" ) {
		if (!$usepl) { $yt_url = $yt_id; }
?>
	<iframe title="YouTube video player" width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="http://www.youtube.com/embed/<?php echo $yt_url."?wmode=opaque&enablejsapi=1"; if ( $controls ) { echo "&controls=0"; } if ( $hideinfo ) { echo "&showinfo=0"; } if ( $autoplay ) { echo "&autoplay=1"; } if ( $hideanno ) { echo "&iv_load_policy=3"; } if ( $themelight ) { echo "&theme=light"; } ?>" frameborder="0" allowfullscreen id="<?php echo $ytc_vid ?>"></iframe>
<?php
	} else { // default is object
?>
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?php echo $width; ?>" height="<?php echo $height; ?>" id="<?php echo $ytc_vid; ?>">
		<param name="movie" value="http://www.youtube.com/<?php echo $yt_url; ?>?version=3<?php if ( $controls ) { echo "&amp;controls=0"; } if ( $hideinfo ) { echo "&amp;showinfo=0"; } if ( $autoplay ) { echo "&amp;autoplay=1"; } if ( $hideanno ) { echo "&amp;iv_load_policy=3"; } if ( $themelight ) { echo "&amp;theme=light"; } ?>" />
		<param name="allowScriptAccess" value="always">
		<!--[if !IE]>-->
		<object type="application/x-shockwave-flash" data="http://www.youtube.com/<?php echo $yt_url; ?>?version=3<?php if ( $controls ) { echo "&amp;controls=0"; } if ( $hideinfo ) { echo "&amp;showinfo=0"; } if ( $autoplay ) { echo "&amp;autoplay=1"; } if ( $hideanno ) { echo "&amp;iv_load_policy=3"; } if ( $themelight ) { echo "&amp;theme=light"; } ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
		<!--<![endif]-->
		<param name="wmode" value="opaque" />
		<!--[if !IE]>-->
		</object>
		<!--<![endif]-->
	</object>
<?php
	}

	// do we need to show video description?
	if ( $instance['showvidesc'] ) {
		preg_match('/<div><span>(.*)<\/span><\/div>/', $item->get_description(), $videsc);
		if ( $instance['videsclen'] > 0 ) {
			$video_description = substr($videsc[1], 0, $instance['videsclen']);
		} else {
			$video_description = $videsc[1];
		}
		if ( $video_description != '' ) {
			if ( $instance['descappend'] ) {
				$etcetera = $instance['descappend'];
			} else {
				$etcetera = '&hellip;';
			}
		}
		echo '<p class="ytc_description">' .$video_description.$etcetera. '</p>';
	}
	echo '</div><!-- .ytc_video_container -->';
}

// function to calculate height by width and ratio
function height_ratio($width, $ratio) {
	if ( $width == "" ) { $width = 220; }

	if ( $ratio == 1 ) { // 4:3
		$height = round(($width / 4 ) * 3);
	} else  if ( $ratio == 2 ) { // 16:10
		$height = round(($width / 16 ) * 10);
	} else  if ( $ratio == 3 ) { // 16:9
		$height = round(($width / 16 ) * 9);
	} else { // set default if 0 or ratio not set
		$height = $instance['height'];
		if ( $height == "" ) { $height = 165; }
	}
	return $height;
}

// function to insert link to channel
function ytc_channel_link($instance) {
	// do we need to show goto link?
	if ( $instance['showgoto'] ) {
		$channel = $instance['channel'];
		$goto_txt = $instance['goto_txt'];
		if ( $goto_txt == "" ) {
			$goto_txt = sprintf( __( 'Visit channel %1$s' , 'youtube-channel' ), $channel );
		}

		echo '<div class="ytc_link">';
		if ( $instance['popupgoto'] ) {
			$newtab = __("in new window/tab", "youtube-channel");
			if ( $instance['target'] ) {
echo <<<EOF
	<a href="http://www.youtube.com/user/$channel/" target="_blank" title="$goto_txt $newtab">$goto_txt</a>
EOF;
			} else {
echo <<<EOF
	<a href="javascript: window.open('http://www.youtube.com/user/$channel/'); void 0;" title="$goto_txt $newtab">$goto_txt</a>
EOF;
			} // target
		} else {
echo <<<EOF
	<p><a href="http://www.youtube.com/user/$channel/" title="$goto_txt">$goto_txt</a></p>
EOF;
		} // popupgoto
		echo '</div>';

	} // showgoto
}

function ytc_clean_playlist_id($playlist) {
	if ( substr($playlist,0,4) == "http" ) {
		// if URL provided, extract playlist ID
		$playlist = preg_replace('/.*list=PL([A-Z0-9]*).*/','$1', $playlist);
	} else if ( substr($playlist,0,2) == 'PL' ) {
		$playlist = substr($playlist,2);
	}
	return $playlist;
}

/* Register plugin's widget */
function youtube_channel_register_widget() {
	register_widget( 'YouTube_Channel_Widget' );
}
add_action( 'widgets_init', 'youtube_channel_register_widget' );
?>
