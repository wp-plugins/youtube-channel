<?php
	global $WPAU_YOUTUBE_CHANNEL;
?>
<div class="wrap" id="youtube_channel_settings">
<p style="float:right;text-align:center;"><small>Support YTC developer</small><br><a href="http://urosevic.net/wordpress/donate/?donate_for=youtube-channel" target="_blank">Donate via PayPal</a></p>
	<h2><?php _e( $WPAU_YOUTUBE_CHANNEL->plugin_name . ' Settings', 'youtube-channel' ); ?></h2>
	<?php
	$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';

	// define available tabs
	$tabs = array(
		'general' => __( 'General', 'youtube-channel' ),
		'video'   => __( 'Video', 'youtube-channel' ),
		'content' => __( 'Content', 'youtube-channel' ),
		'link'    => __( 'Link to Channel', 'youtube-channel' ),
		'tools'   => __( 'Tools', 'youtube-channel' ),
		'help'    => __( 'Help', 'youtube-channel' ),
		'support' => __( 'Support', 'youtube-channel' ),
	);
	?>
<h2 class="nav-tab-wrapper">
	<?php
	foreach ( $tabs as $tab_name => $tab_title ) {
		echo '<a href="?page=' . $WPAU_YOUTUBE_CHANNEL->plugin_slug . '&tab=' . $tab_name . '" class="nav-tab' . ( ( $active_tab == $tab_name ) ? ' nav-tab-active' : '' ) . '">' . $tab_title . '</a>';
	}
	?>
</h2>
	<?php

	if ( ! empty( $tabs[ $active_tab ] ) ) {

		if ( ! in_array( $active_tab, array( 'tools', 'help', 'support' ) ) ) {
			// for all tabs except tools and help

			echo '<form method="post" action="options.php">';

			settings_fields( 'ytc_' . $active_tab );
			do_settings_sections( $WPAU_YOUTUBE_CHANNEL->plugin_slug . '_' . $active_tab );

			submit_button();

			echo '</form>';

		} else if ( 'tools' == $active_tab ) {
			include_once( 'settings-tools.php' );
		} else if ( 'help' == $active_tab ) {
			include_once( 'settings-usage.php' );
			include_once( 'settings-usage-shortcode.php' );
		} else if ( 'support' == $active_tab ) {
			include_once( 'settings-support.php' );
		} // $active_tab != 'tools|help|support'

	} // ! empty ( $tabs[$active_tab] )
?>

</div>
