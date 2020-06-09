<?php
add_action('init', function () {
  $post_slug = 'menu';
  $category_prefix = '';
  $category_suffix = '_category';
  $label = 'MENU';
  register_post_type(
    $post_slug,
    [
      /*ラベルの作成*/
      'labels' => [
        'name' => $label, //管理画面などで表示する名前
        'singular_name' => $label, //管理画面などで表示する名前（単数形）
        'menu_name' => $label, //管理画面メニューで表示する名前（nameより優先される）
        'add_new_item' => '新しい' . $label, //新規作成ページのタイトルに表示される名前
        'add_new' => '新規追加', //メニューの新規追加ボタンのラベル
        'new_item' => '一覧ページの「新規追加」ボタンのラベル',
        'edit_item' => '編集', //編集ページのタイトルに表示される名前
        'view_item' => '編集', //編集ページの「投稿を表示」ボタンのラベル
        'search_items' => $label . 'の検索', //一覧ページの検索ボタンのラベル
        'not_found' => '見つかりません。', //一覧ページに投稿が見つからなかったときに表示
        'not_found_in_trash' => 'ゴミ箱にはありません。' //ゴミ箱に何も入っていないときに表示
      ],
      'menu_position' => 5,
      'descriptions' => "{$label}の概要", //カスタム投稿ページの概要文
      'hierarchical' => false, //falseの場合、階層構造なし
      'public' => true, //ユーザーが内容を投稿する場合true(通常はtrue)
      'has_archive' => true,  //アーカイブページを作成するか否かを設定(trueでindexページを作成)
      'exclude_from_search' => false, //WPの検索機能から検索した際、検索対象に含めるか否かを設定（※trueの場合は検索対象に含めない）
      // 'taxonomies' => ['category'], //投稿の分類に用いるカスタムカテゴリ・カスタムタグ[配列]

      //管理画面から投稿できる項目
      'supports' => [
        'title', //タイトル表示を有効に
        // 'editor', //本文の表示を有効に
        'thumbnail', //アイキャッチ画像を有効に
        // 'revisions', //リビジョンを保存する
      ]
    ]
  );

  // register_taxonomy(
  //   "{$category_prefix}{$post_slug}{$category_suffix}",
  //   $post_slug,
  //   [
  //     'label' => "カテゴリー",
  //     'public' => true,
  //     'rewrite' => true,
  //     'hierarchical' => true,
  //     'show_admin_column' => true
  //   ]
  // );

});
