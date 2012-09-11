=== YouTube Channel ===
Contributors: urkekg
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Q6Q762MQ97XJ6
Tags: youtube, channel, playlist, single, widget, widgets, youtube player, flash player, rss, feed, video, thumbnail, embed, sidebar, chromeless, iframe, html5
Requires at least: 3.2.1
Tested up to: 3.3.1
Stable tag: 1.3.2

Sidebar widget to show latest video thumbnail, playable flash object or chromeless video from YouTube Channel or Playlist.

== Description ==

When you need to display sidebar widget with latest video from some YouTube channel or playlist, you can use customisable `YouTube Channel` plugin.

Simply insert widget to sidebar, set channel name and if you wish leave all other options on default. You will get latest video from chosen YouTube channel embedded in sidebar widget, with link to channel on the bottom of the widget. If you wish to use playlist instead of channel, just set playlist ID and injoy!

If you like this extension and you find it useful, please rate it on the right side.

= Features =
* Display latest video from YouTube channel or playlist
* Option to get random video from channel or playlist
* Set custom widget title
* Custom set of width and height of video thumbnail/embeded object (default 220x165 px)
* Preferred aspect ratio relative to width (custom, 4:3, 16:10 and 16:9)
* Choose to display video thumbnail, iframe (HTML5 video), object embed (Flash video) or chromeless video
* Fix height for old and new YouTube embed and Chromeless video object taken by controls
* Option to enable autoplay video
* Option to hide video controls
* Option to hide video info
* Option to show video title on top of the video
* Option to show video description below vide (experimental)
* Option to hide annotations from video
* Option to use light controls theme
* Set custom text for link to channel
* Option to show link to channel
* Option to open channel in new tab/window
* Option to use target="_blank" instead of javascript window.open() for chanel link in new tab/window
* Translated to Serbian and Spanish (English by default)

= Issues =
Controls light theme and hidden annotations does not work for chromeless object.

= Credits =
Chromeless option borrowed from [Chromeless YouTube](http://wordpress.org/extend/plugins/chromeless-youtube/) extension.
Code improvements and textdomain adds done by [dimadin](http://wordpress.org/extend/plugins/profile/dimadin).
[Federico Bozo](http://corchoweb.com/) reminded me to fix z-index problem

== Installation ==

You can use the built in installer and upgrader, or you can install the plugin manually.

1. You can either use the automatic plugin installer or your FTP program to upload unziped `youtube-channel` directory to your `wp-content/plugins` directory.
2. Activate the plugin through the `Plugins` menu in WordPress
3. Add YouTube Channel widget to your sidebar
4. Set channel name and save changes

If you have to upgrade manually simply repeat the installation steps and re-enable the plugin.

== TODO ==

* Add option to open video for thumbnail image in lightbox
* Add option to show favorite videos

== Frequently Asked Questions ==

= Why yet another YouTube widget extension? =

I could not to find widget with link to channel and thumbnail instead of video object, so I made this one.

= I set more thano one items to fetch, but only one video is displayed. How to fix this? =

Currently YTC can display only one video per time. Option `Items to fetch` us used for calculating what random video from channel or playlist to get as limit of videos of which random is calculated.

= How to get playlist ID? =

Playlist ID can be manualy extracted from YouTube playlist URL. Part of strings after `&list=` that begins with uppercase letters `PL` represent playlist ID.

Since version 1.3.1 you can paste full YouTube playlist URL and ID will be automaticaly extracted.

= How to force embeding 320p video with better audio quality? =

YouTube provide 320p videos if height of embeded video is set to 320 or more. If you use small YTC video size, 240p will be loaded instead.

= There is two playlist checkboxes, how they works? =

If you wish to use videos from playlist instead of videos from channel (display random videos, one or more videos, with all kind of settings) enable option `Use the playlist instead of channel`.
If you wish to show only single embedded playlist block using IFRAME (HTML5), then enable option `Embed only standard playlist` and all other settings will be ignored.

= What is a difference between `Fetch latest` and `Show ... videos`? =

Value for `Fetch latest` says how many items will containt set of videos for choosing random video.
value for `Show ... videos` says how many videos will be displayed in widget.

== Changelog ==
= 1.4.0 =
* Added option to show preferred quantity of videos
* Added option to embed classic playlist
* For random video use channel or playlist
* Fields for width and height converted to number with spinner
* Added class to video title .ytc_title
* Added class to video container: universal .ytc_video_container and selective (.ytc_video_first, .ytc_video_mid, .ytc_video_last)
* Added routine to unique random video from channel if displayed more than one video

= 1.3.3 =
* Added Czech translation by Ladislav Drábek

= 1.3.2 =
* Add option to show video description below video
* Add option to shorten video description to N characters
* Add option to use light theme for controls instead of default dark theme (HTML5 iframe and flash object)
* Add option to hide annotations from video

= 1.3.1 =
* Add support for playlist full URL
* Fixed no random video for playlist

= 1.3 =
* Fixed z-index problem with flash and iframe object
* Add option to try to fix 'No items' error
* Add donate button in options dialog

= 1.2 =
* Fixed number of items for random video (min 1, max 50)
* Fixed no-controls for HTML5 iframe

= 1.1 =
* Added option to use the playlist instead of channel (suggested by Stacy)

= 1.0 =
* Ported to WordPress 3.2.1
* Added option to set maximum number of items for random video
* Version changed from major.minor.micro to to major.minor format
* Adds Spanish translation

= 0.1.3 =
* Uses selected() instead of if [dimadin]
* Uses sprintf for better i18n [dimadin]
* Wraps some strings in gettext [dimadin]
* Adds textdomain and loads it [dimadin]
* Adds target="_blank" for channel link [dimadin]
* Adds option to open channel link in popup
* Uses plugin_dir_url() instead of guessing of location [dimadin]
* Loads widget in its own function [dimadin]
* Adds Serbian translation

= 0.1.2 =
* Option to display random video from channel

= 0.1.1 =
* Fixed option to toggle video title visibility
* Added option to hide controls for iframe and object videos
* Added option to hide video info
* Enabled autostart for iframe and object videos

= 0.1.0 =
* Initial release

== Upgrade Notice ==

= 0.1.3 =
After upgrade check widget options.

= 0.1.2 =
After upgrade set option for random video from channel.

= 0.1.1 =
After upgrade please reconfigure widget. Some variables are changed and implemented new features.

= 0.1.0 =
Just try it and rate it. Only initial release is available right now.

== Screenshots ==

1. Widget `YouTube Channel` configuration panel
2. Widget `YouTube Channel` in action with iframe (HTML5) video object with controls and fixed height
3. Widget `YouTube Channel` in action with Chromeless video object w/o controls
