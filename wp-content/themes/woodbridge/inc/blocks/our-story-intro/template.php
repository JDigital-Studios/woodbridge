<?php
/**
 * Our Story Intro Block Template
 * 
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$name	= get_field('name');
$text	= get_field('text');
?>

<section class="our-story-intro-section relative z-20 bg-primary-600 pt-[64px] pb-[50px] lg:pt-[80px] lg:pb-[60px]" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
	<div class="container max-w-[720px] lg:max-w-[900px] text-center">
		<?php if ($text) : ?>
		<div class="entry entry-3xl mb-12"><?php echo $text; ?></div>
		<?php endif; ?>
		<?php if ($name) : ?>
		<h2 class="text-15 leading-[1.2em]">— <?php echo $name; ?></h2>
		<?php endif; ?>
	</div>
</section>
