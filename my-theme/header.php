<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="page" class="site">

    <a class="screen-reader-text" href="#primary">
        <?php esc_html_e( 'Skip to content', 'my-theme' ); ?>
    </a>

    <?php
    /*
     * TGNE Custom Header
     * Rendered via tgne_render_header() defined in inc/tgne-header.php.
     * The global $tgne_header_done flag prevents double-printing.
     */
    tgne_render_header();
    ?>

    <div id="content" class="site-content">
