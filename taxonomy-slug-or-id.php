<?php

// get category slug in wordpress this can be slug or ID, for the purposes of this project, I needed to use "slug"
$cats =  get_the_category();
$cat = get_category( get_query_var( 'cat' ) );
$cat_slug = $cat->slug; // If you want the ID, we would change it to the following (the containing quotes are for readability- don't include them)- "$cat_id = $cat->ID;" Just a note- I would suggest changing the variable name as I did here to $cat_id. This is just to help keep things clear. Remember, other developers should be able to pick up your work without issue. Comment (probably not as much as I do), format, and use good naming conventions.
$custom_post_args = array(
  "post_type" => array("post","your-custom-post-type"),
  "post_status" => "publish",
  "posts_per_page" => 5,
  "tax_query" => array(
    "relation" => "OR", //this is what makes the soup. Without this relation argument, the query will try and look for either post type but only if they have both conditions. This lets the little fella know that either one is okay. Then you can tussle his hair and take him out for a ballgame and ice cream. Or maybe it's a girl. Maybe non-binary. It's all good. Do something not gender-specific. You are a modern and enlightened type of person.
    array(
      "taxonomy" => "category",
      "field" => "slug", // you can absolutely switch this out for ID, just change out the variable above to call the ID down.
      "terms" => $post_slug, // To switch to ID using the alternate variable we created above just make sure you change this out to "$cat_id" or whatever you named it. It's your life. You do you boo.
    ),
    array(
      "taxonomy" => "your-custom-taxonomy", //this is the slug for your taxonomy type. It could be "custom-taxonomy" or whatever.
      "field" => "slug", // as it is above, so it is below....see the comment on the coresponding line above.
      "terms" => $post_slug, // ONE MORE TIME!!! ...see above.
    )
  )
);

$custom_post_query = new WP_Query($custom_post_args);

?>

<!-- start custom query loop -->
<?php if ( $custom_post_query->have_posts() ) : ?>
  <?php while ( $custom_post_query->have_posts() ) : $custom_post_query->the_post(); ?>


    <!-- initial "if" statement to determine if any posts have been found. -->
    <?php if ( $custom_post_query->have_posts() ) : ?>
      <div class="container">
        <div class="row">
          <h1>Category Archive: <?php echo single_cat_title( '', false ); ?></h1>
        </div>
      </div>
    </div>
    <!-- your awesome content and super sweet layout to display your (my) brilliant loop query -->
    <div class="row">
      <div class="two-thirds column">
        <div class="row">

          <?php while ( $custom_post_query->have_posts() ) : $custom_post_query->the_post(); ?>

            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
            <p><?php the_time('F j, Y'); ?> &bull;
              <?php
              $taxonomy = 'category';
              
              // get the term IDs assigned to post.
              $post_terms = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
              // separator between links
              $separator = ', ';

              if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {

                $term_ids = implode( ',' , $post_terms );
                $terms = wp_list_categories( 'title_li=&style=none&echo=0&taxonomy=' . $taxonomy . '&include=' . $term_ids );
                $terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );

                // display post categories
                echo  $terms;
              }
              ?>
            </p>
            <h2><?php the_field('tenant_property_name'); ?><br/><?php the_title(); ?></h2>
            <?php the_excerpt(); ?>
            <a class="button" href="<?php the_permalink(); ?>">Read More</a>
            <hr/>

          <?php endwhile; ?>
        </div>
      </div>
      <!-- Fallback content if no posts are found. #sadface -->
    <?php else: ?>

      <h2>No posts to display in <?php echo single_cat_title( '', false ); ?></h2>

    </div>

  <?php endif; ?>
