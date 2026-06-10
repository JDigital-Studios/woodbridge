<?php
/**
 * Landing Description Block Template
 *
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$logo				= wp_get_attachment_image_url(get_field('logo'), 'full');
$image				= wp_get_attachment_image_url(get_field('image'), 'full');
$top_description	= get_field('top_description');
$headline			= get_field('headline');
$description		= get_field('description');
?>

<section class="landing-description-section relative z-20 bg-[#FDF8F4] py-[57px] lg:pb-[80px]">
	<div class="container max-w-[1100px]">
		<div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
			<?php if ($logo) : ?>
			<img class="block mx-auto mb-[40px] w-[280px] h-[55px] sm:w-[379px] sm:h-[75px] lg:w-[540px] lg:h-[106px]" src="<?php echo esc_url($logo); ?>" alt="<?php echo get_image_alt(get_field('logo')); ?>">
			<?php endif; ?>
			<?php if ($top_description) : ?>
			<div class="max-w-[770px] w-full mx-auto mb-[44px] lg:mb-[77px] text-center">
				<div class="entry"><?php echo $top_description; ?></div>
			</div>
			<?php endif; ?>
		</div>
		<div class="w-full">
			<div class="flex flex-wrap justify-between items-center mb-[54px] lg:mb-[110px] last:!mb-0" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
				<?php if ($image) : ?>
				<div class="w-full md:w-[48%] lg:w-[46%] md-down:mb-[38px]">
					<img class="block" src="<?php echo esc_url($image); ?>" alt="<?php echo get_image_alt(get_field('image')); ?>"> <!-- 700x700 -->
				</div>
				<?php endif; ?>
				<div class="w-full md:w-[48.5%] lg:w-[46%]" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
					<?php if ($headline) : ?>
					<h2 class="text-35 leading-[1.14em] mb-10"><?php echo $headline; ?></h2>
					<?php endif; ?>
					<?php if ($description) : ?>
					<div class="entry"><?php echo $description; ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
