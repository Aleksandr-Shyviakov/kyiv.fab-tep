<?php
global $post;
$enable_related   = kuteshop_get_option( 'kuteshop_single_related' );
$categories       = get_the_category( $post->ID );
if ( $categories && $enable_related == 1 ) :
	$woo_ls_items = kuteshop_get_option( 'related_ls_items', 3 );
	$woo_lg_items = kuteshop_get_option( 'related_lg_items', 3 );
	$woo_md_items = kuteshop_get_option( 'related_md_items', 3 );
	$woo_sm_items = kuteshop_get_option( 'related_sm_items', 2 );
	$woo_xs_items = kuteshop_get_option( 'related_xs_items', 1 );
	$woo_ts_items = kuteshop_get_option( 'related_ts_items', 1 );
	$atts         = array(
		'owl_loop'     => 'false',
		'owl_ts_items' => $woo_ts_items,
		'owl_xs_items' => $woo_xs_items,
		'owl_sm_items' => $woo_sm_items,
		'owl_md_items' => $woo_md_items,
		'owl_lg_items' => $woo_lg_items,
		'owl_ls_items' => $woo_ls_items,
	);
	$owl_settings = apply_filters( 'generate_carousel_data_attributes', 'owl_', $atts );
	$category_ids = array();
	foreach ( $categories as $value ) {
		$category_ids[] = $value->term_id;
	}
	$args      = array(
		'category__in'        => $category_ids,
		'post__not_in'        => array( $post->ID ),
		'posts_per_page'      => 9,
		'ignore_sticky_posts' => 1,
		'orderby'             => 'rand',
	);
	$new_query = new wp_query( $args );
	if ( $new_query->have_posts() ) : ?>
        <div class="related-post">
            <h3 class="title">
                <span><?php echo esc_html__( 'Related Posts', 'kuteshop' ); ?></span>
            </h3>
            <div class="owl-slick" <?php echo esc_attr( $owl_settings ); ?>>
				<?php while ( $new_query->have_posts() ): $new_query->the_post();
					$class          = array( 'post-item' );
					$lazy           = kuteshop_get_option( 'kuteshop_theme_lazy_load' );
					$lazy_check     = $lazy == 1 ? true : false;
					$image_thumb    = kuteshop_resize_image( get_post_thumbnail_id(), 350, 250, true, $lazy_check );
					$permalink      = apply_filters( 'ovic_loop_post_link', get_the_permalink(), $post );
					$auth_permalink = get_author_posts_url( get_the_author_meta( 'ID' ) );
					$auth_permalink = apply_filters( 'ovic_loop_post_link', $auth_permalink, $post );
					?>
                    <article <?php post_class( $class ); ?>>
                        <div class="post-thumb">
                            <a class="thumb-link" href="<?php echo esc_url( $permalink ); ?>">
								<?php echo wp_specialchars_decode( $image_thumb['img'] ); ?>
                            </a>
                        </div>
                        <div class="post-info">
                            <h2 class="post-title">
                                <a href="<?php echo esc_url( $permalink ); ?>">
									<?php the_title(); ?>
                                </a>
                            </h2>
                            <a class="author"
                               href="<?php echo esc_url( $auth_permalink ) ?>">
								<?php the_author() ?>
                            </a>
                        </div>
                    </article>
				<?php endwhile; ?>
            </div>
        </div>
	<?php endif;
endif;
wp_reset_postdata();