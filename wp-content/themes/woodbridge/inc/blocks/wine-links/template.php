<?php
/**
 * Wine Links Block Template
 * 
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$items = get_field('items'); ?>

<section class="wine-links-section relative z-20 bg-[#FDF8F4]">
	<div class="container max-w-full px-0">
		<div class="boxes grid grid-cols-1 md:grid-cols-2 md-down:gap-5" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
			<?php foreach ($items as $item) : $link = $item['link']; ?>
			<a href="<?php echo esc_url($link['url']); ?>" class="box block w-full relative overflow-hidden before:content-[''] before:absolute before:top-[33%] before:left-0 before:w-full before:h-[67%] before:bg-primary-300 before:z-[-1] group" target="<?php echo $link['target']; ?>">
				<?php if ($item['image']) : $image = wp_get_attachment_image_url($item['image'], '920x882'); ?>
				<div class="pt-5">
					<img class="block mx-auto object-contain transition-all ease-linear duration-200 origin-bottom group-hover:transform group-hover:scale-[1.05]" src="<?php echo esc_url($image); ?>" alt="<?php echo get_image_alt($item['image']); ?>">
				</div>
				<?php endif; ?>
				<h2 class="text-[1.563rem] sm:text-[1.875rem] lg:text-[2.25rem] xl:text-[3.125rem] !leading-[1.2em] text-[#FAF8F8] [text-shadow:0px_3px_6px_rgba(0,0,0,0.5)] text-center absolute left-0 right-0 mx-auto top-[39%] py-5 px-2 bg-transparent z-10 transition-[font-size] ease-linear duration-200 before:content-[''] before:absolute before:top-0 before:left-0 before:w-full before:h-full before:bg-transparent before:transition-all before:ease-linear before:duration-200 before:z-[-1] group-hover:text-[1.813rem] sm:group-hover:text-[2.188rem] lg:group-hover:text-[2.5rem] xl:group-hover:text-[3.375rem] group-hover:before:bg-primary-300"><?php echo $link['title']; ?></h2>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>