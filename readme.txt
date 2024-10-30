=== Commenter Ignore Button ===
Contributors: CK MacLeod
Tags: comments,commenters,ignore commenter,trolls,community,CK MacLeod
Donate link: http://ckmacleod.com/wordpress-plugins/#donate
Requires at least: 3.1
Tested up to: 4.7.1
Stable tag: trunk
License: GPL3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Empower your users with a convenient tool to conceal comments by trolls and other annoying commenters.

== Description ==

Commenter Ignore Button (CIB) lets a user put one or more commenters "on ignore." To have such an option enabled is a frequent request at blogs and other sites where comment threads are plagued by trolls or other problematic commenters, but where site operators prefer to err on the side of open discussion - or don't want to get involved unless they really have to. Once users become generally aware of the option, people just seeking attention may either be more polite or move somewhere else, while regular commenters - and lurkers - may become more willing to engage. 

https://www.youtube.com/watch?v=FE7jWG0w50s

As depicted in the above video, the plug-in will add a (customizable) button to all comments (*in suitable WordPress installations* - see note below). Clicking it will cause all comment content by the selected commenter to disappear. The effect is applied instantly, and also can be immediately reversed and toggled back again. For the overwhelming majority of users - those who have cookies enabled and who return using the same browser - the "on ignore" designation will persist across multiple sessions. 

Customization options include a choice of any of four automatic button positions, and also of placement via template files or theme function. The default styling is meant to be non-obtrusive, but site operators can add CSS from the settings page to adjust button appearance and effects. Filter hooks have also been provided to help advanced users customize output further. 

CIB also comes with a template tag that can provide a list of whomever a user has on ignore. For visitors who do not have anyone on ignore - presumably the majority at most sites - the tag can be configured as a convenient location for summarizing and linking to your site's commenting policy.

https://www.youtube.com/watch?v=6gQgZcPMjQY

Additional usage tips and references can be found via [the CIB home page](http://ckmacleod.com/wordpress-plugins). 

CIB is also translation-ready.

###Note that CIB is designed for standards-compliant WordPress comment threads. ###

*CIB has been written to work "out of the box" with standard WordPress comments and several common variations. In testing, the default setting worked as intended, in a a few cases after minimal adjustments without custom CSS or PHP, with 96 out of 100 "Popular," "Featured," and custom WordPress themes. CIB is **not** suitable for 3rd Party commenting systems like Disqus or Facebook Comments, however.* 

More generally, though CIB can also be adapted to modified commenting templates, the further that your theme and commenting plug-ins diverge from typical, up-to-date WordPress, the more adjustments you may have to make. 

###...also###

*This is a brand-new plugin, so... please be kind!*

All feedback is welcome. If you have a problem, please ask a question in the support forum before using up your one and only chance to rate this work. 

If you like this plugin, please leave a review to encourage development and to help create, site by site, a more thoughtful internet!

== Installation ==

1. Install and activate the plugin
1. View a comment thread and click the little gray x that (in the vast majority of cases) will show up next to each comment author's name. They'll be put "on ignore" (they won't know!). Click the green x that replaced the gray one to un-ignore them.
1. If the x's don't show up, or if you're not happy with the results, or you just want to try some alternatives out, the settings pages offer a range of further options.
1. Alert your commenters to the new tool or (or virtual weapon) at their disposal.

== Frequently Asked Questions ==

*Installed it - but it's not working as expected - so what do I do?*

You might have problems with another plugin that takes over and significantly changes the standard comment template, or that minifies or concatenates javascript (jQuery) and CSS files ineffectively. Try turning off plug-ins, starting with the best candidate for conflict, and seeing whether doing so fixes things. Let me know what you find out! 

*Well, it's kind of working, but the changes commenters make aren't being carried over on the next refresh - why not?*

CIB was tested with major page-caching plug-ins, including the two by far most popular ones (WP Super Cache and W3 Total Cache). Assuming your users have cookies enabled and are using the same browser, "on ignore" effects should both remain visible on page refresh and persistently. If it's not working that way, let me know! (For more, see ["Is This Solution for Caches vs Cookies Going to Get Me in Trouble?"](http://ckmacleod.com/2016/11/30/solution-caches-vs-cookies-going-get-trouble/) )

*I've added the "On Ignore" list to my comments.php template, but it's not showing up - so?*

It won't show up at all if you don't have anyone on ignore. The "Commenting Guidelines" header won't show up unless you tick the box in settings. Otherwise, be sure that the template you're editing is the one your theme is actually using: Some plug-ins, and not just major 3rd Party commenting systems like Disqus and Facebook Comments, will hijack your comments template and substitute their own, without making it clear that they're doing so. To identify the source of the problem, first try disconnecting any plug-ins that affect comment threads, then try turning them all off except for Commenter Ignore Button, or try switching themes. 

*I've tried all of the options, including the "Add CSS" alternative, and I still can't get it right with my theme - can you code it for me?*

I can take a look at whatever problem you're having, and, further, especially while the plug-in is new, I'm interested in accumulating documentable "use cases" and fixes, but I can't promise to do extensive styling and custom-coding for you without compensation. 

*How about extending CIB to "recent comments" widgets and other commenting widgets and things?*

Could be done, but only if you want to try some custom coding. Otherwise, you'll have to wait for release of the developer's ["Commentariat Suite"](http://ckmacleod.com/wordpress-plugins/), with which CIB will be integrated.

*How do you have all of these FAQs if this is the first version of the plug-in?*

From time to time while working on this thing, I've found myself perplexed, or aware of more that I could do, so frequently ask certain questions of myself or of the developer community...

== Screenshots ==

1. Default Button Added to Comment Thread
2. Default Button After Use
3. Reply Button Style
4. An Alternative (Text-Button) Style
5. Settings Page Main Top
6. Settings Page Main Middle
7. Settings Page ADD CSS Top
8. Settings Page ADD CSS Middle

== Upgrade Notice ==

= 1.0 =
* First Version of the Plug-In

== Changelog ==

= 1.0 =
* First Version in WordPress Repo

== Additional Info ==

= Still to Come =

1. Registered User Functions/Privileges
1. Integration with Commenter Highlight and Commenter Archives (both forthcoming)
1. Simultaneously report offensive or abusive comments.
1. Integration with a full ["Commentariat Suite"](http://ckmacleod.com/wordpress-plugins/) of WordPress plugins. 

= Thanks! =

...to all of the developers and everyday code-hackers, far too numerous to name, upon whose work I have depended. Special thanks to [Vikram Bath](http://ordinary-gentlemen.com/author/vikrambath/), who provided invaluable feedback during the development process. 

