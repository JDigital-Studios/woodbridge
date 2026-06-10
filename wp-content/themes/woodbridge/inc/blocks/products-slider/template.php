<?php

/**
 * Products Slider Block Template
 *
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$headline	= get_field('headline');
$items		= (get_field('products_slider')) ? get_field('products_slider') : get_posts(['post_type' => 'wine', 'posts_per_page' => 6, 'fields' => 'ids']); ?>

<section class="products-slider-section relative z-20 bg-[#FDF8F4] pt-[56px] pb-[64px]" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
	<div class="container max-w-[1250px]">
		<?php if ($headline) : ?>
			<h2 class="text-35 !leading-[1.14em] text-center mb-8 md:mb-10 lg:mb-14 px-5"><?php echo $headline; ?></h2>
		<?php endif; ?>
		<?php if ($items) : ?>
			<div class="products-slider-wrap relative overflow-hidden z-30 px-6">
				<div class="products-slider">
					<?php foreach ($items as $itemID) : ?>
						<div class="slideshow text-center">
							<?php if (get_field('field_wine_bottle_image', $itemID)) : $bottle_image = wp_get_attachment_image_url(get_field('field_wine_bottle_image', $itemID), '200x534'); ?>
								<div class="slideshow-image px-4 mb-[30px]">
									<a href="<?php echo get_permalink($itemID); ?>" class="inline-block max-h-[362px] group">
										<img class="block mx-auto max-h-[362px] transition-all ease-linear duration-200 origin-bottom group-hover:transform group-hover:scale-[1.02]" src="<?php echo esc_url($bottle_image); ?>" alt="<?php echo get_image_alt(get_field('field_wine_bottle_image', $itemID)); ?>">
									</a>
								</div>
							<?php endif; ?>
							<h3 class="m-0">
								<a href="<?php echo get_permalink($itemID); ?>" class="text-base !leading-[1.36em] text-black block transition-none hover:underline hover:text-[1.063rem] px-2 lg:px-0"><?php echo (get_field('field_wine_title', $itemID)) ? get_field('field_wine_title', $itemID) : get_the_title($itemID); ?></a>
							</h3>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>