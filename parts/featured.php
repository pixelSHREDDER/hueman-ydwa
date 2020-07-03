<?php
$featured = array();
$now = strtotime(date('c', time()));
$events_table = $wpdb->prefix . 'eme_events';

if (is_home() && !is_paged() && (hu_get_option('featured-posts-count') == '1')) {
	foreach($wpdb->get_results("SELECT event_id, event_name, event_image_id, event_image_url, event_start_date, event_start_time, event_slug FROM " . $events_table . " WHERE event_start_date >= CURRENT_DATE() ORDER BY event_start_date ASC LIMIT 1") as $key => $wpdbq) {
		$permalink = get_site_url() . '/events/' . $wpdbq->event_id . '/' . $wpdbq->event_slug;
        $start_date = date('l, M jS @ g:i A', strtotime("$wpdbq->event_start_date $wpdbq->event_start_time"));
        $array = array(
            'id'                => $wpdbq->event_id,
            'permalink'         => $permalink,
			'esc_permalink'     => esc_url($permalink),
            'title'             => 'Upcoming Event: ' . $wpdbq->event_name,
            'excerpt'           => $start_date,
            'fulldate'          => date('c', strtotime("$wpdbq->event_start_date $wpdbq->event_start_time")),
            'category'          => 'Events'
		);

        if ($wpdbq->event_image_url) {
			list($width, $height, $type, $attr) = @getimagesize($wpdbq->event_image_url);
			$array['thumb_id'] = $wpdbq->event_image_id;
			$array['thumb_meta'] = array(
				'width'     => $width,
				'height'    => $height
			);
		}
        $wpdb_slider_post = (object) $array;
        array_push($featured, $wpdb_slider_post);
	}
    if (empty($featured)) {
		$wp_query = new WP_Query(
			array(
                'no_found_rows'				=> false,
    		    'update_post_meta_cache'    => false,
    		    'update_post_term_cache'    => false,
                'posts_per_page'            => 1,
				'post__in'                  => get_option('sticky_posts'),
				'ignore_sticky_posts'       => 1,
				'orderby'                   => 'date',
				'order'                     => 'DESC',
				'post_status'               => 'publish',
				'cat'                       => hu_get_option('featured-category'),
			)
		);

		while ($wp_query->have_posts()) :
			$wp_query->the_post();
			$full_date = get_the_date('c');
			$thumb_id = get_post_thumbnail_id($wp_query->ID);
			$array = array(
                'id'                => get_the_ID(),
                'permalink'         => get_permalink(),
				'esc_permalink'	    => esc_url(get_permalink()),
				'title'             => get_the_title(),
                'excerpt'           => get_the_excerpt(),
				'thumb_id'          => $thumb_id,
				'thumb_meta'        => wp_get_attachment_metadata($thumb_id),
				'full_date'         => $full_date,
				'author'            => get_the_author(),
                'author_link'       => esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                'comments_link'     => get_comments_link(),
                'comments_number'   => get_comments_number( '0', '1', '%' ),
                'category'          => get_the_category(' / '),
			);
            $wp_query_slider_post = (object) $array;
            array_push($featured, $wp_query_slider_post);
		endwhile;
	}
} elseif (is_home() && !is_paged() && (hu_get_option('featured-posts-count') != '0')) {
	foreach($wpdb->get_results("SELECT event_id, event_name, event_image_id, event_image_url, event_start_date, event_start_time, event_slug FROM " . $events_table . " WHERE event_start_date >= CURRENT_DATE() ORDER BY event_start_date ASC LIMIT " . hu_get_option('featured-posts-count') * 2) as $key => $wpdbq) {
		$permalink = get_site_url() . '/events/' . $wpdbq->event_id . '/' . $wpdbq->event_slug;
        $start_date = date('l, M jS @ g:i A', strtotime("$wpdbq->event_start_date $wpdbq->event_start_time"));
        $array = array(
            'id'                => $wpdbq->event_id,
            'permalink'         => $permalink,
			'esc_permalink'     => esc_url($permalink),
            'title'             => 'Upcoming Event: ' . $wpdbq->event_name,
            'excerpt'           => $start_date,
            'fulldate'          => date('c', strtotime("$wpdbq->event_start_date $wpdbq->event_start_time")),
            'category'          => 'Events'
        );

        if ($wpdbq->event_image_url) {
			list($width, $height, $type, $attr) = @getimagesize($wpdbq->event_image_url);
			$array['thumb_id'] = $wpdbq->event_image_id;
			$array['thumb_meta'] = array(
				'width'     => $width,
				'height'    => $height
			);
		}
		$wpdb_slider_post = (object) $array;
        array_push($featured, $wpdb_slider_post);
	}

    usort($featured, function($a, $b) {
		return ($now - strtotime($b->fulldate)) - ($now - strtotime($a->fulldate));
	});

	if (count($featured) < hu_get_option('featured-posts-count')) {
		$wp_query = new WP_Query(
			array(
				'no_found_rows'				=> false,
				'update_post_meta_cache'    => false,
				'update_post_term_cache'    => false,
				'posts_per_page'            => hu_get_option('featured-posts-count') * 2,
				'orderby'                   => 'date',
				'order'                     => 'DESC',
				'post_status'               => 'publish',
				'cat'                       => hu_get_option('featured-category')
			)
		);

		while ($wp_query->have_posts()) :
			$wp_query->the_post();
			$full_date = get_the_date('c');
			if ((strtotime($full_date) > strtotime('2 months ago')) || (sizeof($featured) < 3)) {
				$thumb_id = get_post_thumbnail_id($wp_query->ID);
				$array = array(
					'id'                => get_the_ID(),
					'permalink'         => get_permalink(),
					'esc_permalink'	    => esc_url(get_permalink()),
					'title'             => get_the_title(),
					'excerpt'           => get_the_excerpt(),
					'thumb_id'          => $thumb_id,
					'thumb_meta'        => wp_get_attachment_metadata($thumb_id),
					'full_date'         => $full_date,
					'author'            => get_the_author(),
					'author_link'       => esc_url(get_author_posts_url(get_the_author_meta('ID'))),
					'comments_link'     => get_comments_link(),
					'comments_number'   => get_comments_number( '0', '1', '%' ),
					'category'          => get_the_category(' / ')
				);
				$wp_query_slider_post = (object) $array;
				array_push($featured, $wp_query_slider_post);
			}
		endwhile;
	}

	array_slice($featured, 0, hu_get_option('featured-posts-count'));
}

