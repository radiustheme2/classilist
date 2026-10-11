# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

ClassiList is a commercial WordPress theme (by RadiusTheme) that ships an end-to-end classified-ads site on top of the **Classified Listing Pro** plugin family (`Rtcl`, `RtclPro`, `RtclStore`). It is *not* a standalone app — it assumes a running WordPress install with the bundled plugins active. PHP ≥ 7.4, WordPress ≥ 5.4.2.

## Build / test / run

There is no asset build, no `composer.json`, no linter config and no test suite — assets in `assets/css`, `assets/css-auto-rtl`, and `assets/js` are pre-built and committed, so edit them directly (and edit the RTL copy too when a change affects direction). To "run" the theme, drop it into a WordPress install's `wp-content/themes/` and activate it from `wp-admin`. The TGMPA flow at `Appearance → Install Plugins` prompts to install the bundle from `plugin-bundle/*.zip`.

The only script is packaging:

- `npm run zip` (`scripts/zip.js`) — reads `Version:` from `style.css` and writes `dist/classilist.<version>.zip`, excluding `.git`, `CLAUDE.md`, `package.json`, `scripts/`, `dist/`, `node_modules`. It runs `zip` from the theme's parent directory, so the theme folder must be named `classilist`.

### Versions & release metadata

- The theme version is the `Version:` header in `style.css` (it also drives `Constants::$theme_version` and the zip name).
- `readme.txt` holds the changelog but is **not tracked by git** (`*.txt` is in `.gitignore`), and its `Version:` line lags behind `style.css` — don't treat it as the source of truth.
- `languages/` ships `.pot`, `.po`, `.mo` and `.l10n.php` files per locale; regenerate all of them when strings change.

Useful side effect of `WP_DEBUG=true`: `Constants::$theme_version` becomes `time()` (`inc/constants.php`), so all enqueued CSS/JS busts cache on every reload — turn it on while editing styles.

## High-level architecture

### Bootstrap chain

`functions.php` (`ClassiList_Main`) is the only entry point. It:

1. Loads textdomain on `init`.
2. On `after_setup_theme` (priority 5), requires `inc/constants.php` → `inc/uri-helper.php` → `inc/includes.php`. The last file fans out to everything else.
3. Emits admin notices if bundled plugins are below the minimum versions hardcoded in `plugin_update_notices()` (checks `CLASSILIST_CORE`, `RTCL_VERSION`, `RTCL_STORE_VERSION` constants). A plugin bump touches three places that must agree: the `.zip` filename in `plugin-bundle/`, its `source` + `version` entry in `inc/tgm-config.php`, and (if the theme now needs it) the minimum in `plugin_update_notices()`.

All theme PHP lives in the `radiustheme\ClassiList` namespace. Most setup classes are singletons with `instance()` + a self-registering `new self()` / `Class::instance()` call at file bottom.

### `URI_Helper` — the loader you must understand

`inc/uri-helper.php` defines child-theme-aware path resolution used everywhere:

- `URI_Helper::requires( $filename, $dir = false )` — if `$dir` is false, loads `inc/$filename`; otherwise loads `$dir/$filename`. **Always checks the child theme first**, falls back to parent. This is how a child theme overrides any single file in `inc/`, `widgets/`, or `classified-listing/`.
- `URI_Helper::get_css|get_js|get_img|get_file` — same child-first resolution for asset URLs.
- `URI_Helper::get_maybe_rtl_css( $name )` — returns `assets/css-auto-rtl/$name.css` when `is_rtl()`, otherwise `assets/css/$name.css`. New stylesheets that need RTL flips must be enqueued through this helper.

Bottom line: when adding or overriding any file, prefer placing it where `URI_Helper` will find it, rather than hardcoding paths.

### Settings & shared state — `RDTheme`

`inc/rdtheme.php` defines a class with **public static properties** that act as the global runtime state:

- `RDTheme::$options` / `RDTheme::$ad_options` — Redux option arrays merged with JSON defaults from `inc/predefined-data.php` (so new options must be added there or they read as `null`).
- `RDTheme::$layout`, `$sidebar`, `$has_top_bar`, `$header_style`, `$has_header_search`, `$classilist_has_breadcrumb` — set per-request by `Layouts` (`inc/layout-settings.php`) on `template_redirect`, based on the cascade: post meta → page-type-specific Redux option → global Redux option.

Templates and helpers read these directly (e.g. `body_class` in `inc/general.php`). When introducing a new layout-affecting option, add it to `predefined-data.php` defaults, surface it in `inc/options/*.php`, and read from `RDTheme::$options` rather than calling `get_option()` again.

