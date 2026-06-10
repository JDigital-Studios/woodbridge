<?php
/**
 * Tabs SLider Block Template
 * 
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$headline	= get_field('headline');
$subheader	= get_field('subheader');
$items		= get_field('items'); ?>

<section class="tabs-slider-section py-[62px] lg:pt-[85px] lg:pb-[90px] relative z-20 bg-[#FDF8F4]">
	<img class="block absolute top-[80px] lg:top-[100px] left-0 right-0 mx-auto w-[calc(100%-40px)] lg:w-[calc(100%-100px)] h-full object-cover object-center z-[-1]" src="<?php echo get_theme_file_uri('/dist/images/WB-Bridge-Graphic-Half.svg'); ?>" alt="">
	<div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="120">
		<div class="container max-w-[1280px] px-0 relative">
			<div class="text-center px-5">
				<?php if ($headline) : ?>
				<h2 class="text-15 mb-2.5"><?php echo $headline; ?></h2>
				<?php endif; ?>
				<?php if ($subheader) : ?>
				<h3 class="text-35 leading-[1.14em]"><?php echo $subheader; ?></h3>
				<?php endif; ?>
			</div>
			<?php if ($items) : ?>
			<div class="tabs-wrap max-w-full lg:max-w-[930px] w-full mx-auto relative">
				<div class="tab-thumbnail-slider-wrap lg-down:px-16 md:max-w-[720px] w-full mx-auto">
					<button class="block absolute left-5 top-[7px] z-30 w-[24px] h-[21px] p-0 bg-no-repeat bg-center text-black focus:outline-0" data-tab="prev"></button>
					<div class="tab-thumbnail-slider flex justify-between">
						<?php foreach ($items as $item) : ?>
						<div class="slideshow cursor-pointer">
							<div class="slideshow-inner font-title text-15 leading-none font-medium uppercase tracking-w text-center px-3 py-2.5"><?php echo $item['headline']; ?></div>
						</div>
						<?php endforeach; ?>
					</div>
					<button class="block absolute right-5 top-[7px] z-30 w-[24px] h-[21px] p-0 bg-no-repeat bg-center text-black focus:outline-0" data-tab="next"></button>
				</div>
				<div class="max-w-full md:max-w-[655px] w-full mx-auto">
					<div class="tab-main-slider-scroll">
						<div class="tab-main-slider flex">
							<?php foreach ($items as $item) : ?>
							<div class="slideshow">
								<div class="slideshow-inner"><?php echo $item['description']; ?></div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
