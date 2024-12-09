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

<h2><?php esc_attr_e('Welcome to Easy Update URLs!', 'easy-update-urls'); ?></h2>

<p><?php esc_attr_e('Thank you for choosing Easy Update URLs. This plugin is not only perfect for domain migrations or switching from HTTP to HTTPS, but it’s also a powerful tool for restructuring your website, fixing broken links, and performing mass content updates, as WordPress stores page and post content in the database.', 'easy-update-urls'); ?></p>

<h3><?php esc_attr_e('Why Easy Update URLs?', 'easy-update-urls'); ?></h3>

<p><?php esc_attr_e('WordPress stores page and post content in the database, so when you need to make widespread changes, manual updates can be time-consuming and prone to errors.', 'easy-update-urls'); ?></p>
<p><?php esc_attr_e('This plugin enables you to perform search and replace operations directly within your WordPress database, ensuring that all your content is updated consistently and accurately.', 'easy-update-urls'); ?></p>

<h3><?php esc_attr_e('Key Features:', 'easy-update-urls'); ?></h3>
<ul>
    <li><?php esc_attr_e('Site Restructuring: Seamlessly update URLs during domain migrations, when reorganizing categories, changing permalinks, or altering internal link structures.', 'easy-update-urls'); ?></li>
    <li><?php esc_attr_e('Database-wide Search and Replace: Quickly replace old URLs, paths, or any other content stored in your database across posts, pages, and custom fields.', 'easy-update-urls'); ?></li>
    <li><?php esc_attr_e('Flexible Targeting: Choose which content types to update, allowing you to target specific areas like posts, pages, or custom post types.', 'easy-update-urls'); ?></li>
</ul>


<h3><?php esc_attr_e('Important Reminder: Backup Your Database First!', 'easy-update-urls'); ?></h3>

<p><?php esc_attr_e('Editing your database comes with inherent risks and can potentially break your site, so it’s crucial to ensure your data is safe. We strongly recommend that you backup your database before making any changes.', 'easy-update-urls'); ?></p>


<a href="tools.php?page=easy_update_urls_admin_page&tab=more&_wpnonce=<?php echo esc_attr($nonce); ?>">

    <p><?php esc_attr_e('You can install our Free Database Backup plugin with just one click, providing you with a reliable backup solution to keep your site secure. This should always be your first step before using Easy Update URLs. Click This Link.', 'easy-update-urls'); ?></p>

</a></p>

<h3><?php esc_attr_e('How to Use:', 'easy-update-urls'); ?></h3>
<ol>
    <li><?php esc_attr_e('Install the Database Backup Plugin', 'easy-update-urls'); ?></li>
    <li><?php esc_attr_e('Backup Your Database: Always backup your database to protect against any potential issues.', 'easy-update-urls'); ?></li>
    <li><?php esc_attr_e('Go to Tab Update URLs (above) and enter Search and Replace Terms: Specify the content you want to search for and what you’d like to replace it with.', 'easy-update-urls'); ?></li>
    <li><?php esc_attr_e('Choose which URLs or content should be updated: Select specific areas of your site, such as Content/URLs in posts, pages, custom post types, revisions, excerpts, links, attachments (images, documents, media), custom fields, meta boxes, and even GUIDs (only on development sites).', 'easy-update-urls'); ?></li>
</ol>

<h3><?php esc_attr_e('Need Help?', 'easy-update-urls'); ?></h3>

<?php
// Output translatable string for the help section
esc_attr_e('Visit the plugin site for FAQ Page and more details.', 'easy-update-urls');

// Output button with translatable text
echo '<br><br>';
echo '<a href="https://easyupdateurls.com/" class="button button-primary">' . esc_attr__('Plugin Site', 'easy-update-urls') . '</a>';
echo '&nbsp;&nbsp;';

echo '</div>';  // Closing database-description div
echo '</div>';  // Closing wrap-easy-update-urls div
?>