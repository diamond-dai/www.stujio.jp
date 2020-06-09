<?php
require_once(__DIR__ .  "/inc/common.php");


/*canonical非表示 ※静的パーツで一括表示*/
remove_action('wp_head', 'rel_canonical');



add_action('wp_enqueue_scripts', function () {
    if (!is_admin() && !is_login_page()) {
        // wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/fontawesome/css/fontawesome-all.min.css');
        // wp_enqueue_style('drawer', get_template_directory_uri() . '/assets/css/drawer.css');
        wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/common.css');
        // wp_enqueue_style('google_fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&family=Roboto:wght@500;700;900&display=swap');
        // wp_enqueue_script('viewport-extra', 'https://cdn.jsdelivr.net/npm/viewport-extra@1.0.3/dist/viewport-extra.min.js');
        // wp_enqueue_script('jquery3', 'https://code.jquery.com/jquery-3.4.1.min.js');
        // wp_enqueue_script('jquery.inview', get_template_directory_uri() . '/assets/js/jquery.inview.min.js', ['jquery3']);
        // wp_enqueue_script('jquery.drawer', get_template_directory_uri() . '/assets/js/drawer.min.js', ['jquery3']);
        // wp_enqueue_script('jquery.iscroll', get_template_directory_uri() . '/assets/js/iscroll.js"', ['jquery3']);
        // wp_enqueue_script('jquery.script', get_template_directory_uri() . '/assets/js/script.js', ['jquery3']);
        // if (is_front_page()) {
        //     //   wp_enqueue_style('simulator', get_template_directory_uri() . '/assets/vue/simulator.css');
        //     //   wp_enqueue_script('simulator', get_template_directory_uri() . '/assets/vue/simulator.js');
        // }
    }
});


add_action(
    'pre_get_posts',
    function ($query) {
        if (is_admin() || !$query->is_main_query()) {
            return;
        }
        if ($query->is_post_type_archive('news')) {
            $query->set('posts_per_page', 20);
            $query->set('order', 'DESC');
            $query->set('orderby', 'date ID');
        }
        if ($query->is_post_type_archive('constraints')) {
            $query->set('posts_per_page', 20);
            $query->set('order', 'DESC');
            $query->set('orderby', 'date ID');
        }
    }
);

add_theme_support('title-tag');

//------------------------------------------------
//    固有関数定義　開始
//------------------------------------------------


// 固定ページが存在しなかったら作成
// add_action('init', function () {
//     $page_items = [
//         'service' => 'SERVICE',
//         'guide' => 'GUIDE',
//         'recruit' => 'RECRUIT',
//         'company' => 'COMPANY',
//         'contact' => 'CONTACT',
//         'contact-confirm' => 'CONFIRM',
//         'contact-thanks' => 'THANKS',
//     ];
//     foreach ($page_items as $page_slug => $page_tille) {
//         $page = get_page_by_path($page_slug);
//         if (!$page) {
//             // 投稿オブジェクトを作成
//             $my_post = [
//                 'post_title'    => $page_tille,
//                 'post_content'  => '',
//                 'post_type' => 'page',
//                 'post_status'   => 'publish',
//                 'post_author'   => 1,
//                 'post_name' => $page_slug,
//             ];
//             // 投稿をデータベースへ追加
//             wp_insert_post($my_post);
//         }
//     }
// });
