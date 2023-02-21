<?php
/**
* Author: April Marshall
* Author Site: http://www.aprilagain.com
* Author Github: https://www.github.com/theamazingaprilb
* This is a single-"custom-post-type" page that is populated in part by the content for each entry in that custom-post-type
* However, it doesn't pull in the category id or slug by default. So to accomplish pulling in the appropriate posts, we have to pull the page slug in order to populate our taxonomies. This is part of the reason that I used slugs in the actual project- because the custom-taxonomy, category, and custom-post-type page all use the same slug format (i.e. "firstname-lastname" or "singlename")
*/
?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?> <!-- this is the initial query for posts associated to this custom post type -->

	<div class="container">
		<div class="row">
			<h1><?php the_title(); ?></h1>
			<h2><?php the_field('subtitle'); ?></h2>

		</div>
		<div class="row">
			<h5>The Latest From <?php the_title(); ?></h5>

			<div>

				<?php

				// get post slug in wordpress.
				// you could also use this on a single page as long as the slug format is the same as the slug on the taxonomies you are using. Just replace post id with page id.
				$post_slug=$post->post_name
				// custom query arguments
				$custom_post_args = array(
					"post_type" => array("post","your-custom-post-type"),
					"post_status" => "publish",
					"posts_per_page" => 5,
					"tax_query" => array(
						"relation" => "OR",
						array(
							"taxonomy" => "category",
							"field" => "slug",
							"terms" => $post_slug,
						),
						array(
							"taxonomy" => "your-custom-taxonomy",
							"field" => "slug",
							"terms" => $post_slug,
						)
					)
				);
				// Custom query ran against your custom arguments. This is the only time you should argue. Hug it out bro.
				$custom_post_query = new WP_Query($custom_post_args);

				?>
				<!-- checking if the query has posts -->
				<?php if ( $custom_post_query->have_posts() ) : ?>

					<!-- the loop -->
					<?php while ( $custom_post_query->have_posts() ) : $custom_post_query->the_post(); ?>

						<a href="<?php the_permalink(); ?>">
							<?php
							if( get_post_type() == 'event' ) :
								echo "<p>" . get_schedule_start( $format = 'M', $post_id ) . "</p>";
								echo "<h3>" . get_schedule_start( $format = 'j', $post_id ) . "</h3>";
								else :
									echo "<p>" . get_the_date('M') . "</p>";
									echo "<h3>" . get_the_date('j') . "</h3>";
								endif;
								?>
							</div>
						<?php endwhile; ?>


						<!-- end of the loop -->


						<?php wp_reset_postdata(); ?>

					<?php else:  ?> <!-- Backup content in the case of no posts being found -->

						<div style="width: 80%; text-align: left;">
							<h2><?php _e( 'No posts found.' ); ?></h2>
						</div>

					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>


	<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
