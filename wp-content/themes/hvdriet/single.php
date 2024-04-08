<?php get_header(); ?>
<section>
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <div class="meta"><?php echo get_the_date(); ?></div>
        <?php the_content(); ?>
    </div>
</section>
<?php get_footer(); ?>