<?php
/*
Plugin Name: Disable Bloat
Description: Disables selected WordPress features for speed via admin UI.
Version: 1.1
Author: Grok
*/

// Register admin page
add_action('admin_menu', function() {
    add_options_page('Disable Bloat', 'Disable Bloat', 'manage_options', 'disable-bloat', 'disable_bloat_options_page');
});

// Render options page
function disable_bloat_options_page() {
    ?>
    <div class="wrap">
        <h1>Disable Bloat Settings</h1>
        <input type="text" id="disable-bloat-search" placeholder="Search features..." style="width: 100%; max-width: 400px; margin-bottom: 10px;">
        <form method="post" action="options.php">
            <?php
            settings_fields('disable_bloat_group');
            do_settings_sections('disable-bloat');
            submit_button();
            ?>
        </form>
    </div>
    <script>
        document.getElementById('disable-bloat-search').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('.form-table tr');
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
    <?php
}

// Register settings
add_action('admin_init', function() {
    register_setting('disable_bloat_group', 'disable_bloat_options', ['sanitize_callback' => 'sanitize_disable_bloat_options']);

    add_settings_section('disable_bloat_section', 'Select Features to Disable', null, 'disable-bloat');

    $features = [
        'comments' => [
            'label' => 'Comments',
            'desc' => 'Disable Comments on Frontend and Admin'
        ],
        'updates' => [
            'label' => 'WP Updates',
            'desc' => 'Disables all WordPress updates (core, plugins and themes) and removes update notifications in admin'
        ],
        'auto_update_emails' => [
            'label' => 'Auto-update Email Notifications for Themes and Plugins',
            'desc' => 'Disable auto-update Email Notifications for Themes and Plugins updates Only'
        ],
        'post_revisions' => [
            'label' => 'Post Revisions',
            'desc' => 'Disable Post Revisions (for All Post Types)'
        ],
        'search' => [
            'label' => 'Search',
            'desc' => 'Disable WordPress Search on Frontend only'
        ],
        'login_logo_favicon' => [
            'label' => 'WP Login Logo and Favicon',
            'desc' => 'Disable WordPress logo on the login page and W favicon (logo is replaced with your site\'s name and new favicon can be added in Customizer)'
        ],
        'admin_email_verification' => [
            'label' => 'Administration Email Verification Prompt',
            'desc' => 'Disables the administration email verification prompt introduced in WordPress 5.3'
        ],
        'lazy_loading' => [
            'label' => 'Lazy Loading',
            'desc' => 'Disable Lazy Loading (introduced in WP version 5.5)'
        ],
        'woocommerce_bloat' => [
            'label' => 'WooCommerce Bloat',
            'desc' => 'Disable WooCommerce Bloat: WooCommerce frontend styles, WooCommerce gallery noscript tag in head, WooCommerce admin features (dashboard, analytics, etc.)'
        ],
        'woocommerce_sticky_header' => [
            'label' => 'WooCommerce Sticky Header',
            'desc' => 'Remove WooCommerce sticky header'
        ],
        'right_click' => [
            'label' => 'Right Click',
            'desc' => 'Disable Right Click (by checking this you will disable right click, view source, cut/copy/paste, text selection, inspect element, image save, image drag & drop. However this will not work if you are logged as Administrator or Editor, in other words you need to be logged out of admin panel in order to see all of these disabled)'
        ],
        'admin_footer' => [
            'label' => 'Admin Footer',
            'desc' => 'Disable the admin footer text and WordPress version number'
        ],
        'elementor_bloat' => [
            'label' => 'Elementor Bloat',
            'desc' => 'Disable JS and CSS Bloat and Dashboard Notifications for both Elementor and Essential Addons for Elementor plugins. Following are Disabled in Elementor: Google Fonts, Elementor Frontend JS, Elementor Dialog, Swipper, Elementor Waypoints, Font Awesome icons by Elementor.'
        ],
        'jetpack_promotions' => [
            'label' => 'Jetpack Promotions',
            'desc' => 'Disable all Jetpack related notices that promote services like the backup services VaultPress, WordPress Apps or Blaze.'
        ],
        'cf7_bloat' => [
            'label' => 'Contact Form 7 Bloat',
            'desc' => 'Remove CF7 scripts and styles from all pages and posts where CF7 is not used'
        ],
        'autoptimize_toolbar' => [
            'label' => 'Autoptimize Toolbar',
            'desc' => 'Disables the Autoptimize Toolbar from the Top Bar in Dashboard'
        ],
        'w3tc_footer' => [
            'label' => 'W3 Total Cache HTML Footer Comments',
            'desc' => 'Disables HTML comments from footer generated by W3 Total Cache plugin'
        ],
        'user_enumeration' => [
            'label' => 'User-Enumeration',
            'desc' => 'Block User-Enumeration'
        ],
        'author_archives' => [
            'label' => 'Author Archives',
            'desc' => 'Disable Author Archives'
        ],
        'capital_p_dangit' => [
            'label' => 'capital_P_dangit',
            'desc' => 'Changes the incorrect capitalization of Wordpress into WordPress. WordPress uses it to filter the content, the title and comment text.'
        ],
        'screen_options_help' => [
            'label' => 'Screen options and help',
            'desc' => 'Disable screen options and contextual help'
        ],
        'howdy' => [
            'label' => 'Howdy in adminbar',
            'desc' => 'Remove Howdy from adminbar'
        ],
        'adminbar_items' => [
            'label' => 'Navigation items in adminbar',
            'desc' => 'Remove reduntant items from adminbar (these items are removed: wp-logo,view-site,new-content,comments,updates,dashboard,appearance)'
        ],
        'clean_dashboard' => [
            'label' => 'Clean Dashboard',
            'desc' => 'Clean up Dasboard from bloat (improves preformance and saves valuable space)'
        ],
        'emojis' => [
            'label' => 'Emojis',
            'desc' => 'Disable support for emojis in posts (saves at least 1 file request and ~16kb)'
        ],
        'embeds' => [
            'label' => 'Embed Objects',
            'desc' => 'Disable support for embedding objects in posts (saves at least 1 file request and ~6kb)'
        ],
        'dashicons' => [
            'label' => 'Dashicons',
            'desc' => 'Disable support for Dashicons when not logged in (saves 1 file request and ~46kb)'
        ],
        'heartbeat' => [
            'label' => 'Heartbeat',
            'desc' => 'Disable support for auto-save when not editing a page/post (saves 1 file request and ~6kb)'
        ],
        'xmlrpc_pingback' => [
            'label' => 'XML-RPC + Pingback',
            'desc' => 'Disable support for third-party application access (such as mobile apps)'
        ],
        'generator' => [
            'label' => 'Generator',
            'desc' => 'Disable the generator tag (includes Wordpress version number)'
        ],
        'wlw_manifest' => [
            'label' => 'WLW Manifest',
            'desc' => 'Disable the Windows Live Writer manifest tag (WLW was discontinued in Jan 2017)'
        ],
        'rsd' => [
            'label' => 'Really Simple Discovery',
            'desc' => 'Disable the Really Simple Discovery (RSD) tag (this protocol never became popular)'
        ],
        'shortlink' => [
            'label' => 'Short Link',
            'desc' => 'Disable the Short Link tag (search engines ignore this tag completely)'
        ],
        'rss_feeds' => [
            'label' => 'RSS Feeds',
            'desc' => 'Disable the RSS feed links and disable the feeds (will redirect to the page instead)'
        ],
        'rest_api' => [
            'label' => 'REST API',
            'desc' => 'Disable the REST API links and disable the endpoints when not on admin pages'
        ],
        'block_library' => [
            'label' => 'Block Library',
            'desc' => 'Disable the Gutenberg blocks library if you are using Classic Editor (saves 1 file request and ~29kb)'
        ],
        'app_passwords' => [
            'label' => 'Application Passwords',
            'desc' => 'Completely disable the new Application Passwords functionality (added in WP version 5.6)'
        ],
        'core_privacy' => [
            'label' => 'Core Privacy Tools',
            'desc' => 'Disable the Core Privacy Tools'
        ],
        'site_health' => [
            'label' => 'Site Health',
            'desc' => 'Disable the Site Health page'
        ],
        'adjacent_posts' => [
            'label' => 'adjacent_posts',
            'desc' => 'Remove the next and previous post links from the header'
        ],
        'version_query' => [
            'label' => 'Version',
            'desc' => 'Remove WordPress version var (?ver=) after styles and scripts.'
        ],
        'pdf_thumbnails' => [
            'label' => 'PDF Thumbnails',
            'desc' => 'This option disables PDF thumbnails.'
        ],
        'empty_trash' => [
            'label' => 'Empty Trash',
            'desc' => 'Shorten the time posts are kept in the trash, which is 30 days by default, to 1 week.'
        ],
        'file_editor' => [
            'label' => 'Plugin and Theme Editor',
            'desc' => 'Disables the plugins and theme editor.'
        ],
        'oembed' => [
            'label' => 'oEmbed',
            'desc' => 'Remove oEmbed Scripts. Since WordPress 4.4, oEmbed is installed and available by default. If you do not need oEmbed, you can remove it.'
        ],
        'remote_patterns' => [
            'label' => 'Remote Block Patterns',
            'desc' => 'Disable Remote Block Patterns. Disable it if you want to improve pattern inserter loading performance or you have privacy concerns regarding loading remote asset.'
        ],
    ];

    foreach ($features as $key => $feature) {
        add_settings_field(
            "disable_bloat_$key",
            $feature['label'],
            'disable_bloat_checkbox_callback',
            'disable-bloat',
            'disable_bloat_section',
            ['key' => $key, 'desc' => $feature['desc']]
        );
    }
});

