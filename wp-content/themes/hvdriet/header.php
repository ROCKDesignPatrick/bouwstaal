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
    <header class="header">
        <div class="header-wrapper">
            <div class="logo">
                <a href="<?php bloginfo('url'); ?>">
                    <!-- <img src="<?php bloginfo('template_directory'); ?>/assets/img/logo.svg" /> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="176" height="40" fill="none" viewBox="0 0 176 40">
                        <path fill="#fff" fill-rule="evenodd" d="M15 28a5 5 0 0 1-5-5V0H0v23c0 8.284 6.716 15 15 15h11V28H15ZM45 10a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm-19 9C26 8.507 34.507 0 45 0s19 8.507 19 19-8.507 19-19 19-19-8.507-19-19ZM153 10a9 9 0 0 0-9 9 9 9 0 0 0 9 9 9 9 0 0 0 9-9 9 9 0 0 0-9-9Zm-19 9c0-10.493 8.507-19 19-19s19 8.507 19 19-8.507 19-19 19-19-8.507-19-19ZM85 0C74.507 0 66 8.507 66 19s8.507 19 19 19h28c1.969 0 3.868-.3 5.654-.856L124 40l5.768-10.804A19.007 19.007 0 0 0 132 20.261V19c0-10.493-8.507-19-19-19H85Zm37 19a9 9 0 0 0-9-9H85a9 9 0 1 0 0 18h28a9 9 0 0 0 9-8.93V19Z" clip-rule="evenodd"></path>
                    </svg>

                </a>
            </div>
            <span class="menu" data-click="toggle-navigation"><i class="icon icon-hamburger-menu"></i></span>
        </div>
        <div class="navigation-wrapper">
            <span class="navigation-close" data-click="toggle-navigation"><i class="icon icon-close"></i></span>
            <nav class="navigation">
                <ul>
                    <li>
                        <a href="<?php echo home_url() ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php the_permalink(13); ?>">Berichten <div class="message-counter"><?php echo get_unread_messages_counter('post'); ?></div></a>
                    </li>
                    <li>
                        <a href="<?php the_permalink(21); ?>">Documenten <div class="message-counter"><?php echo get_unread_messages_counter('document'); ?></div></a>
                    </li>
                    <li><a href="<?php echo wp_logout_url() ?>">Uitloggen</a></li>
                </ul>
            </nav>
        </div>

    </header>

    <main class="main">