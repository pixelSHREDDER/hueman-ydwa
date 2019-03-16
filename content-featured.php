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

$featured_img_url = hu_get_img_src($featured_post->thumb_id);
if (!empty($featured_img_url)) {
	$background_styles = 'background-image: url(' . $featured_img_url . ');';
} else {
	$background_styles = "background: #78c434; background: -moz-linear-gradient(top, #78c434 0%, #1982d1 100%); background: -webkit-linear-gradient(top, #78c434 0%,#1982d1 100%); background: linear-gradient(to bottom, #78c434 0%,#1982d1 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#78c434', endColorstr='#1982d1',GradientType=0 );";
}
?>
<article id="post-<?php echo $featured_post->id ?>" <?php post_class('group ydwa-hero sek-section sek-has-modules '); ?> data-sek-level="section" data-sek-has-bg="true" data-sek-bg-parallax="true" data-bg-width="1920" data-bg-height="1280" data-sek-parallax-force="40" style="background-position-y: calc(50% + 30px); <?php echo $background_styles ?>">
	<div class="sek-container-fluid">
		<div class="sek-row sek-sektion-inner">
			<div data-sek-level="column" class="sek-column sek-col-base sek-col-50">
				<div class="sek-column-inner ">
					<div data-sek-level="module" data-sek-module-type="czr_heading_module" class="sek-module ">
						<div class="sek-module-inner">
							<h2 class="sek-heading"><?php echo $featured_post->title ?></h2>
						</div>
					</div>
					<div data-sek-level="module" data-sek-module-type="czr_tiny_mce_editor_module" class="sek-module ">
						<div class="sek-module-inner">
							<p><?php if ($featured_post->excerpt) { echo $featured_post->excerpt; } ?></p>
						</div>
					</div>
					<div data-sek-level="module" data-sek-module-type="czr_button_module" class="sek-module ">
						<div class="sek-module-inner">
							<!--a class="sek-btn box-shadow push-effect" href="<?php echo $featured_post->esc_permalink ?>"><span class="sek-btn-inner"><i class="far fa-envelope-open"></i><span class="sek-btn-text">Learn more</span></span></a-->
							<a class="btn btn-large" href="<?php echo $featured_post->esc_permalink ?>"><span><i class="far fa-envelope-open"></i>Learn more</span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>