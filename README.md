# mixed-post-type-and-mixed-taxonomy-wordpress
A project for displaying a mix of custom post types and standard posts when dealing with different taxonomy.

I ran into a project where I needed to combine two post types (post and event) into a wp_query.

No problem.

The two post types each used a different taxonomy slug (category and event-category).

Problem.

Running the query with an arg of "post_type" => array('post', 'event') would give me both post types (dur.) but no filtering. Just the whole thing. So I needed to pull in a "category" and an "event-category" that used the same slug "example-name". However adding the arg of "category_name" => "example-name", "event-category" => "example-name" did not work as it was trying to look for both post types, but also looking for posts that had both "category-name" and "event-category". So nothing came up.

Wordpress was not liking my combined queries either. So I came up with the solution of running two tax_query arguments that would query the slugs for each taxonomy type. Then you just have to create a relation of "OR" for the two tax_queries and WordPress will happily look for either post type with EITHER taxonomy.

Easy peasy.
