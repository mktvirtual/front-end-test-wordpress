<?php
/**
 * This is the front page code
 * Template Name: HomePage
 */
get_header();

//load slider
do_action('accesspress_slickslider');
?>
<?php if (is_active_sidebar('promo-widget-1')): ?>
    <section id="promo-section1">
        <div class="ak-container">
            <div class="promo-wrap1">
                <div class="promo-product1 clearfix">
                    <?php dynamic_sidebar('promo-widget-1'); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (is_active_sidebar('product-widget-1')): ?>
    <!-- This is Product 1 Section !-->
    <section id="product1" class="prod1-slider">
        <div class="ak-container">
            <?php dynamic_sidebar('product-widget-1'); ?>
        </div>
    </section>
<?php endif; ?>

<section id="promo-section2">
    <div class="ak-container">
        <div class="promo-wrap2">
            <?php if (is_active_sidebar('promo-widget-2')): ?>
                <div class="promo-product2">
                    <?php dynamic_sidebar('promo-widget-2'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (is_active_sidebar('product-widget-2')): ?>
    <!-- This is Product 2 Section !-->
    <section id="product2" class="prod2-slider">
        <div class="ak-container">
            <?php dynamic_sidebar('product-widget-2'); ?>
        </div>
    </section>
<?php endif; ?>

<?php if (is_active_sidebar('cta-video')): ?>
    <section id="ap-cta-video" class="cta-video-section-wrap">
        <div class="cta-overlay">
            <div class="ak-container">
                <div class="cta-vid-wrap">
                    <?php dynamic_sidebar('cta-video') ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (is_active_sidebar('product-widget-3')): ?>
    <section class="ap-cat-list clear">
        <div class="ak-container">
            <div class="cat-list-wrap">
                <?php dynamic_sidebar('product-widget-3') ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (is_active_sidebar('promo-widget-3')): ?>
    <section id="promo-section3">
        <div class="ak-container">
            <div class="promo-wrap3">
                <div class="promo-product2">
                    <?php dynamic_sidebar('promo-widget-3'); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; 

get_footer();