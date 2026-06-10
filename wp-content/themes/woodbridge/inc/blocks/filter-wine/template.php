<?php

/**
 * Filter Wine Block Template
 *
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$headline		= get_field('headline');
$description	= get_field('description'); ?>

<section class="filter-wine-section relative z-20 bg-[#FDF8F4] pt-[80px] pb-[62px]">
	<div class="container max-w-[1180px]">
		<div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
			<?php if ($headline) : ?>
				<h2 class="text-40 leading-[1.14em] text-center mb-9"><?php echo $headline; ?></h2>
			<?php endif; ?>
			<?php if ($description) : ?>
				<div class="entry text-center mb-[36px] lg:mb-[77px]"><?php echo $description; ?></div>
			<?php endif; ?>
		</div>
		<?php $posts = get_posts(['post_type' => 'wine', 'posts_per_page' => -1, 'fields' => 'ids']); ?>
		<?php if ($posts) : ?>
			<div class="filter-content">
				<div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
					<div class="flex lg-down:flex-col items-center justify-center gap-5 mb-[74px] lg:mb-[124px] lg-down:text-center">
						<h3 class="text-15 !leading-none m-0 lg-down:w-full">Sort by:</h3>
						<ul class="filter-menu flex gap-2.5 sm:gap-5 list-none m-0 p-0">
							<li><a href="#all" class="btn bg-[#FDF8F4] text-black hover:bg-black hover:text-[#FFFDFD] px-[6px] py-[11px] sm:p-[11px] active">All Wines</a></li>
							<?php $terms = get_terms(['taxonomy' => 'wine_category', 'hide_empty' => true]);
							foreach ($terms as $term) : ?>
								<li><a href="#<?php echo $term->slug; ?>" class="btn bg-[#FDF8F4] text-black hover:bg-black px-[6px] py-[11px] sm::p-[11px] hover:text-[#FFFDFD]"><?php echo $term->name; ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
				<div>
					<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-5 gap-y-[50px] lg:gap-y-[80px]">
						<?php foreach ($posts as $postID) : $terms = get_the_terms($postID, 'wine_category');
							$term = (isset($terms[0])) ? $terms[0]->slug : ''; ?>
							<div data-category="<?php echo $term; ?>" class="relative text-center" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
								<a href="<?php echo get_permalink($postID); ?>" class="block h-full pb-8 group">
									<?php /* HIDDEN FOR LAUNCH
									if (get_field('field_wine_points_image', $postID)) : $points_image = wp_get_attachment_image_url(get_field('field_wine_points_image', $postID), 'full'); ?>
										<img class="block absolute top-1 right-0 w-[68px] h-[80px]" src="<?php echo esc_url($points_image); ?>" alt="<?php echo get_image_alt(get_field('field_wine_points_image', $postID)); ?>">
									<?php endif;
									*/ ?>
									<div class="bgr absolute bottom-0 left-0 w-full h-0 z-[-1] transition-all ease-out duration-200 group-hover:h-[55%] lg-down:!h-[57%]" style="background-color: <?php echo get_field('field_wine_color_picker', $postID); ?>"></div>
									<?php if (get_field('field_wine_bottle_image', $postID)) : $bottle_image = wp_get_attachment_image_url(get_field('field_wine_bottle_image', $postID), '200x534'); ?>
										<div class="px-4 max-h-[227px] lg:max-h-[387px] mb-[11px]">
											<img class="block mx-auto max-h-[227px] lg:max-h-[387px]" src="<?php echo esc_url($bottle_image); ?>" alt="<?php echo get_image_alt(get_field('field_wine_bottle_image', $postID)); ?>">
										</div>
									<?php endif; ?>
									<h3 class="text-base !leading-[1.26em] m-0 px-2 lg:px-0"><?php echo (get_field('field_wine_title', $postID)) ? get_field('field_wine_title', $postID) : the_title(); ?></h3>
									<div class="absolute bottom-3 left-0 right-0 mx-auto z-[1] inline-block font-title text-[0.75rem] !leading-[1.2em] font-medium tracking-w uppercase text-black hover:underline">Learn more</div>
								</a>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>