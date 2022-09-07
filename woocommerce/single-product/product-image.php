<?php
	/**
	 * Single Product Image
	 *
	 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
	 *
	 * HOWEVER, on occasion WooCommerce will need to update template files and you
	 * (the theme developer) will need to copy the new files to your theme to
	 * maintain compatibility. We try to do this as little as possible, but it does
	 * happen. When this occurs the version of the template file will be bumped and
	 * the readme will list any important changes.
	 *
	 * @see     https://docs.woocommerce.com/document/template-structure/
	 * @package WooCommerce\Templates
	 * @version 3.5.1
	 */
	global $post;
?>
<div class="product_card_display">
	<img class="cover" src="<?php echo get_the_post_thumbnail_url($post->ID, 'medium'); ?>" alt="<?php the_title(); ?>">
	<?php if (get_field('audio_file')) : ?>
		<div class="audio_preview">
			<h4><?php esc_html_e('Preview'); ?></h4>
			<div class="audio_preview_container">
				<div class="audio_loading">
					<span>Generating Audio Preview...</span>
				</div>
				<div class="generated_player in_progress">
					<div class="player_controls">
						<button class="controls_button" onclick="wavesurfer.playPause()" data-icon-play="<?php echo get_template_directory_uri() . '/assets/images/icons/play.svg'; ?>" data-icon-pause="<?php echo get_template_directory_uri() . '/assets/images/icons/pause.svg'; ?>">
							<img class="playbutton" src="<?php echo get_template_directory_uri() . '/assets/images/icons/play.svg'; ?>" alt="Play Preview" width="24" height="24">
						</button>
					</div>
					<div id="waveform" class="audio_preview_player"></div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="share-item">
		<h4>Share Item</h4>
		<ul class="share-links">
			<li><a href="<?php echo 'http://www.facebook.com/share.php?u=' . get_the_permalink(); ?>" title="Share on Facebook" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=600');return false;">Facebook</a></li>
			<li><a href="<?php echo 'http://www.twitter.com/intent/tweet?url=' . get_the_permalink() . '&via=intakestore&text=' . get_the_title(); ?>" title="Share on Twitter" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=600');return false;">Twitter</a></li>
			<li><a href="<?php echo 'https://www.linkedin.com/sharing/share-offsite/?url=' . get_the_permalink(); ?>" title="Share on LinkedIn" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=600');return false;">LinkedIn</a></li>
			<li><a href="<?php echo 'https://t.me/share/url?url=' . get_the_permalink() . '&text=' . get_the_title(); ?>" title="Share on Telegram" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=600');return false;">Telegram</a></li>
		</ul>
	</div>
</div>
<?php
// Init wavesurfer
add_action('wp_print_footer_scripts', 'init_wavesurfer_plugin', 10);
function init_wavesurfer_plugin(){
	$audiofile = get_field('audio_file');
	if ($audiofile) {
?>
	<script>
		var wavesurfer = WaveSurfer.create({
			container: '#waveform',
			height: 50,
			backend: 'WebAudio',
			barWidth: 1,
			barGap: 2,
			barHeight: 1.5,
			barRadius: 2,
			cursorColor: '#007bec',
			progressColor: '#007bec',
			waveColor: '#ccc',
			cursorWidth: 2,
			responsive: true
		});
		wavesurfer.load("<?php echo $audiofile['url']; ?>");

		// Audio loading
		wavesurfer.on('ready', function(){
			setTimeout(() => {
				document.querySelector('.generated_player').classList.remove('in_progress');
				document.querySelector('.audio_loading').classList.add('loaded');
			}, 2000);
		});

		// play action
		let playbtn = document.querySelector('.controls_button'),
			btnIcon = document.querySelector('.playbutton'),
			iconPlay = playbtn.getAttribute('data-icon-play'),
			iconPause = playbtn.getAttribute('data-icon-pause');

		// Plaing
		wavesurfer.on('play', function(){
			playbtn.classList.add('playing');
			btnIcon.setAttribute('src', iconPause);
		});

		// Pause
		wavesurfer.on('pause', function(){
			playbtn.classList.remove('playing');
			btnIcon.setAttribute('src', iconPlay);
		});

		// Ended
		wavesurfer.on('finish', function(){
			playbtn.classList.remove('playing');
		});
	</script>
	<script>
		let buyBtn = document.querySelector('.product_buy .gray_button');
		buyBtn.addEventListener('click', function(event){
			if (this.classList.contains('clicked')) {
				this.classList.remove('clicked');
			} else {
				this.classList.add('clicked');
			}
		});
	</script>
<?php
	}
}