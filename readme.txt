=== Radar Shortcodes ===
Contributors: radarthemes 
Plugin Name: Radar Shortcodes
Plugin URI: https://radarthemes.com
Tags: radar, shortcodes, tabs, accordions, buttons, blocks, syntax highlighting
Author URI: https://radarthemes.com
Requires at least: 3.0
Tested up to: 5.1.1
Requires PHP: 5.2.4
Stable tag: 2.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows you to use all Radar Themes shortcodes on any WordPress theme.

== Description ==

Radar shortcodes is a lightweight shortcode plugin for WordPress. This plugin was created to provide sites with minimal reusable shortcode elements. The shortcodes provided in this plugin works with all of Radar Themes and third-party WordPress themes. 

<a href="https://preview.radarthemes.com/trooper/shortcodes/">Working Demo</a> | <a href="https://docs.radarthemes.com/radar-shortcodes">Shortcode documentation</a>

Include Shortcodes:

* Tabs
* Accordion
* Text Highlighting
* Syntax Highlighting
* Buttons

== Features ==

* Gutenberg-compatiable
* Works with any WordPress Theme
* Minimal Design
* Developer-Friendly

== Installation ==

1. Upload `portfolios` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

= The Shortcodes =

`Tabs`

```
[tabs]
    [tab title="Tab 1"]
        I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
    [/tab]
    
    [tab title="Tab 2"]
        This is tab 2 textarea
    [/tab]
    
    [tab title="Tab 3"]
        This is tab 3 textarea
    [/tab]
[/tabs]
```

Accordion(s)

```
[accordions]
    [accordion title="accordion 1"]
        some text...
    [/accordion]
    
    [accordion title="accordion 2"]
        some text...
    [/accordion]
    
    [accordion title="accordion 3"]
        some text...
    [/accordion]
[/accordions]
```

Text Highlighting

Choose between blue, orange, green, purple, pink, red, grey, light, black, yellow and blue

```
[highlight color="blue"] Blue Highlight [/highlight]
```

Code Syntax Highlighting

[code language="ruby"]
    code goes here....
[/code]

Buttons

Normal buttons, colors are blue, black ,purple, green, red, gray, fire ,orange and coffee.

`[button link="#" style="1" type="round" fa="twitter"] Follow Me[/button]`

== Frequently Asked Questions ==

= Will this plugin work if I'm not using a Radar theme? =

Yes this plugin should work with any theme and you should have no problem using the plugin upon installation.

= How can I change the styling of the elments?

You can override the css classes to add your own styling to different elements.

= Will this plugin slow down my WordPress website?

No this plugin was created to be lightweight and should have little to no performance impact on your site.


== Changelog ==

= 1.0 =
* Initial public release.
