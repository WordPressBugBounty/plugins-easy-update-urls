<?php
/*
Plugin Name: easy-update-urls
Description: Easy Update Urls in WP database
Version: 1.27
Text Domain: easy-update-urls
Author: Bill Minozzi
Author URI: http://billminozzi.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
// Make sure the file is not directly accessible.
if (!defined('ABSPATH')) {
    die('We\'re sorry, but you can not directly access this file.');
}
$easy_update_urls_plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
$easy_update_urls_plugin_version = $easy_update_urls_plugin_data['Version'];
define('EASY_UPDATE_URLS_VERSION', $easy_update_urls_plugin_version);
define('EASY_UPDATE_URLS_URL', plugin_dir_url(__FILE__));
define('EASY_UPDATE_URLS_PATH', plugin_dir_path(__FILE__));
define('EASY_UPDATE_URLS_IMAGES', plugin_dir_url(__FILE__) . 'assets/images');
$easy_update_urls_is_admin = easy_update_urls_check_wordpress_logged_in_cookie();

// function exist...
add_action('init', "easy_update_urls_init", 1000);
add_action('admin_enqueue_scripts', 'easy_update_urls_enqueue', 1000);
function easy_update_urls_init_ori()
{
    if (is_admin())
        add_management_page(
            'Easy Update Urls',
            'Easy Update Urls',
            'manage_options',
            'easy_update_urls_admin_page', // slug
            'easy_update_urls_admin_page'
        );
}
// add_action('admin_menu', 'easy_update_urls_init');
add_action('admin_menu', 'easy_update_urls_init', 20);
function easy_update_urls_init()
{
    if (is_admin()) {
        add_management_page(
            'Easy Update Urls', // Page title
            'Easy Update Urls', // Menu title
            'manage_options',
            'easy_update_urls_admin_page', // Menu slug
            'easy_update_urls_admin_page' // Callback function
        );
        /*
        add_submenu_page(
            'easy_update_urls_admin_page', // parent slug
            'Pre-Checkup', // page title
            'Pre-Checkup', // menu title
            'manage_options', // capability
            'pre-checkup', // menu slug
            'pre_checkup_page_content' // callback function
        );
        */
    }
}

function pre_checkup_page_content()
{
?>
    <div class="wrap">
        <h2>Pre-Checkup</h2>
        <p>Content of the pre-checkup page.</p>
        <button class="button">Prev</button>
        <button class="button button-primary">Next</button>
        <button class="button button-secondary">Dismiss</button>
    </div>
<?php
}
function easy_update_urls_enqueue()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('wp-pointer');
    wp_enqueue_style('easy-update-urls', EASY_UPDATE_URLS_URL . 'assets/css/styles.css');
    wp_enqueue_style('easy-update-pointer', EASY_UPDATE_URLS_URL . 'assets/css/bill-wp-pointer.css');
    wp_register_script('easy-update-urls-js', EASY_UPDATE_URLS_URL . 'assets/js/easy-update-urls.js', false);
    wp_enqueue_script('easy-update-urls-js');
}
function easy_update_urls_admin_page()
{
    require_once EASY_UPDATE_URLS_PATH . "/dashboard/dashboard_container.php";
}
function easy_update_urls_settings_link($links)
{
    $settings_link = '<a href="admin.php?page=easy_update_urls_admin_page">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'easy_update_urls_settings_link');
/////////// Pointers ////////////////
// Pointer
register_activation_hook(__FILE__, 'easy_update_urls_activated');
function easy_update_urls_activated()
{
    $r = update_option('easy_update_urls_was_activated', '1');
    if (!$r) {
        add_option('easy_update_urls_was_activated', '1');
    }
    $pointers = get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true);
    $pointers = ''; // str_replace( 'plugins', '', $pointers );
    update_user_meta(get_current_user_id(), 'dismissed_wp_pointers', $pointers);
}
function easy_update_urls_dismissible_notice()
{
    $r = update_option('easy_update_urls_dismiss', false);
    if (!$r) {
        $r = add_option('easy_update_urls_dismiss', false);
    }
    wp_die(esc_attr($r));
}
add_action('wp_ajax_easy_update_urls_dismissible_notice', 'easy_update_urls_dismissible_notice');
if (get_option('easy_update_urls_dismiss', true) and is_admin())
    add_action('admin_notices', 'easy_update_urls_dismiss_admin_notice');
