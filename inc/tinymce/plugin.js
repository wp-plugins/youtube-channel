( function() {
	tinymce.PluginManager.add( 'youtube_channel', function( editor, url ) {

		// Add a button that opens a window
		editor.addButton( 'youtube_channel_shortcode', {
			tooltip: 'YouTube Channel',
			icon: 'ytc',
			onclick: function() {
				// Open window
				editor.windowManager.open( {
					title: 'YouTube Channel',
					// width: 600,
					// height: 400,
					// autoScroll: true,
					// resizable: true,
					// classes: 'ytc-shortcode-popup',
					bodyType: 'tabpanel',
					buttons: [
						{
							text: 'Insert Shortcode',
							onclick: 'submit',
							classes: 'widget btn primary',
							minWidth: 130
						},
						{
							text: 'Cancel',
							onclick: 'close'
						}
					],
					body: [

						{
							title: 'General Settings',
							type: 'form',
							items: [
								{
									type: 'textbox',
									name: 'class',
									label: 'Custom CSS Class',
									value: '',
									tooltip: 'Enter custom class for YTC block, if you wish to target block styling'
								},
								{
									type: 'textbox',
									name: 'vanity',
									label: 'Vanity/Custom ID',
									value: '',
									// tooltip: ''
								},
								{
									type: 'textbox',
									name: 'channel',
									label: 'YouTube Channel ID',
									value: '',
									// tooltip: ''
								},
								{
									type: 'textbox',
									name: 'legacy',
									label: 'Legacy username',
									value: '',
									// tooltip: ''
								},
								{
									type: 'textbox',
									name: 'playlist',
									label: 'Playlist ID',
									value: '',
									// tooltip: ''
								},
								{
									type: 'listbox',
									name: 'resource',
									label: 'Resource to use',
									tooltip: '',
									values : [
										{text: 'Channel', value: '0', selected: true},
										{text: 'Favourited videos', value: '1'},
										{text: 'Liked videos', value: '3'},
										{text: 'Playlist', value: '2'},
									]
								},
								{
									type: 'listbox',
									name: 'cache',
									label: 'Cache timeout',
									tooltip: '',
									values : [
										{text: 'Do not cache', value: '0'},
										{text: '1 minute', value: '60'},
										{text: '5 minutes', value: '300', selected: true},
										{text: '15 minutes', value: '900'},
										{text: '30 minutes', value: '1800'},
										{text: '1 hour', value: '3600'},
										{text: '2 hours', value: '7200'},
										{text: '5 hours', value: '18000'},
										{text: '10 hours', value: '36000'},
										{text: '12 hours', value: '43200'},
										{text: '18 hours', value: '64800'},
										{text: '1 day', value: '86400'},
										{text: '2 days', value: '172800'},
										{text: '3 days', value: '259200'},
										{text: '4 days', value: '345600'},
										{text: '5 days', value: '432000'},
										{text: '6 days', value: '518400'},
										{text: '1 week', value: '604800'},
										{text: '2 weeks', value: '1209600'},
										{text: '3 weeks', value: '1814400'},
										{text: '1 month', value: '2419200'},
									]
								},
								{
									type: 'checkbox',
									name: 'only_pl',
									label: 'Embed resource as playlist',
									tooltip: 'Overrides random video option.',
									checked: false
								},
								{
									type: 'checkbox',
									name: 'privacy',
									label: 'Use Enhanced Privacy ',
									// tooltip: '',
									checked: false
								},
								{
									type: 'checkbox',
									name: 'random',
									label: 'Random video',
									tooltip: 'Show random video from resource (Have no effect if \"Embed resource as playlist\" is enabled)',
									checked: false
								},
								{
									type: 'textbox',
									name: 'fetch',
									label: 'Fetch',
									value: '10',
									tooltip: 'Number of videos that will be used for random pick (min 2, max 50, default 25)'
								},
								{
									type: 'textbox',
									name: 'num',
									label: 'Show',
									value: '1',
									tooltip: 'Number of videos to display'
								},
							]
						},
						{
							title: 'Video Settings',
							type: 'form',
							items: [
								{
									type: 'listbox',
									name: 'ratio',
									label: 'Aspect Ratio',
									// tooltip: '',
									values : [
										{text: 'Widescreen (16:9)', value: '3', selected: true},
										{text: 'Standard TV (4:3)', value: '1'},
									]
								},
								{
									type: 'checkbox',
									name: 'responsive',
									label: 'Responsive video',
									tooltip: 'Make video responsive (distribute one full width video per row)',
									checked: true
								},
								{
									type: 'textbox',
									name: 'width',
									label: 'Width (px)',
									value: '306',
									tooltip: 'Set video or thumbnail width in pixels'
								},
								{
									type: 'listbox',
									name: 'display',
									label: 'What to show?',
									tooltip: '',
									values : [
										{text: 'Thumbnail', value: 'thumbnail'},
										{text: 'HTML5 (iframe)', value: 'iframe'},
										{text: 'HTML5 (iframe) Asynchronous', value: 'iframe2'},
									]
								},
								{
									type: 'checkbox',
									name: 'no_thumb_title',
									label: 'Hide thumbnail tooltip',
									checked: false
								},
								{
									type: 'checkbox',
									name: 'themelight',
									label: 'Use light theme',
									tooltip: 'Default theme is dark',
									checked: false
								},
								{
									type: 'checkbox',
									name: 'controls',
									label: 'Hide player controls',
									checked: false
								},
								{
									type: 'checkbox',
									name: 'autoplay',
									label: 'Autoplay video/playlist',
									checked: false
								},
								{
									type: 'checkbox',
									name: 'autoplay_mute',
									label: 'Mute video on autoplay',
									checked: false
								},
								{
									type: 'checkbox',
									name: 'norel',
									label: 'Hide related videos',
									checked: true
								},
								{
									type: 'checkbox',
									name: 'modestbranding',
									label: 'Hide YT Logo',
									tooltip: 'Does not work for all videos',
									checked: true
								},
							]
						},
						{
							title: 'Content Layout',
							type: 'form',
							items: [
								{
									type: 'checkbox',
									name: 'showtitle',
									label: 'Show video title',
									checked: false
								},
								{
									type: 'checkbox',
									name: 'titlebelow',
									label: 'Move title below video',
									checked: false
								},
								{
									type: 'checkbox',
									name: 'showdesc',
									label: 'Show video description',
									checked: false
								},
								{
									type: 'textbox',
									name: 'desclen',
									label: 'Description length',
									value: '0',
									tooltip: 'Set number of characters to cut down video description to (0 means full length)'
								},
								{
									type: 'checkbox',
									name: 'hideanno',
									label: 'Hide annotations',
									checked: false
								},
								{
									type: 'checkbox',
									name: 'hideinfo',
									label: 'Hide video info',
									checked: false
								},
							]
						},
						{
							title: 'Link to Channel',
							type: 'form',
							items: [
								{
									type: 'checkbox',
									name: 'showgoto',
									label: 'Show link',
									tooltip: 'Display link to channel below videos or thumbnails',
									checked: false
								},
								{
									type: 'textbox',
									name: 'goto_txt',
									label: 'Title for link',
									value: 'Visit our YouTube channel',
								},
								{
									type: 'listbox',
									name: 'link_to',
									label: 'Link to',
									// tooltip: '',
									values : [
										{text: 'Vanity/Custom URL', value: '2', selected: true},
										{text: 'Channel page URL', value: '1'},
										{text: 'Legacy username URL', value: '0'},
									]
								},
							]
						}
					],

					onsubmit: function( e ) {
						// Insert content when the window form is submitted
						// Open shortcode
						var shortcode = '[youtube_channel';

						// General Settings
						if ( e.data.vanity ) shortcode += ' vanity=' + e.data.vanity +'';
						if ( e.data.channel ) shortcode += ' channel=' + e.data.channel +'';
						if ( e.data.legacy ) shortcode += ' legacy=' + e.data.legacy +'';
						if ( e.data.playlist ) shortcode += ' playlist=' + e.data.playlist +'';
						if ( e.data.resource ) shortcode += ' resource=' + e.data.resource +'';
						if ( e.data.cache ) shortcode += ' cache=' + e.data.cache +'';
						if ( e.data.only_pl ) shortcode += ' only_pl=1';
						if ( e.data.privacy ) shortcode += ' privacy=1';
						if ( e.data.random ) shortcode += ' random=1';
						if ( e.data.fetch ) shortcode += ' fetch=' + e.data.fetch +'';
						if ( e.data.num ) shortcode += ' num=' + e.data.num +'';

						// Video Settings
						if ( e.data.ratio ) shortcode += ' ratio=' + e.data.ratio + '';
						if ( e.data.responsive ) shortcode += ' responsive=1';
						if ( e.data.width ) shortcode += ' width=' + e.data.width + '';
						if ( e.data.display ) shortcode += ' display=' + e.data.display + '';
						if ( e.data.no_thumb_title ) shortcode += ' no_thumb_title=1';
						if ( e.data.themelight ) shortcode += ' themelight=1';
						if ( e.data.controls ) shortcode += ' controls=1';
						if ( e.data.autoplay ) shortcode += ' autoplay=1';
						if ( e.data.autoplay_mute ) shortcode += ' autoplay_mute=1';
						if ( e.data.norel ) shortcode += ' norel=1';
						if ( e.data.modestbranding ) shortcode += ' modestbranding=1';

						// Content Layout
						if ( e.data.showtitle ) shortcode += ' showtitle=1';
						if ( e.data.titlebelow ) shortcode += ' titlebelow=1';
						if ( e.data.showdesc ) shortcode += ' showdesc=1';
						if ( e.data.desclen ) shortcode += ' desclen=' + e.data.desclen + '';
						if ( e.data.hideanno ) shortcode += ' hideanno=1';
						if ( e.data.hideinfo ) shortcode += ' hideinfo=1';

						// Link to Channel
						if ( e.data.showgoto ) shortcode += ' showgoto=1';
						if ( e.data.goto_txt ) shortcode += ' goto_txt=\"' + e.data.goto_txt + '\"';
						if ( e.data.link_to ) shortcode += ' link_to=' + e.data.link_to + '';

						// Global
						if ( e.data.class ) shortcode += ' class=' + e.data.class + '';

						// Close shortcode
						shortcode += ']';

						editor.insertContent( shortcode );
					} // onsubmit alert

				} );
			} // onclick alert

		} );

	} );

} )();