<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div id="header">
        <div id="logoContainer">
            <a href="<?php bloginfo('url'); ?>">
                <img src="<?php bloginfo('template_directory'); ?>/assets/img/logo.svg" />
            </a>
        </div>
        <div id="mainNav">
            <ul>
                <li>
                    <a href="">Home</a>
                </li>
                <li>
                    <a href="<?php the_permalink(13); ?>">Berichten <div class="message-counter"><?php echo get_unread_messages_counter(); ?></div></a>
                </li>
                <li>
                    <a href="">Documenten <div class="message-counter">0</div></a>
                </li>
            </ul>
        </div>
        <?php //wp_nav_menu(array('theme_location' => 'mainnav', 'container' => 'div', 'container_id' => 'mainNav')); 
        ?>
    </div>

    <div id="mainContainer">