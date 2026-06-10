<?php

/**
 * General Content Block Template
 * 
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$headline	= get_field('headline');
$content	= get_field('content');
?>

<section class="shop-now-section relative z-20 bg-[#FDF8F4] pt-[50px] pb-[75px] lg:pt-[70px] lg:pb-[150px]">
	<div class="container max-w-[1200px]">
		<?php if ($headline) : ?>
			<h2 data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120" class="text-35 leading-[1.14em] text-center"><?php echo $headline; ?></h2>
		<?php endif; ?>
		<?php if ($content) : ?>

			<div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120" class="max-w-1180px w-full mx-auto">
				<div class="entry"><?php echo $content; ?></div>
			</div>
		<?php endif; ?>
	</div>
</section>