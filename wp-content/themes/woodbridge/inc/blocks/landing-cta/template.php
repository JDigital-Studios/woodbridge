<?php
/**
 * Landing CTA Block Template
 * 
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$headline	= get_field('headline');
$subheader	= get_field('subheader');
$text1		= get_field('text_1');
$text2		= get_field('text_2');
$button		= get_field('button');
?>

<section class="landing-cta-section relative z-20 bg-primary-700 pt-[60px] pb-[47px]">
	<div class="container max-w-[540px] text-center">
		<div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
			<?php if ($headline) : ?>
			<h2 class="text-2xl leading-[1.2em] tracking-[0.074em] text-[#FDF8F4] mb-1"><?php echo $headline; ?></h2>
			<?php endif; ?>
			<?php if ($subheader) : ?>
			<h3 class="text-35 leading-[1.25em] tracking-[0.074em] text-[#FDF8F4] mb-4"><?php echo $subheader; ?></h3>
			<?php endif; ?>
			<?php if ($text1) : ?>
			<h4 class="text-2xl leading-[1.2em] text-[#FDF8F4] mb-[30px]"><?php echo $text1; ?></h4>
			<?php endif; ?>
			<?php if ($text2) : ?>
			<p class="text-[#FDF8F4]"><?php echo $text2; ?></p>
			<?php endif; ?>
			<?php if ($button) : ?>
			<div>
				<a href="<?php echo esc_url($button['url']); ?>" class="btn" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?></a>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
