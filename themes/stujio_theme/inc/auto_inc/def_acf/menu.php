<?php

if (function_exists('acf_add_local_field_group')) :

  $menu_items = [];

  $menu_items[] = [
    'key' => 'field_5edf951aa9666',
    'label' => 'サブタイトル',
    'name' => 'sub_title',
    'type' => 'text',
    'instructions' => '日本語のタイトルを入れてください',
    'required' => 1,
    'conditional_logic' => 0,
    'wrapper' => array(
      'width' => '',
      'class' => '',
      'id' => '',
    ),
    'default_value' => '',
    'placeholder' => '',
    'prepend' => '',
    'append' => '',
    'maxlength' => '',
  ];

  $menu_col_num = 3;

  for ($i = 1; $i <= $menu_col_num; $i++) {
    $menu_items[] = [
      'key' => "field_5edf9431a9664_{$i}",
      'label' => "メニュー{$i} アイコン",
      'name' => "menu_{$i}_icon",
      'type' => 'image',
      'instructions' => '',
      'required' => 1,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'return_format' => 'id',
      'preview_size' => 'medium',
      'library' => 'all',
      'min_width' => '',
      'min_height' => '',
      'min_size' => '',
      'max_width' => '',
      'max_height' => '',
      'max_size' => '',
      'mime_types' => '',
    ];
    $menu_items[] = [
      'key' => "field_5edf917ea9662_{$i}",
      'label' => "メニュー{$i} タイトル",
      'name' => "menu_{$i}_title",
      'type' => 'text',
      'instructions' => '',
      'required' => 1,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
    ];

    $menu_items[] = [
      'key' => "field_5edf93f8a9663_{$i}",
      'label' => "メニュー{$i} 説明",
      'name' => "menu_{$i}_description",
      'type' => 'textarea',
      'instructions' => '',
      'required' => １,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'maxlength' => '',
      'rows' => '',
      'new_lines' => '',
    ];
    $menu_items[] = [
      'key' => "field_5edf94a4a9665_{$i}",
      'label' => "メニュー{$i} 価格",
      'name' => "menu_{$i}_price",
      'type' => 'number',
      'instructions' => '',
      'required' => 1,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => '',
      'max' => '',
      'step' => '',
    ];
    $menu_items[] = [
      'key' => "field_5edf958649bcd_{$i}",
      'label' => "メニュー{$i} 所要時間",
      'name' => "menu_{$i}_time",
      'type' => 'text',
      'instructions' => '',
      'required' => 1,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
    ];
  }


  // array(
  //   'key' => 'field_5edf9807f888b',
  //   'label' => '',
  //   'name' => '',
  //   'type' => 'textarea',
  //   'instructions' => '',
  //   'required' => １,
  //   'conditional_logic' => 0,
  //   'wrapper' => array(
  //     'width' => '',
  //     'class' => '',
  //     'id' => '',
  //   ),
  //   'default_value' => '',
  //   'placeholder' => '',
  //   'maxlength' => '',
  //   'rows' => '',
  //   'new_lines' => '',
  // ),

  // num
  //     array(
  //       'key' => 'field_5edf94a4a9665',
  //       'label' => 'メニュー1 価格',
  //       'name' => 'menu_1_price',
  //       'type' => 'number',
  //       'instructions' => '',
  //       'required' => 1,
  //       'conditional_logic' => 0,
  //       'wrapper' => array(
  //         'width' => '',
  //         'class' => '',
  //         'id' => '',
  //       ),
  //       'default_value' => '',
  //       'placeholder' => '',
  //       'prepend' => '',
  //       'append' => '',
  //       'min' => '',
  //       'max' => '',
  //       'step' => '',
  //     ),


  // text
  //     array(
  //       'key' => 'field_5edf958649bcd',
  //       'label' => 'メニュー1 所要時間',
  //       'name' => 'menu_1_time',
  //       'type' => 'text',
  //       'instructions' => '',
  //       'required' => 1,
  //       'conditional_logic' => 0,
  //       'wrapper' => array(
  //         'width' => '',
  //         'class' => '',
  //         'id' => '',
  //       ),
  //       'default_value' => '',
  //       'placeholder' => '',
  //       'prepend' => '',
  //       'append' => '',
  //       'maxlength' => '',
  //     ),

  acf_add_local_field_group(array(
    'key' => 'group_5edf91774ff72',
    'title' => 'menu',
    'fields' => $menu_items,
    'location' => array(
      [
        [
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'menu',
        ],
      ],
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
  ));

endif;
