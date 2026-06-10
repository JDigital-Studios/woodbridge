<?php

/**
 * Description With Image Block Template
 * 
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$desktop_image	= wp_get_attachment_image_url(get_field('desktop_image'), 'full');
$mobile_image	= wp_get_attachment_image_url(get_field('mobile_image'), 'full');
$headline		= get_field('headline');
$description	= get_field('description');
$button			= get_field('button');
?>

<section class="description-with-image relative z-[30] bg-[#FDF8F4] min-h-[400px] py-16 lg:py-0 flex items-center">
	<?php if ($desktop_image) : ?>
		<img class="description-with-image-desktop hidden lg:block w-[calc(100%-100px)] mx-auto absolute top-1/2 transform -translate-y-1/2 left-0 right-0 z-[-1]" src="<?php echo esc_url($desktop_image); ?>" alt="<?php echo get_image_alt(get_field('desktop_image')); ?>">
	<?php endif; ?>
	<?php if ($mobile_image) : ?>
		<img class="description-with-image-mobile block lg:hidden w-full mx-auto absolute top-1/2 transform -translate-y-1/2 left-0 right-0 z-[-1]" src="<?php echo esc_url($mobile_image); ?>" alt="<?php echo get_image_alt(get_field('mobile_image')); ?>">
	<?php endif; ?>
	<div class="container max-w-[840px] text-center">
		<div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
			<?php if ($headline) : ?>
				<h2 class="text-35 leading-[1.24em] mb-[27px]"><?php echo $headline; ?></h2>
			<?php endif; ?>
			<?php if ($description) : ?>
				<div class="entry entry-lg"><?php echo $description; ?></div>
			<?php endif; ?>
			<?php if ($button) : ?>
				<div class="mt-12 lg:mt-12">
					<a href="<?php echo esc_url($button['url']); ?>" class="btn" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>