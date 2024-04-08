<?php
/*
Template name: Berichtenpagina
*/

get_header();
?>

<section id="" class="">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <p class="desc">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc suscipit suscipit turpis ut tempor. Proin ut neque nunc. Vestibulum feugiat neque sed felis ultricies congue vitae id sapien.
        </p>
        <?php
        $oUser = wp_get_current_user();
        //echo '<pre>' . print_r($oUser, true) . '</pre>';
        $iCurrentUserID = $oUser->ID;

        $sReceivers = get_post_meta(11, 'ontvangers', true);

        switch ($sReceivers) {
            case 'employees':
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 5,
                );
                break;
            case 'employee':
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 5,
                    'meta_query'    => array(
                        'relation'      => 'AND',
                        array(
                            'key'       => 'medewerkers',
                            'value'     => '"' . $iCurrentUserID . '"',
                            'compare'   => 'LIKE',
                        ),
                    ),
                );
                break;
            case 'organisation':
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 5,
                );
                break;
        }
        if ($sReceivers == 'employees') {
            $aUserRoles = $oUser->roles;
        }

        //echo '<pre>' . print_r($sReceivers, true) . '</pre>';

        $aPosts = new WP_Query($args);

        if ($aPosts->have_posts()) :
        ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Titel</th>
                        <th scope="col">Datum</th>
                        <th scope="col">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($aPosts->have_posts()) :
                        $aPosts->the_post();
                        $post_id = get_the_ID();
                        $post_date = get_the_date('D d-m-Y H:i', $post_id);

                        // Check if user has read the message
                        $sPostStatus = message_status($post_id);
                    ?>
                        <tr class="<?php echo $sPostStatus; ?>">
                            <td class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
                            <td><?php echo $post_date; ?></td>
                            <td><?php get_template_part('parts/messages', 'actions'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>Er zijn momenteel geen berichten.</p>
        <?php endif;
        wp_reset_postdata(); ?>
    </div>
</section>
<?php get_footer();
