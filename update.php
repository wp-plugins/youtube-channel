<?php
/**
 * Run the incremental updates one by one.
 *
 * For example, if the current DB version is 3, and the target DB version is 6,
 * this function will execute update routines if they exist:
 *  - au_youtube_channel_update_routine_4()
 *  - au_youtube_channel_update_routine_5()
 *  - au_youtube_channel_update_routine_6()
 */

function au_youtube_channel_update() {
	// no PHP timeout for running updates
	set_time_limit( 0 );

	// this is the current database schema version number
	$current_db_ver = get_option( 'youtube_channel_db_ver', 0 );

	// this is the target version that we need to reach
	$target_db_ver = WPAU_YOUTUBE_CHANNEL::DB_VER;

	// run update routines one by one until the current version number
	// reaches the target version number
	while ( $current_db_ver < $target_db_ver ) {
		// increment the current db_ver by one
		++$current_db_ver;

		// each db version will require a separate update function
		// for example, for db_ver 3, the function name should be solis_update_routine_3
		$func = "au_youtube_channel_update_routine_{$current_db_ver}";
		if ( function_exists( $func ) ) {
			call_user_func( $func );
		}

		// update the option in the database, so that this process can always
		// pick up where it left off
		update_option( 'youtube_channel_db_ver', $current_db_ver );
	}
} // END function au_youtube_channel_update()

/**
 * Migrate pre-2.0.0 widgets to 2.0.0 version
 */
function au_youtube_channel_update_routine_2() {

			if ( $old = get_option('widget_youtube_channel_widget') ) {

				// get new YTC widgets
				$new = get_option('widget_youtube-channel');

				// get all widget areas
				$widget_areas = get_option('sidebars_widgets');

				// update options to 2.0.0+ version
				foreach ($old as $k => $v) {

					if ( $k !== "_multiwidget" ){
						// option for resource
						$v['use_res'] = 0;
						if ( $v['usepl'] == 'on' ) {
							$v['use_res'] = 2;
						}

						$v['popup_goto'] = 0;
						if ( $v['popupgoto'] == 'on' ) {
							$v['popup_goto'] = 1;
						} else if ($v['target'] == 'on') {
							$v['popup_goto'] = 2;
						}
						unset($v['usepl'], $v['popupgoto'], $v['target']);

						$v['cache_time']    = 0;
						$v['userchan']      = 0;
						$v['enhprivacy']    = 0;
						$v['autoplay_mute'] = 0;

						// add old YTC widget to new set
						// but append at the end if YTC widget with same ID already exist
						// in new set (created in version 2.0.0)
						if ( is_array($new[$k]) ) {
							// populate at the end
							array_push($new, $v);
							$ytc_widget_id = 'youtube-channel-' . end( array_keys($new) );
						} else {
							// set as current widget ID
							$new[$k] = $v;
							$ytc_widget_id = "youtube-channel-$k";
						}

						$ytc_widget_added = 0;
						foreach ( $widget_areas as $wak => $wav ) {
							// check if here we have this widget
							if ( is_array($wav) && in_array($ytc_widget_id, $wav) ) {
								++$ytc_widget_added;
							}
						}
						// fre some memory
						unset($wak, $wav);

						// if YTC widget has not present in any widget area, add it to inactive widgets ;)
						if ( $ytc_widget_added == 0 ) {
							array_push($widget_areas['wp_inactive_widgets'], $ytc_widget_id);
						}

					} // add to inactive widgets if don't belong to any widget area

				} // foreach widget option

				// update widget areas set
				update_option('sidebars_widgets', $widget_areas);

				// update new YTC widgets
				update_option('widget_youtube-channel', $new);

				// remove old YTC widgets entry
				delete_option('widget_youtube_channel_widget');

			} // if we have old YTC widgets

			// clear temporary vars
			unset ($old, $new, $k, $v, $widget_areas, $ytc_widget_added, $ytc_widget_id);


} // END function au_youtube_channel_update_routine_2()

/**
 * migrate to v3.0.0
 * @return [type] [description]
 */
