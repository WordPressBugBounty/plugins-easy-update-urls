<?php

/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2021-03-02 12:33:13
 */
if (!defined('ABSPATH')) {
    die('We\'re sorry, but you can not directly access this file.');
}


echo '<div class="wrap-easy-update-urls">' . "\n";
echo '<h2 class="title">Useful free plugins from the same Author</h2>';



echo '<div class="database-description">';


if(!is_multisite()){
    easy_update_urls_new_more_plugins();
}
else
{
 
    //wp_redirect('https://siterightaway.net/freebies/');
    ?>
    <script>
    window.location.href = 'https://siterightaway.net/freebies/';
    </script>
    <?php

}





echo '</div>';
echo '</div>';


















