<?php
global $post;

$permalink      = apply_filters( 'ovic_loop_post_link', get_the_permalink(), $post );
$auth_permalink = get_author_posts_url( get_the_author_meta( 'ID' ) );
$auth_permalink = apply_filters( 'ovic_loop_post_link', $auth_permalink, $post );
?>
<div class="blog-info equal-elem">
    <a class="post-content" href="<?php echo esc_url( $permalink ); ?>">
		<?php echo wp_trim_words( apply_filters( 'the_excerpt', get_the_excerpt() ), 12, esc_html__( '', 'kuteshop' ) ); ?>
    </a>
    <a class="the-author" href="<?php echo esc_url( $auth_permalink ); ?>">
        @<?php the_author(); ?>
    </a>
    <p class="time-post"><?php kuteshop_time_ago(); ?></p>
</div>