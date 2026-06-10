<?php

/**
 * Hero Block Template
 * 
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$slider_showcase = get_field('hero_slider_showcase');
$showcase_title  = get_field('hero_showcase_title');
$showcase_items  = get_field('hero_showcase_items');

$slides = get_field('hero_slides');
$global_content = get_field('hero_global_content');
$wider_text = get_field('hero_wider_text');
$remove_min_height = (bool) get_field('hero_remove_min_height');

if (empty($slides) || !is_array($slides)) {
  return;
}

$slide_count = count($slides);
$hero_has_embed_poster = false;

// Check if any content fields exist across all slides
$has_content = false;
$content_data = [];

if ($global_content) {
  // Use content from first slide for all slides
  $first_slide = $slides[0] ?? null;
  if ($first_slide && (!empty($first_slide['logo']) || !empty($first_slide['heading']) || !empty($first_slide['subheading']) ||
    !empty($first_slide['description']) || (!empty($first_slide['cta_link']) && !empty($first_slide['cta_text'])))) {
    $has_content = true;
    $content_data[0] = [
      'logo' => $first_slide['logo'] ?? null,
      'heading' => $first_slide['heading'] ?? null,
      'subheading' => $first_slide['subheading'] ?? null,
      'description' => $first_slide['description'] ?? null,
      'cta_link' => $first_slide['cta_link'] ?? null,
      'cta_text' => $first_slide['cta_text'] ?? null,
    ];
  }
} else {
  // Use individual content for each slide
  foreach ($slides as $index => $slide) {
    if (
      !empty($slide['logo']) || !empty($slide['heading']) || !empty($slide['subheading']) ||
      !empty($slide['description']) || (!empty($slide['cta_link']) && !empty($slide['cta_text']))
    ) {
      $has_content = true;
      $content_data[$index] = [
        'logo' => $slide['logo'] ?? null,
        'heading' => $slide['heading'] ?? null,
        'subheading' => $slide['subheading'] ?? null,
        'description' => $slide['description'] ?? null,
        'cta_link' => $slide['cta_link'] ?? null,
        'cta_text' => $slide['cta_text'] ?? null,
      ];
    }
  }
}

$has_showcase = $slider_showcase && !empty($showcase_items) && is_array($showcase_items);
$show_content_block = $has_content || $has_showcase;
?>

<div class="hero<?php echo $remove_min_height ? ' hero--no-min-height' : ''; ?>" data-hero-slider <?php echo $global_content ? 'data-hero-global-content="true"' : ''; ?>>
  <div class="hero__slides-container">
    <?php foreach ($slides as $index => $slide):
      $media_type = $slide['media_type'] ?? 'image';
      $is_active = $index === 0;
    ?>
      <div class="hero__slide <?php echo $is_active ? 'hero__slide--active' : ''; ?>" data-slide-index="<?php echo esc_attr($index); ?>">
        <?php if ($media_type === 'video'):
          $video_source = $slide['video_source'] ?? 'file';
          $video = $slide['video'] ?? null;
          $video_mobile = $slide['video_mobile'] ?? null;
          $video_url = isset($slide['video_url']) ? trim((string) $slide['video_url']) : '';
          $video_url_mobile = isset($slide['video_url_mobile']) ? trim((string) $slide['video_url_mobile']) : '';
          $fallback_image = $slide['fallback_image'] ?? null;
          $has_video_file = !empty($video) || !empty($video_mobile);
          $has_video_url = $video_source === 'url' && $video_url !== '';
        ?>
          <?php if ($has_video_url): ?>
            <?php
            // Detect URL type for desktop
            $url_lower = strtolower($video_url);
            $is_youtube = (strpos($url_lower, 'youtube.com') !== false || strpos($url_lower, 'youtu.be') !== false);
            $is_vimeo = (strpos($url_lower, 'vimeo.com') !== false);
            $is_direct = (preg_match('/\.(mp4|webm|ogg)(\?|$)/i', $video_url));
            $embed_url_desktop = '';
            if ($is_youtube) {
              if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video_url, $m)) {
                $embed_url_desktop = 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=1&mute=1&loop=1&playlist=' . $m[1] . '&playsinline=1&controls=0&rel=0&enablejsapi=1&cc_load_policy=0&cc_lang_pref=en';
              }
            } elseif ($is_vimeo) {
              if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $video_url, $m)) {
                $embed_url_desktop = 'https://player.vimeo.com/video/' . $m[1] . '?autoplay=1&loop=1&muted=1&controls=1&unmute_button=0&fullscreen=1';
              }
            }
            $url_mobile = $video_url_mobile !== '' ? $video_url_mobile : $video_url;
            $url_mobile_lower = strtolower($url_mobile);
            $is_youtube_m = (strpos($url_mobile_lower, 'youtube.com') !== false || strpos($url_mobile_lower, 'youtu.be') !== false);
            $is_vimeo_m = (strpos($url_mobile_lower, 'vimeo.com') !== false);
            $embed_url_mobile = '';
            if ($is_youtube_m && preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url_mobile, $mm)) {
              $embed_url_mobile = 'https://www.youtube.com/embed/' . $mm[1] . '?autoplay=1&mute=1&loop=1&playlist=' . $mm[1] . '&playsinline=1&controls=0&rel=0&enablejsapi=1&cc_load_policy=0&cc_lang_pref=en';
            } elseif ($is_vimeo_m && preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $url_mobile, $mm)) {
              $embed_url_mobile = 'https://player.vimeo.com/video/' . $mm[1] . '?autoplay=1&loop=1&muted=1&controls=1&unmute_button=0&fullscreen=1';
            } elseif ($embed_url_desktop && $is_vimeo && $embed_url_mobile === '') {
              $embed_url_mobile = $embed_url_desktop;
            }
            $has_embed_apis = $is_youtube || $is_vimeo || $is_youtube_m || $is_vimeo_m;
            $embed_type = ($is_youtube || $is_youtube_m) ? 'youtube' : 'vimeo';
            ?>
            <div class="hero__video-container hero__video-container--embed" data-hero-embed-container <?php echo $has_embed_apis ? ' data-hero-embed-type="' . esc_attr($embed_type) . '"' : ''; ?>>
              <?php if (!empty($fallback_image)): ?>
                <img
                  src="<?php echo esc_url($fallback_image['url']); ?>"
                  alt=""
                  class="hero__video-embed-poster"
                  aria-hidden="true"
                  data-hero-embed-poster>
              <?php endif; ?>
              <?php if ($embed_url_desktop): ?>
                <iframe
                  class="hero__video-embed hero__video--desktop"
                  src="<?php echo esc_url($embed_url_desktop); ?>"
                  frameborder="0"
                  allow="autoplay; fullscreen"
                  allowfullscreen
                  data-video-player="desktop"
                  data-slide-video="<?php echo esc_attr($index); ?>"
                  data-hero-embed-iframe
                  title="Hero video"></iframe>
              <?php elseif ($is_direct): ?>
                <video
                  class="hero__video hero__video--desktop"
                  autoplay muted loop playsinline
                  data-video-player="desktop"
                  data-slide-video="<?php echo esc_attr($index); ?>"
                  <?php if (!empty($fallback_image)): ?>poster="<?php echo esc_url($fallback_image['url']); ?>" <?php endif; ?>>
                  <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                </video>
              <?php endif; ?>
              <?php if ($embed_url_mobile): ?>
                <iframe
                  class="hero__video-embed hero__video--mobile"
                  src="<?php echo esc_url($embed_url_mobile); ?>"
                  frameborder="0"
                  allow="autoplay; fullscreen"
                  allowfullscreen
                  data-video-player="mobile"
                  data-slide-video="<?php echo esc_attr($index); ?>"
                  data-hero-embed-iframe
                  title="Hero video"></iframe>
              <?php elseif ($embed_url_desktop): ?>
                <iframe
                  class="hero__video-embed hero__video--mobile"
                  src="<?php echo esc_url($embed_url_desktop); ?>"
                  frameborder="0"
                  allow="autoplay; fullscreen"
                  allowfullscreen
                  data-video-player="mobile"
                  data-slide-video="<?php echo esc_attr($index); ?>"
                  data-hero-embed-iframe
                  title="Hero video"></iframe>
              <?php elseif (preg_match('/\.(mp4|webm|ogg)(\?|$)/i', $url_mobile)): ?>
                <video
                  class="hero__video hero__video--mobile"
                  autoplay muted loop playsinline
                  data-video-player="mobile"
                  data-slide-video="<?php echo esc_attr($index); ?>"
                  <?php if (!empty($fallback_image)): ?>poster="<?php echo esc_url($fallback_image['url']); ?>" <?php endif; ?>>
                  <source src="<?php echo esc_url($url_mobile); ?>" type="video/mp4">
                </video>
              <?php endif; ?>
              <?php if ($has_embed_apis): ?>
                <div class="hero__video-custom-controls" data-hero-custom-controls aria-label="Video controls">
                  <div class="hero__video-progress-wrap">
                    <button type="button" class="hero__video-play-pause" data-hero-play-pause aria-label="Pause" title="Pause">
                      <svg class="hero__video-play-pause-icon hero__video-play-pause-icon--pause" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <rect x="6" y="4" width="4" height="16" />
                        <rect x="14" y="4" width="4" height="16" />
                      </svg>
                      <svg class="hero__video-play-pause-icon hero__video-play-pause-icon--play" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M8 5v14l11-7z" />
                      </svg>
                    </button>
                    <div class="hero__video-progress" role="slider" tabindex="0" data-hero-progress aria-label="Seek" aria-valuemin="0" aria-valuemax="100">
                      <div class="hero__video-progress-track">
                        <div class="hero__video-progress-fill" data-hero-progress-fill></div>
                      </div>
                    </div>
                    <span class="hero__video-time" data-hero-time>0:00 / 0:00</span>
                  </div>
                  <div class="hero__video-volume-wrap">
                    <button type="button" class="hero__video-mute" data-hero-mute aria-label="Mute or unmute" title="Mute">
                      <svg class="hero__video-mute-icon hero__video-mute-icon--on" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M11 5L6 9H2v6h4l5 4V5z" />
                        <path d="M15.54 8.46a5 5 0 0 1 0 7.07M19.07 4.93a10 10 0 0 1 0 14.14" />
                      </svg>
                      <svg class="hero__video-mute-icon hero__video-mute-icon--off" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M11 5L6 9H2v6h4l5 4V5z" />
                      </svg>
                    </button>
                    <input type="range" class="hero__video-volume" data-hero-volume min="0" max="100" value="100" aria-label="Volume">
                    <button type="button" class="hero__video-fullscreen" data-hero-fullscreen aria-label="Full screen" title="Full screen">
                      <svg class="hero__video-fullscreen-icon hero__video-fullscreen-icon--expand" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3" />
                      </svg>
                      <svg class="hero__video-fullscreen-icon hero__video-fullscreen-icon--exit" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3" />
                      </svg>
                    </button>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          <?php elseif ($has_video_file): ?>
            <div class="hero__video-container">
              <?php if (!empty($video)): ?>
                <video
                  class="hero__video hero__video--desktop"
                  autoplay
                  muted
                  loop
                  playsinline
                  data-video-player="desktop"
                  data-slide-video="<?php echo esc_attr($index); ?>"
                  <?php if (!empty($fallback_image)): ?>
                  poster="<?php echo esc_url($fallback_image['url']); ?>"
                  <?php endif; ?>>
                  <source src="<?php echo esc_url($video['url']); ?>" type="video/mp4">
                </video>
              <?php endif; ?>
              <?php if (!empty($video_mobile)): ?>
                <video
                  class="hero__video hero__video--mobile"
                  autoplay
                  muted
                  loop
                  playsinline
                  data-video-player="mobile"
                  data-slide-video="<?php echo esc_attr($index); ?>"
                  <?php if (!empty($fallback_image)): ?>
                  poster="<?php echo esc_url($fallback_image['url']); ?>"
                  <?php endif; ?>>
                  <source src="<?php echo esc_url($video_mobile['url']); ?>" type="video/mp4">
                </video>
              <?php elseif (!empty($video)): ?>
                <video
                  class="hero__video hero__video--mobile"
                  autoplay
                  muted
                  loop
                  playsinline
                  data-video-player="mobile"
                  data-slide-video="<?php echo esc_attr($index); ?>"
                  <?php if (!empty($fallback_image)): ?>
                  poster="<?php echo esc_url($fallback_image['url']); ?>"
                  <?php endif; ?>>
                  <source src="<?php echo esc_url($video['url']); ?>" type="video/mp4">
                </video>
              <?php endif; ?>
            </div>
          <?php elseif (!empty($fallback_image)): ?>
            <img
              src="<?php echo esc_url($fallback_image['url']); ?>"
              alt="<?php echo esc_attr($fallback_image['alt'] ?? ''); ?>"
              class="hero__fallback-image">
          <?php endif; ?>
        <?php else:
          $image = $slide['image'] ?? null;
        ?>
          <?php if (!empty($image)): ?>
            <img
              src="<?php echo esc_url($image['url']); ?>"
              alt="<?php echo esc_attr($image['alt'] ?? ''); ?>"
              class="hero__fallback-image">
          <?php endif; ?>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>

</div>

<?php if ($show_content_block): ?>
  <div class="hero__content-block<?php echo $remove_min_height ? ' hero__content-block--no-min-height' : ''; ?>" data-hero-content-block data-gradient-scroll>
    <?php if ($has_content): ?>
      <!-- Slide Indicators -->
      <?php if ($slide_count > 1): ?>
        <div class="hero__indicators" data-hero-indicators>
          <?php for ($i = 0; $i < $slide_count; $i++): ?>
            <button
              type="button"
              class="hero__indicator <?php echo $i === 0 ? 'hero__indicator--active' : ''; ?>"
              aria-label="Slide <?php echo esc_attr($i + 1); ?>"
              data-slide-index="<?php echo esc_attr($i); ?>"></button>
          <?php endfor; ?>
        </div>
      <?php endif; ?>
      <?php foreach ($content_data as $index => $content): ?>
        <div class="hero__content hero__content--slide <?php echo $index === 0 ? 'hero__content--active' : ''; ?> <?php echo $wider_text ? 'hero__content--wider' : ''; ?>" data-slide-content="<?php echo esc_attr($index); ?>" <?php echo $index === 0 ? 'style="display: flex;"' : 'style="display: none;"'; ?>>
          <?php if (!empty($content['logo'])): ?>
            <div class="hero__logo">
              <?php echo file_get_contents($content['logo']); ?>
            </div>
          <?php endif; ?>

          <div class="hero__text-container">
            <?php if (!empty($content['heading'])): ?>
              <h1 class="hero__heading"><?php echo $content['heading']; ?></h1>
            <?php endif; ?>

            <?php if (!empty($content['subheading'])): ?>
              <h2 class="hero__subheading"><?php echo esc_html($content['subheading']); ?></h2>
            <?php endif; ?>

            <?php if (!empty($content['description'])): ?>
              <div class="hero__description"><?php echo wp_kses_post($content['description']); ?></div>
            <?php endif; ?>

            <?php if (!empty($content['cta_link']) && !empty($content['cta_text'])): ?>
              <a href="<?php echo esc_url($content['cta_link']); ?>" class="hero__cta btn-diagonal">
                <?php echo esc_html($content['cta_text']); ?>
              </a>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($has_showcase): ?>
      <div class="hero-showcase">
        <div class="hero-showcase__container" data-stagger data-animate-fade-up>
          <?php if ($showcase_title) : ?>
            <h2 class="hero-showcase__title"><?php echo $showcase_title; ?></h2>
          <?php endif; ?>
          <div class="hero-showcase__grid">
            <?php foreach ($showcase_items as $item_index => $item) :
              $item_slides = $item['slides'] ?? [];
              $item_description = $item['description'] ?? '';
              if (empty($item_slides)) continue;
            ?>
              <div class="hero-showcase__item stagger-item" data-hero-showcase-slider>
                <div class="hero-showcase__slider">
                  <button type="button" class="hero-showcase__nav hero-showcase__nav--prev" aria-label="Previous slide">
                    <svg width="20" height="48" viewBox="0 0 10 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8 18L2 12L8 6" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </button>
                  <button type="button" class="hero-showcase__nav hero-showcase__nav--next" aria-label="Next slide">
                    <svg width="20" height="48" viewBox="0 0 10 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M2 18L8 12L2 6" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </button>
                  <div class="hero-showcase__track">
                    <div class="hero-showcase__slides">
                      <?php foreach ($item_slides as $slide_index => $slide) :
                        $img = $slide['image'] ?? null;
                        if (empty($img)) continue;
                      ?>
                        <div class="hero-showcase__slide <?php echo $slide_index === 0 ? 'hero-showcase__slide--active' : ''; ?>" data-slide-index="<?php echo esc_attr($slide_index); ?>">
                          <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt'] ?? ''); ?>" class="hero-showcase__image" loading="lazy" />
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
                <?php if ($item_description) : ?>
                  <p class="hero-showcase__description"><?php echo wp_kses_post(nl2br($item_description)); ?></p>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>

<script>
  function videoPreload() {
    const desktopVideos = document.querySelectorAll(
      '[data-video-player="desktop"]',
    );
    const mobileVideos = document.querySelectorAll(
      '[data-video-player="mobile"]',
    );

    function handleVideoPreload() {
      const isMobile = window.matchMedia("(max-width: 768px)").matches;
      const onlyVideos = (el) => typeof el.pause === "function";

      if (isMobile) {
        mobileVideos.forEach((el) => {
          if (onlyVideos(el)) el.setAttribute("preload", "metadata");
        });
        desktopVideos.forEach((el) => {
          if (onlyVideos(el)) el.pause();
        });
      } else {
        desktopVideos.forEach((el) => {
          if (onlyVideos(el)) el.setAttribute("preload", "metadata");
        });
        mobileVideos.forEach((el) => {
          if (onlyVideos(el)) el.pause();
        });
      }
    }

    // Initial handling
    handleVideoPreload();

    // Handle screen resize
    window.addEventListener("resize", handleVideoPreload);
  }

  /**
   * Hero embed: when iframe loads, add --loaded so the video is visible and can autoplay.
   * When a poster exists, keep it visible for POSTER_DELAY_MS after load, then reveal video.
   * When no poster, reveal video after SHORT_DELAY_MS so the iframe shows quickly.
   */
  function initHeroEmbedPoster() {
    const SHORT_DELAY_MS = 400;
    const POSTER_DELAY_MS = 2000;
    const FALLBACK_NO_POSTER_MS = 2500;
    const FALLBACK_WITH_POSTER_MS = 4500;
    const containers = document.querySelectorAll(".hero__video-container--embed");
    containers.forEach((container) => {
      const iframes = container.querySelectorAll("iframe.hero__video-embed");
      if (!iframes.length) return;

      const hasPoster = !!container.querySelector(".hero__video-embed-poster");
      const delayAfterLoad = hasPoster ? POSTER_DELAY_MS : SHORT_DELAY_MS;
      const fallbackMs = hasPoster ?
        FALLBACK_WITH_POSTER_MS :
        FALLBACK_NO_POSTER_MS;

      let done = false;
      const showVideo = () => {
        if (done) return;
        done = true;
        container.classList.add("hero__video-container--loaded");
        const poster = container.querySelector(".hero__video-embed-poster");
        if (poster) {
          poster.style.setProperty("transition", "none", "important");
          poster.style.setProperty("opacity", "0", "important");
          poster.style.setProperty("pointer-events", "none", "important");
          poster.style.setProperty("visibility", "hidden", "important");
        }
      };

      const onIframeLoad = () => setTimeout(showVideo, delayAfterLoad);
      iframes.forEach((iframe) => iframe.addEventListener("load", onIframeLoad));
      setTimeout(showVideo, fallbackMs);
    });
  }

  /**
   * Hero custom controls: progress bar and volume for YouTube/Vimeo embeds.
   * Requires enablejsapi=1 (YouTube) and no controls=1 so our overlay is the only UI.
   */
  function initHeroCustomControls() {
    const containers = document.querySelectorAll(
      "[data-hero-embed-container][data-hero-embed-type]",
    );
    if (!containers.length) return;

    function getVisibleIframe(container) {
      const desktop = container.querySelector(
        ".hero__video-embed.hero__video--desktop",
      );
      const mobile = container.querySelector(
        ".hero__video-embed.hero__video--mobile",
      );
      const isMobile = window.matchMedia("(max-width: 767px)").matches;
      const iframe = isMobile ? mobile : desktop;
      return iframe && iframe.offsetParent !== null ? iframe : desktop || mobile;
    }

    function formatTime(seconds) {
      if (!Number.isFinite(seconds) || seconds < 0) return "0:00";
      const m = Math.floor(seconds / 60);
      const s = Math.floor(seconds % 60);
      return `${m}:${s < 10 ? "0" : "" }${s}`;
    }

    function bindVimeo(container, iframe, controls) {
      if (typeof window.Vimeo === "undefined") {
        const script = document.createElement("script");
        script.src = "https://player.vimeo.com/api/player.js";
        script.async = true;
        script.onload = () => bindVimeo(container, iframe, controls);
        document.head.appendChild(script);
        return;
      }
      const player = new window.Vimeo.Player(iframe);
      container._heroVimeoPlayer = player;
      let duration = 0;
      container._heroVimeoDuration = 0;
      container._heroPlayer = {
        play: () => player.play().catch(() => {}),
        pause: () => player.pause().catch(() => {}),
      };

      player
        .getDuration()
        .then((d) => {
          duration = d;
          container._heroVimeoDuration = d;
        })
        .catch(() => {});
      player
        .getVolume()
        .then((v) => {
          controls.volumeInput.value = Math.round(v * 100);
        })
        .catch(() => {});
      player
        .getMuted()
        .then((m) => {
          controls.wrapper.setAttribute("data-muted", m ? "true" : "false");
        })
        .catch(() => {});

      player.on("timeupdate", (data) => {
        const t = data.seconds;
        if (duration <= 0) return;
        const pct = (t / duration) * 100;
        controls.fill.style.width = `${pct}%`;
        controls.time.textContent = `${formatTime(t)} / ${formatTime(duration)}`;
      });

      player.on("volumechange", (data) => {
        controls.volumeInput.value = Math.round((data.volume ?? 0) * 100);
        controls.wrapper.setAttribute(
          "data-muted",
          data.muted ? "true" : "false",
        );
      });

      player.on("pause", () => {
        controls.wrapper.setAttribute("data-paused", "true");
        controls.playPauseBtn.setAttribute("aria-label", "Play");
      });
      player.on("play", () => {
        controls.wrapper.setAttribute("data-paused", "false");
        controls.playPauseBtn.setAttribute("aria-label", "Pause");
      });
      player
        .getPaused()
        .then((paused) => {
          controls.wrapper.setAttribute("data-paused", paused ? "true" : "false");
          controls.playPauseBtn.setAttribute(
            "aria-label",
            paused ? "Play" : "Pause",
          );
        })
        .catch(() => {});

      controls.progress.addEventListener("click", (e) => {
        const p = container._heroVimeoPlayer;
        const dur = container._heroVimeoDuration ?? 0;
        if (!p || dur <= 0) return;
        const rect = controls.progress.getBoundingClientRect();
        const pct = (e.clientX - rect.left) / rect.width;
        const time = Math.max(0, Math.min(1, pct)) * dur;
        p.setCurrentTime(time).catch(() => {});
      });

      controls.playPauseBtn.addEventListener("click", () => {
        container._heroVimeoPlayer
          ?.getPaused()
          .then((paused) =>
            paused ? container._heroVimeoPlayer.play() : container._heroVimeoPlayer.pause(),
          )
          .catch(() => {});
      });

      controls.muteBtn.addEventListener("click", () => {
        container._heroVimeoPlayer
          ?.getMuted()
          .then((muted) => container._heroVimeoPlayer.setMuted(!muted))
          .catch(() => {});
      });

      controls.volumeInput.addEventListener("input", () => {
        const p = container._heroVimeoPlayer;
        if (!p) return;
        const v = Number(controls.volumeInput.value) / 100;
        p.setVolume(v)
          .then(() => p.setMuted(v === 0))
          .catch(() => {});
      });

      player.play().catch(() => {});
    }

    function bindYouTube(container, iframe, controls) {
      function runWhenYTReady(fn) {
        if (window.YT && window.YT.Player) {
          fn();
          return;
        }
        const prev = window.onYouTubeIframeAPIReady;
        window.onYouTubeIframeAPIReady = function() {
          if (prev) prev();
          fn();
        };
        if (!document.querySelector('script[src*="youtube.com/iframe_api"]')) {
          const script = document.createElement("script");
          script.src = "https://www.youtube.com/iframe_api";
          script.async = true;
          document.head.appendChild(script);
        }
      }

      runWhenYTReady(() => {
        const player = new window.YT.Player(iframe, {
          events: {
            onReady() {
              container._heroPlayer = {
                play: () => player.playVideo(),
                pause: () => player.pauseVideo(),
              };
              let duration = player.getDuration();
              if (typeof player.getVolume === "function") {
                controls.volumeInput.value = player.getVolume();
                controls.wrapper.setAttribute(
                  "data-muted",
                  player.isMuted() ? "true" : "false",
                );
              }
              if (player.playVideo) player.playVideo();
              const tick = () => {
                if (duration <= 0) duration = player.getDuration();
                const t = player.getCurrentTime();
                if (duration > 0) {
                  const pct = (t / duration) * 100;
                  controls.fill.style.width = `${pct}%`;
                  controls.time.textContent = `${formatTime(t)} / ${formatTime(duration)}`;
                }
              };
              setInterval(tick, 250);

              const updatePausedState = () => {
                const state = player.getPlayerState ? player.getPlayerState() : 1;
                const paused = state === 2;
                controls.wrapper.setAttribute(
                  "data-paused",
                  paused ? "true" : "false",
                );
                controls.playPauseBtn.setAttribute(
                  "aria-label",
                  paused ? "Play" : "Pause",
                );
              };
              updatePausedState();
              setInterval(updatePausedState, 500);

              controls.progress.addEventListener("click", (e) => {
                const rect = controls.progress.getBoundingClientRect();
                const pct = Math.max(
                  0,
                  Math.min(1, (e.clientX - rect.left) / rect.width),
                );
                const dur = player.getDuration();
                if (Number.isFinite(dur) && dur > 0)
                  player.seekTo(pct * dur, true);
              });
              controls.playPauseBtn.addEventListener("click", () => {
                const state = player.getPlayerState ? player.getPlayerState() : 1;
                if (state === 1 || state === 3) player.pauseVideo();
                else player.playVideo();
              });
              controls.muteBtn.addEventListener("click", () => {
                if (player.isMuted()) player.unMute();
                else player.mute();
                controls.wrapper.setAttribute(
                  "data-muted",
                  player.isMuted() ? "true" : "false",
                );
              });
              controls.volumeInput.addEventListener("input", () => {
                const v = Number(controls.volumeInput.value);
                player.setVolume(v);
                if (v === 0) player.mute();
                else player.unMute();
                controls.wrapper.setAttribute(
                  "data-muted",
                  v === 0 ? "true" : "false",
                );
              });
            },
          },
        });
      });
    }

    containers.forEach((container) => {
      const controlsEl = container.querySelector("[data-hero-custom-controls]");
      if (!controlsEl) return;

      const progress = controlsEl.querySelector("[data-hero-progress]");
      const fill = controlsEl.querySelector("[data-hero-progress-fill]");
      const time = controlsEl.querySelector("[data-hero-time]");
      const playPauseBtn = controlsEl.querySelector("[data-hero-play-pause]");
      const muteBtn = controlsEl.querySelector("[data-hero-mute]");
      const volumeInput = controlsEl.querySelector("[data-hero-volume]");
      const fullscreenBtn = controlsEl.querySelector("[data-hero-fullscreen]");

      if (
        !progress ||
        !fill ||
        !time ||
        !playPauseBtn ||
        !muteBtn ||
        !volumeInput
      )
        return;

      const controls = {
        wrapper: controlsEl,
        progress,
        fill,
        time,
        playPauseBtn,
        muteBtn,
        volumeInput,
        fullscreenBtn,
      };

      const embedType = container.getAttribute("data-hero-embed-type");
      const iframe = getVisibleIframe(container);
      if (!iframe) return;

      if (embedType === "youtube") bindYouTube(container, iframe, controls);
      else if (embedType === "vimeo") bindVimeo(container, iframe, controls);

      if (fullscreenBtn) {
        const fullscreenEl = () =>
          document.fullscreenElement ?? document.webkitFullscreenElement;
        const requestFs = () =>
          container.requestFullscreen?.() ??
          container.webkitRequestFullscreen?.();
        const exitFs = () =>
          document.exitFullscreen?.() ?? document.webkitExitFullscreen?.();
        const updateFullscreenState = () => {
          const isFullscreen = fullscreenEl() === container;
          container.setAttribute(
            "data-fullscreen",
            isFullscreen ? "true" : "false",
          );
          fullscreenBtn.setAttribute(
            "aria-label",
            isFullscreen ? "Exit full screen" : "Full screen",
          );
        };
        fullscreenBtn.addEventListener("click", () => {
          if (fullscreenEl() === container) {
            exitFs().catch(() => {});
          } else {
            requestFs().catch(() => {});
            container._heroPlayer?.play?.();
          }
        });
        document.addEventListener("fullscreenchange", updateFullscreenState);
        document.addEventListener(
          "webkitfullscreenchange",
          updateFullscreenState,
        );
        updateFullscreenState();
      }
    });
  }

  function heroSlider() {
    console.log("heroSlider function called");
    const heroSliders = document.querySelectorAll("[data-hero-slider]");
    console.log("Found hero sliders:", heroSliders.length);

    if (heroSliders.length === 0) {
      console.warn("No hero sliders found with [data-hero-slider]");
      return;
    }

    heroSliders.forEach((slider, sliderIndex) => {
      console.log(`Processing hero slider ${sliderIndex + 1}:`, slider);
      const slides = slider.querySelectorAll(".hero__slide");
      console.log(`Found ${slides.length} slides`);

      // Find indicators - they're in a sibling content block
      // The slider is the element with data-hero-slider (the .hero div)
      const contentBlock = slider.nextElementSibling;
      console.log("Next sibling element:", contentBlock);
      console.log(
        "Has data-hero-content-block?",
        contentBlock?.hasAttribute("data-hero-content-block"),
      );

      let indicators = [];
      let indicatorsContainer = null;

      if (contentBlock && contentBlock.hasAttribute("data-hero-content-block")) {
        indicatorsContainer = contentBlock.querySelector(
          "[data-hero-indicators]",
        );
        console.log("Indicators container found:", indicatorsContainer);
        if (indicatorsContainer) {
          indicators = Array.from(
            indicatorsContainer.querySelectorAll(".hero__indicator"),
          );
          console.log(`Found ${indicators.length} indicators in container`);
        }
      }

      // Fallback: try to find indicators anywhere near this hero
      if (indicators.length === 0) {
        console.log("Trying fallback: searching parent element");
        const heroContainer = slider.closest(".hero") || slider;
        const parent = heroContainer.parentElement;
        console.log("Parent element:", parent);
        if (parent) {
          const allIndicators = parent.querySelectorAll(
            "[data-hero-indicators] .hero__indicator",
          );
          console.log(`Found ${allIndicators.length} indicators in parent`);
          if (allIndicators.length > 0) {
            indicators = Array.from(allIndicators);
            indicatorsContainer = parent.querySelector("[data-hero-indicators]");
          }
        }
      }

      // Final fallback: search entire document
      if (indicators.length === 0) {
        console.log("Trying final fallback: searching entire document");
        const allIndicators = document.querySelectorAll(".hero__indicator");
        console.log(`Found ${allIndicators.length} indicators in document`);
        if (allIndicators.length > 0) {
          // Try to match by proximity - find the closest indicators container to this slider
          const allContainers = document.querySelectorAll(
            "[data-hero-indicators]",
          );
          console.log(
            `Found ${allContainers.length} indicator containers in document`,
          );
          if (allContainers.length > 0) {
            // Use the first one as fallback
            indicatorsContainer = allContainers[0];
            indicators = Array.from(
              indicatorsContainer.querySelectorAll(".hero__indicator"),
            );
            console.log(
              `Using first container with ${indicators.length} indicators`,
            );
          }
        }
      }

      // Debug logging
      console.log("Hero slider initialized:", {
        slidesCount: slides.length,
        indicatorsCount: indicators.length,
        hasContentBlock: !!contentBlock,
        hasIndicatorsContainer: !!indicatorsContainer,
        indicatorsContainer: indicatorsContainer,
      });

      let currentSlide = 0;
      let slideInterval = null;
      const autoSlideDelay = 5000; // 5 seconds

      if (slides.length === 0) {
        return;
      }

      if (slides.length <= 1) {
        // Even with one slide, ensure it's visible
        if (slides.length === 1) {
          slides[0].classList.add("hero__slide--active");
        }
        return; // No need for slider functionality with single slide
      }

      // Ensure first slide is active on load and others are hidden
      slides.forEach((slide, index) => {
        if (index === 0) {
          slide.classList.add("hero__slide--active");
        } else {
          slide.classList.remove("hero__slide--active");
        }
      });

      function showSlide(index) {
        // Hide all slides
        slides.forEach((slide) => {
          slide.classList.remove("hero__slide--active");
        });

        // Show selected slide
        if (slides[index]) {
          slides[index].classList.add("hero__slide--active");

          // Handle video playback
          const activeSlide = slides[index];
          const videos = activeSlide.querySelectorAll("video");

          // Pause all videos in other slides
          slides.forEach((slide, slideIndex) => {
            if (slideIndex !== index) {
              const slideVideos = slide.querySelectorAll("video");
              slideVideos.forEach((video) => {
                video.pause();
                video.currentTime = 0;
              });
            }
          });

          // Play videos in active slide
          videos.forEach((video) => {
            const isMobile = window.matchMedia("(max-width: 768px)").matches;
            const isMobileVideo = video.classList.contains("hero__video--mobile");
            const isDesktopVideo = video.classList.contains(
              "hero__video--desktop",
            );

            if ((isMobile && isMobileVideo) || (!isMobile && isDesktopVideo)) {
              video.play().catch((error) => {
                console.log("Video autoplay prevented:", error);
              });
            } else {
              video.pause();
            }
          });
        }

        // Update indicators - find them fresh each time in case DOM changed
        let currentIndicators = indicators;
        if (indicators.length === 0) {
          const currentContentBlock = slider.nextElementSibling;
          if (
            currentContentBlock &&
            currentContentBlock.hasAttribute("data-hero-content-block")
          ) {
            const indicatorsContainer = currentContentBlock.querySelector(
              "[data-hero-indicators]",
            );
            if (indicatorsContainer) {
              currentIndicators = Array.from(
                indicatorsContainer.querySelectorAll(".hero__indicator"),
              );
            }
          }
        }

        currentIndicators.forEach((indicator, indIndex) => {
          const indicatorIndex = parseInt(
            indicator.getAttribute("data-slide-index"),
            10,
          );
          const targetIndex = !isNaN(indicatorIndex) && indicatorIndex >= 0 ?
            indicatorIndex :
            indIndex;

          if (targetIndex === index) {
            indicator.classList.add("hero__indicator--active");
          } else {
            indicator.classList.remove("hero__indicator--active");
          }
        });

        currentSlide = index;

        // Update content block below slider (it's now a sibling element)
        // Skip if global content is enabled
        const isGlobalContent =
          slider.hasAttribute("data-hero-global-content") &&
          slider.getAttribute("data-hero-global-content") === "true";

        if (!isGlobalContent) {
          const heroContainer = slider.closest(".hero");
          const contentBlock = heroContainer?.nextElementSibling;
          if (
            contentBlock &&
            contentBlock.hasAttribute("data-hero-content-block")
          ) {
            const allContent = contentBlock.querySelectorAll(
              "[data-slide-content]",
            );

            // Hide all content with fade out
            allContent.forEach((content) => {
              content.classList.remove("hero__content--active");
              setTimeout(() => {
                if (!content.classList.contains("hero__content--active")) {
                  content.style.display = "none";
                }
              }, 150);
            });

            // Show content for active slide if it exists
            const activeContent = contentBlock.querySelector(
              `[data-slide-content="${index}"]`,
            );

            if (activeContent) {
              // Show immediately
              activeContent.style.display = "flex";
              // Trigger reflow to ensure display change takes effect
              void activeContent.offsetHeight;
              // Add active class for opacity transition
              setTimeout(() => {
                activeContent.classList.add("hero__content--active");
              }, 10);
            } else {
              // If no content exists for this slide, hide all content
              allContent.forEach((content) => {
                content.style.display = "none";
                content.classList.remove("hero__content--active");
              });
            }
          }
        }

        // Dispatch custom event for hero content animation
        const slideChangeEvent = new CustomEvent("heroSlideChange", {
          detail: {
            activeSlide: slides[index],
            index: index
          },
        });
        slider.dispatchEvent(slideChangeEvent);
      }

      function nextSlide() {
        const nextIndex = (currentSlide + 1) % slides.length;
        showSlide(nextIndex);
      }

      function startAutoSlide() {
        if (slideInterval) {
          clearInterval(slideInterval);
        }
        slideInterval = setInterval(nextSlide, autoSlideDelay);
      }

      function stopAutoSlide() {
        if (slideInterval) {
          clearInterval(slideInterval);
          slideInterval = null;
        }
      }

      // Use event delegation for indicator clicks (more reliable)
      if (indicatorsContainer) {
        // Remove any existing listeners by cloning
        const newContainer = indicatorsContainer.cloneNode(true);
        indicatorsContainer.parentNode.replaceChild(
          newContainer,
          indicatorsContainer,
        );

        // Update indicators reference
        indicators = Array.from(
          newContainer.querySelectorAll(".hero__indicator"),
        );

        newContainer.addEventListener(
          "click",
          function(e) {
            const indicator = e.target.closest(".hero__indicator");
            if (!indicator) return;

            e.preventDefault();
            e.stopPropagation();

            const slideIndex = parseInt(
              indicator.getAttribute("data-slide-index"),
              10,
            );
            if (
              !isNaN(slideIndex) &&
              slideIndex >= 0 &&
              slideIndex < slides.length
            ) {
              console.log("Indicator clicked via delegation, target index:",
                slideIndex,
              );
              showSlide(slideIndex);
              startAutoSlide(); // Restart auto-slide after manual navigation
            }
          },
          false,
        );

        // Also handle mousedown as backup
        newContainer.addEventListener("mousedown",
          function(e) {
            const indicator = e.target.closest(".hero__indicator");
            if (!indicator) return;

            e.preventDefault();
            e.stopPropagation();

            const slideIndex = parseInt(
              indicator.getAttribute("data-slide-index"),
              10,
            );
            if (
              !isNaN(slideIndex) &&
              slideIndex >= 0 &&
              slideIndex < slides.length
            ) {
              console.log("Indicator mousedown via delegation, target index:",
                slideIndex,
              );
              showSlide(slideIndex);
              startAutoSlide();
            }
          },
          false,
        );
      } else {
        console.warn("Hero slider: Indicators container not found for slider",
          slider,
        );
      }

      // Also attach direct listeners as fallback
      if (indicators.length > 0) {
        indicators.forEach((indicator) => {
          const slideIndex = parseInt(
            indicator.getAttribute("data-slide-index"),
            10,
          );
          if (isNaN(slideIndex) || slideIndex < 0) return;

          indicator.addEventListener("click",
            function(e) {
              e.preventDefault();
              e.stopPropagation();
              console.log("Direct indicator click, target index:", slideIndex);
              if (slideIndex < slides.length) {
                showSlide(slideIndex);
                startAutoSlide();
              }
            },
            false,
          );
        });
      }

      // Pause auto-slide on hover
      slider.addEventListener("mouseenter", stopAutoSlide);
      slider.addEventListener("mouseleave", startAutoSlide);

      // Handle video preload for responsive behavior
      function handleVideoPreload() {
        const isMobile = window.matchMedia("(max-width: 768px)").matches;
        slides.forEach((slide) => {
          const videos = slide.querySelectorAll("video");
          videos.forEach((video) => {
            const isMobileVideo = video.classList.contains("hero__video--mobile");
            const isDesktopVideo = video.classList.contains(
              "hero__video--desktop",
            );
            const isActive = slide.classList.contains("hero__slide--active");

            if (isActive) {
              if ((isMobile && isMobileVideo) || (!isMobile && isDesktopVideo)) {
                video.play().catch((error) => {
                  console.log("Video autoplay prevented:", error);
                });
              } else {
                video.pause();
              }
            }
          });
        });
      }

      window.addEventListener("resize", handleVideoPreload);

      // Initialize content block visibility (it's now a sibling element)
      const heroContainerInit = slider.closest(".hero");
      const contentBlockInit = heroContainerInit?.nextElementSibling;
      if (
        contentBlockInit &&
        contentBlockInit.hasAttribute("data-hero-content-block")
      ) {
        const allContent = contentBlock.querySelectorAll("[data-slide-content]");

        // Hide all content except the first one
        allContent.forEach((content, idx) => {
          if (idx === 0) {
            content.style.display = "flex";
            content.classList.add("hero__content--active");
          } else {
            content.style.display = "none";
            content.classList.remove("hero__content--active");
          }
        });
      }

      // Initialize
      showSlide(0);
      startAutoSlide();
    });
  }
</script>