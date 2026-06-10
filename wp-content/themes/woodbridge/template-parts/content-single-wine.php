<?php

/**
 * The template used for displaying content single post
 *
 * @package WordPress
 * @subpackage woodbridge
 * @since 1.0
 * @version 1.0
 */
?>

<section class="hero-varietal-section pt-[30px]">
	<div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="180">
		<?php if (get_field('field_wine_location')) : ?>
			<h2 class="md:hidden text-15 leading-[1.2em] text-center px-5 mb-2.5"><?php echo get_field('field_wine_location'); ?></h2>
		<?php endif; ?>
		<?php if (get_field('field_wine_title')) : ?>
			<h3 class="md:hidden text-35 lg:text-40 leading-[1.14em] text-center px-5 mb-3"><?php echo get_field('field_wine_title'); ?></h3>
		<?php else : ?>
			<h3 class="md:hidden text-35 lg:text-40 leading-[1.14em] text-center px-5 mb-3"><?php the_title(); ?></h3>
		<?php endif; ?>
	</div>
	<div class="flex flex-wrap items-center">
		<?php if (get_field('varietals')) : ?>
			<div class="w-full md:w-1/2 relative pb-5 lg-down:mb-8" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
				<div class="absolute bottom-0 left-0 w-full h-[56%] z-[-1]" style="background-color: <?php echo get_field('field_wine_color_picker'); ?>"></div>
				<?php /* HIDDEN FOR LAUNCH
				if (get_field('field_wine_points_image')) : $points_image = wp_get_attachment_image_url(get_field('field_wine_points_image'), 'full'); ?>
					<img class="block absolute left-5 bottom-[46%] w-[82px] h-[96px] z-[1]" src="<?php echo esc_url($points_image); ?>" alt="<?php echo get_image_alt(get_field('field_wine_points_image')); ?>">
				<?php endif;
				*/ ?>
				<div>
					<div class="hero-varietal-slider">
						<?php foreach (get_field('field_wine_varietals') as $varietal) : $image = wp_get_attachment_image_url($varietal['image'], 'full'); ?>
							<div class="slideshow">
								<div class="slideshow-inner">
									<img class="block mx-auto max-h-[435px]" src="<?php echo esc_url($image); ?>" alt="<?php echo get_image_alt($varietal['image']); ?>">
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="hero-varietal-thumbnail-slider-wrap max-w-[350px] w-full mx-auto mt-4">
						<div class="hero-varietal-thumbnail-slider">
							<?php foreach (get_field('field_wine_varietals') as $varietal) : ?>
								<div class="slideshow size-<?php echo esc_attr($varietal['size']['value']); ?>">
									<div class="slideshow-inner text-center">
										<img class="block mx-auto mb-2" src="<?php echo get_theme_file_uri('/dist/images/' . $varietal['size']['value'] . '.svg'); ?>" alt="">
										<span class="block font-title text-10 leading-none font-medium tracking-w text-black relative pb-1 before:content-[''] before:absolute before:left-0 before:right-0 before:mx-auto before:bottom-0 before:w-full before:h-0.5 before:bg-black before:opacity-0 before:invisible"><?php echo $varietal['size']['label']; ?></span>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						<h4 class="text-15 leading-[1.2em] text-center m-0 mt-4">Available sizes</h4>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="w-full md:w-1/2" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
			<div class="max-w-[540px] w-full mx-auto px-5 text-center">
				<?php if (get_field('field_wine_location')) : ?>
					<h2 class="md-down:hidden text-15 leading-[1.2em] mb-2.5"><?php echo get_field('field_wine_location'); ?></h2>
				<?php endif; ?>
				<?php if (get_field('field_wine_title')) : ?>
					<h3 class="md-down:hidden text-35 lg:text-40 leading-[1.14em] mb-3"><?php echo get_field('field_wine_title'); ?></h3>
				<?php else : ?>
					<h3 class="md-down:hidden text-35 lg:text-40 leading-[1.14em] mb-3"><?php the_title(); ?></h3>
				<?php endif; ?>
				<?php if (get_field('field_wine_description')) : ?>
					<div class="entry"><?php echo get_field('field_wine_description'); ?></div>
				<?php endif; ?>
			</div>
			<?php
			$wine_upc = get_field('field_wine_upc');
			// $widget_id = get_field('mikmak_widget_id', 'option');
			$widget_id = '6a15c5e57bed13d7ae1519d5';
			if ($widget_id && $wine_upc) : ?>
				<div class="wine-mikmak-wrap mt-6">
					<div data-mm-wtbid="<?php echo esc_attr($widget_id); ?>" data-mm-ids="<?php echo esc_attr(sanitize_text_field($wine_upc)); ?>"></div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php if (get_field('field_brand_logos')) : ?>
	<section class="brand-logo-section py-[56px] lg:py-[80px]" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
		<div class="container max-w-[888px]">
			<div class="grid grid-cols-4 gap-2">
				<?php foreach (get_field('field_brand_logos') as $item) : $logo = wp_get_attachment_image_url($item['logo'], 'full'); ?>
					<div>
						<img class="block mx-auto w-[81px] h-[81px] md:w-[128px] md:h-[128px]" src="<?php echo esc_url($logo); ?>" alt="<?php echo get_image_alt($item['logo']); ?>">
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if (get_field('field_wine_description_headline') || get_field('field_wine_description_description')) : ?>
	<section class="wine-description-section pt-[65px] pb-[37px]" style="background-color: <?php echo get_field('field_wine_color_picker'); ?>" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
		<div class="container max-w-[850px] text-center">
			<?php if (get_field('field_wine_description_headline')) : ?>
				<h2 class="text-15 leading-[1.2em]"><?php echo get_field('field_wine_description_headline'); ?></h2>
			<?php endif; ?>
			<?php if (get_field('field_wine_description_description')) : ?>
				<div class="entry entry-2xl"><?php echo get_field('field_wine_description_description'); ?></div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>

