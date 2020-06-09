<?php
/*
Template Name: single-constraints
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
      <?php
      while ( have_posts() ) {
        the_post();
        if (has_post_thumbnail()) {
          list($image_url) = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail', true);
        } else {
            $image_url =  get_template_directory_uri() . '/assets/img/no_photo.png';
        }
      ?>
      <div class="content_inner_box constraints_box fadein">
        <div class="flex_box">
          <div class="estate_ph">
            <img src="<?= $image_url ?>" alt="">
            <?php if($post->is_sold){ ?>
            <span class="sold_icon">SOLD</span>
            <?php } ?>
          </div>
          <ul class="estate_date">
            <li class="estate_name"><?php the_title() ?></li>
            <li><span class="label">販売価格</span><?= number_format($post->price) ?><span class="min_txt">万円</span></li>
            <li><span class="label">間取り</span><?= $post->floor_plan ?></li>
            <li><span class="label">エリア</span><?= $post->area ?></li>
          </ul>
        </div>
        <p class="normal_txt"><?php the_content() ?></p>
        <div class="content_foot_contact">
          <div class="link_tit">物件に関するお問合せ</div>
          <p class="normal_txt">ご質問等、お気軽にお問合せください。</p>
          <a href="/contact/" class="contact_link">
            <p class="normal_txt">お問い合わせ</p>
            <span class="arrow_01"></span>
          </a>
        </div>
      </div>
      <?php } ?>

    </div>
	</section>
	<!-- /first_content -->



<?php get_footer(); ?>
