<?php
/**
 * Main template file for displaying posts.
 *
 * @package TailPress
 */

get_header();
?>

<div class="container mx-auto">
	<?php
	// Query the Portfolio custom post type
	$portfolio_query = new WP_Query([
		'post_type' => 'portfolio',
		'posts_per_page' => 9,
		'post_status' => 'publish'
	]);
	?>

	<?php if ($portfolio_query->have_posts()): ?>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php while ($portfolio_query->have_posts()):
				$portfolio_query->the_post(); ?>
				<?php
				// Get project link from metabox
				$project_url = get_post_meta(get_the_ID(), '_portfolio_url', true);
				if (empty($project_url))
					$project_url = get_permalink(); // fallback
		
				// Get client name
				$client_name = get_post_meta(get_the_ID(), '_portfolio_client', true);
				if (empty($client_name))
					$client_name = get_the_title(); // fallback
		
				// Get image
				$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
				if (!$thumb_url) {
					$thumb_url = 'https://via.placeholder.com/600x400/1E293B/FFFFFF?text=Aper%C3%A7u+Projet';
				}
				?>
				<div class="flip-card reveal" data-delay="100">
					<div class="flip-card-inner">
						<!-- Front of Card: Image + Company Name -->
						<div class="flip-card-front" style="background-image: url('<?php echo esc_url($thumb_url); ?>');">
							<div class="flip-card-overlay"></div>
							<div class="flip-card-front-content">
								<span class="flip-card-client"><?php echo esc_html($client_name); ?></span>
							</div>
						</div>

						<!-- Back of Card: Title, Description & Link -->
						<div class="flip-card-back">
							<div class="flip-card-back-inner">
								<h3 class="flip-card-back-title"><?php the_title(); ?></h3>
								<div class="flip-card-divider"></div>
								<div class="flip-card-desc">
									<?php
									if (has_excerpt()) {
										the_excerpt();
									} else {
										echo wp_trim_words(get_the_content(), 18, '...');
									}
									?>
								</div>
								<a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener noreferrer"
									class="btn-visit">
									Visiter le projet
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
										stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
										<line x1="5" y1="12" x2="19" y2="12" />
										<polyline points="12 5 19 12 12 19" />
									</svg>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	<?php else: ?>
		<p class="text-center" style="color:#64748B;">Les projets arrivent bientôt...</p>
	<?php endif; ?>
</div>

<?php
get_footer();