function easy_update_urls_dismiss_admin_notice()
{
    //if(!bill_check_resources(false))
    //   return;
?>
    <div id="easy_update_urls_an1" class="notice-warning notice is-dismissible">
        <p>
            Please, look the Easy Update URLs plugin Dashboard &nbsp;
            <a class="button button-primary" href="admin.php?page=easy_update_urls_admin_page">or click here</a>
        </p>
    </div>
<?php
    //endif;
}
require_once ABSPATH . 'wp-includes/pluggable.php';
if (is_admin() or is_super_admin()) {
    //$r = get_option('easy_update_urls_was_activated', '0') ;
    // die(var_export($r));
    if (get_option('easy_update_urls_was_activated', '0') == '1') {
        add_action('admin_enqueue_scripts', 'easy_update_urls_adm_enqueue_scripts2');
    }
}
function easy_update_urls_adm_enqueue_scripts2()
{
    // die(var_export(__LINE__));
    global $bill_current_screen;
    // wp_enqueue_style( 'wp-pointer' );
    wp_enqueue_script('wp-pointer');
    require_once ABSPATH . 'wp-admin/includes/screen.php';
    $myscreen = get_current_screen();
    $bill_current_screen = $myscreen->id;
    $dismissed_string = get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true);
    // $dismissed = explode(',', (string) get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
    // if (in_array('plugins', $dismissed)) {  
    if (!empty($dismissed_string)) {
        $r = update_option('easy_update_urls_was_activated', '0');
        if (!$r) {
            add_option('easy_update_urls_was_activated', '0');
        }
        return;
    }
    // die(var_export(__LINE__));
    add_action('admin_print_footer_scripts', 'easy_update_urls_admin_print_footer_scripts');
}
function easy_update_urls_admin_print_footer_scripts()
{
    global $bill_current_screen;
    $pointer_content = esc_attr__("Open Easy Update URLs Plugin Here!", "easy-update-urls");
    $pointer_content2 = esc_attr__("Just Click Over Tools => Easy Update URLs.", "easy-update-urls");
?>
    <script type="text/javascript">
        //<![CDATA[
        // setTimeout( function() { this_pointer.pointer( 'close' ); }, 400 );
        jQuery(document).ready(function($) {
            console.log('entrou');
            jQuery('.dashicons-admin-tools').pointer({
                content: '<?php echo '<h3>' . esc_attr($pointer_content) . '</h3>' . '<div id="bill-pointer-body">' . esc_attr($pointer_content2) . '</div>'; ?>',
                position: {
                    edge: 'left',
                    align: 'right'
                },
                close: function() {
                    // Once the close button is hit
                    jQuery.post(ajaxurl, {
                        pointer: '<?php echo esc_attr($bill_current_screen); ?>',
                        action: 'dismiss-wp-pointer'
                    });
                }
            }).pointer('open');
            jQuery('.wp-pointer').css("margin-left", "100px");
            jQuery('#wp-pointer-0').css("padding", "10px");
        });
        //]]>
    </script>
<?php
}

function easy_update_urls_check_wordpress_logged_in_cookie()
{
    // Percorre todos os cookies definidos
    foreach ($_COOKIE as $key => $value) {
        // Verifica se algum cookie começa com 'wordpress_logged_in_'
        if (strpos($key, 'wordpress_logged_in_') === 0) {
            // Cookie encontrado
            return true;
        }
    }
    // Cookie não encontrado
    return false;
}




// ---------------------------------- 2024  -------------------------------------
function easy_update_urls_new_more_plugins()
{
    $plugin = new easy_update_urls_Bill_show_more_plugins();
    $plugin->bill_show_plugins();
}

function easy_update_urls_bill_more()
{
    global $easy_update_urls_is_admin;
    //if (function_exists('is_admin') && function_exists('current_user_can')) {
    if ($easy_update_urls_is_admin and current_user_can("manage_options")) {
        $declared_classes = get_declared_classes();
        foreach ($declared_classes as $class_name) {
            if (strpos($class_name, "Bill_show_more_plugins") !== false) {
                //return;
            }
        }
        require_once dirname(__FILE__) . "/includes/more-tools/class_bill_more.php";
        //debug2(dirname(__FILE__) . "/includes/more-tools/class_bill_more.php");
    }
    // }
}

add_action("init", "easy_update_urls_bill_more", 5);





// -------------------------------------


function easy_update_urls_bill_hooking_diagnose()
{
    global $easy_update_urls_is_admin;
    // if (function_exists('is_admin') && function_exists('current_user_can')) {
    if ($easy_update_urls_is_admin and current_user_can("manage_options")) {
        $declared_classes = get_declared_classes();
        foreach ($declared_classes as $class_name) {
            if (strpos($class_name, "Bill_Diagnose") !== false) {
                return;
            }
        }
        $plugin_slug = 'recaptcha-for-all';
        $plugin_text_domain = $plugin_slug;
        $notification_url = "https://wpmemory.com/fix-low-memory-limit/";
        $notification_url2 =
            "https://wptoolsplugin.com/site-language-error-can-crash-your-site/";
        require_once dirname(__FILE__) . "/includes/diagnose/class_bill_diagnose.php";
    }
    // } 
}
add_action("init", "easy_update_urls_bill_hooking_diagnose", 10);
//
//



