<?php
/**
 *
 * @package HyperVid_Theme
 *
 */
get_header(); ?>
	<button class="prev">&lt;</button>
<div class="slider-body">
	<div class="gallery">
		<ul class="cards">
		    <?php
				if ( have_posts() ) : while ( have_posts() ): the_post(); 
					if ( has_post_thumbnail()) {?>

				<li id="post-<?php the_ID(); ?>">
					<div class="top-bar"></div>
					<div  class="img" style="background-image:url('<?php the_post_thumbnail_url(); ?>');">
					</div>
					<div class="descr">
					<h3><?php the_title(); ?></h3>
					<div class="post-excerpt"><?php the_excerpt(); ?></div>
					</div>
					<div class="bottom-bar"></div>
				</li>

					<?php } else if (get_post_meta(get_the_ID(), 'codeless_video_embed', true)) { ?>

				<li id="post-<?php the_ID(); ?>">
					<div class="top-bar"></div>
					<div  class="img">
							<?php echo get_post_meta(get_the_ID(), 'codeless_video_embed', true); ?>
					</div>
					<div class="descr">
					<h3><?php the_title(); ?></h3>
					<div class="post-excerpt"><?php the_excerpt(); ?></div>
					</div>
					<div class="bottom-bar"></div>
				</li>

				<?php }
					endwhile;
				endif;
			?>
		</ul>
	</div>
</div>
<button class="next">&gt;</button>
