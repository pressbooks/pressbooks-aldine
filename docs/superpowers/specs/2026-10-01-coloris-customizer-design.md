# Replace Aldine Customizer Color Pickers with Coloris

**Date:** 2026-10-01
**Issue:** [pressbooks/pressbooks-aldine#500](https://github.com/pressbooks/pressbooks-aldine/issues/500)
**Status:** Proposed

## Problem

The WordPress Customizer is used to customize colors in the Aldine network root theme. Its `WP_Customize_Color_Control` controls render the WordPress Iris color picker, which has known accessibility problems ([pressbooks/private#1705](https://github.com/pressbooks/private/issues/1705)). The pressbooks plugin already replaced its Iris pickers with [Coloris](https://github.com/melloware/coloris) in [pressbooks/pressbooks#4049](https://github.com/pressbooks/pressbooks/pull/4049); Aldine is the only first-party repository still using Iris.

## Findings

An inventory of `/web/app/plugins`, `/web/app/themes`, and mu-plugins found:

**Already on Coloris (pressbooks plugin, no action needed):**
- Theme Options: 12 color fields via `Pressbooks\Options::renderColorField()` (`inc/class-options.php:298-326`)
- Cover Generator: 6 color fields (`inc/admin/covergenerator/namespace.php:234-305, 592-598`)
- Catalog sidebar: 1 color field (`templates/admin/catalog.php:116`)
- Initializer: `assets/src/scripts/color-picker.js` (`el: '.coloris'` + a11y strings)

**Still on Iris (the target):**
- Aldine Customizer: 8 `WP_Customize_Color_Control` instances (`inc/customizer/namespace.php:114-189`); WordPress core auto-enqueues `wp-color-picker`/Iris for them
- Aldine WCAG contrast validator reads Iris DOM: `.color-picker-hex` (`lib/customizer-validate-wcag-color-contrast/customizer-validate-wcag-color-contrast.js:48`)
- pressbooks plugin `assets/src/scripts/a11y.js:29-71` patches Iris sliders/palettes with aria-labels; enqueued admin-wide (`inc/admin/laf/namespace.php:1230`) and again in the Customizer from Aldine (`inc/customizer/namespace.php:480-483`)

**No other first-party repository uses Iris.** Zero `wp-color-picker`, `wpColorPicker`, or `iris()` calls outside Aldine. No `theme.json` or editor color palette configuration exists.

**Third-party (out of scope):** `wp-quicklatex` (bundled jQuery ColorPicker), `tablepress` (bundled jSuites color UI), `enable-media-replace` (native `<input type="color">`), `h5p` (bundled CKEditor color UI).

## Scope

**In scope:**
- Replace the 8 Aldine Customizer controls with a Coloris-backed custom control
- Bundle and enqueue Coloris assets for the Customizer
- Adapt the WCAG contrast validator to the Coloris DOM
- Dead-code cleanup: Iris a11y patches in the pressbooks plugin, Aldine's duplicate `pb-a11y` Customizer enqueue, and the vestigial `PB_ColorPicker` global

**Out of scope:**
- The MathJax text-color hex field (`pressbooks/templates/admin/mathjax.blade.php:66-69`) — it is a plain text input, not a picker
- Third-party pickers listed above
- Gutenberg palettes / `theme.json`
- Extracting a shared Coloris package for other themes

## Design

### Architecture (Aldine)

1. **Dependency:** add `"@melloware/coloris": "^0.25.0"` to `package.json` (same version as the pressbooks plugin).

2. **New JS entry:** `assets/scripts/customizer-color-picker.js`
   - Imports Coloris and `@melloware/coloris/dist/coloris.css`
   - Initializes with the same `a11y` option strings used in `pressbooks/assets/src/scripts/color-picker.js` (`open`, `close`, `clear`, `marker`, `hueSlider`, `alphaSlider`, `input`, `format`, `swatch`, `instruction`)
   - Adapts the swatch-button accessible-name fixup: the pressbooks version reads the label from `parents('td').prev('th')` (settings tables); the Customizer version reads `.customize-control-title` within the control container, calls `Coloris.wrap('.coloris')` to wrap dynamically rendered fields, and re-applies labels via a MutationObserver, since Customizer controls render dynamically
   - Sets `alpha: false` for Iris parity: the old Iris control had no alpha channel, `maxlength="7"` assumes 6-digit hex, and the WCAG validator's `hexRgb()` assumes 6-digit hex
   - Imports `assets/styles/customizer-color-picker.scss`, which raises `#clr-picker` above the Customizer overlay (`z-index: 500001`, above `.wp-full-overlay`'s `500000`)
   - No custom setting plumbing: see "Control behavior" below
   - **Translation:** the a11y strings are passed from PHP via `wp_localize_script()` on the `aldine/customizer-color-picker` handle (object `PB_Aldine_ColorPicker`), matching the existing `PB_Ajax`/`PB_Aldine_Admin` pattern. All strings use the `pressbooks-aldine` text domain and are covered by the existing `composer localize` PHP scan, so no changes to the i18n extraction pipeline are needed.

3. **Build:** add entry `'scripts/customizer-color-picker'` to `vite.config.js`. `assets/dist` is git-tracked, so the built output is committed.

4. **New control class:** `inc/customizer/class-coloriscontrol.php`
   - `namespace Aldine\Customizer; class ColorisControl extends \WP_Customize_Control`
   - `public $type = 'coloris';`
   - `render_content()` outputs the control title/description and:
     `<input type="text" class="coloris" data-default-color="…" value="…" <?php $this->link(); ?>>`
   - The HM Autoloader resolves the class file by the same convention as `class-searchfeaturedbooks.php`
   - Because the control does not extend `WP_Customize_Color_Control`, core never enqueues Iris

5. **Registration:** in `inc/customizer/namespace.php`
   - Swap `new \WP_Customize_Color_Control(...)` to `new ColorisControl(...)` in the 8-color loop (setting IDs, defaults, labels, descriptions unchanged)
   - Add `enqueue_coloris()` that enqueues the new bundle via `Assets( 'pressbooks-aldine', AssetType::THEME )` with handle `aldine/customizer-color-picker`, dependency `[ 'customize-controls' ]`, and the `PB_Aldine_ColorPicker` localized a11y strings

6. **Hook:** `functions.php` — `add_action( 'customize_controls_enqueue_scripts', '\Aldine\Customizer\enqueue_coloris' );`

### Control behavior

Core's `api.Control.linkElements()` automatically links any element carrying `data-customize-setting-link` (emitted by `$this->link()`) to its setting via `api.Element.sync(setting)`. That handles both directions:

- Input `change` event → `setting.set( value )`
- `setting.bind` → input value update (e.g. programmatic changes such as `header_links` defaulting from `primary`, or `header_textcolor` postMessage transport)

Coloris dispatches native `input` and `change` events on the source input, so no custom sync code is required. If verification shows the `change` event does not reach `api.Element`, the fallback is an explicit listener that calls `setting.set()`.

A per-setting "Default" button is not added: core's `api.ColorControl.ready` never passed `defaultColor` to Iris in the Customizer, so no reset affordance exists today and parity is preserved. `data-default-color` is carried for consistency only.

### WCAG contrast validator

Single change in `lib/customizer-validate-wcag-color-contrast/customizer-validate-wcag-color-contrast.js:48`:

```js
// before
let other_color = other_control.container.find( '.color-picker-hex' ).val();
// after
let other_color = other_control.container.find( '.coloris' ).val();
```

Everything else is unchanged: the `_validateWCAGColorContrastExports` mapping in `inc/customizer/namespace.php:449-460`, the `setting.validate` wrapper, the luminance math, and the warning notifications. Validation still runs because core calls `setting.validate` when `setting.set()` is invoked by the auto-synced `change` event. Coloris emits `#rrggbb`, so `hexRgb()` remains well-formed.

### Dead-code cleanup

1. **pressbooks plugin `assets/src/scripts/a11y.js`** — remove lines 29-71 (Iris slider/palette aria-label patches) and rebuild the git-tracked `assets/dist` so the `a11y-*.js` bundle drops them. The rest of the file stays: list-table `aria-sort`, notice roles, quicktags labels, duet date pickers, admin-bar logo role.

2. **Aldine `enqueue_pb_a11y_in_customizer()`** (`inc/customizer/namespace.php:480-483`) and its hook (`functions.php:71`) — the pressbooks plugin already enqueues `pb-a11y` on every admin screen via `init_css_js` (`inc/admin/laf/namespace.php:1230`, hooked on `admin_init`), and `customize.php` is an admin screen, so this is a duplicate. Verify in a running Customizer that the script loads once with no 404 before removing. Removing it also eliminates the current source-vs-dist inconsistency (Aldine enqueues the unbuilt `assets/src/scripts/a11y.js`; the plugin enqueues the built bundle).

3. **pressbooks plugin `assets/src/scripts/color-picker.js:1`** — remove the vestigial `/* global PB_ColorPicker */` comment. It was introduced by PR #4049 but never implemented: no JS assigns it, no PHP registers or localizes it, and it is absent from the minified bundle.

## Verification

**Automated:**
- Aldine: new PHPUnit test `tests/test-coloris-control.php` for `ColorisControl` (render output includes `class="coloris"`, `type="text"`, setting link, escaped value) and an assertion that `customize_register()` registers the 8 controls as `coloris` type; run `composer standards` and `composer test`
- Both repos: `npm run lint`; `npm run build` (committing updated `assets/dist`)

**Manual Customizer acceptance (a11y focus):**
1. `wp-color-picker`/`iris` JS and CSS are absent from `customize.php`; Coloris JS and CSS are present
2. All 8 controls render `.coloris` inputs; each swatch button has an accessible name from `.customize-control-title` and no dangling `aria-labelledby`
3. Keyboard: open via swatch, arrow-key navigation, labeled hue/alpha sliders, Escape closes, focus is sane
4. Picking a color updates the control, publish persists the option, reload restores it; programmatic changes update the input
5. WCAG warnings fire and clear for the existing mappings (e.g. `primary_fg` vs `primary`)
6. Controls bind correctly when the Colors section is expanded; `pb-a11y` loads exactly once (no 404 from the removed theme enqueue)

## Risks

- **Dynamic binding:** Coloris 0.25 has no MutationObserver. Its document-level click/input delegation covers dynamically added fields, but the bundle must call `Coloris.wrap('.coloris')` after controls render to create the `.clr-field` wrapper and swatch button; the bundle's own MutationObserver on `#customize-controls` does this.
- **Event sync:** setting updates depend on Coloris dispatching `change`; fallback is an explicit `input` listener calling `setting.set()`.
- **Collapsed controls:** the WCAG validator reads sibling control DOM; all 8 color controls live in the same section and render together, matching current behavior.

## Rollout

Two pull requests:

1. **pressbooks/pressbooks-aldine** — Coloris control, assets, WCAG validator update, duplicate `pb-a11y` enqueue removal, tests, rebuilt dist
2. **pressbooks/pressbooks** — `a11y.js` Iris patch removal, `PB_ColorPicker` comment removal, rebuilt dist

Both repos commit `assets/dist`; build and commit the output as part of each PR.
