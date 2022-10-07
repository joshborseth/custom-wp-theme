<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package josh-underscores-sass
 */

get_header();
?>

    <main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

        <section>
            <p>
                Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni
                dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia
                dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore
                et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam
                corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure
                reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum
                fugiat quo voluptas nulla pariatur?
            </p>
			<?php
			$terms = get_terms( array( 'taxonomy' => 'fwd-staff-category' ) );
			foreach ( $terms as $term ) {
				$args  = array(
					'post_type'      => 'fwd-staff',
					'posts_per_page' => - 1,
					'order_by'       => 'title',
					'order'          => 'ASC',
					'tax_query'      => array(
						array(
							'taxonomy' => 'fwd-staff-category',
							'field'    => 'slug',
							'terms'    => $term->name
						)
					)
				);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) {
					?> <h2><?php echo $term->name; ?></h2>
					<?php
					while ( $query->have_posts() ) {
						$query->the_post();
						?>

                        <article>

                            <h3><?php the_title(); ?></h3>
							<?php
							if ( function_exists( 'get_field' ) ) {

								if ( get_field( 'staff_biography' ) ) {
									echo "<p>";
									the_field( 'staff_biography' );
									echo "</p>";
								}
								if ( get_field( 'courses' ) && $term->name == 'Faculty' ) {
									echo "<p>";
									the_field( 'courses' );
									echo "</p>";
								}
								if ( get_field( 'website_link' ) && $term->name == 'Faculty' ) {
									?><a href="<?php the_field( 'website_link' ); ?>">Go to Website</a><?php
								}

							}

							?>
                        </article>

						<?php
					}
					wp_reset_postdata();
				}
			}
			?>

        </section>


    </main><!-- #main -->

<?php
get_footer();
