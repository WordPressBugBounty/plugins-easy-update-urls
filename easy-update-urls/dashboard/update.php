<?php
if (!defined("ABSPATH")) {
    die('We\'re sorry, but you can not directly access this file.');
}

if (!current_user_can('administrator')) {
    wp_die('You do not have sufficient permissions to access this page.');
}

echo '<h2 class="title">' . esc_attr__('Search/Replace', 'easy-update-urls') . '</h2>' . "\n";

if (isset($_POST['process']) && sanitize_text_field($_POST['process']) == 'run_update_url' && !check_admin_referer("easy_update_urls_submit", "easy_update_urls_nonce")) {
    easy_update_urls_error(esc_html__('Please try again.', 'easy-update-urls'));
} elseif (isset($_POST['process']) && sanitize_text_field($_POST['process']) == 'run_update_url' && !isset($_POST["easy_update_urls_update_links"])) {
    easy_update_urls_error(esc_html__('Please select at least one checkbox.', 'easy-update-urls'));
} elseif (isset($_POST['process']) && sanitize_text_field($_POST['process']) == 'run_update_url') {
    if (isset($_POST["easy_update_urls_update_links"]) && is_array($_POST["easy_update_urls_update_links"])) {
        $easy_update_urls_update_links = array_map('sanitize_text_field', $_POST["easy_update_urls_update_links"]);
    }

    $easy_update_urls_oldurl = isset($_POST["easy_update_urls_oldurl"]) ? trim(sanitize_text_field($_POST["easy_update_urls_oldurl"])) : '';
    $easy_update_urls_newurl = isset($_POST["easy_update_urls_newurl"]) ? trim(sanitize_text_field($_POST["easy_update_urls_newurl"])) : '';

    if (
        $easy_update_urls_oldurl &&
        $easy_update_urls_oldurl != "https://www.oldurl.com" &&
        trim($easy_update_urls_oldurl) != "" &&
        $easy_update_urls_newurl &&
        $easy_update_urls_newurl != "https://www.newurl.com" &&
        trim($easy_update_urls_newurl) != ""
    ) {
        $results = easy_update_urls_run(
            $easy_update_urls_update_links,
            $easy_update_urls_oldurl,
            $easy_update_urls_newurl
        );
        $empty = true;
        //$emptystring = '<strong>' . esc_html__('0 URLs updated. This happens if a URL is incorrect OR if it is not found in the content. Check your URLs and try again.', 'easy-update-urls') . '</strong><br/>';
        $emptystring = '<strong>' . esc_html__('0 terms updated. This happens if the search term is incorrect OR if it is not found in the content. Check your terms and try again.', 'easy-update-urls') . '</strong><br/>';

        $resultstring = "";

        foreach ($results as $result) {
            $empty = $result[0] != 0 || $empty == false ? false : true;
            $resultstring .= "<br/><strong>" . $result[0] . "</strong> " . $result[1];
        }



        if ($empty) : ?>

            <!-- MUDANÇA 1: A classe agora é "updated" (verde), indicando um status, não um erro. -->
            <div id="message" class="updated fade">
                <p>
                    <?php
                    // MUDANÇA 2: A mensagem de erro foi removida e substituída pela variável
                    // $emptystring, que contém a mensagem informativa e correta.
                    echo wp_kses(
                        $emptystring,
                        [
                            'strong' => [],
                            'br'     => [],
                        ]
                    );
                    ?>
                </p>
            </div>

        <?php else : ?>

            <!-- O bloco 'else' (sucesso com atualizações) permanece o mesmo. Nenhuma alteração aqui. -->
            <div id="message" class="updated fade">
                <table>
                    <tr>
                        <td>
                            <p><strong>
                                    <?php esc_attr_e("Success! Your URLs have been updated.", "easy-update-urls"); ?>
                                </strong></p>
                            <p><u>
                                    <?php esc_attr_e("Results", "easy-update-urls"); ?>
                                </u><?php echo wp_kses($resultstring, array(
                                        'strong' => array('align' => array()),
                                        'br' => array('align' => array())
                                    )); ?></p>
                            <?php echo $empty ? "<p>" . wp_kses($emptystring, array(
                                'strong' => array('align' => array()),
                                'br' => array('align' => array())
                            )) . "</p>" : ""; ?>
                        </td>
                        <td width="60"></td>
                        <td align="center">
                            <?php if (!$empty) : ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
    <?php endif;
    } else {
        echo '<div id="message" class="error fade"><p><strong>' . esc_attr__('ERROR', 'easy-update-urls') . ' - ' . esc_attr__('Your URLs have not been updated.', 'easy-update-urls') . '</p></strong><p>' . esc_attr__("Please enter a value in both the 'Search For' and 'Replace With' fields.", 'easy-update-urls') . '</p></div>';
    }
} else {
    echo '<form id="easy-update-urls-form-run" method="post" action="admin.php?page=easy_update_urls_admin_page&tab=update">';
    echo '<input type="hidden" name="process" value="run_update_url" />';
    echo "<big>";
    echo '<div id="easy-update-urls-help-run">';
    echo "<br>";
    echo esc_attr__("Define the search and replace terms below.", "easy-update-urls");
    echo "</div>";
    echo "</big>";
    ?>
    <table class="form-table">
        <tr valign="middle">
            <th scope="row" width="140" style="width:140px"><strong>
                    <?php esc_attr_e("Search For", "easy-update-urls"); ?>
                </strong><br />
                <span class="description"></span>
            </th>
            <td><input name="easy_update_urls_oldurl" type="text" id="easy_update_urls_oldurl" value="<?php echo (isset($easy_update_urls_oldurl) && trim($easy_update_urls_oldurl) != '') ? esc_url_raw($easy_update_urls_oldurl) : 'https://www.oldurl.com'; ?>" style="width:300px;font-size:20px;" onfocus="if(this.value=='https://www.oldurl.com') this.value='';" onblur="if(this.value=='') this.value='https://www.oldurl.com';" /></td>
        </tr>
        <tr valign="middle">
            <th scope="row" width="140" style="width:140px"><strong>
                    <?php esc_attr_e("Replace Width", "easy-update-urls"); ?>
                </strong><br />
                <span class="description"></span>
            </th>
            <td><input name="easy_update_urls_newurl" type="text" id="easy_update_urls_newurl" value="<?php echo (isset($easy_update_urls_newurl) && trim($easy_update_urls_newurl) != '') ? esc_url_raw($easy_update_urls_newurl) : 'https://www.newurl.com'; ?>" style="width:300px;font-size:20px;" onfocus="if(this.value=='https://www.newurl.com') this.value='';" onblur="if(this.value=='') this.value='https://www.newurl.com';" /></td>
        </tr>
    </table>
    <?php
    echo "<big>";
    echo '<div id="easy-update-urls-help-run">';
    echo "<br>";
    echo esc_attr__("Choose which Content/URLs should be updated", "easy-update-urls");
    echo "</div>";
    echo "</big>";
    ?>
    <table class="form-table">
        <tr>
            <td>
                <p style="line-height:20px;">
                    <input name="easy_update_urls_update_links[]" type="checkbox" id="easy_update_urls_update_true" value="content" checked="checked" />
                    <label for="easy_update_urls_update_true"><strong>
                            <?php esc_attr_e("Content/URLs in page content", "easy-update-urls"); ?>
                        </strong> (
                        <?php esc_attr_e("posts, pages, custom post types, revisions", "easy-update-urls"); ?>
                        )</label>
                    <br />
                    <input name="easy_update_urls_update_links[]" type="checkbox" id="easy_update_urls_update_true1" value="excerpts" />
                    <label for="easy_update_urls_update_true1"><strong>
                            <?php esc_attr_e("Content/URLs in excerpts", "easy-update-urls"); ?>
                        </strong></label>
                    <br />
                    <input name="easy_update_urls_update_links[]" type="checkbox" id="easy_update_urls_update_true2" value="links" />
                    <label for="easy_update_urls_update_true2"><strong>
                            <?php esc_attr_e("Content/URLs in links", "easy-update-urls"); ?>
                        </strong></label>
                    <br />
                    <input name="easy_update_urls_update_links[]" type="checkbox" id="easy_update_urls_update_true3" value="attachments" />
                    <label for="easy_update_urls_update_true3"><strong>
                            <?php esc_attr_e("Content/URLs for attachments", "easy-update-urls"); ?>
                        </strong> (
                        <?php esc_attr_e("images, documents, general media", "easy-update-urls"); ?>
                        )</label>
                    <br />
                    <input name="easy_update_urls_update_links[]" type="checkbox" id="easy_update_urls_update_true4" value="custom" />
                    <label for="easy_update_urls_update_true4"><strong>
                            <?php esc_attr_e("Content/URLs in custom fields and meta boxes", "easy-update-urls"); ?>
                        </strong></label>
                    <br />
                    <input name="easy_update_urls_update_links[]" type="checkbox" id="easy_update_urls_update_true5" value="guids" />
                    <label for="easy_update_urls_update_true5"><strong>
                            <?php esc_attr_e("Update ALL GUIDs", "easy-update-urls"); ?>
                        </strong> <span class="description" style="color:#f00;">
                            <?php esc_attr_e("GUIDs for posts should only be changed on development sites.", "easy-update-urls"); ?>
                        </span> <a href="https://wordpress.org/documentation/article/changing-the-site-url/" target="_blank">
                            <?php esc_attr_e("Learn More.", "easy-update-urls"); ?>
                        </a></label>
                </p>
            </td>
        </tr>
    </table>
    <div id="easy-update-urls-spinner">
        <img id="easy-update_urls_snake" src="<?php echo esc_attr(EASY_UPDATE_URLS_IMAGES); ?>/snake.gif" width="32">
    </div>
<?php
    echo "<br><big><strong><span style='color: red;'>" . esc_attr__('Run a backup of your database before beginning!', 'easy-update-urls') . "</span></strong></big>";
    echo "<br>" . esc_attr__("After click, please, wait a few seconds... and don't reload page neither click back or stop in your browser.", 'easy-update-urls');
    echo "</big><br>";
    wp_nonce_field('easy_update_urls_submit', 'easy_update_urls_nonce');
    echo '<input id="easy-update-urls-run-update" class="easy-update-urls-submit button-primary" type="submit" value="Update URLs Now"> ';
    echo "</form>" . "\n";
}

