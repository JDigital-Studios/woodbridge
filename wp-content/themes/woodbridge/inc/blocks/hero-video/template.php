<?php
/**
 * Hero Video Block Template
 *
 * @var array $block The block settings and attributes
 * @var string $content The block inner HTML (empty)
 * @var bool $is_preview True during backend preview render
 * @var int $post_id The post ID the block is rendering content against
 */

$vimeo_id = vimeo_id(get_field('vimeo_url'));

if ($vimeo_id) : ?>
<div class="hero-video" data-hero-video>
	<div class="hero-video__embed">
		<iframe
			id="hero-vimeo-<?php echo esc_attr($vimeo_id); ?>"
			src="https://player.vimeo.com/video/<?php echo esc_attr($vimeo_id); ?>?autoplay=1&muted=1&loop=1&controls=0&playsinline=1&title=0&byline=0&portrait=0"
			frameborder="0"
			allow="autoplay; fullscreen; picture-in-picture"
			allowfullscreen
			title="Hero video"></iframe>
	</div>
	<div class="hero-video__controls" data-hero-video-controls aria-label="Video controls">
		<div class="hero-video__row">
			<button type="button" class="hero-video__btn" data-hero-play-pause aria-label="Pause" title="Pause">
				<svg class="hero-video__icon hero-video__icon--pause" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
					<rect x="6" y="4" width="4" height="16" />
					<rect x="14" y="4" width="4" height="16" />
				</svg>
				<svg class="hero-video__icon hero-video__icon--play" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
					<path d="M8 5v14l11-7z" />
				</svg>
			</button>
			<div class="hero-video__progress" role="slider" tabindex="0" data-hero-progress aria-label="Seek" aria-valuemin="0" aria-valuemax="100">
				<div class="hero-video__progress-track">
					<div class="hero-video__progress-fill" data-hero-progress-fill></div>
				</div>
			</div>
			<span class="hero-video__time" data-hero-time>0:00 / 0:00</span>
		</div>
		<div class="hero-video__row">
			<button type="button" class="hero-video__btn" data-hero-mute aria-label="Unmute" title="Unmute">
				<svg class="hero-video__icon hero-video__icon--muted" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
					<path d="M11 5L6 9H2v6h4l5 4V5z" />
				</svg>
				<svg class="hero-video__icon hero-video__icon--unmuted" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
					<path d="M11 5L6 9H2v6h4l5 4V5z" />
					<path d="M15.54 8.46a5 5 0 0 1 0 7.07M19.07 4.93a10 10 0 0 1 0 14.14" />
				</svg>
			</button>
			<input type="range" class="hero-video__volume" data-hero-volume min="0" max="100" value="0" aria-label="Volume">
			<button type="button" class="hero-video__btn hero-video__btn--cc" data-hero-cc aria-label="Turn on captions" title="Captions">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
					<rect x="2" y="4" width="20" height="16" rx="2" />
					<path d="M10.5 9.5a2.5 2.5 0 1 0 0 5" stroke-linecap="round" />
					<path d="M17.5 9.5a2.5 2.5 0 1 0 0 5" stroke-linecap="round" />
				</svg>
			</button>
			<button type="button" class="hero-video__btn hero-video__btn--fullscreen" data-hero-fullscreen aria-label="Full screen" title="Full screen">
				<svg class="hero-video__icon hero-video__icon--expand" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
					<path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3" />
				</svg>
				<svg class="hero-video__icon hero-video__icon--collapse" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
					<path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3" />
				</svg>
			</button>
		</div>
	</div>
</div>

