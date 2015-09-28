<?php
/**
 * The Template for displaying all single posts.
 *
 * @package web2feel
 */

get_header(); ?>

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h3> <?php if ( is_front_page() ){?>
			        <div style="text-align:center;">
			        - Give your children the best of both words - <br/>
			        <h1>Academic Excellence and Spiritual Growth</h1></div>
			         <?php  }?>
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

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php if ( get_the_title() == 'Home' ){get_sidebar();}
        else if( get_the_title() == 'Contact Us' ){get_sidebar();}
        else if (get_the_title() == 'Testimonials'){  
 ?>
          <br><br><div class="widget-area col-sm-4"><aside class="widget widget_text"><?php echo do_shortcode('[katb_input_testimonials group="All" form="1"]');}           
 ?></aside></div>