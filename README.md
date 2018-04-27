# Aldine 

[![Packagist](https://img.shields.io/packagist/l/pressbooks/pressbooks-aldine.svg)](https://packagist.org/packages/pressbooks/pressbooks-aldine)
[![Current Release](https://img.shields.io/github/release/pressbooks/pressbooks-aldine.svg)](https://github.com/pressbooks/pressbooks/releases/latest/)
[![Packagist](https://img.shields.io/packagist/v/pressbooks/pressbooks-aldine.svg)](https://packagist.org/packages/pressbooks/pressbooks-aldine)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/pressbooks/pressbooks-aldine.svg)](https://packagist.org/packages/pressbooks/pressbooks-aldine)

[![Build Status](https://travis-ci.org/pressbooks/pressbooks-aldine.svg?branch=dev)](https://travis-ci.org/pressbooks/pressbooks-aldine)
[![Translate Aldine](https://img.shields.io/badge/dynamic/json.svg?label=translated&url=https%3A%2F%2Ftenpercent.now.sh%2F%3Forganization%3Dpressbooks%26project%3Daldine&query=%24.status&colorB=e05d44&suffix=%25)](https://www.transifex.com/pressbooks/aldine/translate/)

[![Packagist](https://img.shields.io/packagist/dt/pressbooks/pressbooks-aldine.svg)](https://packagist.org/packages/pressbooks/pressbooks-aldine)
[![Slack](https://pressbooks-slack.now.sh/badge.svg)](https://pressbooks-slack.now.sh)
[![Open Collective](https://opencollective.com/pressbooks/tiers/backer/badge.svg?label=backers&color=brightgreen)](https://opencollective.com/pressbooks/)
[![Open Collective](https://opencollective.com/pressbooks/tiers/sponsor/badge.svg?label=sponsors&color=brightgreen)](https://opencollective.com/pressbooks/)
**Tags:** publishing, catalog, pressbooks, default-theme  

**Requires at least:** 4.9.4  
**Tested up to:** 4.9.4  
**Stable tag:** 1.2.1  
**License:** GNU General Public License v3 or later  
**License URI:** LICENSE  

Aldine is the default theme for the home page of Pressbooks networks. It is named for the Aldine Press, founded by Aldus Manutius in 1494, who is regarded by many as the world’s first publisher.


## Description 

Aldine is the default theme for the home page of [Pressbooks](https://pressbooks.org) networks. It is named for the Aldine Press, founded by Aldus Manutius in 1494, who is regarded by many as the world’s first publisher. Aldine is based on [Underscores](https://underscores.me/).


## Installation 

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload Theme and Choose File, then select the theme's [.zip file](https://github.com/pressbooks/pressbooks-aldine/releases/latest/). Click Install Now.
3. Click Activate to use your new theme right away.


## Frequently Asked Questions 

TK.


## Changelog 


# 1.2.1 

**Patches**

- Fix an issue where inserting a Call to Action via the toolbar used the wrong shortcode attribute for the link ([#118](https://github.com/pressbooks/pressbooks-aldine/issues/118)): [#119](https://github.com/pressbooks/pressbooks-aldine/pull/119)


# 1.2.0 

**Minor Changes**

- Allow the contact form email to be edited in the Customizer ([#109](https://github.com/pressbooks/pressbooks-aldine/issues/109)): [#113](https://github.com/pressbooks/pressbooks-aldine/issues/113)
- Adjust the title size to better support longer network titles ([#114](https://github.com/pressbooks/pressbooks-aldine/issues/114)): [874030e](https://github.com/pressbooks/pressbooks-aldine/commit/874030e)

**Patches**

- Fix an issue where active and hover state colours could not be customized ([#111](https://github.com/pressbooks/pressbooks-aldine/issues/111)): [cb604c7](https://github.com/pressbooks/pressbooks-aldine/commit/cb604c7)
- Fix some layout issues on the registration screen ([#112](https://github.com/pressbooks/pressbooks-aldine/issues/112)): [#115](https://github.com/pressbooks/pressbooks-aldine/issues/115)
- Fix some layout issues on the activation screen ([#116](https://github.com/pressbooks/pressbooks-aldine/issues/116)): [#117](https://github.com/pressbooks/pressbooks-aldine/issues/117)


# 1.1.0 

**Minor Changes**

- Add editor buttons to insert shortcodes for page sections and calls to action: [#108](https://github.com/pressbooks/pressbooks-aldine/pull/108/)

**Patches**

- Hide archived, spammed and deleted books from catalog (props [@colomet](https://github.com/colomet) for reporting): [#107](https://github.com/pressbooks/pressbooks-aldine/pull/107/)


# 1.0.1 

#### Patches

- Load header image from `dist` ([#104](https://github.com/pressbooks/pressbooks-aldine/issues/104), props [@steven1350](https://github.com/steven1350) for reporting): [826dc93](https://github.com/pressbooks/pressbooks-aldine/commit/826dc930869041df0ffdd15748f686013fbed54e)
- Prevent page header from overlapping menu in some situations ([#103](https://github.com/pressbooks/pressbooks-aldine/issues/103), props [@beckej13820](https://github.com/beckej13820) for reporting): [df793ac](https://github.com/pressbooks/pressbooks-aldine/commit/df793acda9a4ccd4975056e150862e73f9e8379f)
- Improve display of pages without content ([#102](https://github.com/pressbooks/pressbooks-aldine/issues/102)): [0866e9a](https://github.com/pressbooks/pressbooks-aldine/commit/0866e9afe80f82b7d79dfd5a4d17095ee0bf716b)
- Update activation routine to use shortcodes: [1409a01](https://github.com/pressbooks/pressbooks-aldine/commit/1409a01b7759b6b4117316763957d498a5827692)
- Use a unique cookie name for the network homepage font size setting: [d109496](https://github.com/pressbooks/pressbooks-aldine/commit/d10949677ccc3fee67fbb9b1069c360b2270c779)


# 1.0.0 

#### Customisation & Branding

Aldine is the new default network theme for Pressbooks installations. Its creation was supported by [Ryerson University](https://ryerson.ca). Designed with customization in mind, it allows network managers to add institutional branding in the form of colours, logos and contact information, as well as custom content in blocks on the front page.

#### Standalone Catalog

In addition, Aldine introduces a standalone catalog page that is sortable and filterable by subject or license. Adding books to the catalog is controlled in the [same way as before](https://eduguide.pressbooks.com/chapter/catalogs/).

#### Additional Pages

You can now more easily add additional pages to the network root, such as an “About Us” or “Help” page.


## Credits 

* Based on [Underscores](https://underscores.me/), (C) 2012-2017 Automattic, Inc., [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html)