// Checkbox callback
function disable_bloat_checkbox_callback($args) {
    $options = get_option('disable_bloat_options', []);
    $key = $args['key'];
    $desc = $args['desc'];
    $checked = isset($options[$key]) ? checked(1, $options[$key], false) : '';
    echo "<input type='checkbox' name='disable_bloat_options[$key]' value='1' $checked />";
    if ($desc) {
        echo '<p class="description">' . esc_html($desc) . '</p>';
    }
}

// Sanitize
function sanitize_disable_bloat_options($input) {
    $output = [];
    foreach ($input as $key => $value) {
        $output[$key] = $value ? 1 : 0;
    }
    return $output;
}

// Apply disables based on options
$options = get_option('disable_bloat_options', []);

// Disable comments
if (!empty($options['comments'])) {
    add_filter('comments_open', '__return_false', 20);
    add_filter('pings_open', '__return_false', 20);
    add_filter('comments_array', '__return_empty_array', 10, 2);
    add_action('admin_init', function() {
        remove_menu_page('edit-comments.php');
        remove_submenu_page('options-general.php', 'options-discussion.php');
    });
}

// Disable updates
if (!empty($options['updates'])) {
    define('WP_AUTO_UPDATE_CORE', false);
    add_filter('pre_site_transient_update_core', '__return_null');
    add_filter('pre_site_transient_update_plugins', '__return_null');
    add_filter('pre_site_transient_update_themes', '__return_null');
    add_filter('auto_update_plugin', '__return_false');
    add_filter('auto_update_theme', '__return_false');
    remove_action('admin_init', '_maybe_update_core');
    remove_action('admin_init', '_maybe_update_plugins');
    remove_action('admin_init', '_maybe_update_themes');
    add_action('admin_menu', function() {
        remove_action('admin_notices', 'update_nag', 3);
    });
}

