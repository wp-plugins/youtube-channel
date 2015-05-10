=== YouTube Channel ===
Contributors: urkekg
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Q6Q762MQ97XJ6
Tags: youtube, channel, playlist, single, widget, widgets, youtube player, flash player, rss, feed, video, thumbnail, embed, sidebar, chromeless, iframe, html5, responsive
Requires at least: 3.9.0
Tested up to: 4.2.2
Stable tag: 3.0.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Show video thumbnails or playable blocks of recent videos from YouTube Channel or Playlist.

== Description ==

When you need to display sidebar widget with latest video from some YouTube channel or playlist, you can use customisable `YouTube Channel` plugin.

Simply insert widget to sidebar, set channel name and if you wish leave all other options on default. You will get latest video from chosen YouTube channel embedded in sidebar widget, with link to channel on the bottom of the widget. If you wish to use playlist instead of channel, just set playlist ID and injoy!

If you like this extension and you find it useful, please rate it on the right side.

= Features =
* Display latest videos from YouTube channel, favorites or playlist
* Option to get random video from resources mentioned above
* Responsive (one full width video per row) or non responsive (video wall)
* Preferred aspect ratio relative to width (16:9, 16:10 and 4:3)
* Custom width for video embeded object (default is 306px)
* Enhanced Privacy
* Choose to display video as thumbnail, HTML5 (iframe), HTML5 Asynchronous (iframe2), Flash (object) or Chromeless video
* Thumbnail mode opens video in lightbox
* Custom caching timeout
* Optimized gdata feeds
* Optional video autoplay with optional muted audio
* Show customized link to channel below videos

= Notice =

For fully functional plugin you need to have PHP 5.3 or newer! If you experience issues on older PHP, we can't help you as we don't have access to such old development platform.

= Styling =
You can use `style.css` from theme to style `YouTube Video` widget content.

* `.youtube_channel` - main widget wrapper class (non-responsive block have additional class `default`, responsive block have additional class `responsive`)
* `.ytc_title` - class of video title abowe thumbnail/video object
* `.ytc_video_container` - class of container for single item
* `.ytc_video_1`, `.ytc_video_2`, ... - class of container for single item with ordering number of item in widget
* `.ytc_video_first` - class of first container for single item
* `.ytc_video_last` - class of last container for single item
* `.ytc_video_mid` - class of all other containers for single item
* `.ytc_description` - class for video description text
* `.ytc_link` - class of container for link to channel

= Known Issues =

* Video description for videos from playlist does not work.
* Removing YouTube logo from playback control bar does not work for all videos
* Async HTML5 video does not work for 2nd same video on same page (two YTC blocks set to Async HTML5)
* Thumbnail and opening video in lightbox does not work with `Responz` theme by `Thenify.me` if you wish to hide related videos, because this theme uses original `Magnific Popup` library that does not support `rel` parameter.

If WordFence or other malware scan tool detect YouTube Channel fule youtube-channel.php as potential risk because `base64_encode()` and `base64_decode()` functions, remember that we use this two functions to store and restore JSON feeds to transient cache, so potential detection is false positive.

= Credits =

