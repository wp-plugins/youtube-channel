<?php
/*
Plugin Name: YouTube Channel
Plugin URI: http://blog.urosevic.net/wordpress/youtubet-channel/
Description: <a href="widgets.php">Widget</a> that display latest video thumbnail, playable flash object or chromeless video from YouTube Channel.
Author: Aleksandar Urošević
Version: 0.1.1
Author URI: http://urosevic.net/
*/

/* youtube widget */
class YouTube_Channel_Widget extends WP_Widget {
	function YouTube_Channel_Widget() {
		// widget actual processes
		parent::WP_Widget(false, $name = 'YouTube Channel');
	}

	function form($instance) {
		// outputs the options form on admin
		$title      = esc_attr($instance['title']);
		$channel    = esc_attr($instance['channel']);
		$goto_txt   = esc_attr($instance['goto_txt']);
		$showgoto  = esc_attr($instance['showgoto']);
		$showtitle = esc_attr($instance['showtitle']);
		$width      = esc_attr($instance['width']);
		$height     = esc_attr($instance['height']);
		$to_show    = esc_attr($instance['to_show']);
		$autoplay   = esc_attr($instance['autoplay']);
		$controls   = esc_attr($instance['controls']);
		$ratio      = esc_attr($instance['ratio']);
		$fixyt      = esc_attr($instance['fixyt']);
		$hideinfo   = esc_attr($instance['hideinfo']);
		?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('channel'); ?>"><?php _e('Channel:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('channel'); ?>" name="<?php echo $this->get_field_name('channel'); ?>" type="text" value="<?php echo $channel; ?>" /></label></p>
            <p><input class="checkbox" type="checkbox" <?php checked( (bool) $instance['showtitle'], true ); ?> id="<?php echo $this->get_field_id( 'showtitle' ); ?>" name="<?php echo $this->get_field_name( 'showtitle' ); ?>" /> <label for="<?php echo $this->get_field_id( 'showtitle' ); ?>"><?php _e('Show video title'); ?></label></p>
            <p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width'); ?> (<?php _e('default'); ?> 220):<input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height'); ?> (<?php _e('default'); ?> 165):<input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('to_show'); ?>"><?php _e('Aspect ratio (relative to width):'); ?>
            <select class="widefat" id="<?php echo $this->get_field_id( 'ratio' ); ?>" name="<?php echo $this->get_field_name( 'ratio' ); ?>">
				<option value="0"<?php if ($instance['ratio'] == "0") { echo 'selected="selected"'; } ?>><?php _e('Custom'); ?></option>
				<option value="1"<?php if ($instance['ratio'] == "1") { echo 'selected="selected"'; } ?>>4:3</option>
				<option value="2"<?php if ($instance['ratio'] == "2") { echo 'selected="selected"'; } ?>>16:10</option>
				<option value="3"<?php if ($instance['ratio'] == "3") { echo 'selected="selected"'; } ?>>16:9</option>
			</select>
            </p>
            <p><label for="<?php echo $this->get_field_id('to_show'); ?>"><?php _e('What to show?'); ?>
            <select class="widefat" id="<?php echo $this->get_field_id( 'to_show' ); ?>" name="<?php echo $this->get_field_name( 'to_show' ); ?>">
				<option value="thumbnail"<?php if ($instance['to_show']  == "thumbnail") { echo 'selected="selected"'; } ?>><?php _e('Thumbnail'); ?></option>
				<option value="object"<?php if ($instance['to_show']     == "object") { echo 'selected="selected"'; } ?>><?php _e('object (flash player)'); ?></option>
				<option value="iframe"<?php if ($instance['to_show']     == "iframe") { echo 'selected="selected"'; } ?>><?php _e('iframe (HTML5 player)'); ?></option>
				<option value="chromeless"<?php if ($instance['to_show'] == "chromeless") { echo 'selected="selected"'; } ?>><?php _e('chromeless video'); ?></option>
			</select>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['fixyt'], true ); ?> id="<?php echo $this->get_field_id( 'fixyt' ); ?>" name="<?php echo $this->get_field_name( 'fixyt' ); ?>" /> <label for="<?php echo $this->get_field_id( 'fixyt' ); ?>"><?php _e('Fix height taken by controls'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['autoplay'], true ); ?> id="<?php echo $this->get_field_id( 'autoplay' ); ?>" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" /> <label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php _e('Autoplay video'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['controls'], true ); ?> id="<?php echo $this->get_field_id( 'controls' ); ?>" name="<?php echo $this->get_field_name( 'controls' ); ?>" /> <label for="<?php echo $this->get_field_id( 'controls' ); ?>"><?php _e('Hide player controls'); ?></label><br />
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['hideinfo'], true ); ?> id="<?php echo $this->get_field_id( 'hideinfo' ); ?>" name="<?php echo $this->get_field_name( 'hideinfo' ); ?>" /> <label for="<?php echo $this->get_field_id( 'hideinfo' ); ?>"><?php _e('Hide video info'); ?></label></p>
            <p><label for="<?php echo $this->get_field_id('goto_txt'); ?>"><?php _e('Visit YouTube Channel text:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('goto_txt'); ?>" name="<?php echo $this->get_field_name('goto_txt'); ?>" type="text" value="<?php echo $goto_txt; ?>" /></label>
            <input class="checkbox" type="checkbox" <?php checked( (bool) $instance['showgoto'], true ); ?> id="<?php echo $this->get_field_id( 'showgoto' ); ?>" name="<?php echo $this->get_field_name( 'showgoto' ); ?>" /> <label for="<?php echo $this->get_field_id( 'showgoto' ); ?>"><?php _e('Show link to channel'); ?></label></p>
		<?php
	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = $old_instance;
		$instance['title']     = strip_tags($new_instance['title']);
		$instance['channel']   = strip_tags($new_instance['channel']);
		$instance['goto_txt']  = strip_tags($new_instance['goto_txt']);
		$instance['showgoto'] = $new_instance['showgoto'];
		$instance['showtitle']= $new_instance['showtitle'];
		$instance['width']     = strip_tags($new_instance['width']);
		$instance['height']    = strip_tags($new_instance['height']);
		$instance['to_show']   = strip_tags($new_instance['to_show']);
		$instance['autoplay']  = $new_instance['autoplay'];
		$instance['controls']  = $new_instance['controls'];
		$instance['ratio']     = strip_tags($new_instance['ratio']);
		$instance['fixyt']     = $new_instance['fixyt'];
		$instance['hideinfo']  = $new_instance['hideinfo'];

		return $instance;
	}

	function widget($args, $instance) {
		// outputs the content of the widget
		extract( $args );
		$title   = apply_filters('widget_title', $instance['title']);

		// set default channel if nothing predefined
		$channel = $instance['channel'];
		if ( $channel == "" ) { $channel = "urkekg"; }

		// get hideinfo, autoplay and controls settings
		$hideinfo = $instance['hideinfo'];
		$autoplay = $instance['autoplay'];
		$controls = $instance['controls'];

		// set width and height
		$width   = $instance['width'];
		if ( $width == "" ) { $width = 220; }
		// use ratio?
		$ratio = $instance['ratio'];
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

		// which type to show
		$to_show = $instance['to_show'];
		if ( $to_show == "" ) { $to_show = "object"; }

		// if not thumbnail, increase video height for 25px taken by video controls
		if ( !$instance['thumbnail'] && !$controls ) {
			$height += 25;
		}

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		?>
	<div class="youtube_channel">
	<?php
	include_once(ABSPATH . WPINC . '/rss.php');

	$rss = fetch_rss('http://gdata.youtube.com/feeds/base/users/'.$channel.'/uploads?alt=rss&v=2&orderby=published&client=ytapi-youtube-profile');

	if ($rss) { $items = array_slice($rss->items, 0, 1); }
	if (empty($items)) {
		echo "No items";
	} else {
		$item = $items[0];
		$yt_id = split(":", $item['guid']);
		$yt_id = $yt_id[3];
		$yt_thumb = "http://i3.ytimg.com/vi/$yt_id/default.jpg";
		$yt_video = "http://www.youtube.com/watch?v=$yt_id";
		$yt_title = $item['title'];
		$yt_date  = $item['pubdate'];
		// $next = $items[1];
		// $next_id = split(":", $next['guid']);
		// $next_id = $yt_id[3];

		// show video title?
		if ( $instance['showtitle'] ) {
			echo "<h3>$yt_title</h3>";
		}
		
		// print out video
		if ( $to_show == "thumbnail" ) {
echo <<<EOF
		<a href="$yt_video" title="Watch video $yt_title published on $yt_date"><img src="$yt_thumb" alt="$yt_title" style="width: ${width}px; height: ${height}px; border: 0;" /></a>
EOF;
		} else if ( $to_show == "chromeless" ) {
?>
        <object type="application/x-shockwave-flash" data="<?php echo get_bloginfo('wpurl'); ?>/wp-content/plugins/youtube-channel/chromeless.swf" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
          <param name="flashVars" value="video_source=<?php echo $yt_id; ?>&video_width=<?php echo $width; ?>&video_height=<?php echo $height; ?><?php if ( $autoplay ) { echo "&autoplay=Yes"; } if ( !$controls ) { echo "&youtube_controls=Yes"; } ?>" />
          <param name="quality" value="high" />
          <param name="wmode" value="opaque" />
          <param name="swfversion" value="6.0.65.0" />
          <param name="movie" value="<?php echo get_bloginfo('wpurl'); ?>/wp-content/plugins/youtube-channel/chromeless.swf" />
        </object>	
<?php
		} else if ( $to_show == "iframe" ) {
?>
<iframe title="YouTube video player" width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="http://www.youtube.com/embed/<?php echo "$yt_id?enablejsapi=1"; if ( $controls ) { echo "&controls=0"; } if ( $hideinfo ) { echo "&showinfo=0"; } if ( $autoplay ) { echo "&amp;autoplay=1"; } ?>" frameborder="0" allowfullscreen></iframe>
<?php
		} else { // default is object
?>
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
			<param name="movie" value="http://www.youtube.com/v/<?php echo $yt_id; ?>?version=3<?php if ( $controls ) { echo "&amp;controls=0"; } if ( $hideinfo ) { echo "&amp;showinfo=0"; } if ( $autoplay ) { echo "&amp;autoplay=1"; } ?>" />
			<!--[if !IE]>-->
			<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/<?php echo $yt_id; ?>?version=3<?php if ( $controls ) { echo "&amp;controls=0"; } if ( $hideinfo ) { echo "&amp;showinfo=0"; } if ( $autoplay ) { echo "&amp;autoplay=1"; } ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
			<!--<![endif]-->
			<!--[if !IE]>-->
			</object>
			<!--<![endif]-->
		</object>
<?php
		}

		// do we need to show goto link?
		if ( $instance['showgoto'] ) {
			$goto_txt = $instance['goto_txt'];
			if ( $goto_txt == "" ) { $goto_txt = __("Visit channel")." $channel"; }
			echo <<<EOF
		<p><a href="javascript: window.open('http://www.youtube.com/user/$channel/'); void 0;" title="$goto_txt">$goto_txt</a></p>
EOF;
		} // showgoto
	}
	?>
	</div>
		<?php
		echo $after_widget;
	}

}
add_action('widgets_init', create_function('', 'return register_widget("YouTube_Channel_Widget");'));
?>