// Disable auto-update emails
if (!empty($options['auto_update_emails'])) {
    add_filter('auto_plugin_update_send_email', '__return_false');
    add_filter('auto_theme_update_send_email', '__return_false');
}

// Disable post revisions
if (!empty($options['post_revisions'])) {
    define('WP_POST_REVISIONS', false);
}

// Disable search
if (!empty($options['search'])) {
    add_action('init', function() {
        if (!is_admin()) {
            add_action('parse_query', function($query) {
                if ($query->is_search) {
                    $query->set_404();
                    status_header(404);
                }
            });
        }
    });
}

// Disable login logo favicon
if (!empty($options['login_logo_favicon'])) {
    add_filter('login_headerurl', function() { return home_url(); });
    add_filter('login_headertext', function() { return get_bloginfo('name'); });
    add_action('wp_head', function() {
        echo '<link rel="shortcut icon" href="' . get_site_icon_url() . '" />';
    }, 1);
}

// Disable admin email verification
if (!empty($options['admin_email_verification'])) {
    add_filter('admin_email_check_interval', '__return_false');
}

// Disable lazy loading
if (!empty($options['lazy_loading'])) {
    add_filter('wp_lazy_loading_enabled', '__return_false');
}

// Disable WooCommerce bloat
if (!empty($options['woocommerce_bloat'])) {
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    add_action('wp', function() {
        remove_action('wp_head', 'wc_gallery_noscript');
    });
    add_filter('woocommerce_admin_disabled', '__return_true');
}

// Disable WooCommerce sticky header
if (!empty($options['woocommerce_sticky_header'])) {
    add_action('admin_head', function() {
        echo '<style>.woocommerce-layout__header { position: static !important; }</style>';
    });
}

