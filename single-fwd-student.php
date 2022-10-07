<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package josh-underscores-sass
 */

get_header();
?>

    <main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
			?>
            <article><h1><?php the_title(); ?></h1>
				<?php
				the_content();
				the_post_thumbnail( '200x300' );
				?>
            </article>

			<?php

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'josh-underscores-sass' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'josh-underscores-sass' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			$student_type = wp_list_pluck( get_the_terms( get_the_ID(), 'fwd-student-category' ), 'slug' )[0];
			$this_id      = get_the_ID();
			$args         = array(
				'post_type'      => 'fwd-student',
				'posts_per_page' => - 1,
				'order_by'       => 'title',
				'order'          => 'ASC',
				'tax_query'      => array(
					array(
						'taxonomy' => 'fwd-student-category',
						'field'    => 'slug',
						'terms'    => $student_type
					)
				)
			);
			$query        = new WP_Query( $args );
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					if ( $this_id !== get_the_ID() ) {
						?>
                        <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
						<?php
					}
				}
				wp_reset_postdata();
			}
		endwhile; // End of the loop
		?>

    </main><!-- #main -->

<?php
get_footer();
