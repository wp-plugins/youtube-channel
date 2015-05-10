<?php
	global $WPAU_YOUTUBE_CHANNEL;
?>
<div class="wrap" id="youtube_channel_settings">
	<h2><?php _e( $WPAU_YOUTUBE_CHANNEL->plugin_name . ' Settings', 'wpsk' ); ?></h2>
<?php

	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';


	// define available tabs
	$tabs = array(
		'general' => 'General',
		'video'   => 'Video',
		'content' => 'Content',
		'link'    => 'Link to Channel',
		'tools'   => 'Tools',
		'help'    => 'Help',
		'support' => 'Support'
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

	if ( ! empty($tabs[ $active_tab ]) ) {

		if ( ! in_array( $active_tab, array('tools', 'help', 'support') ) ) {
			// for all tabs except tools and help

			echo '<form method="post" action="options.php">';

			settings_fields( 'ytc_' . $active_tab );
			// settings_fields( $WPAU_YOUTUBE_CHANNEL->plugin_slug . '_' . $active_tab );
			do_settings_sections( $WPAU_YOUTUBE_CHANNEL->plugin_slug . '_' . $active_tab );
			// do_settings_sections( 'ytc_' . $active_tab );
			// settings_fields( $WPAU_YOUTUBE_CHANNEL->plugin_slug . '_' . $active_tab );
			// do_settings_sections( $WPAU_YOUTUBE_CHANNEL->plugin_slug . '_' . $active_tab );

			submit_button();

			echo '</form>';

		} else if ( $active_tab == 'tools' ) {
			include_once("settings_tools.php");
		} else if ( $active_tab == 'help' ) {
			include_once("settings_usage.php");
			include_once("settings_usage_shortcode.php");
		} else if ( $active_tab == 'support' ) {
			include_once("settings_support.php");
		} // $active_tab != 'tools|help|support'

	} // ! empty ( $tabs[$active_tab] )
?>

</div>