function easy_update_urls_bill_hooking_catch_errors()
{
    global $easy_update_urls_plugin_slug;

    $declared_classes = get_declared_classes();
    foreach ($declared_classes as $class_name) {
        if (strpos($class_name, "bill_catch_errors") !== false) {
            return;
        }
    }
    $easy_update_urls_plugin_slug = 'easy_update_urls';
    require_once dirname(__FILE__) . "/includes/catch-errors/class_bill_catch_errors.php";
}
add_action("init", "easy_update_urls_bill_hooking_catch_errors", 15);





// ------------------------

function easy_update_urls_load_feedback()
{
    global $easy_update_urls_is_admin;
    //if (function_exists('is_admin') && function_exists('current_user_can')) {
    if ($easy_update_urls_is_admin and current_user_can("manage_options")) {
        // ob_start();
        //
        require_once dirname(__FILE__) . "/includes/feedback-last/feedback-last.php";
        // ob_end_clean();
        //
    }
    //}
    //
}
add_action('wp_loaded', 'easy_update_urls_load_feedback', 10);


// ------------------------


function easy_update_urls_bill_install()
{
    global $easy_update_urls_is_admin;
    if ($easy_update_urls_is_admin and current_user_can("manage_options")) {
        $declared_classes = get_declared_classes();
        foreach ($declared_classes as $class_name) {
            if (strpos($class_name, "Bill_Class_Plugins_Install") !== false) {
                return;
            }
        }
        if (!function_exists('bill_install_ajaxurl')) {
            function bill_install_ajaxurl()
            {
                echo '<script type="text/javascript">
					var ajaxurl = "' .
                    esc_attr(admin_url("admin-ajax.php")) .
                    '";
					</script>';
            }
        }
        // ob_start();
        $plugin_slug = 'easy-update-urls';
        $plugin_text_domain = $plugin_slug;
        $notification_url = "https://wpmemory.com/fix-low-memory-limit/";
        $notification_url2 =
            "https://wptoolsplugin.com/site-language-error-can-crash-your-site/";
        $logo = EASY_UPDATE_URLS_IMAGES . '/logo.png';
        $plugin_adm_url = admin_url();
        require_once dirname(__FILE__) . "/includes/install-checkup/class_bill_install.php";
        // ob_end_clean();
    }
}
add_action('wp_loaded', 'easy_update_urls_bill_install', 15);


function easy_update_urls_localization_init()
{
    $path = EASY_UPDATE_URLS_PATH . 'language/';
    $locale = apply_filters('plugin_locale', determine_locale(), 'easy-update-urls');

    // Full path of the specific translation file (e.g., es_AR.mo)
    $specific_translation_path = $path . "easy-update-urls-$locale.mo";
    $specific_translation_loaded = false;

    // Check if the specific translation file exists and try to load it
    if (file_exists($specific_translation_path)) {
        $specific_translation_loaded = load_textdomain('easy-update-urls', $specific_translation_path);
    }

    // List of languages that should have a fallback to a specific locale
    $fallback_locales = [
        'de' => 'de_DE',  // German
        'fr' => 'fr_FR',  // French
        'it' => 'it_IT',  // Italian
        'es' => 'es_ES',  // Spanish
        'pt' => 'pt_BR',  // Portuguese (fallback to Brazil)
        'nl' => 'nl_NL'   // Dutch (fallback to Netherlands)
    ];

    // If the specific translation was not loaded, try to fallback to the generic version
    if (!$specific_translation_loaded) {
        $language = explode('_', $locale)[0];  // Get only the language code, ignoring the country (e.g., es from es_AR)
        
        if (array_key_exists($language, $fallback_locales)) {
            // Full path of the generic fallback translation file (e.g., es_ES.mo)
            $fallback_translation_path = $path . "easy-update-urls-{$fallback_locales[$language]}.mo";
            
            // Check if the fallback generic file exists and try to load it
            if (file_exists($fallback_translation_path)) {
                load_textdomain('easy-update-urls', $fallback_translation_path);
            }
        }
    }

    // Load the plugin
    load_plugin_textdomain('easy-update-urls', false, plugin_basename(EASY_UPDATE_URLS_PATH ) . '/language/');
}
if ($easy_update_urls_is_admin) {
    add_action('plugins_loaded', 'easy_update_urls_localization_init');
}

