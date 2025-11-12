# Disable Bloat Plugin

## Overview

Disable Bloat is a lightweight WordPress plugin that allows users to disable various WordPress features, plugins' bloat, and unnecessary elements to improve site speed and reduce resource usage. All options are configurable via an admin settings page under Settings > Disable Bloat.

## Installation

1. Upload the plugin files to the `/wp-content/plugins/disable-bloat/` directory, or install via the WordPress plugin installer.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Settings > Disable Bloat to configure options.

## Usage

On the settings page, check the boxes for features you want to disable and save changes. Each option toggles specific hooks, filters, or constants in WordPress to remove bloat.

## Options and Detailed Descriptions

Below is a list of all available options, with detailed explanations of what each does, based on the plugin's functionality:

- **Comments**: Disables comments on the frontend (no new comments or pings allowed) and admin (removes comments menu and discussion settings submenu). This prevents comment-related queries and UI elements, improving performance on sites without comments.

- **WP Updates**: Disables all automatic WordPress core, plugin, and theme updates. Removes update notifications and nags in the admin dashboard. This prevents background update checks, reducing server load, but requires manual updates for security.

- **Auto-update Email Notifications for Themes and Plugins**: Disables email notifications sent after automatic theme or plugin updates. Useful for sites where admins handle updates manually and don't need alerts.

- **Post Revisions**: Disables post revisions for all post types by setting WP_POST_REVISIONS to false. This stops WordPress from saving multiple versions of posts, saving database space and reducing storage bloat.

- **Search**: Disables the built-in WordPress search functionality on the frontend only. Redirects search queries to a 404 page, preventing search-related database queries on public-facing sites.

- **WP Login Logo and Favicon**: Replaces the WordPress logo on the login page with the site's name and uses the site's custom favicon (from Customizer) instead of the default WordPress one. This customizes the login screen without loading extra WP assets.

- **Administration Email Verification Prompt**: Disables the periodic admin email verification prompt introduced in WordPress 5.3. Prevents the nagging screen asking to confirm the admin email.

- **Lazy Loading**: Disables native lazy loading for images (introduced in WP 5.5). Removes the 'loading="lazy"' attribute, allowing custom lazy loading or none at all.

- **WooCommerce Bloat**: Disables WooCommerce frontend styles (prevents enqueuing WooCommerce CSS) and removes the gallery noscript tag in the head. This reduces unnecessary assets on WooCommerce sites, but note: it may conflict with WooPayments if admin features are needed (error: "WooPayments requires WooCommerce Admin to be enabled").

- **WooCommerce Sticky Header**: Removes the sticky header in the WooCommerce admin area by adding inline CSS to make it static. Improves admin usability if the sticky behavior is unwanted.

- **Right Click**: Disables right-click context menu, dragstart, selectstart, copy, cut, paste, and certain keyboard shortcuts (F12, Ctrl+Shift+I/J, Ctrl+U) on the frontend for non-admin/editor users. This protects content from easy copying but doesn't affect logged-in admins/editors.

- **Admin Footer**: Clears the admin footer text (e.g., "Thank you for creating with WordPress") and hides the WordPress version number in the admin dashboard footer.

- **Elementor Bloat**: Disables Elementor frontend JS/CSS, Google Fonts loading, dialog, Swiper, Waypoints, and Font Awesome icons. Also removes dashboard notifications for Elementor and Essential Addons. Reduces bloat from Elementor plugins.

- **Jetpack Promotions**: Disables Jetpack's promotional notices for services like VaultPress backups, WordPress Apps, or Blaze. Removes admin notices promoting upsells.

- **Contact Form 7 Bloat**: Dequeues Contact Form 7 scripts and styles on pages/posts where the CF7 shortcode is not present. Prevents loading unnecessary assets site-wide.

- **Autoptimize Toolbar**: Hides the Autoptimize toolbar in the admin top bar. Useful if Autoptimize is installed but the toolbar is not needed.

- **W3 Total Cache HTML Footer Comments**: Prevents W3 Total Cache from adding HTML comments (e.g., performance stats) to the site footer.

- **User-Enumeration**: Blocks user enumeration by redirecting author archive queries (e.g., ?author=1) to the homepage if not in admin. Enhances security by preventing username discovery.

- **Author Archives**: Disables author archive pages by redirecting them to the homepage. Prevents public author listings.

- **capital_P_dangit**: Disables the filter that corrects "Wordpress" to "WordPress" in content, titles, and comments. Allows custom capitalization if needed.

- **Screen options and help**: Hides the "Screen Options" and "Help" tabs in the admin area. Cleans up the interface for simpler usage.

- **Howdy in adminbar**: Removes the "Howdy," prefix from the user greeting in the admin bar (e.g., changes "Howdy, User" to "User").

- **Navigation items in adminbar**: Removes redundant items from the admin bar: WP logo, site name/view site, new content, comments, updates, dashboard, appearance. Streamlines the top bar.

- **Clean Dashboard**: Removes default dashboard widgets like "At a Glance," "Activity," "Quick Draft," and "WordPress Events and News." Improves dashboard performance and space.

- **Emojis**: Disables emoji support in posts, removing detection scripts, styles, and filters. Saves ~16KB and 1 file request.

- **Embed Objects**: Disables oEmbed discovery links and host JS in the head. Prevents embedding external content, saving ~6KB and 1 file request.

- **Dashicons**: Dequeues Dashicons CSS on the frontend for non-logged-in users. Saves ~46KB and 1 file request if not needed.

- **Heartbeat**: Disables the Heartbeat API (autosave) except on post edit screens. Reduces server requests, saving ~6KB and 1 file request.

- **XML-RPC + Pingback**: Disables XML-RPC access and pingbacks, preventing third-party app connections and pings.

- **Generator**: Removes the meta generator tag from the head, hiding the WordPress version.

- **WLW Manifest**: Removes the Windows Live Writer manifest link (discontinued in 2017).

- **Really Simple Discovery**: Removes the RSD link tag, as the protocol is obsolete.

- **Short Link**: Removes the shortlink tag from the head, ignored by search engines.

- **RSS Feeds**: Disables RSS feed links and redirects feed requests to a "No feeds available" message.

- **REST API**: Disables REST API endpoints and links except in admin, returning a 403 error for non-admin access.

- **Block Library**: Dequeues Gutenberg block styles on frontend if Classic Editor is active. Saves ~29KB and 1 file request.

- **Application Passwords**: Disables application passwords feature (added in WP 5.6).

- **Core Privacy Tools**: Removes privacy tools menu and scheduled cleanup tasks.

- **Site Health**: Removes the Site Health submenu from Tools.

- **adjacent_posts**: Removes next/previous post links from the head.

- **Version**: Removes the ?ver= query string from enqueued scripts and styles.

- **PDF Thumbnails**: Disables thumbnail generation for PDF attachments.

- **Empty Trash**: Reduces trash retention from 30 days to 7 days.

- **Plugin and Theme Editor**: Disables the built-in file editor for plugins and themes via DISALLOW_FILE_EDIT constant.

- **oEmbed**: Deregisters oEmbed scripts, removes discovery links, host JS, and data parse filter.

- **Remote Block Patterns**: Disables loading of remote block patterns, improving inserter performance and privacy.

## Support

For issues, check the plugin code or contact the author. Always test on a staging site.