* For playing videos in lightbox we use enhanced [Magnific Popup](http://dimsemenov.com/plugins/magnific-popup/).
* Initial textdomain adds done by [dimadin](http://wordpress.org/extend/plugins/profile/dimadin).
* [Federico Bozo](http://corchoweb.com/) reminded me to fix z-index problem
* Czech localization by [Ladislav Drábek](http://zholesova.cz)
* Spanish localization by [Diego Riaño](http://Digital03.net)
* Danish localisation by [GSAdev v. Georg Adamsen](http://www.gsadev.dk)

= Shortcode =

Along to Widget, you can add YouTube Channel block inline by using shortcode `[youtube_channel]`. Default plugin parameters will be used for shortcode, but you can customize all parameters per shortcode.

**General Settings**

* `class` (string) Set custom class if you wish to target special styling for specific YTC block
* `channel` (string) ID of preferred YouTube channel. Do not set full URL to channel, but just last part from URL - ID (name)
* `vanity` (string) part after www.youtube.com/c/ from [Custom URL](https://support.google.com/youtube/answer/2657968?hl=en)
* `playlist` (string) ID of preferred YouTube playlist.
* `resource` (int) Resource to use for feed:
  * `0` Channel
  * `1` Favorites (for defined channel)
  * `2` Playlist
  * `3` Liked Videos
* `only_pl` (bool) If you set to use Playlist as resource, you can embed youtube playlist block instead single video from playlist. Simply set this option to true (1 or true)
* `cache` (int) Period in seconds for caching feed. You can disable caching by setting this option to 0, but if you have a lot of visits, consider at least short caching (couple minutes).
* `fetch` (int) Number of videos that will be used as stack for random pick (min 2, max 50)
* `num` (int) Number of videos to display per YTC block.
* `random` (bool) Option to randomize videos on every page load.

**Video Settings**

* `ratio` (int) Set preferred aspect ratio for thumbnail and video. You can use:
  * `3` 16:9 (widescreen)
  * `1` 4:3
* `responsive` (bool) Distribute one full width video per row.
* `width` (int) Width of thumbnail and video in pixels.
* `display` (string) Object that will be used to represent video. We have couple predefined options:
  * `thumbnail` Thumbnail will be used and video will be loaded in lightbox. (default)
  * `iframe` HTML5 (iframe)
  * `iframe2` HTML5 (iframe) with asynchronous loading - recommended
* `no_thumb_title` (bool) By default YouTube thumbnail will have tooltip with info about video title and date of publishing. By setting this option to 1 or true you can hide tooltip
* `themelight` (bool) By default YouTube have dark play controls theme. By setting this option to 1 or true you can get light theme in player (HTML5 and Flash)
* `controls` (bool) Set this option to 1 or true to hide playback controls.
* `autoplay` (bool) Enable autoplay of first video in YTC video stack by setting this option to 1 or true
* `mute` (bool) Set this option to 1 or true to mute videos set to autoplay on load
* `norel` (bool) Set this option to 1 or true to hire related videos after finished playbak
* `nobrand` (bool) Set this option to 1 or true to hire YouTube logo from playback control bar

**Content Layout**

* `showtitle` (bool)
* `showdesc` (bool)
* `desclen` (int)
* `noinfo` (bool)
* `noanno` (bool)

**Link to Channel**

* `goto` (bool)
* `goto_txt` (string)
* `popup` (int)
* `link_to` (int)

== Installation ==

You can use the built in installer and upgrader, or you can install the plugin manually.

1. You can either use the automatic plugin installer or your FTP program to upload unziped `youtube-channel` directory to your `wp-content/plugins` directory.
2. Activate the plugin through the `Plugins` menu in WordPress
3. Add YouTube Channel widget to sidebar
4. Set channel name and save changes

If you have to upgrade manually simply repeat the installation steps and re-enable the plugin.

= YouTube Data API Key =
Main difference since v2.x branch is that now we use [YouTube Data API v3](https://developers.google.com/youtube/v3/) so to make plugin to work, you'll need to generate YouTube Data API Key and insert it to `wp-config.php` file.

Learn more about [Obtaining authorization credentials](https://developers.google.com/youtube/registering_an_application) and for detailed instructions how to generate your own API Key watch video below.

[youtube http://www.youtube.com/watch?v=8NlXV77QO8U]

1. Visit [Google Developers Console](https://console.developers.google.com/project)
1. If you don't have any project, create new one. Name it so you can recognize it (for example **My WordPress Website**).
1. Select your new project and from LHS sidebar expand group **APIs & auth**, then select item **APIs**
1. Locate and click **YouTube Data API** under **YouTube API** section
1. Click **Enable API** button
1. When you get enabled YouTube Data API in your project, click **Credentials** item from LHS menu **APIs & auth**
1. Click **Create New Key** button and select **Browser Key**
1. Leave empty or enter domain name of your website with wildcards. If you get message **Ups, something went wrong.** try to tune referer with wildcars (I did not success in that) or leave any restriction.
1. Click **Create** button
1. Copy newly created **API Key**

When you generate your own YouTube Data API Key, edit wp-config.php file and find line

`/* That's all, stop editing! Happy blogging. */`

Insert above that line code
`define('YOUTUBE_DATA_API_KEY', 'YOUR_API_KEY');`

just replace keyword <strong>YOUR_API_KEY</strong> with your real API Key previously generated (surround API key to single quotes). For example, if your key is **AIzaCuBWKZLyQthAgV3ofeYtCwrMSYvm6tX8IEY** then that line should be:
`define('YOUTUBE_DATA_API_KEY', 'AIzaCuBWKZLyQthAgV3ofeYtCwrMSYvm6tX8IEY');`

== Frequently Asked Questions ==

= I set more than one items to fetch, but only one video is displayed. How to fix this? =

Below option `Fetch ... video(s)` you can find `Show ... video(s)` since version 2.0.0. Here you can set number of videos to display.

= How to get playlist ID? =

Playlist ID can be manualy extracted from YouTube playlist URL. Part of strings after `&list=` that begins with uppercase letters `PL` represent playlist ID. You can paste ID with or without leading `PL` string.

Since version 1.3.1 you can also paste full YouTube playlist URL and ID will be automaticaly extracted.

= How to fix error `Invalid value for parameter: username` =

Double check YouTube Channel ID which you set in widget/settings. Channel ID (username) should not contain spaces.

= How to force embeding 320p video with better audio quality? =

YouTube provide 320p videos if height of embeded video is set to 320 or more. If you use small YTC video size, 240p will be loaded instead. So, you could not force 720p in tiny YTC.

= What is a difference between `Fetch latest` and `Show ... videos`? =

Value for `Fetch latest` says how many items will containt videos feed for choosing random video.
Value for `Show ... videos` says how many videos will be displayed in widget.

= In wich way does the plugin order the videos? Not by the time they were uploaded... =

By default, YTC sort videos by publishing date/time, not by uploaded date/time.

If you have enabled option `Fix No items error/Respect playlist order`, then videos are not sorted by publishing date, but by YouTube default order.

= When I upload a new video to youtube, it is not in the list at my site =

Video feed for YTC has been retreived with standard youtube feed [uploads by specified user](https://developers.google.com/youtube/2.0/developers_guide_protocol?hl=en#User_Uploaded_Videos "User Uploaded Videos"), and as Google say: [uploaded videos will be included in a user's public uploaded videos feed a few minutes after the upload completes and YouTube finishes processing the video](https://developers.google.com/youtube/2.0/reference#Latency_Information).

If you does not see your latest video in your uplaods feed (which you can access at https://gdata.youtube.com/feeds/api/users/YOUR_YT_USERID/uploads by replacing YOUR_YT_USERID with your real youtube user ID), then YTC will not see it too.

= I enabled option `Hide YT Logo` but YouTube logo is still visible =

Modestbranding option does not work for all videos, so a lot of videos will still have YouTube logo in control bar. I recommend to enable option `Hide player controls` instead.

Also, even when hidding logo works for your video, on hover or when video is paused in upper right corner will be displayed YouTube link/logo. [Read more here](https://developers.google.com/youtube/player_parameters#modestbranding)

= How I can achieve wall layout with one featured thumbnail? =

You can try with shortcode combination:
`[youtube_channel num=7 responsive=1 class=ytc_wall_1-6 resource=2 random=1]`

and custom CSS code added to theme style.css or similar customization:
`.youtube_channel.ytc_wall_1-6 .ytc_video_container {
	padding: 5px;
	box-sizing: border-box;
}
.youtube_channel.ytc_wall_1-6 .ytc_video_container:not(:first-child) {
	max-width: 33.333%;
}
@media screen and (max-width: 768px) {
	.youtube_channel.ytc_wall_1-6 .ytc_video_container:not(:first-child) {
		max-width: 50%;
	}
}
@media screen and (max-width: 480px) {
	.youtube_channel.ytc_wall_1-6 .ytc_video_container:not(:first-child) {
		max-width: 100%;
	}
}`

So, we display thumbnails for 7 random videos from default (global) playlist, and distribute small thumbnails to 3 columns on wide screens, 2 columns under 768px and single thumbnail per row under 480px.

== Changelog ==

= 3.0.3 (2015-05-10) =
* Fix: "Ups, something went wrong." when Playlist selected as resource because wrong switch
* Fix: Jumping thumbnails in responsive wall on hover in Twenty Fifteen theme because border-bottom for anchors
* Fix: Another deprecated shortcode attribute backward compatibility (`use_res`)
* Add: Example of dynamic responsive wall (1 large + 6 small thumbnails) (to [Description](https://wordpress.org/plugins/youtube-channel/))

= 3.0.2 (2015-05-10) =
* Fix: (typo - experiencing on frontend when no API Key set) PHP Fatal error:  Call to undefined function __sprintf() in youtube-channel.php on line 445
* Fix: shortcode deprecated params `res` and `show` not backward compatibile

= 3.0.1 (2015-05-10) =
* Fix: Fatal error: Using $this when not in object context in youtube-channel.php on line 89
* Fix: Link to channel not visible on Twenty Fifteen theme

= 3.0.0 (2015-05-07/08/09/10) =
* Fix: Migraton of global and widget settings to v3.0.0
* Add: New Global Settings page as replacement of Redux Framework solution
* Add: Non-Dismissable Dashboard notice if YouTube Data API Key missing with link to explanation page
* Change: Option key `ytc_version` to `youtube_channel_version`
* Change: Shortcode parameters: `res` to `resource`, `show` to `display`; but leave old parameter names for backward compatibility
* Enhance: Various plugin core micro optimizations
* Enhance: Dashboard notices
* Enhance: Proper options migration on plugin update
* Remove: Redux Framework mentioning from core plugin
* Remove: Redux Framework config.php
* Remove: chromeless.swf asset
* Remove: option `Fix height taken by controls` as now YouTube displays control bar only when video is hovered

= 3.0.0alpha2 (2015-03-07/22/24) =
* Add: Rewrite plugin to work with YouTube Data API v3
* Add: Vanity link as option to Link to channel (now supports Legacy username, Channel and Vanity URL) with cleanup Vanity ID routine
* Add: Liked videos as resource (now support channel, playlists, favourites and liked videos)
* Add: Admin notification in widget output on front-end if no YouTube Data API Key is defined to prevent errors
* Add: Dismissable Dashboard notice if PHP version is lower than 5.3 as YTC maybe will not work with older versions.
* Change: Global and widget option names: `use_res` to `resource`, `cache_time` to `cache`, `maxrnd` to `fetch`, `vidqty` to `num`, `getrnd` to `random`, `to_show` to `display`, `showvidesc` to `showdesc`, `enhprivacy` to `privacy`, `videsclen` to `desclen`,
* Change: Widget settings functionality, two column options, better toggle for playlist and GoTo section
* Enhance: Caching routine (reduce possibility of failed feed fetch)
* Remove: Chromeless and Flash player - leave only Thumbnail and HTML5
* Remove: Aspect Ration 16:10 (so support only 16:9 and 4:3, same as modern YouTube)
* Remove: "Fix No Item" option - not required for YouTube API 3.0

*OLD RELEASES*
= 2.4.2.1 (2015-04-24) =
* Fix: devicesupport workaround strip 1st video from playlist and favourites and apply only for channel

= 2.4.2 (2015-04-22) =
* Fix: Broken layout introduced by missing responsive for embedded playlist, iframe and iframe2
* Fix: Replace amp's with HTML entity in thumbnail link
* Add: Option to disable thumbnail tooltips (shortcode parameter no_thumb_title)
* Add: List of Shortcode attributes to README file
* Add: Danis localisation by GSAdev v. Georg Adamsen
* Micro optimizations

= 2.4.1.7 (2015-04-20) =
* Quick Fix: strip 1st video from feed that provides notice "YouTube is upgrading to a newer version, which is not supported by this device or app." (more on www.youtube.com/devicesupport) until we finish YouTube Channel 3.0.0 (on the way)

= 2.4.1.6 (2015-04-15) =
* Fix: missing responsive support for embedded playlist, iframe and iframe2
* Fix: missing support to hide playback controls, info and annotations for embedded playlist

= 2.4.1.5 (2015-04-13) =
* (2015-04-13) Change: Add dismiss link for Old PHP notice and lower suggested PHP version to 5.3.x
* (2015-02-19) Fix: missing admin notices if ReduxFramework not active
* (2015-02-10) Add: links to explanations for channel ID and vanity URL
* (2015-02-10) Add: goto macro %vanity% to insert vanity ID
* (2015-02-10) Add: field for vanity URL ID
* (2015-02-10) Add: option to select link to user page, channel page or vanity URL for goto link
* (2015-02-10) Remove: option to use channel instead user page for goto link

= 2.4.1.4 (2015-04-09) =
* (2015-04-09) Add: Notification about old PHP if lower than 5.3.29
* (2015-04-09) Change: Run admin functions only in dashboard
* (2015-02-09) Fix: strip whitespace from the beginngine/end of channel and playlist ID
* (2014-12-30) Fix: prevent Undefined Offset notice when on resource we get less items than user requested in shortcode/widget
* (2014-12-30) Fix: prevent Undefined Offset notice when on resource we get less items than user requested in shortcode/widget
* (2014-12-30) Add: make fallback cache for every feed and use it if no item occurs to avoid No items

= 2.4.1.3 (2014-12-10) =
* Fix: previous release broke opening lightbox for thumbnails and load YouTube website.

= 2.4.1.2 (2014-12-07) =
* Add: Add support for hidden controls and YouTube logo in Thumbnail mode.
* Change: Rename Magnific Popup function to prevent clash with original Modest Branding that does not have support for disabling related videos, player controls and YouTube logo.

= 2.4.1.1 (2014-12-07) =
* Change: Remove parameter `&rel=1` from thumbnail link because that is a default value and can prevent some lightboxes to load video.

= 2.4.1 (2014-11-15) =
* Fix: Typo in widget `Do not chache` [2014-10-03]
* Fix: do not show global settings notice with link to settings page if not Redux Framerowk is active [2014-11-15]
* Fix: Plugin name on Support tab in global plugin settings. [2014-11-15]
* Change: Remove protocol from links and leave browser to decide should get resource from HTTP or HTTPS (depends on website protocol) [2014-10-03]
* Change: Add height addition for `Fix height taken by controls` for embedded playlist and count control above video [2014-10-03]
* Change: Move debug log from widget to downloadable dynamic JSON [2014-11-15]
* Add: ModestBranding (remove YouTube logo from player control bar) [2014-10-03]
* Add: Responsive (make video optionally responsive) [2014-10-04]
* Add: Support for WordPress 4.1 [2014-11-15]

= 2.4.0.2 (2014-10-02) =
* Fix: light theme not applicable to embedded playlist [2014-10-01]
* Fix: add clearfix after YTC widget to prevent jumping out of widget block on bad styled themes [2014-10-02]
* Add: explanation that `What to embed` have no effect for embedded playlist (HTML5 always used) [2014-10-01]

= 2.4.0.1 (2014-10-01) =
* Fix: fatal error - broken execution for embedded playlist with enhanced privacy
* Add: button to discard warning notice for Redux Framework

= 2.4.0 (2014-10-01) =
* Fix: false options set in shortcode had no effect to output box and default settings always used [20140924]
* Fix: enabled checkbox in global settings could not be unticked (disabled) [20140924]
* Fix: prevent array_slice notice if channel have no uploaded videos [20141001]
* Add: fitVids for responsive videos [20140924]
* Add: option for additional YTC box class in widget and shortcode [20140924]
* Change: global settings page re-implemented with Redux Framework and requires Redux Framework Plugin [20140924]
* Change: rewrite plugin to be more OOP [20140924]
* Change: removed obsolete methods [20140924]
* Change: default box width changed from 220 to 306px [20140924]
* Change: YTC block and video pieces now floated left to enable horizontal stack [20140924]
* Change: update localization support [20140926]
* Change: updated Serbian localization [20140926]
* Change: removed PayPal donation button from widget and moved to plugin Settings page [20141001]

= 2.2.3 (2014-09-14) =
* Add: option to disable related videos (not supported by chromeless player)
* Enhance: added support for YouTube `rel` parameter in Magnific PopUp IFRAME module
* Minified assets
* Add plugin icon for WordPress 4.x plugin installer
* Update plugin banner

= 2.2.2 (2014-07-25) =
* Add: admin notices after upgrade to prevent errors and avare users to do ReCache and prevent mixed json_decode / base64_encode strings for cached feeds
* Change: moved ReCache part to Tools tab on settings page

= 2.2.1 (2014-07-13) =
* Fix: to prevent broken JSON feed, transient caching changed from plain serialized string to base64_encode
* Add: URL parameter `ytc_force_recache` to force recache, also included on Help tab in plugin settings

= 2.2.0 =
* Add: open thumbnails in lightbox and stay on site, instead opening YouTube page (Magnific Popup jQuery library)
* Add: make thumbnail responsive
* Add: play indicator for thumbnails
* Add: shortcode [youtube_channel]
* Add: tabbed settings page for default options for shortcodes
* Add: Help tab for shortcode parameters
* Change: moved parts of code to helper functions

= 2.1.0.2 =
* Fix: remove embed object below old IFRAME implementation

= 2.1.0.1 =
* Change: add back old iframe functionality, second iframe option is async loading

= 2.1.0 =
* Change: iframe/HTML5 player inject with IFrame Player API https://developers.google.com/youtube/player_parameters#IFrame_Player_API
* Change: use native WP remote file download function wp_remote_get to fetch feeds (prevent some permission errors on some hosts)
* Change: removed height parameter so height is calculated by aspect ratio selection - 16:9 as default
* Add: mute audio on autoplay if iframe/HTML5 is selected
* Add: converter that will port pre-2.0.0 YTC widgets to 2.0.0+ version
* Fix: playlist parser (now allowed dash and underscore in playlist ID)

= 2.0.0 =
* Fix: undefined vars notices
* Fix: embedding default plugin playlist instead custom set for "Embed standard playlist"
* Add: caching system
* Add: option to link to channel instead to user
* Add: support for enhanced privacy by YouTube
* Enhance: RSS feed replaced with JSON
* Enhance: better formatted debug info with site URL
* Enhance: re-group widget options
* Enhance: updated wording
* Enhance: added tooltips for options
* Enhance: playlist ID detection from URL
* Remove: modified error_reporting

= 1.5.1 =
* Fix issue in widget settings when no apache_get_version() support on server
* Fix validation errors for widget settings
* Fix broken sidebar issue introduced in 1.5.0 release

= 1.5.0 =
* Add inline debug tracker
* Fix deprecated functions - changed rss.php by feed.php and split() by extract()
* Fix video description parser for new YouTube feed format
* Fix autoplay for single video bug
* Fix autoplay for multiple videos to play only first video
* Code cleanup
* Update compatibility to WordPress 3.5.1

= 1.4.0 =
* Added option to show preferred quantity of videos
* Added option to embed classic playlist
* Added class to video container: universal .ytc_video_container and selective (.ytc_video_first, .ytc_video_mid, .ytc_video_last)
* Added class to video title .ytc_title
* Added class to video description text .ytc_description
* Added class to container for link to channel .ytc_link
* Added routine to unique random video from channel if displayed more than one video
* Added option to set `et cetera` string for shortened video description
* Changed option for random video to use channel or playlist
* Fields for width and height converted to number with spinner
* Improved playlist ID handler

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

Responsive, bug fixes, support for WordPress 4.1

== Screenshots ==

1. YouTube Channel plugin default settings
2. YouTube Channel customized widget settings
3. YouTube Channel in WP Customizer
4. YouTube Channel preview
