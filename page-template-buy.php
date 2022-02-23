<?php
/**
 * Template Name: Strona zakupowa
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>


<?php get_header(); ?>

    <div id="main-content" data-buy-content>

        <?php if (!$is_page_builder_used) : ?>

        <div id="content-area" class="clearfix">
            <div id="left-area">

                <?php endif; ?>

                <?php while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php if (!$is_page_builder_used) : ?>
                            <?php
                            $thumb = '';

                            $width = (int)apply_filters('et_pb_index_blog_image_width', 1080);

                            $height = (int)apply_filters('et_pb_index_blog_image_height', 675);
                            $classtext = 'et_featured_image';
                            $titletext = get_the_title();
                            $alttext = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                            $thumbnail = get_thumbnail($width, $height, $classtext, $alttext, $titletext, false, 'Blogimage');
                            $thumb = $thumbnail["thumb"];

                            if ('on' === et_get_option('divi_page_thumbnails', 'false') && '' !== $thumb)
                                print_thumbnail($thumb, $thumbnail["use_timthumb"], $alttext, $width, $height);
                            ?>

                        <?php endif; ?>

                        <div class="entry-content">
                            <?php
                            the_content();
                            ?>
                        </div> <!-- .entry-content -->


                    </article> <!-- .et_pb_post -->

                <?php endwhile; ?>

                <?php if (!$is_page_builder_used) : ?>

            </div> <!-- #left-area -->
        </div> <!-- #content-area -->


    <?php endif; ?>

    </div> <!-- #main-content -->

<?php
if (isset($_GET['product'])) {

    echo "<script type='text/javascript'>

        let product = '" . $_GET['product'] . "';
        let qta = '" . $_GET['qty'] . "';
        let type = '" . $_GET['type'] . "';
        let coupon = '" . $_GET['coupon'] . "';
        let main  = document.querySelector('[data-buy-content]');
        main.innerHTML = '';

        let shop_url = 'https://rapanpl.secure.force.com/commerciallicense?product='+product;


        if(type === 'upgrade') {
           shop_url = 'https://rapanpl.secure.force.com/commerciallicense?product='+product+'&QTY='+qta;
        }
        
        if (coupon) {
            shop_url += '&coupon=' + coupon;
        } else {
            shop_url += '&coupon=';
        }


        let frame = '<iframe width=\"100% \" height=\"1300px\" src='+shop_url+'></iframe>';
        main.innerHTML = frame;

    </script>";

}
?>


<?php

get_footer();