<?php $items = (get_field('products_slider', 'options')) ? get_field('products_slider', 'options') : get_posts(['post_type' => 'wine', 'posts_per_page' => 6, 'fields' => 'ids']); ?>
<section class="products-slider-section pt-[56px] pb-[64px]" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
	<div class="container max-w-[1250px]">
		<?php if (get_field('products_slider_headline', 'options')) : ?>
			<h2 class="text-35 !leading-[1.14em] text-center mb-8 md:mb-10 lg:mb-14 px-5"><?php echo get_field('products_slider_headline', 'options'); ?></h2>
		<?php endif; ?>
		<div class="products-slider-wrap relative overflow-hidden z-30 px-6">
			<div class="products-slider">
				<?php foreach ($items as $itemID) : ?>
					<div class="slideshow text-center">
						<?php if (get_field('field_wine_bottle_image', $itemID)) : $bottle_image = wp_get_attachment_image_url(get_field('field_wine_bottle_image', $itemID), 'full'); ?>
							<div class="slideshow-image px-4 mb-[30px]">
								<a href="<?php echo get_permalink($itemID); ?>" class="inline-block max-h-[362px] group">
									<img class="block mx-auto max-h-[362px] transition-all ease-linear duration-200 origin-bottom group-hover:transform group-hover:scale-[1.02]" src="<?php echo esc_url($bottle_image); ?>" alt="<?php echo get_image_alt(get_field('field_wine_bottle_image', $itemID)); ?>">
								</a>
							</div>
						<?php endif; ?>
						<h3 class="m-0">
							<a href="<?php echo get_permalink($itemID); ?>" class="text-base !leading-[1.36em] text-black block transition-none hover:underline hover:text-[1.063rem]"><?php echo (get_field('field_wine_title', $itemID)) ? get_field('field_wine_title', $itemID) : get_the_title($itemID); ?></a>
						</h3>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>