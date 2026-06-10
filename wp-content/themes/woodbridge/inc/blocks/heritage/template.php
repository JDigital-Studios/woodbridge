<?php
/**
 * Heritage Block Template
 *
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */



$headline		= get_field('headline');
$description	= get_field('description');
$button			= get_field('button');
$image			= wp_get_attachment_image_url(get_field('image'), 'full');
?>

<section class="heritage-section relative z-20 bg-[#FDF8F4]">
	<div class="flex flex-wrap items-center">
		<?php if ($image) : ?>
		<div class="w-full md:w-1/2 md-down:order-1" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
			<img class="block w-full" src="<?php echo esc_url($image); ?>" alt="<?php echo get_image_alt(get_field('image')); ?>"> <!-- 1009x880 -->
		</div>
		<?php endif; ?>
		<div class="w-full md:w-1/2 md-down:order-2 md-down:mb-10" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
			<div class="max-w-[550px] w-full mx-auto text-center px-5">
				<?php if ($headline) : ?>
				<h2 class="text-35 leading-[1.14em] mt-8 md:mt-0 mb-3 lg:mb-8"><?php echo $headline; ?></h2>
				<?php endif; ?>
				<?php if ($description) : ?>
				<div class="entry mb-8 lg:mb-12"><?php echo $description; ?></div>
				<?php endif; ?>
				<?php if ($button) : ?>
				<div>
					<a href="<?php echo esc_url($button['url']); ?>" class="btn" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?></a>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
