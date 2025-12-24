<?php
global $post;

$permalink   = apply_filters( 'ovic_loop_post_link', get_the_permalink(), $post );
$lazy        = kuteshop_get_option( 'kuteshop_theme_lazy_load' );
$lazy_check  = $lazy == 1 ? true : false;
$image_thumb = kuteshop_resize_image( get_post_thumbnail_id(), 270, 260, true, $lazy_check );
?>
<div class="blog-thumb">
    <a href="<?php echo esc_url( $permalink ); ?>">
		<?php
		echo '<figure>';
		echo wp_specialchars_decode( $image_thumb['img'] );
		echo '</figure>';
		?>
    </a>
</div>
<div class="blog-info">
    <h4 class="blog-title"><a href="<?php echo esc_url( $permalink ); ?>"><?php the_title(); ?></a></h4>
    <div class="blog-date"><?php echo get_the_date( 'd F, Y' ); ?></div>
    <div class="post-content">
		<?php echo wp_trim_words( apply_filters( 'the_excerpt', get_the_excerpt() ), 20, esc_html__( '...', 'kuteshop' ) ); ?>
    </div>
    <div class="blog-category">
        <i class="fa fa-bookmark"></i>
		<?php the_category(); ?>
    </div>
</div>