<?php

/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2022 www.BillMinozzi.com
 * Created: 2023 - Jan 16 23
 * 
 */
if (!defined('ABSPATH')) {
  die('We\'re sorry, but you can not directly access this file.');
}

// https://minozzi.eu/wp-admin/tools.php?page=update_urls_admin_page&tab=update
?>


<div id="easy-update-urls-logo">
  <img src="<?php echo esc_attr(EASY_UPDATE_URLS_IMAGES); ?>/logo.png" width="250">
</div>
<?php


if (isset($_GET['tab']))
  $active_tab = sanitize_text_field($_GET['tab']);
else
  $active_tab = 'dashboard';



$nonce = wp_create_nonce('easy-update-url');
if (isset($_GET['tab']) and !wp_verify_nonce($nonce, 'easy-update-url')) {
  echo '<div class="error"><p>Invalid Nonce!!</p></div>';
  die();
} else {
  if (isset($_GET['tab']))
    $active_tab = sanitize_text_field($_GET['tab']);
  else
    $active_tab = 'dashboard';
}


?>
<h2 class="nav-tab-wrapper">

  <a href="tools.php?page=easy_update_urls_admin_page&tab=dashboard&_wpnonce=<?php echo esc_attr($nonce); ?>" class="nav-tab">Dashboard</a>
  <a href="tools.php?page=easy_update_urls_admin_page&tab=update&_wpnonce=<?php echo esc_attr($nonce); ?>" class="nav-tab">Update URLs</a>
  <a href="tools.php?page=easy_update_urls_admin_page&tab=more&_wpnonce=<?php echo esc_attr($nonce); ?>" class="nav-tab">More Tools</a>

</h2>
<?php

echo '<div id="easy-update-urls-dashboard-wrap">';
echo '<div id="easy-update-urls-dashboard-left">';

if ($active_tab == 'update') {
  require_once(EASY_UPDATE_URLS_PATH . 'dashboard/update.php');
} elseif ($active_tab == 'more') {
  require_once(EASY_UPDATE_URLS_PATH . 'dashboard/more.php');
} else {
  require_once(EASY_UPDATE_URLS_PATH . 'dashboard/dashboard.php');
}

echo '</div> <!-- "easy-update-urls-dashboard-left"> -->';
echo '<div id="easy-update-urls-dashboard-right">';
echo '<div id="easy-update-urls-containerright-dashboard">';
require_once(EASY_UPDATE_URLS_PATH . 'dashboard/mybanners.php');
echo '</div>';
echo '</div> <!-- "easy-update-urls-dashboard-right"> -->';
echo '</div> <!-- "easy-update-urls-dashboard-wrap"> -->';