// Disable right click
if (!empty($options['right_click'])) {
    add_action('wp_enqueue_scripts', function() {
        if (!current_user_can('edit_posts')) {
            wp_enqueue_script('disable-right-click', '', [], false, true);
            wp_add_inline_script('disable-right-click', '
                document.addEventListener("contextmenu", e => e.preventDefault());
                document.addEventListener("dragstart", e => e.preventDefault());
                document.addEventListener("selectstart", e => e.preventDefault());
                document.addEventListener("copy", e => e.preventDefault());
                document.addEventListener("cut", e => e.preventDefault());
                document.addEventListener("paste", e => e.preventDefault());
                document.onkeydown = e => {
                    if (e.keyCode == 123 || (e.ctrlKey && e.shiftKey && (e.keyCode == 73 || e.keyCode == 74)) || (e.ctrlKey && e.keyCode == 85)) return false;
                };
            ');
        }
    });
}

// Disable admin footer
if (!empty($options['admin_footer'])) {
    add_filter('admin_footer_text', '__return_empty_string', 11);
    add_filter('update_footer', '__return_empty_string', 11);
}

// Disable Elementor bloat
if (!empty($options['elementor_bloat'])) {
    add_action('init', function() {
        remove_action('wp_enqueue_scripts', ['Elementor\Frontend', 'register_scripts']);
        remove_action('wp_enqueue_scripts', ['Elementor\Frontend', 'enqueue_styles']);
        add_filter('elementor/frontend/print_google_fonts', '__return_false');
        remove_action('elementor/editor/after_enqueue_styles', 'enqueue_font_awesome_icons');
        add_action('admin_init', function() {
            remove_action('admin_notices', 'eael_admin_notice');
            remove_action('admin_notices', 'elementor_pro_license_notice');
        });
    });
}

// Disable Jetpack promotions
if (!empty($options['jetpack_promotions'])) {
    add_filter('jetpack_just_in_time_msgs', '__return_false');
    add_action('init', function() {
        remove_action('admin_notices', 'jetpack_backup_notice');
    });
}

// CF7 bloat
if (!empty($options['cf7_bloat'])) {
    add_action('wp_print_scripts', function() {
        if (!is_singular() || !has_shortcode(get_post()->post_content, 'contact-form-7')) {
            wp_dequeue_script('contact-form-7');
            wp_dequeue_style('contact-form-7');
        }
    }, 100);
}

// Disable Autoptimize toolbar
if (!empty($options['autoptimize_toolbar'])) {
    add_filter('autoptimize_toolbar_show', '__return_false');
}

// Disable W3TC footer
if (!empty($options['w3tc_footer'])) {
    add_filter('w3tc_can_print_comment', '__return_false');
}

// Block user enumeration
if (!empty($options['user_enumeration'])) {
    add_action('init', function() {
        if (isset($_GET['author']) && !is_admin()) {
            wp_redirect(home_url());
            exit;
        }
    });
}

// Disable author archives
if (!empty($options['author_archives'])) {
    add_action('template_redirect', function() {
        if (is_author()) {
            wp_redirect(home_url());
            exit;
        }
    });
}

// Disable capital_P_dangit
if (!empty($options['capital_p_dangit'])) {
    remove_filter('the_content', 'capital_P_dangit', 11);
    remove_filter('the_title', 'capital_P_dangit', 11);
    remove_filter('comment_text', 'capital_P_dangit', 31);
}

// Disable screen options help
if (!empty($options['screen_options_help'])) {
    add_filter('screen_options_show_screen', '__return_false');
    add_filter('contextual_help', '__return_false');
}

// Remove Howdy
if (!empty($options['howdy'])) {
    add_filter('admin_bar_menu', function($wp_toolbar) {
        $wp_toolbar->add_node([
            'id' => 'my-account',
            'title' => preg_replace('/Howdy, /', '', $wp_toolbar->get_node('my-account')->title)
        ]);
    }, 11);
}

// Remove adminbar items
if (!empty($options['adminbar_items'])) {
    add_action('admin_bar_menu', function($wp_admin_bar) {
        $wp_admin_bar->remove_menu('wp-logo');
        $wp_admin_bar->remove_menu('site-name');
        $wp_admin_bar->remove_menu('new-content');
        $wp_admin_bar->remove_menu('comments');
        $wp_admin_bar->remove_menu('updates');
        $wp_admin_bar->remove_menu('dashboard');
        $wp_admin_bar->remove_menu('appearance');
    }, 999);
}

// Clean dashboard
if (!empty($options['clean_dashboard'])) {
    add_action('wp_dashboard_setup', function() {
        remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
        remove_meta_box('dashboard_activity', 'dashboard', 'normal');
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
        remove_meta_box('dashboard_primary', 'dashboard', 'side');
    });
}

// Disable emojis
if (!empty($options['emojis'])) {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}

// Disable embeds
if (!empty($options['embeds'])) {
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
}

// Disable dashicons
if (!empty($options['dashicons'])) {
    add_action('wp_enqueue_scripts', function() {
        if (!is_user_logged_in()) {
            wp_dequeue_style('dashicons');
        }
    });
}

// Disable heartbeat
if (!empty($options['heartbeat'])) {
    add_action('init', function() {
        if (!strpos($_SERVER['REQUEST_URI'], 'post.php') && !strpos($_SERVER['REQUEST_URI'], 'post-new.php')) {
            wp_deregister_script('heartbeat');
        }
    });
}

// Disable XML-RPC pingback
if (!empty($options['xmlrpc_pingback'])) {
    add_filter('xmlrpc_enabled', '__return_false');
    add_filter('pings_open', '__return_false');
    remove_action('do_pings', 'do_all_pings');
}

// Disable generator
if (!empty($options['generator'])) {
    remove_action('wp_head', 'wp_generator');
}

// Disable WLW manifest
if (!empty($options['wlw_manifest'])) {
    remove_action('wp_head', 'wlwmanifest_link');
}

// Disable RSD
if (!empty($options['rsd'])) {
    remove_action('wp_head', 'rsd_link');
}

// Disable shortlink
if (!empty($options['shortlink'])) {
    remove_action('wp_head', 'wp_shortlink_wp_head');
}

// Disable RSS feeds
if (!empty($options['rss_feeds'])) {
    add_action('do_feed', function() { wp_die('No feeds available.'); }, 1);
    add_action('do_feed_rdf', function() { wp_die('No feeds available.'); }, 1);
    add_action('do_feed_rss', function() { wp_die('No feeds available.'); }, 1);
    add_action('do_feed_rss2', function() { wp_die('No feeds available.'); }, 1);
    add_action('do_feed_atom', function() { wp_die('No feeds available.'); }, 1);
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
}

// Disable REST API
if (!empty($options['rest_api'])) {
    add_filter('rest_authentication_errors', function($result) {
        if (!empty($result) || is_admin()) return $result;
        return new WP_Error('rest_disabled', 'REST API disabled.', ['status' => 403]);
    });
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('template_redirect', 'rest_output_link_header', 11);
}

// Disable block library
if (!empty($options['block_library'])) {
    if (function_exists('classic_editor_init_actions')) {
        remove_action('wp_enqueue_scripts', 'wp_common_block_scripts_and_styles');
    }
}

// Disable app passwords
if (!empty($options['app_passwords'])) {
    add_filter('wp_is_application_passwords_available', '__return_false');
}

// Disable core privacy
if (!empty($options['core_privacy'])) {
    remove_action('admin_menu', '_wp_privacy_hook_requests_page');
    remove_action('wp_privacy_personal_data_cleanup', 'wp_privacy_delete_old_export_files');
}

// Disable site health
if (!empty($options['site_health'])) {
    add_action('admin_menu', function() {
        remove_submenu_page('tools.php', 'site-health.php');
    });
}

// Remove adjacent posts
if (!empty($options['adjacent_posts'])) {
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
}

// Remove version query
if (!empty($options['version_query'])) {
    add_filter('script_loader_src', 'remove_version', 9999);
    add_filter('style_loader_src', 'remove_version', 9999);
    function remove_version($src) {
        return $src ? remove_query_arg('ver', $src) : false;
    }
}

// Disable PDF thumbnails
if (!empty($options['pdf_thumbnails'])) {
    add_filter('fallback_post_thumbnail_html', function($html) {
        return '';
    });
    add_filter('wp_generate_attachment_metadata', function($metadata, $attachment_id) {
        if (get_post_mime_type($attachment_id) == 'application/pdf') {
            return [];
        }
        return $metadata;
    }, 10, 2);
}

// Shorten empty trash
if (!empty($options['empty_trash'])) {
    define('EMPTY_TRASH_DAYS', 7);
}

// Disable file editor
if (!empty($options['file_editor'])) {
    define('DISALLOW_FILE_EDIT', true);
}

// Disable oEmbed
if (!empty($options['oembed'])) {
    wp_deregister_script('wp-embed');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
}

// Disable remote patterns
if (!empty($options['remote_patterns'])) {
    add_filter('should_load_remote_block_patterns', '__return_false');
}

?>