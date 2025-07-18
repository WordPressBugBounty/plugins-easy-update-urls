<?php

/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2022 www.BillMinozzi.com
 * Created: 2023 - Jan 16 23
 * 
 */

if (!defined('ABSPATH')) {
    die(esc_attr__('We\'re sorry, but you cannot directly access this file.', 'easy-update-urls'));
}



echo '<div class="wrap-easy-update-urls">' . "\n";
echo '<div class="database-description">';

// Ensure that all translatable strings are properly escaped using esc_attr__() and esc_attr_e()
// These functions ensure that translated text is securely escaped, especially in attributes

?>

<h2><?php esc_attr_e('A Powerful Search & Replace Tool for Your Database', 'easy-update-urls'); ?></h2>

<p><?php esc_attr_e('Welcome! While its name highlights URL updates, this plugin is a comprehensive Search and Replace tool for your entire WordPress database. It is expertly designed to find and replace any text, from URLs and image paths to recurring phrases or old branding, making it indispensable for site migrations, content overhauls, and routine maintenance.', 'easy-update-urls'); ?></p>

<h3><?php esc_attr_e('Why You Need a Database Search & Replace Tool', 'easy-update-urls'); ?></h3>

<p><?php esc_attr_e('WordPress stores all your content, settings, and links in the database. When you need to change a piece of text that appears in many places—like an old company name, a deprecated shortcode, or a simple typo—updating each instance manually is tedious and prone to errors.', 'easy-update-urls'); ?></p>
<p><?php esc_attr_e('This plugin empowers you to perform these mass updates directly within the database safely and efficiently. You can change any string of text across your entire site with just a few clicks, ensuring complete and consistent results without writing a single line of SQL code.', 'easy-update-urls'); ?></p>

<h3><?php esc_attr_e('Key Features:', 'easy-update-urls'); ?></h3>
<ul>
    <li><?php esc_attr_e('Comprehensive Search & Replace: Find and replace any text string across all your database tables. Perfect for mass content revisions, correcting widespread typos, or updating branding information.', 'easy-update-urls'); ?></li>
    <li><?php esc_attr_e('Effortless Site Migration: While its power is broad, it excels at its original purpose: seamlessly updating URLs and file paths when moving a WordPress site to a new domain or server.', 'easy-update-urls'); ?></li>
    <li><?php esc_attr_e('Bulk Content Management: Quickly update outdated information, fix broken links, change affiliate codes, or modify any recurring content within your posts, pages, and custom fields.', 'easy-update-urls'); ?></li>
</ul>


<h3><?php esc_attr_e('Important Reminder: Always Backup Your Database First!', 'easy-update-urls'); ?></h3>

<p><?php esc_attr_e('Directly modifying your database is a powerful action that carries inherent risks. A mistake could potentially disrupt your site. To protect your work, we strongly recommend you create a complete database backup before proceeding with any changes.', 'easy-update-urls'); ?></p>


<a href="tools.php?page=easy_update_urls_admin_page&tab=more&_wpnonce=<?php echo esc_attr($nonce); ?>">

    <p><?php esc_attr_e('For your peace of mind, you can install our free Database Backup plugin with a single click. This provides a reliable, one-step backup solution. We advise making this your first step. Click this link to install.', 'easy-update-urls'); ?></p>

</a></p>

<h3><?php esc_attr_e('How to Use:', 'easy-update-urls'); ?></h3>
<ol>
    <li><?php esc_attr_e('Install our recommended FREE Database Backup Plugin.', 'easy-update-urls'); ?></li>
    <li><?php esc_attr_e('Backup Your Database: Secure your site by creating a fresh backup before you begin.', 'easy-update-urls'); ?></li>
    <li><?php esc_attr_e('Go to the "Update" Tab: Enter the exact text you want to find in the "Search for" field and the new text in the "Replace with" field.', 'easy-update-urls'); ?></li>
</ol>

<h3><?php esc_attr_e('Need Help?', 'easy-update-urls'); ?></h3>

<?php
// Output translatable string for the help section
esc_attr_e('Visit the plugin site for our FAQ Page and more detailed information.', 'easy-update-urls');

// Output button with translatable text
echo '<br><br>';
echo '<a href="https://easyupdateurls.com/" class="button button-primary">' . esc_attr__('Plugin Site', 'easy-update-urls') . '</a>';
echo '  ';

echo '</div>';  // Closing database-description div
echo '</div>';  // Closing wrap-easy-update-urls div
?>