<?php
/**
 * Landing Two Cols Block Template
 * 
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$image			= wp_get_attachment_image_url(get_field('image'), 'full');
$headline		= get_field('headline');
$description	= get_field('description');
?>

<section class="landing-two-cols-section relative z-20 bg-[#FDF8F4]">
	<div class="flex flex-wrap items-center">
		<?php if ($image) : ?>
		<div class="w-full md:w-1/2" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
			<img class="block w-full" src="<?php echo esc_url($image); ?>" alt="<?php echo get_image_alt(get_field('image')); ?>">
		</div>
		<?php endif; ?>
		<div class="w-full md:w-1/2" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
			<div class="max-w-[540px] w-full mx-auto text-center py-12 px-5">
				<?php if ($headline) : ?>
				<h2 class="text-2xl leading-[1.2em]"><?php echo $headline; ?></h2>
				<?php endif; ?>
				<?php if ($description) : ?>
				<div class="entry"><?php echo $description; ?></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
