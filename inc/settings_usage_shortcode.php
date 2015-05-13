<h3>How to use shortcode</h3>
<p>You can use shortcode <code>[youtube_channel]</code> with options listed below (all options are optional):</p>

<h4>General Settings</h4>
<ul>
    <li><code>channel</code> <em>(string)</em> ID of preferred YouTube channel. Do not set full URL to channel, but just last part from URL - ID (name)</li>
    <li><code>vanity</code> <em>(string)</em> Vanity name.</li>
    <li><code>username</code> <em>(string)</em> Legacy YouTube username.</li>
    <li><code>playlist</code> <em>(string)</em> ID of preferred YouTube playlist.</li>
    <li><code>resource</code> <em>(int)</em> Resource to use for feed:
    <ul>
        <li>&bullet; <code>0</code> Channel</li>
        <li>&bullet; <code>1</code> Favorites (for defined channel)</li>
        <li>&bullet; <code>2</code> Playlist</li>
        <li>&bullet; <code>3</code> Liked Videos (for defined channel)</li>
    </ul></li>
    <li><code>only_pl</code> <em>(bool)</em> If you set to use Playlist as resource, you can embed youtube playlist block instead single video from playlist. Simply set this option to true (<code>1</code> or <code>true</code>)</li>
    <li><code>cache</code> <em>(int)</em> Period in seconds for caching feed. You can disable caching by setting this option to <code>0</code>, but if you have a lot of visits, consider at least short caching (couple minutes).</li>

    <li><code>fetch</code> <em>(int)</em> Number of videos that will be used as stack for random pick (min 2, max 50)</li>
    <li><code>num</code> <em>(int)</em> Number of videos to display per YTC block.</li>

    <li><code>random</code> <em>(bool)</em> Option to randomize videos on every page load.</li>
</ul>
<h4>Video Settings</h4>
<ul>
    <li><code>ratio</code> <em>(int)</em> Set preferred aspect ratio for thumbnail and video. You can use:
    <ul>
        <li>&bullet; <code>3</code> 16:9 widescreen (default)</li>
        <li>&bullet; <code>1</code> 4:3</li>
    </ul></li>
    <li><code>width</code> <em>(int)</em> Width of thumbnail and video in pixels.</li>
    <li><code>responsive</code> <em>(bool)</em> Distribute one full width video per row.</li>
    <li><code>display</code> <em>(string)</em> Object that will be used to represent video. We have couple predefined options:
    <ul>
        <li>&bullet; <code>thumbnail</code> Thumbnail will be used and video will be loaded in lightbox.</li>
        <li>&bullet; <code>iframe</code> HTML5 (iframe)</li>
        <li>&bullet; <code>iframe2</code> HTML5 (iframe) with asynchronous loading - recommended</li>
    </ul></li>

    <li><code>no_thumb_title</code> <em>(bool)</em> By default YouTube thumbnail will have tooltip with info about video title and date of publishing. By setting this option to <code>1</code> or <code>true</code> you can hide tooltip</li>
    <li><code>themelight</code> <em>(bool)</em> By default YouTube have dark play controls theme. By setting this option to <code>1</code> or <code>true</code> you can get light theme in player (HTML5 and Flash)</li>
    <li><code>controls</code> <em>(bool)</em> Set this option to <code>1</code> or <code>true</code> to hide playback controls. To display controls set this option to <code>0</code> or <code>false</code>.</li>
    <li><code>fix_h</code> <em>(bool)</em> If you did not set to hide player controls, you can set this option to <code>1</code> or <code>true</code> to fix video height taken by controls</li>
    <li><code>autoplay</code> <em>(bool)</em> Enable autoplay of first video in YTC video stack by setting this option to <code>1</code> or <code>true</code></li>
    <li><code>mute</code> <em>(bool)</em> Set this option to <code>1</code> or <code>true</code> to mute videos set to autoplay on load</li>
    <li><code>norel</code> <em>(bool)</em> Set this option to <code>1</code> or <code>true</code> to hire related videos after finished playbak</li>
    <li><code>nobrand</code> <em>(bool)</em> Set this option to <code>1</code> or <code>true</code> to hire YouTube logo from playback control bar</li>
</ul>
<h4>Content Layout</h4>
<ul>
    <li><code>showtitle</code> <em>(bool)</em> Set to <code>1</code> or <code>true</code> to show video title.</li>
    <li><code>titlebelow</code> <em>(bool)</em> Set to <code>1</code> or <code>true</code> to move video title below video.</li>
    <li><code>showdesc</code> <em>(bool)</em> Set to <code>1</code> or <code>true</code> to show video description.</li>
    <li><code>desclen</code> <em>(int)</em> Set number of characters to cut down length of video description. Set to <code>0</code> to use full length description.</li>
    <li><code>noinfo</code> <em>(bool)</em> Set to <code>1</code> or <code>true</code> to hide overlay video infos (from embedded player)</li>
    <li><code>noanno</code> <em>(bool)</em> Set to <code>1</code> or <code>true</code> to hide overlay video annotations (from embedded player)</li>
</ul>
<h4>Link to Channel</h4>
<ul>
    <li><code>goto</code> <em>(bool)</em> Set to <code>1</code> or <code>true</code> to display link to channel at the bottom of YTC block.</li>
    <li><code>goto_txt</code> <em>(string)</em></li>
    <li><code>popup</code> <em>(int)</em> Control where link to channel will be opened:
    <ul>
        <li>&bullet; <code>0</code> open link in same window</li>
        <li>&bullet; <code>1</code> open link in new window with JavaScript</li>
        <li>&bullet; <code>2</code> open link in new window with <code>target="_blank"</code> anchor attribute</li>
    </ul>
    </li>
    <li><code>link_to</code> <em>(int)</em> URL to link:
    <ul>
        <li>&bullet; <code>2</code> Vanity custom URL (default)</li>
        <li>&bullet; <code>1</code> Channel page</li>
        <li>&bullet; <code>0</code> Legacy username page</li>
    </ul>
    </li>
</ul>

<p>Please note, you can exclude all options listed above, and then we'll use default options from Settings page.</p>
<p>YTC blocks inserted through widget have own settings.</p>