// Query featured entries
/*$featured = new WP_Query(
  	array(
    		'no_found_rows'				   => false,
    		'update_post_meta_cache' => false,
    		'update_post_term_cache' => false,
    		'ignore_sticky_posts'		 => 1,
    		'posts_per_page'			   => hu_get_option('featured-posts-count'),
    		'cat'						         => hu_get_option('featured-category')
  	)
);*/
?>

<?php do_action( '__before_featured' ); ?>
<?php if (is_home() && !is_paged() && (hu_get_option('featured-posts-count') == '1') && !empty($featured)): // No slider if 1 post is featured ?>

    <div class="featured">
        <?php
			foreach($featured as $featured_post) {
                /*get_template_part('content-featured');*/
                include(locate_template('content-featured.php'));
			}
		?>
	</div><!--/.featured-->

<?php elseif (is_home() && !is_paged() && (hu_get_option('featured-posts-count') != '0') && !empty($featured)): // Show slider if posts are not 1 or 0 ?>
    <script type="text/javascript">
		// Check if first slider image is loaded, and load flexslider on document ready
		jQuery(function($){
		 //var firstImage = $('#flexslider-featured').find('img').filter(':first'),
		 var firstImage = $('<img/>').attr('src', '<?php echo hu_get_img_src(current($featured)->thumb_id); ?>'),
			checkforloaded = setInterval(function() {
				var image = firstImage.get(0);
				if (image.complete || image.readyState == 'complete' || image.readyState == 4) {
					clearInterval(checkforloaded);

					$.when( $('#flexslider-featured').flexslider({
						animation: "slide",
						useCSS: false, // Fix iPad flickering issue
						directionNav: true,
						controlNav: true,
						pauseOnHover: true,
						animationSpeed: 400,
						smoothHeight: true,
            rtl: <?php echo json_encode( is_rtl() ) ?>,
						touch: <?php echo apply_filters('hu_flexslider_touch_support' , true); ?>,
						slideshow: <?php echo hu_is_checked('featured-slideshow') ? 'true' : 'false'; ?>,
						slideshowSpeed: <?php echo hu_get_option('featured-slideshow-speed', 5000); ?>,
					}) ).done( function() {
            var $_self = $(this);
                _trigger = function( $_self ) {
              $_self.trigger('featured-slider-ready');
            };
            _trigger = _.debounce( _trigger, 100 );
            _trigger( $_self );
          } );

				}
			}, 20);
		});
	</script>

	<div class="featured flexslider" id="flexslider-featured">
		<ul class="slides">
            <?php
                foreach($featured as $featured_post) {
                    echo '<li>';
                        include(locate_template('content-featured.php'));
                    echo '</li>';
                }
            ?>
		</ul>
	</div><!--/.featured-->

<?php endif; ?>
<?php wp_reset_postdata(); ?>
<?php do_action( '__after_featured' ); ?>
