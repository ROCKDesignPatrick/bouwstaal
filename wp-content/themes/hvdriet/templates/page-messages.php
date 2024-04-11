<?php
/*
Template name: Berichtenpagina
*/

get_header();
?>


<?php

$args = ['post_type' => 'post', 'posts_per_page' => 1, 'paged' => $paged];
query_posts($args);
?>


<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php the_title(); ?>
    <?php endwhile; ?>

    <?php the_posts_pagination(); ?>
<?php else : ?>
<?php endif; ?>




<section id="" class="">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <p class="desc">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc suscipit suscipit turpis ut tempor. Proin ut neque nunc. Vestibulum feugiat neque sed felis ultricies congue vitae id sapien.
        </p>
        <?php
        $user = wp_get_current_user();
        $userID = $user->ID;
        $userRole = $user->roles[0];
        // get_current_user_role
        $canView = false;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $aPosts = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => 1,
            'paged'          => $paged
        ]);

        if ($aPosts->have_posts()) : ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Titel</th>
                        <th scope="col">Gepubliceerd op</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($aPosts->have_posts()) :
                        $aPosts->the_post();
                        $post_id = get_the_ID();
                        $post_date = get_the_date('D d-m-Y H:i', $post_id);
                        $sPostStatus = message_status($post_id);

                        $recievers = get_field('ontvangers');
                        $employees = get_field('medewerkers');
                        $canView = false;

                        if ($userRole == 'administrator' || $recievers == 'employees') {
                            $canView = true;
                        } else if (is_array($employees) && $userRole != 'administrator' && $recievers == 'employee') {
                            if (in_array($userID, $employees)) {
                                $canView = true;
                            }
                        }
                    ?>

                        <?php if ($canView) : ?>
                            <tr class="<?php echo $sPostStatus; ?>">
                                <td class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
                                <td><?php echo $post_date; ?></td>
                            </tr>
                        <?php endif; ?>

                    <?php endwhile; ?>
                </tbody>
            </table>

            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p>Er zijn momenteel geen berichten.</p>
        <?php endif;


        wp_reset_postdata(); ?>
    </div>
</section>
<?php get_footer();
