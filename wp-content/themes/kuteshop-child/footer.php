<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Kuteshop
 * @since 1.0
 * @version 1.0
 **/
kuteshop_get_footer();
if ( is_front_page() ) {
	get_template_part( 'templates-parts/popup', 'newsletter' );
}
?>
<a href="#" class="backtotop">
    <i class="pe-7s-angle-up"></i>
</a>
<div id="kuteshop-modal-popup" class="modal fade"></div>

<?php
    if (get_locale() == 'ru_RU') {
        $promo_link = 'https://kyiv.fabrika-teplic.com/ru/zakaz/';
        $promo_title = 'ЦЕНЫ';
        $promo_bottom = 'ВСЕ ТЕПЛИЦЫ';
        $modal_title = 'Выберите теплицу';
        $modal_subtitle = 'Оставьте свой номер телефона и мы перезвоним';
        $modal_form_id = '11315';
    } else {
        $promo_link = 'https://kyiv.fabrika-teplic.com/zamovlennya/';
        $promo_title = 'ЦІНИ';
        $promo_bottom = 'ВСІ ТЕПЛИЦІ';
        $modal_title = 'Виберіть теплицю';
        $modal_subtitle = 'Залиште свій номер телефону і ми передзвонимо';
        $modal_form_id = '10697';
    }
?>

<div class="promo-attention">
    <a class="promo-attention__container" href="<?php echo $promo_link; ?>">

        <div class="promo-attention__label">
            <?php echo $promo_title; ?>
        </div>
        <div class="promo-attention__figure">
            <img class="promo-attention__figure-img" src="https://fabrika-teplic.com/wp-content/themes/kuteshop-child/img/greenhouse-02.png" alt="">
        </div>
        <div class="promo-attention__date">
            <?php echo $promo_bottom; ?>
        </div>

    </a>
</div>

<div class="price-order modal fade" id="modal-price-order" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-body__name">
                    <?php echo $modal_title; ?>
                </div>
                <div class="modal-body__heading">
                    <?php echo $modal_subtitle; ?>
                </div>
                <?php echo do_shortcode("[contact-form-7 id='" . $modal_form_id . "' . html_class='price-form' title='']");  ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-close__btn" data-dismiss="modal">x</button>
            </div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