`set_redux_compability_options()` is the shim path for fields added after release; mirror the pattern when introducing new options that must have a default on already-installed sites.

### Redux options panel

`inc/options/init.php` boots Redux with `opt_name = 'classilist'` and registers each tab file (`general.php`, `header.php`, `listings.php`, …). The Ads options live under a separate Redux instance (`opt_name = 'classilist_ads'`) — both names are centralized in `Constants::$theme_options` / `Constants::$theme_ad_options`. If Redux isn't loaded, `init.php` short-circuits — the theme still runs on the JSON defaults.

### Classified Listing integration

This is the heart of the theme.

- `classified-listing/` is the WordPress template-override directory for the Rtcl plugin: files mirror Rtcl's plugin `templates/` paths and replace them when the theme is active.
- `classified-listing/custom/` holds theme-specific extensions (not direct overrides). `Listing_Functions` (`classified-listing/custom/functions.php`) wires them into the plugin via filters/actions: archive titles, placeholder image, grid column classes from Redux options (`grid_desktop_column` etc.), Top-Ad badge, related-listing slider config, etc. It also overrides plugin colors via `rtcl_style_settings` so the plugin uses Redux's `primary_color` / `secondery_color`.
- `classified-listing/custom/list-items/` — five archive card variants (`archive-grid-1/2`, `archive-list-1/2/alt`) selected from Redux.
- `classified-listing/single-layout/builder.php` + `Shortcode` (`classified-listing/custom/shortcode.php`) — single-listing-page Elementor builder. Note the shortcode prefix is `classilsit_*` (the typo is intentional and part of the public API — do **not** "fix" it without coordinating).
- The whole Rtcl block is only loaded if `class_exists('Rtcl')` (see `inc/includes.php`). New custom listing code must live behind that guard or break activation without the plugin.

### Asset pipeline (`inc/scripts.php`)

`Scripts::register_scripts()` registers everything; `enqueue_scripts()` pulls the always-on subset and `conditional_scripts()` adds isotope/sticky/comments based on options + context. Inline dynamic CSS is built by buffering `dynamic-style.php`, `dynamic-style-listing.php`, `dynamic-style-elementor.php` and feeding the result through `wp_add_inline_style` on the `classilist-dynamic` handle — so per-color-option tweaks belong in those three files, *not* in static CSS.

### Other moving parts worth knowing

- `inc/ad-management.php` — `Ad_Management` listens on theme action hooks (`classilist_header_top`, `classilist_before_sidebar`, `classilist_listing_before_items`, etc.) and renders Redux-configured ad slots. New ad placements need both a hook firing in the template and a switch case in `Ad_Management::get_page_type()`.
- `inc/sidebar-generator.php` — AJAX endpoints `rdtheme_add_sidebar` / `rdtheme_remove_sidebar` let admins create custom sidebars stored in option `classilist_custom_sidebars`; they are registered on `init` from that option.
- `widgets/init.php` — `Custom_Widgets_Init` registers theme widgets but **only if `RT_Widget_Fields` class exists** (provided by the RT Framework plugin). Add new widgets by extending the `$widgets` map and dropping a class file in `widgets/`.
- `inc/breadcrumbs.php` is lazy-loaded by `Helper::the_breadcrumb()` (only when the `bcn_display()` plugin isn't available) — don't move its includes into the eager chain.
- `inc/updater/` — self-hosted theme updater (not WordPress.org). Configuration lives at the top of `theme-updater.php`.

## Working with this codebase

- **Adding a new file under `inc/`**: also add a `URI_Helper::requires(...)` call in `inc/includes.php` (or in the relevant submodule loader like `inc/options/init.php` or `widgets/init.php`). Nothing autoloads.
- **Reading or setting a theme option**: prefer `RDTheme::$options['key']`. Add the default to `inc/predefined-data.php` and the field UI to the appropriate `inc/options/*.php`.
- **Overriding an Rtcl plugin template**: copy from the plugin into the matching path under `classified-listing/` — the plugin's `Functions::get_template()` will pick the theme copy automatically.
- **Touching listing archive cards**: edit `classified-listing/custom/list-items/archive-*.php`; the active layout is chosen by Redux option, and grid column classes come from `Listing_Functions::classilist_listing_archive_grid()`.
- **Escaping/i18n**: text domain is `classilist`. The codebase enforces escaping at output (note the `phpcs:ignore` comments where intentional unescaped output is required, e.g. JSON in `data-options` attributes in `Listing_Functions::seller_phone_number`).
