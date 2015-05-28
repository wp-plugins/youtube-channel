=== YouTube Channel ===
Contributors: urkekg
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Q6Q762MQ97XJ6
Tags: youtube, channel, playlist, single, widget, widgets, youtube player, feed, video, thumbnail, embed, sidebar, iframe, html5, responsive
Requires at least: 3.9.0
Tested up to: 4.2.2
Stable tag: 3.0.7.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Show video thumbnails or playable blocks of recent videos from YouTube Channel or Playlist.

== Description ==

When you need to display sidebar widget with latest video from some YouTube channel or playlist, you can use customisable `YouTube Channel` plugin.

Simply insert widget to sidebar, set channel name and if you wish leave all other options on default. You will get latest video from chosen YouTube channel embedded in sidebar widget, with link to channel on the bottom of the widget. If you wish to use playlist instead of channel, just set playlist ID and injoy!

If you like this extension and you find it useful, please rate it on the right side.

= Features =
* Display latest videos from YouTube Channel (resources are sorted in reverse chronological order based on the date they were created) or videos naturaly sorted from Favorited Videos, Liked Videos and Playlist
* Option to get random video from any of 4 resources
* Responsive (one full width video per row) or non responsive
* Preferred aspect ratio relative to width (16:9 and 4:3)
* Custom width for video embeded object (default is 306px)
* Enhanced Privacy
* Choose to display video as thumbnail (default), HTML5 (iframe) or HTML5 Asynchronous (iframe2)
* Thumbnail mode opens video in lightbox
* Custom caching timeout
* Optimized data feeds
* Optional video autoplay with optional muted audio
* Show customized link to channel below videos

= Notice =

For fully functional plugin you need to have PHP 5.3 or newer! If you experience issues on older PHP, we can't help you as we don't have access to such old development platform.

= Styling =

You can use `style.css` from theme to style `YouTube Video` widget content.

* `.widget_youtube-channel` – class of whole widget (parent for widget title and YTC block)
* `.youtube_channel` – YTC block wrapper class. Additional classes are available:
  * `.default` – for non-responsive block
  * `.responsive` – when you have enabled responsive option
* `.ytc_title` – class of H3 tag for video title above thumbnail/video object
* `.ytc_video_container` – class of container for single item, plus:
  * `.ytc_video_1`, `.ytc_video_2`, … – class of container for single item with ordering number of item in widget
  * `.ytc_video_first` – class of first container for single item
  * `.ytc_video_mid` – class of all other containers for single item
  * `.ytc_video_last` – class of last container for single item
  * `.ar16_9` – class for Aspect Ratio 16:9
  * `.ar4_3` – class for Aspect Ration 4:3
* `.ytc_thumb` – class of anchor for Thumbnail mode
* `.fluid-width-video-wrapper` – class for parent element of IFRAME for enabled responsive
* `.ytc_description` – class for video description text below thumbnail/video object
* `.ytc_link` – class of container for link to channel

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

* `showtitle` (bool) Set to 1 or true to show video title.
* `titlebelow` (bool) Set to 1 or true to move video title below video.
* `showdesc` (bool) Set to 1 or true to show video description.
* `desclen` (int) Set number of characters to cut down length of video description. Set to 0 to use full length description.
* `noinfo` (bool) Set to 1 or true to hide overlay video infos (from embedded player)
* `noanno` (bool) Set to 1 or true to hide overlay video annotations (from embedded player)

**Link to Channel**

* `goto` (bool) Set to 1 or true to display link to channel at the bottom of YTC block.
* `goto_txt` (string)
* `popup` (int) Control where link to channel will be opened:
  * `0` open link in same window
  * `1` open link in new window with JavaScript
  * `2` open link in new window with target="_blank" anchor attribute
* `link_to` (int) URL to link:
  * `2` Vanity custom URL (default)
  * `1` Channel page
  * `0` Legacy username page

== Installation ==

You can use the built in installer and upgrader, or you can install the plugin manually.

1. You can either use the automatic plugin installer or your FTP program to upload unziped `youtube-channel` directory to your `wp-content/plugins` directory.
1. Activate the plugin through the `Plugins` menu in WordPress
1. Add YouTube Channel widget to sidebar
1. Set Channel ID and save changes

If you have to upgrade manually simply repeat the installation steps and re-enable the plugin.

