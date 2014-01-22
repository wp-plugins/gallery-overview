=== Gallery Overview ===
Contributors: antwortzeit
Donate link: http://www.antwortzeit.de/buyusapint/
Tags: gallery, core, overview, album, foto, fotoalbum, image, photo, photoalbum, photogallery, pictures
Requires at least: 3.7
Tested up to: 3.9
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin fixes the one thing that is really wrong with WordPress' Core Gallery: You don't have an Gallery Overview Page.

== Description ==

WordPress' own Gallery is pretty good. You can upload images, order them around and generate galleries in a very short amount of time. So that's a big advance compared to all those mighty powerful plugins out there, because sometimes they are kind of hard to use. But they bring a gallery overview with them, one page that lists all your galleries and gives your users access to them. Which WordPress doesn't. 

Gallery Overview is here to fix this. Basically it crawls all your galleries and lists them with previews containing 3 images. You can attach Gallery Overview to a page via the options panel or you can use our shortcode for more sophisticated use cases.

On the settings panel you can configure the following options:

*	Add to page
*	List all Galleries (Not only from Child Pages)
*	Thumbnail Size
*	Image Number
*	Column Count
*	Link to Gallery (heading, gallery, both, none)

If these settings shouldn't be enough for you, you can use the [gallery_overview] shortcode, which comes with the following parameters:

*	*all_galleries*: List all Galleries (not only from Child Pages). Doesn't accept any Parameters.
*	*pages*: Include only Galleries from Pages listed comma-separated by ID. Parameters needed like `pages="30,42"`
*	*limit*: Limit the number of images shown. Parameter needed as integer like `limit=5`
*	*columns*: Set the number of columns. Parameter needed as integer like `columns=2`
*	*size*: Chooses an existing thumbnail size. Parameter needed as string like `size="medium"`
*	*header*: Disables the header, if you want to. Remember to put a link on the gallery. Parameter needed is `header=false`
*	*before*: Simple HTML-Output before any other Gallery-Code. Parameter needed is `before="<ul>"`.
*	*after*: Simple HTML-Output after any other Gallery-Code. Parameter needed is `after="</ul>"`.
*	*layout*: Well, now it's getting kind of tricky. With this attribute you can change the appearance of each gallery. There are 4 variables available: "%linkopen%", "%linkclose%", "%heading%" and "%gallery%". You can pass any HTML you'd like. Example: `layout="%linkopen%<h3>%heading%</h3>%linkclose%"` will print you just the heading, wrapped in a link.
*	*link*: Let's you choose, what will be wrapped in the link. Available Options are "heading", "gallery" and "both". To be used like `link="heading"`.

== Installation ==

1. Upload Plugin-Folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the Options or use the shortcode [gallery_overview]

== Frequently Asked Questions ==

= The galleries don't work, don't show up, can't be linked =

We use WordPress' own gallery shortcode. Chances are, one of your plugins or your theme hooks into the filters provided by this shortcode and changes the content. Bad behaviour that is. Go contact your theme or plugin authors or change it yourself. We can't do anything against it.

= Can i place Gallery Overview in a post or custom post type? =

Well, not via the Settings. But you could use the shortcode [gallery_overview] instead. Take a look at the description to see how it is used.

= I completely want to change the layout. How'd i do this? =

Because Gallery Overview uses the [gallery] shortcode, you can hook into the filters provided by it and change the content. Remember what we said about this in the first question? Never mind, if you don't break our plugin, you're good.

== Screenshots ==

1. How Gallery Overview looks in Twenty Eleven
2. Gallery Overviews' Backend Options

== Changelog ==

= 0.1 =
* Initial release

== Upgrade Notice ==

= 0.1 =
Well you can't upgrade from 0.0, can you?