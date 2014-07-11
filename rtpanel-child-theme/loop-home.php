<?php
/**
 * The loop that displays the post according to the query
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */
global $rtp_post_comments;
	global $wpdb;

/* Archive Page Titles */
if ( is_search() ) { ?>
    <h1 class="post-title rtp-main-title"><?php printf( __( 'Search Results for: %s', 'rtPanel' ), '<span>' . get_search_query() . '</span>' ); ?></h1><?php
} elseif ( is_tag() ) { ?>
    <h1 class="post-title rtp-main-title"><?php printf( __( 'Tags: %s', 'rtPanel' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1><?php
} elseif ( is_category() ) { ?>
    <h1 class="post-title rtp-main-title"><?php printf( __( 'Category: %s', 'rtPanel' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1><?php
} elseif ( is_day() ) { ?>
    <h1 class="post-title rtp-main-title"><?php printf( __( 'Archive for %s', 'rtPanel' ), '<span>' . get_the_time( 'F jS, Y' ) . '</span>' ); ?></h1><?php
} elseif ( is_month() ) { ?>
    <h1 class="post-title rtp-main-title"><?php printf( __( 'Archive for  %s', 'rtPanel' ), '<span>' . get_the_time( 'F, Y' ) . '</span>' ); ?></h1><?php
} elseif ( is_year() ) { ?>
    <h1 class="post-title rtp-main-title"><?php printf( __( 'Archive for  %s', 'rtPanel' ), '<span>' . get_the_time( 'Y' ) . '</span>' ); ?></h1><?php
} elseif ( is_author() ) {
    $curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) ); ?>
    <h1 class="post-title rtp-main-title"><?php printf( __( 'Author: %s', 'rtPanel' ), '<span>' . $curauth->display_name . '</span>' ); ?></h1><?php
}

/* The Loop */
if ( have_posts() ) {
    while( have_posts() ) {
        the_post(); ?>

        <article id="post-<?php if ( !rtp_is_bbPress() ) { the_ID(); } else { echo 'forum-index'; } ?>" <?php post_class( 'clearfix rtp-post-box' ); ?>>
            <?php rtp_hook_begin_post(); ?>
			<header>
            <div class="my_slider">
            <?php 
			echo do_shortcode('[rohan_veer]');
			 $selected_value = $wpdb->get_results( 'SELECT option_value FROM wp_options WHERE option_name = \'slider_page\'');
 $selected_page_name = $selected_value[0]->option_value;
 $page = get_page_by_title( $selected_page_name );
 $page_title = $page->post_title;
 $trimmed_content = wp_trim_words( $page->post_content, 50, '<br /><a href="'. get_permalink() .'"> ...Read More</a>' );
 echo '<h4 style="float: right;margin-right: 15%;color: #F00;">'.$page_title.'</h4><div class="slider_page">';echo get_the_post_thumbnail( $page->ID, 'thumbnail');
echo $trimmed_content.'</div>';
			?>
            </div>
            </header>
            <div class="you_tube_gallery">
            <?php echo do_shortcode('[wonderplugin_carousel id="1"]'); ?>
            </div>
            <div class="right_sidebar_home">
            <div class="post_gallery" style="margin-right: 4%;">
            <h3 class="header_img" style="margin-bottom: 5%;">Glimpses of Exhibition</h3>
            <?php
global $post;
$gridnumber = 4;
$counter = 0;
$flag = 0;
$args = array( 'post_type' => 'homegallery','posts_per_page'   => 8,);
$myposts = get_posts( $args );
foreach ( $myposts as $post ) : if($flag == 0)
{
echo '<ul>';
$flag = 1;	
}
?>
	<li style="display: inline-block;margin-right: 10px;">
     <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail');?></a>
     <p><?php  the_title();  ?></p>
    </li>
<?php 
$counter++;
if($counter==$gridnumber){
$flag=0;
echo '</ul>';
}
endforeach; ?>
            </div>
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('bottomwidget') ) : ?>
      <?php endif; ?>
            </div>
            <div>
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('leftsidebar') ) : ?>
      <?php endif; ?>
      </div>
      <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('bottomwidgetlast') ) : ?>
      <?php endif; ?>
            <div class="post-content">
                <?php rtp_hook_begin_post_content(); ?>

                <?php rtp_show_post_thumbnail(); ?>

                <?php   if ( is_singular() || !$rtp_post_comments['summary_show'] || rtp_is_bbPress() || rtp_is_rtmedia() ) {
                            the_content( __( 'Read More &rarr;', 'rtPanel' ) );
                            wp_link_pages( array( 'before' => '<div class="page-link clearfix">' . __( 'Pages:', 'rtPanel' ), 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                        } else {
                            @the_excerpt();
                        } ?>

                <?php rtp_hook_end_post_content(); ?>
            </div><!-- .post-content -->

            <?php rtp_hook_post_meta( 'bottom' ); ?>

            <?php rtp_hook_end_post(); ?>

        </article><!-- .rtp-post-box --><?php

            /* Post Pagination */
        rtp_hook_single_pagination();

        // Comment Form
        //rtp_hook_comments();
    }

    rtp_hook_archive_pagination();

} else {
    /* If there are no posts to display */ 
    if ( !is_search() ) { ?>
        <h1 class="post-title rtp-main-title"><?php _e( 'Not Found', 'rtPanel' ); ?></h1><?php
    } ?>

        <?php rtp_hook_begin_post(); ?>

        <div class="post-content rtp-not-found">
            <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'rtPanel' ); ?></p>
            <?php get_search_form(); ?>
        </div>

        <?php rtp_hook_end_post(); ?>
    <?php
}