= YouTube Data API Key =
Main difference since v2.x branch is that now we use [YouTube Data API v3](https://developers.google.com/youtube/v3/) so to make plugin to work, you'll need to generate YouTube Data API Key and insert it to General plugin settings.

Learn more about [Obtaining authorization credentials](https://developers.google.com/youtube/registering_an_application) and for detailed instructions how to generate your own API Key watch video below.

[youtube http://www.youtube.com/watch?v=8NlXV77QO8U]

1. Visit [Google Developers Console](https://console.developers.google.com/project)
1. If you don't have any project, create new one. Name it so you can recognize it (for example **My WordPress Website**).
1. Select your new project and from LHS sidebar expand group **APIs & auth**, then select item **APIs**
1. Locate and click **YouTube Data API** under **YouTube API** section
1. Click **Enable API** button
1. When you get enabled YouTube Data API in your project, click **Credentials** item from LHS menu **APIs & auth**
1. Click **Create New Key** button and select **Server Key**
1. Leave empty or enter IP of your website. If you get message **Oops, something went wrong.** make sure you set proper IP, or leave any restriction.
1. Click **Create** button
1. Copy newly created **API Key**

When you generate your own YouTube Data API Key, from your **Dashboard** go to **Settings** -> **YouTube Channel** -> **General** and paster key in to field **YouTube Data API Key**.

Also, do not forget to check and update **Channel ID** in plugin's General settings, Widgets and/or shortcodes.
You can get **Channel ID** from page [Account Advanced](https://www.youtube.com/account_advanced) while you're loagged in to your YouTube account.

== Frequently Asked Questions ==

= How to get that YouTube Data API Key? =

Please folllow [Installation](https://wordpress.org/plugins/youtube-channel/installation/) instructions.

= I set everything correct but receiveing 'Oops, something went wrong' message =

Right click that message on your website, click *Inspect Element*, expand tag with class *youtube_channel* and look for HTML comment below it, message will look like this:

`<!-- YTC ERROR:
Please check did you set proper Channel ID. You set to show videos from channel, but YouTube does not recognize MyCoolLegacyName as existing and public channel.
-->`

Do exactly what message says - check and correct Channel ID in default settings/widget/shortcode.

`<!-- YTC ERROR:
Check YouTube Data API Key restrictions, empty cache if enabled by appending in browser address bar parameter ?ytc_force_recache=1
-->`

1. Try to remove restrictions by referer or IP in your **YouTube Data API Key** and refresh page after couple minutes.
1. If that does not help, please try to create new API Key for Server w/o restrictions (not to regenerate existing one).

If there is no `YTC ERROR` code in HTML source, visit [Google API Explorer](https://developers.google.com/apis-explorer/#p/youtube/v3/youtube.playlistItems.list?part=snippet&maxResults=5&playlistId=) and append:

* for videos from channel replace **UC** with **UU** in Channel ID (so *UCRPqmcpGcJ_gFtTmN_a4aVA* becomes *UURPqmcpGcJ_gFtTmN_a4aVA*)
* for videos from Favourited videos replace **UC** with **FL** (so *UCRPqmcpGcJ_gFtTmN_a4aVA* becomes *FLRPqmcpGcJ_gFtTmN_a4aVA*)
* for videos from Liked Videos replace **UC** with **LL** (so *UCRPqmcpGcJ_gFtTmN_a4aVA* becomes *LLRPqmcpGcJ_gFtTmN_a4aVA*)
* for videos from Playlist simply use Playlist ID (like *PLEC850BE962234400*)

Note that all four resources are *playlists* (including channel), so append mentioned ID to field **playlistId** (not to **id**), and click **Execute** button at the bottom of that page.

1. If you receive some error, fix settings.
1. If there is no error but you do not get any video in results - contact Google Support.
1. If there are video results but not displayed with YouTube Channel plugin - [contact us](https://wordpress.org/support/plugin/youtube-channel)

= Where to find correct Channel ID and/or Vanity custom Name? =

Login to your YouTube account and visit page [Account Advanced](https://www.youtube.com/account_advanced).

You'll find your **Vanity Name** as "Your custom URL" in **Channel settins** section on that page. For YTC plugin use only part **after www.youtube.com/c/**, not full URL.

**Channel ID** is **YouTube Channel ID** value composed of mixed characters starting with **UC**.

= Where to find ID for Favourites and/or Liked Videos? =

You will not need that two ID's, in general. But, if you really wish to know, these two ID's are produced from your **Channel ID**. Channel ID start with **UC** (like `UCRPqmcpGcJ_gFtTmN_a4aVA`)

* For Favourites ID replace **UC** with **FL** (so you get `FLRPqmcpGcJ_gFtTmN_a4aVA`)
* For Liked Videos ID replace **UC** with **LL** (so you get `LLRPqmcpGcJ_gFtTmN_a4aVA`)

= What is Vanity custom URL? =

Check out [Channel custom URL](https://support.google.com/youtube/answer/2657968?ref_topic=3024172&hl=en-GB) article.

= Where to find Playlist ID? =

Playlist ID can be manualy extracted from YouTube playlist URL. Part of strings after `&list=` that begins with uppercase letters **PL** represent Playlist ID (not full URL).

= How to force embeding 320p video with better audio quality? =

YouTube provide 320p videos if height of embeded video is set to 320 or more. If you use small YTC video size, 240p will be loaded instead. So, you could not force 720p in tiny YTC.

= I enabled option `Hide YT Logo` but YouTube logo is still visible =

Modestbranding option does not work for all videos, so a lot of videos will still have YouTube logo in control bar. I recommend to enable option `Hide player controls` instead.

Also, even when hidding logo works for your video, on hover or when video is paused in upper right corner will be displayed YouTube link/logo. [Read more here](https://developers.google.com/youtube/player_parameters#modestbranding)

= How I can achieve 'wall' layout with one featured thumbnail? =

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

= Your plugin does not support *THIS* or *THAT* =

If you really need that missing feature ASAP, feel free to [contact me](urosevic.net/wordpress/contact/). Select *Subject* option "Quote For New Feature in YouTube Channel", provide detailed explanation of feature you need, also provide some example if there is such, and I'll send you price for implementation.

If you don't wish to pay for enhancements (then you don't care would that be implemented in a week, month, year or so), then send new [Support topic](https://wordpress.org/support/plugin/youtube-channel) with *Topic title* in format **[Feature Request] ...**

== Changelog ==

= 3.0.7.3 (2015-05-29) =
* Add: TinyMCE button to easy configure and insert shortcode to post/page content
* Add: Report about zero videos in resource
* Add: Helper method to generate resource nice name (DRY)

= 3.0.7.2 (2015-05-24) =
* Add: Error report if we have broken feed on record
* Add: Report about failed HTTP connections and other problems ocurred when we try to fetch feed
* Add: DRY of visible errors for Administrator and visitors (Oops message)

= 3.0.7.1 (2015-05-17/18) =
* Fix: Plugin version number not updated in DB
* Fix: Magnific Popup appear under header on Twenty Eleven theme
* Fix: .clearfix break layout if used as class on content division

= 3.0.7 (2015-05-17) =
* Fix: Uncaught TypeError: e(...).fitVids is not a function
* Change: Remove plugin default Channel ID, Vanity custom name, Legacy username and Playlist ID; leave them empty by default and allow them to be empty parameters; throw error if required value not provided. All this to prevent questions like *Why I see your videos on my website* or *Why my website link to your channel*
* Cleanup: Deprecated widget toggler for Playlist Only depending on selected Resource
* Cleanup: Deprecated 16:10 styles
* Optimize: Minimize admin style for widget layout

= 3.0.6.2 (2015-05-15) =
* Fix: Fatal error: Cannot unset string offsets in update.php on line 229 (introduced in 3.0.6.1)
* Add: Helpfull links to plugin settings page

= 3.0.6.1 (2015-05-14) =
* Fix: Undefined index: random
* Fix: Unremoved only_pl from global settings
* Add: Box sizing of .youtube_channel element for crappy themes

= 3.0.6 (2015-05-13/14) =

* Fix: Prevent Fatal error on PHP<5.3 because required __DIR__ for updater replaced with dirname(__FILE__)
* Fix: No retrieved or missing videos from some channels so switch `search` to `playlistItems` API call (kudos to @[mmirus](https://wordpress.org/support/profile/mmirus))
* Add: Embed As Playlist for all resources
* Add: Clearfix for crappy themes where clearfix does not exists
* Add: Option to move video title below video (boolean shortcode parameter `titlebelow`)
* Add: PayPal donate button to settings page
* Improved: Move YouTube Data API Key to plugin settings and add notification to remove YOUTUBE_DATA_API_KEY from wp-config.php (optional)
* Improved: Updated shortcode explanation in README and Help tab in plugin settings.
* Improved: Better tips for 'Oops, something went wrong' message.
* Change: Wording `Ups` to `Oops`
* Remove: Options `Embed standard playlist` and `Show random video` from global settings as this should be off by default
* Remove: Loading of fitVids JS library for test before final removing.

= 3.0.5 (2015-05-11/12) =

* Fix: Setting back dropdown options with `0` ID does not work on Settings page (Channel as resource to use, Cache timeout, Aspect ratio, What to show, Open link to, Link to)
* Add: Option to export global settings to JSON and add to Tools tab in settings button to download global settings JSON
* Change: Update plugin features
* Improved: Retrieve only fields which will be used for output w/o unused items to reduce
* Improved: More micro optimizations

= 3.0.4 (2015-05-11) =

* Add: Tip what to do if error ocurred with YouTube Data API Key printed inside YTC ERROR comment
* Change: Where to ask for support links in widget
* Change: Timeout for getting feed increased from 2 to 5 seconds
* Change: Update FAQ sections in readme file
* Remove: Check for Redux Framework in debug JSON generator

= 3.0.3 (2015-05-10) =

* Fix: "Oops, something went wrong." when Playlist selected as resource because wrong switch
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

**OLD RELEASES**

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

1. YouTube Channel default plugin settings (General tab)
2. YouTube Channel customized widget settings
3. YouTube Channel in WP Customizer and Dynamic Wall layout
4. How to add YouTube Data API Key to YouTube Channel
