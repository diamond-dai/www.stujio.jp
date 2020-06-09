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

	<section class="first_content">
    <div class="content_area">
      <div class="tit_flex">
        <h2 class="section_tit fadein">
          <div class="jp_tit">お知らせ一覧</div>
          <div class="en_tit">NEWS</div>
        </h2>
      </div>
      <div class="content_inner_box recruit_box">
        <ul class="news_post_list">
          <?php while ( have_posts() ) {
          the_post();
          ?>
         <li class="news_post fadein">
            <a href="<?php the_permalink() ?>">
              <p class="news_date"><?= get_post_time('Y.m.d')  ?></p>
              <p class="normal_txt"><?=  mb_strimwidth(get_the_title(), 0, 88 + 1, "…", "utf-8"); ?><i class="far fa-chevron-right"></i></p>
            </a>
          </li>
          <?php } ?>
        </ul>
        <div class="paginate_box">
        <?php echo_custom_pagenate('<','>') ?>
        </div>
      </div>
    </div>
	</section>
	<!-- /first_content -->

<?php get_footer(); ?>

