<?php

// iframeが特権管理者しか使用できないことへの対策
add_filter('content_save_pre', function ($content) {
    global $allowedposttags;

    // iframeとiframeで使える属性を指定する
    $allowedposttags['iframe'] = array(
        'class' => [], 'src' => [], 'width' => [],
        'height' => [], 'frameborder' => [], 'scrolling' => [], 'marginheight' => [],
        'marginwidth' => []
    );

    return $content;
});


add_filter('excerpt_length', function ($length) {
    return 90;
}, 100);

add_filter('excerpt_more', function ($more) {
    return '…';
});


// ダッシュボードウィジェット非表示
add_action('wp_dashboard_setup', function () {
    if (!current_user_can('level_11')) { //level11未満のユーザーの場合ウィジェットをunsetする 要するに管理者も含む
        global $wp_meta_boxes;
        //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // 現在の状況
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // 最近のコメント
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // 被リンク
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); // プラグイン
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // クイック投稿
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); // 最近の下書き
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // WordPressブログ
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); // WordPressフォーラム
    }
});



// メニューを非表示にする
add_action('admin_menu', function () {
    if (!current_user_can('level_8')) { //level8未満のユーザーの場合ウィジェットを非表示にする // level11の場合は管理者も含む
        $restricted = array(
            __('ダッシュボード'),
            //__('メディア'),
            __('投稿'),
            //__('ユーザー'),
            __('固定ページ'),
            __('ツール'),
            __('コメント'),
            __('プロフィール'),
            __('お問い合わせ'),
            __('外観'),
            __('テーマ'),
        );
    } else { //それ以外、要するに管理者
        $restricted = array(
            //__('ダッシュボード'),
            //__('メディア'),
            __('投稿'),
            //__('ユーザー'),
            //__('固定ページ'),
            //__('ツール'),
            __('コメント'),
            __('プロフィール'),
            //__('外観')
        );
    }
    global $menu;
    end($menu);
    while (prev($menu)) {
        $value = explode(' ', $menu[key($menu)][0]);
        if (in_array($value[0] != null ? $value[0] : "", $restricted)) {
            unset($menu[key($menu)]);
        }
    }
});


// エディタに現在のスタイルを適用
// add_editor_style('style-editor.css');

//TinyMCEのタグ変更
add_filter('tiny_mce_before_init', function ($initArray) {
    $initArray['block_formats'] = '段落=p;大見出し=h2;中見出し=h3;小見出し=h4';
    $initArray['body_id'] = 'contents-main';    // コンテンツエリアのid指定
    $initArray['body_class'] = 'post content-main';    // コンテンツエリアのclass指定

    return $initArray;
});


//
// /**
//  * 投稿のアーカイブページを設定
//  */
// add_filter('register_post_type_args', function($args, $post_type) {
//     if ('post' == $post_type) {
//         global $wp_rewrite;
//         $archive_slug = 'news';
//         $args['label'] = 'お知らせ';
//         $args['has_archive'] = $archive_slug;
//         $archive_slug = $wp_rewrite->root.$archive_slug;
//         $feeds = '(' . trim( implode('|', $wp_rewrite->feeds) ) . ')';
//         add_rewrite_rule("{$archive_slug}/?$", "index.php?post_type={$post_type}", 'top');
//         add_rewrite_rule("{$archive_slug}/feed/{$feeds}/?$", "index.php?post_type={$post_type}".'&feed=$matches[1]', 'top');
//         add_rewrite_rule("{$archive_slug}/{$feeds}/?$", "index.php?post_type={$post_type}".'&feed=$matches[1]', 'top');
//         add_rewrite_rule("{$archive_slug}/{$wp_rewrite->pagination_base}/([0-9]{1,})/?$", "index.php?post_type={$post_type}".'&paged=$matches[1]', 'top');
//     }
//     return $args;
// }, 10, 2);

//------------------------------------------------
// headの最適化 開始
// headの余計なタグを無効化
//------------------------------------------------
// サイト全体へのfeedを出力する。
remove_action('wp_head', 'feed_links', 2);

// その他のフィード（カテゴリー等）へのリンクを表示
// remove_action('wp_head', 'feed_links_extra', 3);

// 外部ツールを使ったブログ更新用のURL
remove_action('wp_head', 'rsd_link');

// wlwmanifestWindows Live Writerを使った記事投稿URL
remove_action('wp_head', 'wlwmanifest_link');

// linkタグを出力。出力されたリンク先が、現在の文書に対する「索引（インデックス）」であることを示す。
remove_action('wp_head', 'index_rel_link');

// ブラウザが先読みするためlink rel="next"などのタグを吐き出す。FireFoxなどではサーバーかける負荷があがるとも。
remove_action('wp_head', 'parent_post_rel_link', 10, 0);

remove_action('wp_head', 'start_post_rel_link', 10, 0);

// 該当記事の前と後の記事のURL
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

// デフォルトパーマリンクのURL(?p=[投稿ID])
remove_action('wp_head', 'wp_shortlink_wp_head');

// WordPressのバージョン情報
remove_action('wp_head', 'wp_generator');

//------------------------------------------------
//    headの最適化 終了
//------------------------------------------------

// コメントの停止
add_filter('comments_open', function ($open, $post_id) {
    $post = get_post($post_id);
    if ($post->post_type == 'any') {         // 全てのページのコメントを停止
        return false;
    }
    return $open;
}, 10, 2);

// //レンダリングブロックしているJavascriptの読み込みを遅らせる
// function move_scripts_head_to_footer_ex()
// {
//     //ヘッダーのスクリプトを取り除く
//     remove_action('wp_head', 'wp_print_scripts');
//     remove_action('wp_head', 'wp_print_head_scripts', 9);
//     remove_action('wp_head', 'wp_enqueue_scripts', 1);

//     //フッターにスクリプトを移動する
//     add_action('wp_footer', 'wp_print_scripts', 5);
//     add_action('wp_footer', 'wp_print_head_scripts', 5);
//     add_action('wp_footer', 'wp_enqueue_scripts', 5);
// }
// add_action('wp_enqueue_scripts', 'move_scripts_head_to_footer_ex');



//アイキャッチ画像とカスタムフィールドを投稿一覧に表示
add_filter('manage_posts_columns', function ($columns) {
    global $post;
    $columns['thumbnail'] = __('Thumbnail');
    return $columns;
});
add_action('manage_posts_custom_column', function ($column_name, $post_id) {
    if ('thumbnail' == $column_name) {
        $data = get_the_post_thumbnail($post_id, [100, 100], 'thumbnail');
    }
    if (isset($data) && $data) {
        echo $data;
    }
}, 10, 2);


//スラッグ、テンプレート名をページ一覧に表示
add_filter('manage_pages_columns', function ($columns) {
    $columns['template'] = 'テンプレート';
    $columns['slug'] = "スラッグ";
    return $columns;
});
add_action('manage_pages_custom_column', function ($column_name, $post_id) {
    if ($column_name == 'template') {
        $template = get_page_template_slug($post_id);
        echo ($template) ? $template : 'Default';
    }
    if ($column_name == 'slug') {
        $post = get_post($post_id);
        $slug = $post->post_name;
        echo attribute_escape($slug);
    }
}, 10, 2);