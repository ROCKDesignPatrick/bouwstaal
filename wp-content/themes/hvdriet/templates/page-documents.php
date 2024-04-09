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
        $user = wp_get_current_user();
        $userID = $user->ID;
        $userRole = $user->roles[0];
        $canView = false;

        $aPosts = new WP_Query([
            'post_type' => 'document',
            'posts_per_page' => 5,
        ]);

        if ($aPosts->have_posts()) : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Titel</th>
                        <th scope="col">Gepubliceerd op</th>
                        <th scope="col">Acties</th>
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
                        $file = get_field('file');

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
                                <td><a href="<?php echo $file['url'] ?>" data-click="set-post-unread" data-post-id="<?php echo $post_id ?>" target="_blank"><?php the_title(); ?> (<?php echo size_format($file['filesize']) ?>)</a></td>
                                <td><?php echo $post_date; ?></td>
                                <td><a href="<?php echo $file['url'] ?>" data-click="set-post-unread" data-post-id="<?php echo $post_id ?>" download>Download bestand</a></td>
                            </tr>
                        <?php endif; ?>

                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>Er zijn momenteel geen berichten.</p>
        <?php endif;
        wp_reset_postdata(); ?>
    </div>
</section>
<?php get_footer(); ?>

<script>
    jQuery(document).ready(function($) {
        $('[data-click="set-post-unread"]').on('click', function(e) {
            let ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            let postID = $(this).data('post-id')
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'increment_post_views',
                    data: postID,
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        });
    });
</script>