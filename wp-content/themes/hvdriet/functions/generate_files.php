<?php

function generate_css()
{

    // Start output buffer capture
    ob_start();

    // Include all general files
    foreach (glob(get_template_directory() . "/assets/css/general/*.css") as $sFilename) include $sFilename;

    // Get the output of all includes
    $sStylesheet = ob_get_contents();

    // Clear the buffer.
    ob_end_clean();

    // Write the file
    file_put_contents(get_template_directory() . "/assets/css/main.css", $sStylesheet);
}

function generate_js()
{

    // Start output buffer capture
    ob_start();

    // Include all general files
    foreach (glob(get_template_directory() . "/assets/js/general/*.js") as $sFilename) include $sFilename;

    // Get the output of all includes
    $sJavascript = ob_get_contents();

    // Clear the buffer.
    ob_end_clean();

    // Write the file
    file_put_contents(get_template_directory() . "/assets/js/main.js", $sJavascript);
}

if (!get_transient('generate_css')) {

    // Set transient
    set_transient('generate_css', true, 1 * MINUTE_IN_SECONDS);

    // Generate the css
    generate_css();
}

if (!get_transient('generate_js')) {

    // Set transient
    set_transient('generate_js', true, 1 * MINUTE_IN_SECONDS);

    // Generate the js
    generate_js();
}

add_action('init', 'generate_css');
add_action('init', 'generate_js');

function add_custom_styles_scripts()
{
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/css/vendor/bootstrap/bootstrap.min.css');
    wp_enqueue_style('main-css', get_template_directory_uri() . '/assets/css/main.css');
    wp_enqueue_script('jquery-js', get_template_directory_uri() . '/assets/js/vendor/jquery/jquery-3.3.1.min.js', array(), '3.3.1', false);
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/vendor/bootstrap/bootstrap.bundle.min.js', array(), '3.0.0', true);
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'add_custom_styles_scripts');
