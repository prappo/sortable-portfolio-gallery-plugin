<?php

class SPG_Sortcode {


	public function spg_shortcode_menu() {

		add_submenu_page(
			'edit.php?post_type=spg_portfolio',
			'Shortcode',
			'Sortcode',
			'manage_options',
			'spg_shortcode',
			[ $this, 'spg_shortcode_page' ]
		);

	}


	public function spg_shortcode_page() {

		echo '<h2> Shortcode </h2>';
		echo '<small>Copy shortcode and use in your page</small>';
		echo "<h1><code>[portfolio_gallery]</code></h1>";

	}

	public function spg_portfolio_gallery_content( $atts ) {
		ob_start();

		?>
        <div class="spg_container">
            <div id="myBtnContainer">
                <button class="spgBtn active" onclick="filterSelection('all')"> Show all</button>
				<?php
				$spg_categories = get_terms( 'portfolio_categories' );
				if ( ! empty( $spg_categories ) && ! is_wp_error( $spg_categories ) ):

					foreach ( $spg_categories as $category ) :


						?>

                        <button class="spgBtn"
                                onclick="filterSelection('<?php echo esc_html( $category->term_id, 'sortable-portfolio-gallery' ) ?>')"> <?php echo esc_html( $category->name, 'sortable-portfolio-gallery' ) ?></button>

					<?php
					endforeach;

				endif;

				?>
            </div>
            <!-- Portfolio Gallery Grid -->


            <div class="spgRow">

				<?php


				$args = array(
					'post_type'           => 'spg_portfolio',
					'order'               => 'ASC',
					'posts_per_page'      => 200,
					'ignore_sticky_posts' => true
				);

				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) :
						$the_query->the_post();
						// content goes here


						?>
                        <div class="spgColumn <?php echo get_the_terms( get_the_ID(), 'portfolio_categories' )[0]->term_id ?>">
                            <div class="spgContent">
                                <img src="<?php echo get_the_post_thumbnail_url() ?>"
                                     alt="Mountains" style="width:100%">
                                <h6 class="psg_title"><?php echo get_the_title() ?></h6>

                                <p style="text-align: center">
                                    <a class="detailsLink" href="<?php echo get_the_permalink() ?>" target="_blank">View
                                        Details</a>
                                </p>
                                <!--	                        <p>--><?php //echo $cat_id;
								?><!--</p>-->
                            </div>
                        </div>

					<?php

					endwhile;
					wp_reset_postdata();
				else:
				endif;
				?>

                <!-- END GRID -->
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	public function init() {
		add_action( 'admin_menu', [ $this, 'spg_shortcode_menu' ] );
		add_shortcode( 'portfolio_gallery', [ $this, 'spg_portfolio_gallery_content' ] );
	}
}