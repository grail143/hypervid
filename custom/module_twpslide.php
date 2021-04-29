<?php
/**
 *
 * @package HyperVid_Theme
 *
 */?>

	<button class="hv-twpslide-prev">&lt;</button> <!--prev button outside of all the gsap magic -->
	<div class="hv-twpslide-slider-body"><!--BEGIN: hv-twpslide-slider-body is the div used by gsap for scrolling. The outermost gsap div with expected width, height and hidden overflow, hidden scrollbar-->
		<div class="hv-twpslide-gallery"><!--BEGIN: hv-twpslide-gallery used by gsap to hold all the scrolling objects-->
			<ul class="hv-twpslide-cards"><!--BEGIN:  hv-twpslide-cards to scroll-->
		    <?php
				if ( have_posts() ) : //BEGIN: get the posts
					while ( have_posts() ): the_post(); //BEGIN: loop posts
						if (get_post_meta(get_the_ID(), 'codeless_video_embed', true) || has_post_thumbnail()): //BEGIN: if thumbnail or video
			?> 
				<li  class="pure-g" id="post-<?php the_ID(); ?>"><!--BEGIN: li for each post is contained in list item and pure grid-->
					<div class="hv-twpslide-top-bar"></div><!--pretty gradient-->
					<div  class="hv-twpslide-img pure-u-1 pure-u-md-3-4"><!--BEGIN: image/vid div; hv-twpslide-img needed for img tag to confine to this div-->
					<?php
						if (get_post_meta(get_the_ID(), 'codeless_video_embed', true)): //if it is a video post
							echo get_post_meta(get_the_ID(), 'codeless_video_embed', true); //currently featured video is saved as embed code . . . todo: update featured video input, do I need 'echo'?, confine embed to this size
						else: //no video but only got here with photo
							the_post_thumbnail('scroller-size'); //returns img tag
						endif;//end video or image
					?>
					</div><!--END: image/vid div-->
					<div class="pure-hidden-xs pure-hidden-sm pure-u-md-1-4 hv-twpslide-info"><!--BEGIN: div with all the info on post, hidden on small-->
						<h3><?php the_title(); ?></h3>
						<?php
							$posttags = get_the_tags(); 
							if ($posttags) ://BEGIN: if the post has tags
						?>
							<div class="hv-twpslide-tags"><!--BEGIN: tag div-->
							<?php
								foreach($posttags as $tag): //BEGIN: tag loop
							?>
								<div class="hv-twpslide-tag" title="<?php echo trim($tag->name . ' '); ?>"><!--BEGIN: each tag-->
									<?php echo trim($tag->name . ' '); ?>
								</div><!--END: each tag-->
							<?php 
								endforeach; // END: tag loop
							?>
							</div><!--END: tag div--> 
						<?php 
							endif; //BEGIN: if the post has tags
						?>
						<div><?php the_excerpt(); ?></div>
						<div class="hv-twpslide-read-more"><a href="<?php get_the_permalink() ?>" rel="nofollow"><span style="font-weight:bolder;">&gt;</span></a></div>
					</div><!--END: div with all the info on post-->
					<div class="hv-twpslide-bottom-bar"></div><!--pretty gradient-->
				</li><!--END: : li for each post-->
			<?php 
					endif; //END: if thumbnail or video
				endwhile; //END: loop posts
			endif; //END: get the posts
			?>
			</ul><!-- END: hv-twpslide-cards -->
		</div><!--END: hv-twpslide-gallery-->
	</div><!--END: hv-twpslide-slider-body-->
	<button class="hv-twpslide-next">&gt;</button> <!--next button outside of all the gsap magic -->
