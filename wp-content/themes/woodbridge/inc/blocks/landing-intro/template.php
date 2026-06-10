<?php
/**
 * Landing Intro Block Template
 * 
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$desktop_image	= wp_get_attachment_image_url(get_field('desktop_image'), 'full');
$mobile_image	= wp_get_attachment_image_url(get_field('mobile_image'), 'full');
$logo			= wp_get_attachment_image_url(get_field('logo'), 'full');
$headline		= get_field('headline');
$description	= get_field('description');
?>

<section class="landing-intro-section pt-[36px] pb-[50px] lg:pt-[50px] lg:pb-[90px] relative z-20 bg-[#FDF8F4]">
	<div class="container max-w-[1220px] text-center">
		<?php if ($desktop_image) : ?>
		<img class="landing-intro-section-image-desktop hidden lg:block w-[calc(100%-100px)] absolute top-1/2 left-0 right-0 mx-auto h-full transform -translate-y-1/2 z-[-1]" src="<?php echo esc_url($desktop_image); ?>" alt="<?php echo get_image_alt(get_field('desktop_image')); ?>">
		<?php endif; ?>
		<?php if ($mobile_image) : ?>
		<img class="landing-intro-section-image-mobile block lg:hidden absolute top-1/2 left-0 right-0 mx-auto w-full transform -translate-y-1/2 z-[-1]" src="<?php echo esc_url($mobile_image); ?>" alt="<?php echo get_image_alt(get_field('mobile_image')); ?>">
		<?php endif; ?>
		<?php if ($logo) : ?>
		<img data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120" class="landing-intro-section-logo block mx-auto mb-[54px] w-[180px] h-[180px]" src="<?php echo esc_url($logo); ?>" alt="<?php echo get_image_alt(get_field('logo')); ?>">
		<?php endif; ?>
		<div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
			<?php if ($headline) : ?>
			<h2 class="text-40 leading-[1.14em] mb-3"><?php echo $headline; ?></h2>
			<?php endif; ?>
			<?php if ($description) : ?>
			<div class="entry max-w-[780px] w-full mx-auto"><?php echo $description; ?></div>
			<?php endif; ?>
		</div>
	</div>
</section>
