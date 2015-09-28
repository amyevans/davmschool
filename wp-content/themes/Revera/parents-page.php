<?php
/**
 * Template Name: Parents Page
 *
 * The template for displaying the parent page (which includes the events sidebar).
 *
 * @package web2feel
 */

get_header(); ?>

	<?php if ( is_front_page() ){ echo do_shortcode('[rev_slider davm]'); } ?>

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h3> <?php if ( is_front_page() ){?>
                            <div style="text-align:center;">
                           - Give your children the best of both words - <br/>
                             <h1>Academic Excellence and Spiritual Growth</h1></div>
                             <?  }?>
                               </h3>
				<p> </p>
			</div>
			
		</div>
	</div>
</div>

<div class="container">	
	<div class="row">
		<div id="primary" class="content-area col-sm-8">
			<main id="main" class="site-main" role="main">
				<h1 class="entry-title">Parents</h1>
				<?php 
					query_posts( array( 
						'cat' => '4,5', 
						'posts_per_page' => 10, 
						'order' => 'DESC' ) );
						while(have_posts()) : the_post(); ?>

					<div class="parents-post" style="margin-bottom:40px;">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php the_content(); ?></p>
						<p><em>Posted on <?php echo get_the_date(); ?></em></p>
					</div>

				<?php endwhile; wp_reset_query(); ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<!-- Only display sidebar to parents -->
		<?php if ( is_user_logged_in() ) : ?>
			<!-- Custom sidebar for Parents page -->
			<div id="secondary" class="widget-area col-sm-4" role="complementary">
				<?php do_action( 'before_sidebar' ); ?>
				<?php if( dynamic_sidebar('events-sidebar') ) : else : endif; ?>
				<?php if( dynamic_sidebar('parents-photos-sidebar') ) : else : endif; ?>
			</div><!-- #secondary -->
		<?php endif; ?>		
	</div>
</div>
<?php get_footer(); ?>
