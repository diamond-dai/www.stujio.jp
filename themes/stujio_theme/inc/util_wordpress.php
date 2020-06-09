<?php

function is_login_page()
{
    return in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php']);
}

/**
 * HTMLの特殊文字をエスケープして結果を出力
 */
function h($str)
{
    echo htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
/**
 * HTMLの特殊文字をエスケープして改行の前にbrタグを追加し、結果を出力
 */
function hbr($str)
{
    echo nl2br(htmlspecialchars($str, ENT_QUOTES, 'UTF-8'), true);
}
/**
 * HTMLの特殊文字をエスケープして結果を返却 通常は h() を使う
 */
function hdata($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * HTMLの特殊文字をエスケープ+改行をbrに変換して結果を返却 通常は h() を使う
 */
function hdatabr($str)
{
    return nl2br(htmlspecialchars($str, ENT_QUOTES, 'UTF-8'), true);
}

//スパム対策 メールアドレスをボットに拾われないように変換
function email_transformation($string)
{
    $string = str_replace('@', ' [at] ', $string);
    $string = str_replace('.', ' [dot] ', $string);
    return $string;
}

//テキストを1行毎に分割 改行コード混在に対応
function explode_lines($text)
{
    //str_replace ("検索文字列", "置換え文字列", "対象文字列");
    $cr = ["\r\n", "\r"];
    $text = str_replace($cr, "\n", $text);
    //改行コードで分割（結果は配列に入る）
    return explode("\n", $text);
}

function get_permalink_by_slug($slug)
{
    $page = get_page_by_path($slug);
    return get_permalink($page->ID);
}

//指定したスラッグを親に持つカテゴリをすべて取得
function getCategoryChilds($slug)
{
    $obj = get_category_by_slug($slug);
    $args = ['child_of' => $obj->term_id];
    return get_categories($args);
}

// postに設定されているpostidカテゴリの一覧を取得
// 親親カテゴリを指定した場合親カテゴリに含まれるものだけを取得
function getCategoryChildsByPostID($post_id, $parent)
{
    $cat = get_category_by_slug($parent);
    $parent_id = $cat->term_id;

    $results = [];
    $categorys = get_the_category($post_id);
    foreach ($categorys as $category) {
        if ($category->parent == $parent_id) {
            $results[] = $category;
        }
    }
    return $results;
}

// 曜日を取得
function get_week_ja($date)
{
    $week = ['日', '月', '火', '水', '木', '金', '土'];
    $w = date("w", strtotime($date));
    return $week[$w];
}
// 曜日を取得
function get_week_en($date)
{
    //Sunday (Sun.) Monday (Mon.) Tuesday (Tue.) Wednesday (Wed.) Thursday (Thu.) Friday (Fri.) Saturday (Sat.)
    $week = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    $w = date("w", strtotime($date));
    return $week[$w];
}


// メニューIDから メニュー名を取得
function get_menu_id_by_name($menu_name)
{
    if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
        $menu = wp_get_nav_menu_object($locations[$menu_name]);
        return $menu->term_id;
    } else {
        return null;
    }
}

function edit_menu_item($menu_item, $class = null, $sub_menu_html = null)
{
    $target = "";
    $classes = "";
    if (mb_strlen($menu_item->target) != 0) {
        $target = " target=\"$menu_item->target\"";
    }
    if (count($menu_item->classes) != 0) {
        foreach ($menu_item->classes as $menu_class) {
            $classes .= "$menu_class ";
        }
    }
    $classes = " class=\"$class $classes\"";
    $content = "<li$classes><a href=\"$menu_item->url\" $target>$menu_item->title</a>$sub_menu_html</li>\n";
    return $content;
}

function get_breadcrumb_list()
{
    $breadcrumb_list = [];
    $breadcrumb_item = [];
    $position = 1;

    global $post;

    if (!is_home() && !is_admin()) {
        $breadcrumb_item['url'] = home_url();
        $breadcrumb_item['label'] = 'ホーム';
        $breadcrumb_item['position'] = $position;
        $breadcrumb_list[] = $breadcrumb_item;
        $position++;

        if (is_page()) {
            if ($post->post_parent != 0) {
                $ancestors = array_reverse(get_post_ancestors($post->ID));
                foreach ($ancestors as $ancestor) {
                    $breadcrumb_item['url'] = get_permalink($ancestor);
                    $breadcrumb_item['label'] = get_the_title($ancestor);
                    $breadcrumb_item['position'] = $position;
                    $breadcrumb_list[] = $breadcrumb_item;
                    $position++;
                }
            }
            $breadcrumb_item['url'] = get_permalink($post->ID);
            $breadcrumb_item['label'] = get_the_title($post->ID);
            $breadcrumb_item['position'] = $position;
            $breadcrumb_list[] = $breadcrumb_item;
            $position++;
        } elseif (is_single()) {
            $categories = get_the_category($post->ID);
            $cat = $categories[0];
            $type_obj = get_post_type_object(get_post_type());
            $breadcrumb_item['url'] = "/{$type_obj->name}";
            $breadcrumb_item['label'] = $type_obj->label;
            $breadcrumb_item['position'] = $position;
            $breadcrumb_list[] = $breadcrumb_item;
            $position++;
            //カテゴリリストは取得しない

            $breadcrumb_item['url'] = get_permalink($ancestor);
            $breadcrumb_item['label'] = get_the_title($ancestor);
            $breadcrumb_item['position'] = $position;
            $breadcrumb_list[] = $breadcrumb_item;
            $position++;
        } elseif (is_archive()) {
            // post_type
            $type_obj = get_post_type_object(get_post_type());
            $breadcrumb_item['url'] = "/{$type_obj->name}";
            $breadcrumb_item['label'] = $type_obj->label;
            $breadcrumb_item['position'] = $position;
            $breadcrumb_list[] = $breadcrumb_item;
            $position++;
            // tax
            if (is_tax()) {
                // archivesのタームを取得
                global $wp_query;
                $term = $wp_query->queried_object;
                $breadcrumb_item['url'] = "/{$term->taxonomy}";
                $breadcrumb_item['label'] = $term->name;
                $breadcrumb_item['position'] = $position;
                $breadcrumb_list[] = $breadcrumb_item;
                $position++;
            }
        }
    }
    return $breadcrumb_list;
}


// パンくずリスト
function breadcrumb()
{
    $item_template = "<li itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/ListItem\">
    <a itemprop=\"item\" href=\"%s\">
      <span itemprop=\"name\">%s</span>
    </a>
    <meta itemprop=\"position\" content=\"%d\" />
  </li>";

    $breadcrumb_list = get_breadcrumb_list();

    for ($i = 0; $i < count($breadcrumb_list); $i++) {
        // var_dump($breadcrumb_list[$i]) ;
        $str .= sprintf(
            $item_template,
            $breadcrumb_list[$i]['url'],
            $breadcrumb_list[$i]['label'],
            $breadcrumb_list[$i]['position']
        );
    }

    echo "<div class=\"breadcrumb\"><ul class=\"breadcrumb-list\" itemscope itemtype=\"http://schema.org/BreadcrumbList\">{$str}</ul></div>";
}


// ページネーション表示
// WP_Queryとメインループの差異を吸収
// function echo_custom_pagenate($label_prev, $label_next, $type = 'array', $anchor_id = '', $the_query = null)
function echo_custom_pagenate($label_prev, $label_next, $the_query = null)
{
    if ($the_query != null) {
        $max_page = $the_query->max_num_pages;
    } else {
        global $wp_query;
        $max_page = $wp_query->max_num_pages;
    }
    $big = 999999999; // need an unlikely integer
    $paginate_list = paginate_links(
        [
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            // 'type' => $type,
            'prev_text'  => $label_prev,
            'next_text'  => $label_next,
            'total' => $max_page
        ]
    );
    echo $paginate_list;
    // if (!empty($paginate_list)) {
    //     if ($anchor_id === '') {
    //         echo implode($paginate_list);
    //     } else {
    //         foreach ($paginate_list as $value) {
    //             // [ " ] と [ ' ] が混在してるので[ ' ]に統一してから正規表現で置換
    //             $value = str_replace('"', "'", $value);
    //             preg_match("/href='(.*)'/", $value, $match);
    //             if ($match) {
    //                 // var_dump($match[1]);
    //                 $url = $match[1] . $anchor_id;
    //                 // var_dump($url);
    //                 $replace =  "href='{$url}'";
    //                 $value = preg_replace("/href='(.*)'/u", $replace, $value);
    //             }
    //             echo $value;
    //         }
    //     }
    // }
}
