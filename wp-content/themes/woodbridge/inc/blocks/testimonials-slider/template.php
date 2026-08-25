<?php
/**
 * Testimonials Slider Block Template
 * 
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$headline	= get_field('headline');
$items		= get_field('items');
?>

<section class="testimonials-slider-section relative z-20 bg-[#FDF8F4] pt-[75px]">
	<div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
		<?php if ($headline) : ?>
		<h2 class="text-2xl !leading-[1.32em] text-center mb-10 px-5"><?php echo $headline; ?></h2>
		<?php endif; ?>
	</div>
	<div class="testimonials-slider-wrap" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="240">
		<div class="testimonials-slider">
			<?php foreach ($items as $item) : ?>
			<div class="slideshow">
				<div class="slideshow-inner text-center" style="background-color: <?php echo $item['color_picker']; ?>">
					<?php if ($item['description']) : ?>
					<div class="text-lg !leading-[1.44em]"><?php echo $item['description']; ?></div>
					<?php endif; ?>
					<?php if ($item['name']) : ?>
					<h2 class="m-0">— <?php echo $item['name']; ?></h2>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
