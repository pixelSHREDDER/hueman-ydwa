<?php
//Let's determine which image size would be the best for the current user layout
$map = array(
      'col-1c'  => 'thumb-xxlarge',
      'col-2cl' => 'thumb-xlarge',
      'col-2cr' => 'thumb-xlarge',
      'col-3cm' => 'thumb-large',
      'col-3cl' => 'thumb-large',
      'col-3cr' => 'thumb-large'
);
$sb_layout = hu_get_layout_class();
$featured_img_size = array_key_exists( $sb_layout, $map ) ? $map[ $sb_layout ] : null;
//the featured img size is also used to generate a dynamic concatenated css class, featured-img-$featured_img_size
//for which the rule is defined assets/front/css/_parts/0_5_single_post_page.css

$featured_img_url = hu_get_img_src(get_post_thumbnail_id(get_the_ID()));
if (!empty($featured_img_url)) {
	$background_styles = 'background-image: url(' . $featured_img_url . ');';
} else {
	$background_styles = "background: #78c434; background: -moz-linear-gradient(top, #78c434 0%, #1982d1 100%); background: -webkit-linear-gradient(top, #78c434 0%,#1982d1 100%); background: linear-gradient(to bottom, #78c434 0%,#1982d1 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#78c434', endColorstr='#1982d1',GradientType=0 );";
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('group ydwa-hero sek-section sek-has-modules '); ?> data-sek-level="section" data-sek-has-bg="true" data-sek-bg-parallax="true" data-bg-width="1920" data-bg-height="1280" data-sek-parallax-force="40" style="background-position-y: calc(50% + 30px); <?php echo $background_styles ?>">
	<div class="sek-container-fluid">
		<div class="sek-row sek-sektion-inner">
			<div data-sek-level="column" class="sek-column sek-col-base sek-col-50">
				<div class="sek-column-inner ">
					<div data-sek-level="module" data-sek-module-type="czr_heading_module" class="sek-module ">
						<div class="sek-module-inner">
							<h2 class="sek-heading"><?php echo get_the_title() ?></h2>
						</div>
					</div>
					<div data-sek-level="module" data-sek-module-type="czr_tiny_mce_editor_module" class="sek-module ">
						<div class="sek-module-inner">
							<p><?php echo get_the_excerpt() ?></p>
						</div>
					</div>
					<div data-sek-level="module" data-sek-module-type="czr_button_module" class="sek-module ">
						<div class="sek-module-inner">
							<!--a class="sek-btn box-shadow push-effect" href="<?php the_permalink(); ?>"><span class="sek-btn-inner"><i class="far fa-envelope-open"></i><span class="sek-btn-text">Learn more</span></span></a-->
							<a class="btn btn-large" href="<?php the_permalink(); ?>"><span><i class="far fa-envelope-open"></i>Learn more</span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>
<!--article id="post-<?php the_ID(); ?>" <?php post_class('group'); ?>>
	<div class="post-inner post-hover">
		<div class="post-thumbnail featured-img-<?php echo $featured_img_size; ?>">
			<a href="<?php the_permalink(); ?>">
				<?php hu_the_post_thumbnail( apply_filters( 'hu_grid_featured_thumb_size', $featured_img_size ), '', $placeholder = true, $placeholder_size = apply_filters( 'hu_grid_featured_placeholder_size', $featured_img_size ) ); ?>
				<?php if ( has_post_format('video') && !is_sticky() ) echo'<span class="thumb-icon"><i class="fas fa-play"></i></span>'; ?>
				<?php if ( has_post_format('audio') && !is_sticky() ) echo'<span class="thumb-icon"><i class="fas fa-volume-up"></i></span>'; ?>
				<?php if ( is_sticky() ) echo'<span class="thumb-icon"><i class="fas fa-star"></i></span>'; ?>
			</a>
			<?php if ( hu_is_comment_icon_displayed_on_grid_item_thumbnails() ): ?>
				<a class="post-comments" href="<?php comments_link(); ?>"><i class="far fa-comments"></i><?php comments_number( '0', '1', '%' ); ?></a>
			<?php endif; ?>
		</div--><!--/.post-thumbnail-->

		<!--div class="post-meta group">
			<p class="post-category"><?php the_category(' / '); ?></p>
      <?php get_template_part('parts/post-list-author-date'); ?>
		</div--><!--/.post-meta-->

		<!--h2 class="post-title entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to ', 'hueman' ) ) ); ?>"><?php the_title(); ?></a>
		</h2--><!--/.post-title-->

		<!--?php if ( ! hu_is_checked('featured-posts-full-content') ) : ?>
  		<div class="entry excerpt entry-summary">
  			<?php if ( hu_get_option('excerpt-length') != '0' ) { the_excerpt(); } ?>
  		</div--><!--/.entry-->
		<!--?php else : ?>
      <div class="entry excerpt">
        <?php the_content() ?>
      </div--><!--/.entry-->
    <!--?php endif; ?>

	</div--><!--/.post-inner-->
<!--/article--><!--/.post-->