<?php
/*
Template Name: front-page
*/
?>
<?php get_header() ?>
<div class="main-content-wrap">
  <main class="main-content">



    <div class="menu-groups content-inner">
      <?php
      $args = [
        'post_type' => ['menu'],
        'posts_per_page' => -1,
        'post_status' => 'publish',
        //   'orderby' => 'date',
        //   'order'   => 'DESC',
        'orderby'   => 'menu_order',

      ];
      $the_query = new WP_Query($args);
      while ($the_query->have_posts()) {
        $the_query->the_post();
      ?>
        <div class="menu-group">
          <div class="menu-group-head">
            <h2 class="menu-group-title"><span class="mein-text"><?= the_title() ?> / </span><span class="sub-text"><?= $post->sub_title ?></span></h2>
          </div>

          <div class="menu-list">

            <?php
            for ($i = 1; $i <= $menu_col_num; $i++) { ?>
              <div class="menu-list-item">
                <div class="menu-list-item-icon">
                  <?php list($icon_url) =  wp_get_attachment_image_src(get_post_meta($post->ID, "menu_{$i}_icon", true),'thumbnail');
                  ?>
                  <div class="icon-wrap">
                    <img src="<?= $icon_url ?>" alt="" class="icon-image">
                  </div>
                </div>

                <div class="menu-list-item-title">
                  <?= get_post_meta($post->ID, "menu_{$i}_title", true) ?>
                </div>
                <div class="menu-list-item-description">
                  <?= nl2br(get_post_meta($post->ID, "menu_{$i}_description", true)) ?>
                </div>
                <div class="menu-list-item-price">
                  <?= number_format(get_post_meta($post->ID, "menu_{$i}_price", true)) ?> (<?= get_post_meta($post->ID, "menu_{$i}_time", true) ?>分)
                </div>
              </div>
            <?php } ?>
          </div>





        </div>
      <?php }
      wp_reset_postdata(); ?>
    </div>

  </main>
</div>
<?php get_footer(); ?>