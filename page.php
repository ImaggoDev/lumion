<?php

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used(get_the_ID());

?>

<style>
    .imogo{
        width:100%;
        height:100%;
        position:absolute;
        top:0;
        padding-top:24%;
        width:100%;
        height:100vh;
        -webkit-background-size: cover !important;
      -moz-background-size: cover !important;
      -o-background-size: cover !important;
      background-size: cover !important;
        background: url(<?php echo get_field('zdjecie_przed_filmem', 'option'); ?>) no-repeat center center; 
    }
    .imogo h1{
        text-align:center;
     
        font-weight: 300;
    font-size:3rem;
    color: #ffffff!important;
    letter-spacing: 1px;
    line-height: 1.2em;
    text-align: center;
    text-shadow: 0em 0em 0.3em rgba(0, 0, 0, 0.87);
    }
    .imogo p{
        text-align:center;
    
        font-weight: 300;
    font-size:2rem;
    color: #ffffff!important;
    letter-spacing: 1px;
    line-height: 1.2em;
    text-align: center;
    text-shadow: 0em 0em 0.3em rgba(0, 0, 0, 0.87);
    }
</style>
<?php 
if(is_front_page()){
?>
<div class="imogo">
    <p><?php echo get_field('tekst_przed_filmem_1', 'option'); ?></p>
<h1><?php echo get_field('tekst_przed_filmem_2', 'option'); ?></h1>
</div>

    <?php } ?>
    <script>
     $(document).ready(function () {
        $('.imogo').hide('slow');
    });
</script>
<div id="main-content">

    <?php if (!$is_page_builder_used) : ?>

        <div class="container">
            <div id="content-area" class="clearfix">
                <div id="left-area">

                <?php endif; ?>

                <?php while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php if (!$is_page_builder_used) : ?>

                            <h1 class="entry-title main_title"><?php the_title(); ?></h1>
                            <?php
                            $thumb = '';

                            $width = (int) apply_filters('et_pb_index_blog_image_width', 1080);

                            $height = (int) apply_filters('et_pb_index_blog_image_height', 675);
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

                            if (!$is_page_builder_used)
                                wp_link_pages(array('before' => '<div class="page-links">' . esc_html__('Pages:', 'Divi'), 'after' => '</div>'));
                            ?>
                        </div> <!-- .entry-content -->

                        <?php
                        if (!$is_page_builder_used && comments_open() && 'on' === et_get_option('divi_show_pagescomments', 'false')) comments_template('', true);
                        ?>

                    </article> <!-- .et_pb_post -->

                <?php endwhile; ?>

                <?php if (!$is_page_builder_used) : ?>

                </div> <!-- #left-area -->

                <?php get_sidebar(); ?>
            </div> <!-- #content-area -->
        </div> <!-- .container -->

    <?php endif; ?>

</div> <!-- #main-content -->




<?php


get_footer();