return;

function easy_update_urls_run($options, $oldurl, $newurl)
{
    $start_time = microtime(true);
    global $wpdb;
    $results = array();
    $queries = array(
        'content' => array("UPDATE $wpdb->posts SET post_content = replace(post_content, %s, %s)", __('Content Items (Posts, Pages, Custom Post Types, Revisions)', 'easy-update-urls')),
        'excerpts' => array("UPDATE $wpdb->posts SET post_excerpt = replace(post_excerpt, %s, %s)", __('Excerpts', 'easy-update-urls')),
        'attachments' => array("UPDATE $wpdb->posts SET guid = replace(guid, %s, %s) WHERE post_type = 'attachment'", __('Attachments', 'easy-update-urls')),
        'links' => array("UPDATE $wpdb->links SET link_url = replace(link_url, %s, %s)", __('Links', 'easy-update-urls')),
        'custom' => array("UPDATE $wpdb->postmeta SET meta_value = replace(meta_value, %s, %s)", __('Custom Fields', 'easy-update-urls')),
        'guids' => array("UPDATE $wpdb->posts SET guid = replace(guid, %s, %s)", __('GUIDs', 'easy-update-urls'))
    );

    foreach ($options as $option) {
        if ($option == "custom") {
            $n = 0;
            $row_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->postmeta");
            $page_size = 10000;
            $pages = ceil($row_count / $page_size);

            for ($page = 0; $page < $pages; $page++) {
                $current_row = 0;
                $start = $page * $page_size;
                $end = $start + $page_size;
                $items = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_value <> ''");

                foreach ($items as $item) {
                    $value = $item->meta_value;
                    if (trim($value) == "") {
                        continue;
                    }
                    $edited = easy_update_urls_unserialize_replace($oldurl, $newurl, $value);
                    if ($edited != $value) {
                        $fix = $wpdb->query($wpdb->prepare(
                            "UPDATE `$wpdb->postmeta` SET meta_value = %s WHERE meta_id = %s",
                            $edited,
                            $item->meta_id
                        ));
                        if ($fix) {
                            $n++;
                        }
                    }
                }
            }
            $results[$option] = [$n, $queries[$option][1]];
        } else {
            $result = $wpdb->query($wpdb->prepare($queries[$option][0], $oldurl, $newurl));
            $results[$option] = [$result, $queries[$option][1]];
        }
    }
    return $results;
}

function easy_update_urls_unserialize_replace($from = "", $to = "", $data = "", $serialised = false)
{
    try {
        if (false !== is_serialized($data)) {
            $unserialized = unserialize($data);
            $data = easy_update_urls_unserialize_replace($from, $to, $unserialized, true);
        } elseif (is_array($data)) {
            $_tmp = [];
            foreach ($data as $key => $value) {
                $_tmp[$key] = easy_update_urls_unserialize_replace($from, $to, $value, false);
            }
            $data = $_tmp;
            unset($_tmp);
        } else {
            if (is_string($data)) {
                $data = str_replace($from, $to, $data);
            }
        }
        if ($serialised) {
            return serialize($data);
        }
    } catch (Exception $error) {
    }
    return $data;
}

function easy_update_urls_error($error_txt)
{
    echo '<div class="easy_update_urls">' . esc_attr__("ERROR", "easy-update-urls") . " - " . esc_attr($error_txt) . "</div>";
}
