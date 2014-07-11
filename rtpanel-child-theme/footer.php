<?php
/**
 * The template for displaying the footer
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */
global $rtp_general;

                    rtp_hook_end_content_row(); ?>

                </div> <!-- End of content-wrapper row -->

                <?php rtp_hook_end_content_wrapper(); ?>

            </div><!-- #content-wrapper -->

            <?php rtp_hook_before_footer(); ?>

            <footer id="footer-wrapper" role="contentinfo" class="clearfix rtp-footer-wrapper rtp-section-wrapper">

<div class="my_footer">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footerwidget') ) : ?>
      <?php endif; ?>
      </div>

                <?php rtp_hook_begin_footer(); ?>

                <?php
                /* Grid class for widget */
                $rtp_footer_widget_grid_class = apply_filters( 'rtp_set_footer_widget_grid_class', 'large-4 columns' );

                if ( $rtp_general['footer_sidebar'] ) { ?>
                    <aside role="complementary" id="rtp-footer-widgets-wrapper" class="rtp-footerbar rtp-section-container row"><?php
                        // Default Widgets ( Fallback )
                        if ( !dynamic_sidebar( 'footer-widgets' ) ) { ?>
                            <div class="widget footerbar-widget <?php echo esc_attr($rtp_footer_widget_grid_class); ?>"><h3 class="widgettitle"><?php _e( 'Archives', 'rtPanel' ); ?></h3><ul><?php wp_get_archives( array( 'type' => 'monthly' ) ); ?></ul></div>
                            <div class="widget footerbar-widget <?php echo esc_attr($rtp_footer_widget_grid_class); ?>"><h3 class="widgettitle"><?php _e( 'Tags', 'rtPanel' ); ?></h3><div class="tagcloud"><?php wp_tag_cloud(); ?></div></div>
                            <div class="widget footerbar-widget <?php echo esc_attr($rtp_footer_widget_grid_class); ?>"><h3 class="widgettitle"><?php _e( 'Meta', 'rtPanel' ); ?></h3><ul><?php wp_register(); ?><li><?php wp_loginout(); ?></li><?php wp_meta(); ?></ul></div><?php
                        } ?>
                    </aside><!-- #footerbar --><?php
                } ?>

                <?php //rtp_hook_end_footer(); ?>
<div style="display: inline-block;background-color:#AF9B69;">
                <p style="margin-bottom: 0px;
font-size: 12px;
color: #fff;
margin-left: 12%;
width: 78%;line-height: 20px;"><b>Desclaimer:</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent in quam sit amet metus dignissim fermentum sit amet vel metus. Nam euismod vel justo vulputate euismod. Praesent orci diam, sagittis a ipsum eget, convallis volutpat nunc. Fusce e</p>
                </div>
            </footer><!-- #footer-wrapper-->

            <?php rtp_hook_after_footer(); ?>

            <?php rtp_hook_end_main_wrapper(); ?>

        </div><!-- #main-wrapper -->

        <?php wp_footer(); ?>
    </body>
</html>