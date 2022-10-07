<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package josh-underscores-sass
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php if ( have_posts() ) : ?>

        <header class="page-header">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
        </header><!-- .page-header -->
	<?php endif; ?>
	<?php
	$args  = array( 'post_type' => 'fwd-student', 'posts_per_page' => - 1 );
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			?>
            <h1><?php the_title(); ?></h1>
            <a href="<?php esc_url( the_permalink() ); ?>">Profile</a>
			<?php
			the_excerpt();
			the_post_thumbnail( 'medium' );
		}
		wp_reset_postdata();
	}
	?>

</main><!-- #main -->

<?php
get_footer();

?>