function au_youtube_channel_update_routine_3() {

	// Remove deprecated option keys
	delete_option('ytc_no_redux_notice');
	delete_option('ytc_old_php_notice');
	delete_option('ytc_version');

	// get options from DB
	$defaults = get_option('youtube_channel_defaults');

	// prepare migration matrix
	$options_matrix = array(
		'use_res'    => 'resource',
		'cache_time' => 'cache',
		'maxrnd'     => 'fetch',
		'vidqty'     => 'num',
		'getrnd'     => 'random',
		'to_show'    => 'display',
		'showvidesc' => 'showdesc',
		'videsclen'  => 'desclen',
		'enhprivacy' => 'privacy'
	);
	// set defaults
	$init = array(
		'resource' => 0, // ex use_res
		'cache'    => 300, // 5 minutes // ex cache_time
		'fetch'    => 25, // ex maxrnd
		'num'      => 1, // ex vidqty
		'random'   => 0, // ex getrnd
		'display'  => 'thumbnail', // ex to_show
		'showdesc' => 0, // ex showvidesc
		'desclen'  => 0, // ex videsclen
		'privacy'  => 0 // ex enhprivacy
	);

	// Do migration of option names
	foreach ( $options_matrix as $old_option => $new_option ) {
		if ( isset($defaults[ $old_option ]) ) {
			$defaults[ $new_option ] = $defaults[ $old_option ];
			unset($defaults[ $old_option ]);
		} else if ( empty($defaults[ $new_option ]) ) {
			$defaults[ $new_option ] = $init[ $new_option ];
		}
	}
	// Free some memory
	unset ( $old_option, $new_option );

	// Write back updated defaults
	update_option( 'youtube_channel_defaults', $defaults );

	// Add empty option key for dismissed notices
	add_option('youtube_channel_dismissed_notices', '', '', 'no');

	// Update plugin version number
	update_option('youtube_channel_version', WPAU_YOUTUBE_CHANNEL::VER);

	// Delete all YouTube Channel transients
	global $_wp_using_ext_object_cache, $wpdb;
	if ( ! $_wp_using_ext_object_cache ) {
		$sql = "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_ytc_%' OR option_name LIKE '_transient_timeout_ytc_%'";
		$clean = $wpdb -> query( $sql );

		// optimize wp_options table
		$wpdb -> query( "OPTIMIZE TABLE $wpdb->options" );
	}

	$ytc_widgets = get_option('widget_youtube-channel');
	foreach ( $ytc_widgets as $widget_id => $widget_data ) {
		// process widget arrays, not _multiwidget bool
		if ( $widget_id != '_multiwidget' ) {

			foreach ( $widget_data as $key => $val ) {
				// if old key is in matrix
				if ( array_key_exists($key, $options_matrix) ) {
					// create new option if does not exists
					if ( ! array_key_exists($options_matrix[ $key ], $widget_data) ) {
						// copy old value to new key name
						$ytc_widgets[ $widget_id ][ $options_matrix[ $key ] ] = $val;
					}
					// delete old key
					unset ($ytc_widgets[ $widget_id ][ $key ]);
				}
			} // END foreach ( $widget_data as $key => $val )

		} // END if ( $widget_id != '_multiwidget' )

	}
	update_option('widget_youtube-channel', $ytc_widgets);
	unset ($options_matrix, $init, $ytc_widgets, $widget_id, $widget_data);

} // END function au_youtube_channel_update_routine_3()

/**
 * Store API Key to DB
 */
function au_youtube_channel_update_routine_5() {

	// get options from DB
	$defaults = get_option('youtube_channel_defaults');
	unset($defaults['only_pl']);

	if ( defined('YOUTUBE_DATA_API_KEY') ) {


		if ( empty($defaults['apikey']) ) {
			$defaults['apikey'] = YOUTUBE_DATA_API_KEY;
		}
		unset($defaults);

	}

	update_option('youtube_channel_defaults', $defaults);

	// remove unused keys from DB
	delete_option('youtube_channel_ver');

	// Update plugin version number
	update_option('youtube_channel_version', WPAU_YOUTUBE_CHANNEL::VER);

} //END function au_youtube_channel_update_routine_5()
