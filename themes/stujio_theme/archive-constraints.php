
<?php
/*
Template Name: archive constraints
*/
?>
<?php get_header() ?>


<section class="mv page_head fadein">
    <div class="copy_box">
      <div class="jp_tit">成約物件</div>
      <h1 class="page_tit"><span>CONSTRAINTS</span></h1>
    </div>
	</section>
	<!-- /MV -->

	<section class="first_content">
    <div class="content_area">
      <div class="tit_flex">
        <h2 class="section_tit fadein">
          <div class="jp_tit">成約物件</div>
          <div class="en_tit">CONSTRAINTS</div>
        </h2>
      </div>
      <div class="box_container">
      <?php
      while (have_posts()) {
          the_post();
          if (has_post_thumbnail()) {
              list($image_url) = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail', true);
          } else {
              $image_url =  get_template_directory_uri() . '/assets/img/no_photo.png';
          }
        ?>
        <a href="<?php the_permalink() ?>" class="estate_box fadein">
          <div class="estate_ph">
            <img src="<?= $image_url ?>" alt="">
            <?php if($post->is_sold){ ?>
            <span class="sold_icon">SOLD</span>
            <?php } ?>
          </div>
          <div class="txt_box">
            <p class="estate_name"><?php the_title() ?></p>
            <p class="icon_txt price"><?= number_format($post->price) ?>万円</p>
            <p class="icon_txt floor"><?= $post->floor_plan ?></p>
            <p class="more_link">READ MORE</p>
          </div>
        </a>
      <?php
      } ?>
      </div>
      <div class="paginate_box">
        <?php echo_custom_pagenate('<','>') ?>
      </div>
    </div>
	</section>
	<!-- /first_content -->
<?php get_footer(); ?>
