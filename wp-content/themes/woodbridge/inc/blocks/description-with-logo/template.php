<?php
/**
 * Description With Logo Block Template
 * 
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$headline		= get_field('headline');
$description	= get_field('description');
?>

<section class="description-with-logo relative z-30 pt-[70px] pb-[68px] lg:pt-[90px] lg:pb-[60px]" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
	<img class="block mx-auto absolute top-1/2 transform -translate-y-1/2 left-0 right-0 z-[-1] w-[300px] h-[282px]" src="<?php echo get_theme_file_uri('/dist/images/WB-Monogram.svg'); ?>" alt="">
	<div class="container max-w-[840px] text-center">
		<?php if ($headline) : ?>
		<h2 class="text-35 lg:text-40 leading-[1.24em] mb-[27px]"><?php echo $headline; ?></h2>
		<?php endif; ?>
		<?php if ($description) : ?>
		<div class="entry entry-xl"><?php echo $description; ?></div>
		<?php endif; ?>
	</div>
</section>
