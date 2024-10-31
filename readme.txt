=== Pan Macmillan Book Extracts ===
Contributors: danbrown180
Tags: books, reading, look inside, previews, extracts
Requires at least: 3.0.1
Tested up to: 4.4.2
Stable tag: 4.4.2
License: MIT
License URI: http://mit-license.org/

The Pan Macmillan Book Extracts Plugin allows you to show the first chapter of a book published by Pan Macmillan in a number of ways on your blog.

== Description ==

This plugin creates a shortcode for displaying extracts directly from the Pan Macmillan extracts API (extracts.panmacmillan.com).
You can use this to show the selected extract (usually the first chapter) of a book you are blogging about within your post.
This works with any book published by Pan Macmillan UK or by one of the subsidiary imprints (Bluebird, Tor, Mantle, Picador).


== Installation ==

Install the plugin by uploading the .zip file or using the Wordpress Plugin Manager.

Example Extract link shortcodes:

Plain Extract 

[extract title="Mightier Than The Sword" author="Jeffrey Archer"]

Extract In Reader Pane

[extract title="Mightier Than The Sword" author="Jeffrey Archer" viewer = true]

Jacket Image With Lightbox Extract

[extract title="Mightier Than The Sword" author="Jeffrey Archer" lightbox=true images=true]

Text Link with Lightbox Extract

[extract title="Mightier Than The Sword" author="Jeffrey Archer" lightbox=true linktext="Click here to read an extract"]

List of Books By Author With Link

[extract author="Jeffrey Archer"]

List of Books By Author With Lightbox Extract

[extract author="Jeffrey Archer" lightbox = true]

List of Books by Author With Jackets and Link

[extract author="Jeffrey Archer" images=true]

List of Books By Author With Jackets and Lightbox Extract

[extract author="Jeffrey Archer" images=true lightbox=true]


== Changelog ==
= 1.03 =
* Added ability to use a text link to open a lightbox with the extract
* Updated the jacket image with lightbox option to require images=true

= 1.02 =
* Fix for changed image URL

= 1.01 =
* Added pagination support

= 1.0 =
* Initial Release