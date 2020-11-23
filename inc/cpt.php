<?php

class SPG_CPT {

	public function spg_project_portfolio() {

		$labels  = array(
			'name'                  => _x( 'All Portfolio', 'Post Type General Name', 'sortable-portfolio-gallery' ),
			'singular_name'         => _x( 'Portfolio', 'Post Type Singular Name', 'sortable-portfolio-gallery' ),
			'menu_name'             => __( 'Project Portfolio', 'sortable-portfolio-gallery' ),
			'name_admin_bar'        => __( 'Project Portfolio', 'sortable-portfolio-gallery' ),
			'archives'              => __( 'Item Archives', 'sortable-portfolio-gallery' ),
			'attributes'            => __( 'Portfolio Attributes', 'sortable-portfolio-gallery' ),
			'parent_item_colon'     => __( 'Parent Item:', 'sortable-portfolio-gallery' ),
			'all_items'             => __( 'All Portfolio', 'sortable-portfolio-gallery' ),
			'add_new_item'          => __( 'Add New Item', 'sortable-portfolio-gallery' ),
			'add_new'               => __( 'Add New Portfolio', 'sortable-portfolio-gallery' ),
			'new_item'              => __( 'New Portfolio', 'sortable-portfolio-gallery' ),
			'edit_item'             => __( 'Edit Portfolio', 'sortable-portfolio-gallery' ),
			'update_item'           => __( 'Update Portfolio', 'sortable-portfolio-gallery' ),
			'view_item'             => __( 'View Portfolio', 'sortable-portfolio-gallery' ),
			'view_items'            => __( 'View Portfolios', 'sortable-portfolio-gallery' ),
			'search_items'          => __( 'Search Portfolio', 'sortable-portfolio-gallery' ),
			'not_found'             => __( 'Portfolio Not found', 'sortable-portfolio-gallery' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'sortable-portfolio-gallery' ),
			'featured_image'        => __( 'Portfolio Image', 'sortable-portfolio-gallery' ),
			'set_featured_image'    => __( 'Set Portfolio image', 'sortable-portfolio-gallery' ),
			'remove_featured_image' => __( 'Remove portfolio image', 'sortable-portfolio-gallery' ),
			'use_featured_image'    => __( 'Use as portfolio image', 'sortable-portfolio-gallery' ),
			'insert_into_item'      => __( 'Insert into item', 'sortable-portfolio-gallery' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'sortable-portfolio-gallery' ),
			'items_list'            => __( 'Items list', 'sortable-portfolio-gallery' ),
			'items_list_navigation' => __( 'Items list navigation', 'sortable-portfolio-gallery' ),
			'filter_items_list'     => __( 'Filter items list', 'sortable-portfolio-gallery' ),
		);
		$rewrite = array(
			'slug'       => 'portfolio',
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);
		$args    = array(
			'label'               => __( 'Post Type', 'sortable-portfolio-gallery' ),
			'description'         => __( 'Sortable Portfolio Gallery', 'sortable-portfolio-gallery' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'page-attributes', 'post-attributes', 'editor', 'thumbnail' ),
			'taxonomies'          => array( 'portfolio_categories' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-format-gallery',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'page',
		);
		register_post_type( 'spg_portfolio', $args );

	}

	public function spg_taxonomy() {
		register_taxonomy(
			'portfolio_categories',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
			'spg_portfolio',             // post type name
			array(
				'hierarchical' => true,
				'label'        => 'Portfolio Categories', // display name
				'query_var'    => true,
				'rewrite'      => array(
					'slug'       => 'portfolio',    // This controls the base slug that will display before each term
					'with_front' => false  // Don't display the category base before
				)
			)
		);
	}

	public function spg_meta_boxes() {
		add_meta_box(
			'preview_url',
			'Preview URL',
			[ $this, 'spg_meta_preview_url_content' ],
			'spg_portfolio',
			'side',
			'default'
		);
	}

	public function spg_meta_preview_url_content() {
		global $post;
		wp_nonce_field( basename( __FILE__ ), 'spg_fields' );
		$preview_url = get_post_meta( $post->ID, 'preview_url', true );
		echo '<input type="text" name="preview_url" value="' . $preview_url . '">';
	}

	public function spg_save_preview_url( $post_id, $post ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		if ( ! isset( $_POST['preview_url'] ) || ! wp_verify_nonce( $_POST['spg_fields'], basename( __FILE__ ) ) ) {
			return $post_id;
		}

		update_post_meta( $post_id, 'preview_url', $_POST['preview_url'] );
	}


	public function init() {

		add_action( 'init', [ $this, 'spg_project_portfolio' ], 0 );
		add_action( 'init', [ $this, 'spg_taxonomy' ] );
		add_action( 'add_meta_boxes', [ $this, 'spg_meta_boxes' ] );
		add_action( 'save_post_spg_portfolio',[$this,'spg_save_preview_url'],1,2);
	}
}