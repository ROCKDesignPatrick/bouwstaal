<?php get_header(); ?>


<section>
    <div class="container">
        <h1><?php the_title() ?></h1>
        <p>Hallo <?php echo wp_get_current_user()->data->user_nicename; ?></p>
        <div class="information">
            <div class="information-wrapper">
                <div class="information-item">
                    <?php
                    $aPosts = new WP_Query([
                        'post_type' => 'post',
                        'posts_per_page' => 1,
                    ]); ?>
                    <?php if (get_unread_messages_counter('post') === 1) : ?>
                        <h3><?php echo get_unread_messages_counter('post'); ?> Nieuw bericht</h3>
                    <?php else : ?>
                        <h3><?php echo get_unread_messages_counter('post'); ?> Nieuwe berichten</h3>
                    <?php endif; ?>


                </div>
                <div class="information-item">
                    <?php if (get_unread_messages_counter('document') === 1) : ?>
                        <h3><?php echo get_unread_messages_counter('document'); ?> Nieuw bestand</h3>
                    <?php else : ?>
                        <h3><?php echo get_unread_messages_counter('document'); ?> Nieuwe bestanden</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>