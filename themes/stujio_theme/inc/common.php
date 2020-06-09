<?php
require_once(dirname(__FILE__) . "/util_wordpress.php");
require_once(dirname(__FILE__) . "/config_customize.php");
foreach (glob( get_template_directory() . "/inc/auto_inc/**/*.php") as $filename) {
    require_once($filename);
}



//ようこそを削除
remove_action('welcome_panel', 'wp_welcome_panel');
// // 管理バーを非表示に
// add_filter('show_admin_bar', '__return_false');
// 管理画面からのテーマやプラグインの編集機能を無効にする
define('DISALLOW_FILE_EDIT', true);
// アイキャッチ画像有効化
add_theme_support('post-thumbnails');

//作成者アーカイブをつくらない
//http:/ドメイン/?author=1などでユーザ名が表示されてしまう。
add_filter('author_rewrite_rules', '__return_empty_array');

// テーマファイルの更新非通知
// このテーマがたまたま公式テーマと同名の場合上書きされることを防止する
add_filter('pre_site_transient_update_themes', '__return_null');

// エディタで画像を挿入する時 リンク先をなしにする
// file：ファイルのURL
// attachment：投稿のURL
// blank：なし
if (get_option('image_default_link_type') !== 'none') {
    update_option('image_default_link_type', 'none');
}

//画像挿入時の添付ファイルのページの選択肢を消す

add_action('post-upload-ui', function () {
    ob_start();
});

add_action('print_media_templates', function ()
{
    $scripts = ob_get_clean();
    $scripts = preg_replace('#<option value="post">.*?</option>#s', '', $scripts);
    echo $scripts;
});

//attachment_id=ページに404を返す
add_action('template_redirect', function () {
    if (is_attachment()) { // 添付ファイルの個別ページなら
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
    }
});

// 勝手に絵文字変換を無効化
add_action('init', function () {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', function ($plugins) {
        if (is_array($plugins)) {
            return array_diff($plugins, ['wpemoji']);
        } else {
            return [];
        }
    });
});


// 開発環境のときはrewrite_rulesを更新 パーマリンク設定毎回更新するの手間なので
if($_SERVER['HTTP_HOST'] ==='localhost'){
    flush_rewrite_rules();
}

