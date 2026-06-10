<?php
/**
 * Two Cols Block Template
 *
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$headline		= get_field('headline');
$description	= get_field('description');
$items			= get_field('items'); ?>

<section class="two-cols-section relative z-20 bg-[#FDF8F4] pb-[64px] lg:pb-[106px]">
	<div class="container max-w-[1090px]">
		<div class="text-center mb-[40px] lg:mb-[90px]" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
			<?php if ($headline) : ?>
			<h2 class="text-40 leading-[1.14em] mb-5"><?php echo $headline; ?></h2>
			<?php endif; ?>
			<?php if ($description) : ?>
			<div class="entry"><?php echo $description; ?></div>
			<?php endif; ?>
		</div>
		<?php if ($items) : ?>
		<div class="two-cols-section-wrap">
			<?php foreach ($items as $item) : ?>
			<div class="boxes flex flex-wrap justify-between items-center mb-[54px] lg:mb-[110px] last:!mb-0" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
				<?php if ($item['image']) : $image = wp_get_attachment_image_url($item['image'], 'full'); ?>
				<div class="box-image w-full md:w-[48%] lg:w-[46%] md-down:mb-[38px]">
					<img class="block" src="<?php echo esc_url($image); ?>" alt="<?php echo get_image_alt($item['image']); ?>"> <!-- 700x700 -->
				</div>
				<?php endif; ?>
				<div class="box-content w-full md:w-[48.5%] lg:w-[46%]">
					<?php if ($item['headline']) : ?>
					<h2 class="text-2xl leading-[1.22em]"><?php echo $item['headline']; ?></h2>
					<?php endif; ?>
					<?php if ($item['description']) : ?>
					<div class="entry"><?php echo $item['description']; ?></div>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
</section>