<script src="https://player.vimeo.com/api/player.js"></script>
<script>
(function() {
	var iframe = document.getElementById('hero-vimeo-<?php echo esc_js($vimeo_id); ?>');
	if (!iframe) return;

	var container = iframe.closest('[data-hero-video]');
	if (!container) return;

	var controlsEl = container.querySelector('[data-hero-video-controls]');
	var fill = controlsEl.querySelector('[data-hero-progress-fill]');
	var timeEl = controlsEl.querySelector('[data-hero-time]');
	var progressEl = controlsEl.querySelector('[data-hero-progress]');
	var playPauseBtn = controlsEl.querySelector('[data-hero-play-pause]');
	var muteBtn = controlsEl.querySelector('[data-hero-mute]');
	var volumeInput = controlsEl.querySelector('[data-hero-volume]');
	var fullscreenBtn = controlsEl.querySelector('[data-hero-fullscreen]');
	var ccBtn = controlsEl.querySelector('[data-hero-cc]');

	var player = new Vimeo.Player(iframe);
	var duration = 0;
	var ccOn = false;
	var ccLang = null;

	function fmt(sec) {
		if (!Number.isFinite(sec) || sec < 0) return '0:00';
		var m = Math.floor(sec / 60);
		var s = Math.floor(sec % 60);
		return m + ':' + (s < 10 ? '0' : '') + s;
	}

	player.ready().then(function() {
		container.setAttribute('data-paused', 'false');
		container.setAttribute('data-muted', 'true');
		return player.getDuration();
	}).then(function(d) {
		duration = d;
	}).catch(function(e) {
		console.warn('Vimeo player ready error:', e);
	});

	player.getTextTracks().then(function(tracks) {
		if (tracks.length > 0) {
			ccLang = tracks[0].language;
			var active = tracks.some(function(t) { return t.mode === 'showing'; });
			ccOn = active;
			container.setAttribute('data-cc', active ? 'true' : 'false');
		} else {
			if (ccBtn) ccBtn.style.display = 'none';
		}
	}).catch(function() {});

	player.on('timeupdate', function(data) {
		if (duration <= 0) {
			player.getDuration().then(function(d) { duration = d; }).catch(function() {});
			return;
		}
		fill.style.width = ((data.seconds / duration) * 100) + '%';
		timeEl.textContent = fmt(data.seconds) + ' / ' + fmt(duration);
	});

	player.on('pause', function() {
		container.setAttribute('data-paused', 'true');
		playPauseBtn.setAttribute('aria-label', 'Play');
	});
	player.on('play', function() {
		container.setAttribute('data-paused', 'false');
		playPauseBtn.setAttribute('aria-label', 'Pause');
	});
	player.on('volumechange', function(data) {
		volumeInput.value = Math.round((data.volume || 0) * 100);
		container.setAttribute('data-muted', data.volume === 0 ? 'true' : 'false');
	});

	playPauseBtn.addEventListener('click', function() {
		player.getPaused().then(function(paused) {
			return paused ? player.play() : player.pause();
		}).catch(function() {});
	});

	muteBtn.addEventListener('click', function() {
		player.getMuted().then(function(muted) {
			if (muted) {
				player.setMuted(false);
				player.setVolume(1);
				volumeInput.value = 100;
				container.setAttribute('data-muted', 'false');
			} else {
				player.setMuted(true);
				volumeInput.value = 0;
				container.setAttribute('data-muted', 'true');
			}
		}).catch(function() {});
	});

	volumeInput.addEventListener('input', function() {
		var v = Number(volumeInput.value) / 100;
		player.setVolume(v).then(function() {
			return player.setMuted(v === 0);
		}).catch(function() {});
		container.setAttribute('data-muted', v === 0 ? 'true' : 'false');
	});

	if (ccBtn) {
		ccBtn.addEventListener('click', function() {
			if (ccOn) {
				player.disableTextTrack().catch(function() {});
				ccOn = false;
				container.setAttribute('data-cc', 'false');
				ccBtn.setAttribute('aria-label', 'Turn on captions');
			} else if (ccLang) {
				player.enableTextTrack(ccLang).catch(function() {});
				ccOn = true;
				container.setAttribute('data-cc', 'true');
				ccBtn.setAttribute('aria-label', 'Turn off captions');
			}
		});
	}

	progressEl.addEventListener('click', function(e) {
		if (duration <= 0) return;
		var rect = progressEl.getBoundingClientRect();
		var pct = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
		player.setCurrentTime(pct * duration).catch(function() {});
	});

	if (fullscreenBtn) {
		fullscreenBtn.addEventListener('click', function() {
			var fsEl = document.fullscreenElement || document.webkitFullscreenElement;
			if (fsEl === container) {
				(document.exitFullscreen || document.webkitExitFullscreen).call(document);
			} else {
				(container.requestFullscreen || container.webkitRequestFullscreen).call(container);
				player.play().catch(function() {});
			}
		});
		function updateFs() {
			var fsEl = document.fullscreenElement || document.webkitFullscreenElement;
			container.setAttribute('data-fullscreen', fsEl === container ? 'true' : 'false');
		}
		document.addEventListener('fullscreenchange', updateFs);
		document.addEventListener('webkitfullscreenchange', updateFs);
	}
})();
</script>
<?php endif; ?>
