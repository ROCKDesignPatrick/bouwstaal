<?php get_header(); ?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <section>
        	<div class="container">
				<?php the_title(); ?>
                <?php the_content(); ?>
        	</div>
        </section>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>