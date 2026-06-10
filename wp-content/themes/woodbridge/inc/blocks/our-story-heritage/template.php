<?php
/**
 * Two Cols Block Template
 * 
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$image			= wp_get_attachment_image_url(get_field('image'), 'full');
$headline		= get_field('headline');
$description	= get_field('description'); ?>

<section class="our-story-heritage-section relative z-20 pt-[70px] pb-[50px] lg:pt-[100px] lg:pb-[80px] bg-primary-600" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
	<div class="container max-w-[1080px]">
		<div class="flex flex-wrap justify-between">
			<?php if ($image) : ?>
			<div class="w-full md:w-[180px] lg:w-[220px] md:shrink-0 md-down:mb-[36px]">
				<img class="block max-w-[220px] md-down:mx-auto" src="<?php echo esc_url($image); ?>" alt="<?php echo get_image_alt(get_field('image')); ?>">
			</div>
			<?php endif; ?>
			<div class="md:w-[calc(100%-220px)] lg:w-[calc(100%-310px)]">
				<?php if ($headline) : ?>
				<h2 class="text-35 leading-[1.22em]"><?php echo $headline; ?></h2>
				<?php endif; ?>
				<?php if ($description) : ?>
				<div class="entry"><?php echo $description; ?></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
