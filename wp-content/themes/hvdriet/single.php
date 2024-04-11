<?php get_header(); ?>
<section class="message">
    <div class="container message-wrapper">
        <h1><?php the_title(); ?></h1>
        <div class="message-date"><?php echo get_the_date(); ?></div>
        <div class="message-content">
            <?php the_content(); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>