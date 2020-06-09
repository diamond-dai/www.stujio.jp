<?php
/*
Template Name: single-news
*/
?>
<?php get_header() ?>

<section class="mv page_head fadein">
    <div class="copy_box">
      <div class="jp_tit">お知らせ</div>
      <h1 class="page_tit"><span>NEWS</span></h1>
    </div>
	</section>
	<!-- /MV -->
  <?php while ( have_posts() ) {
  the_post();
  ?>
	<section class="first_content">
    <div class="content_area">

      <div class="content_inner_box recruit_box">
        <div class="news_post_head">
          <p class="news_tit"><?= get_the_title() ?></p>
          <p class="news_date"><?= get_post_time('Y.m.d') ?></p>
        </div>
        <p class="normal_txt"><?php the_content() ?></p>
      </div>
    </div>
	</section>
	<!-- /first_content -->

  <?php } ?>

<?php get_footer(); ?>