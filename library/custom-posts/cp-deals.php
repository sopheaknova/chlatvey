<?php
/*
*****************************************************
* Deals custom post
*
* CONTENT:
* - 1) Actions and filters
* - 2) Creating a custom post
* - 3) Custom post list in admin
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering CP
		add_action( 'init', 'sp_deals_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'sp_deals_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-deals_columns', 'sp_deals_cp_columns' );




/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'sp_deals_cp_init' ) ) {
		function sp_deals_cp_init() {
			global $cp_menu_position;

			$role     = 'post'; // page
			$slug     = 'deals';
			$supports = array('title'); // 'title', 'editor', 'thumbnail', 'post-formats'

			/*if ( $smof_data['sp_newsticker_revisions'] )
				$supports[] = 'revisions';*/

			$args = array(
				'query_var'           => 'deals',
				'capability_type'     => $role,
				'public'              => true,
				'show_ui'             => true,
				'show_in_nav_menus'	  => false,
				'exclude_from_search' => false,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => $slug ),
				'menu_position'       => $cp_menu_position['deals'],
				'menu_icon'           => SP_ASSETS_ADMIN . 'images/icon-deals.png',
				'supports'            => $supports,
				'labels'              => array(
					'name'               => __( 'Deals', 'sptheme_admin' ),
					'singular_name'      => __( 'Deal', 'sptheme_admin' ),
					'add_new'            => __( 'Add new', 'sptheme_admin' ),
					'add_new_item'       => __( 'Add new gift', 'sptheme_admin' ),
					'new_item'           => __( 'New gift', 'sptheme_admin' ),
					'all_items' 		 => __('All gift', 'sptheme_admin'),
					'edit_item'          => __( 'Edit gift', 'sptheme_admin' ),
					'view_item'          => __( 'View gift', 'sptheme_admin' ),
					'search_items'       => __( 'Search gift', 'sptheme_admin' ),
					'not_found'          => __( 'No gift found', 'sptheme_admin' ),
					'not_found_in_trash' => __( 'No gift found in trash', 'sptheme_admin' ),
					'parent_item_colon'  => ''
				)
			);
			register_post_type( 'deals' , $args );
		}
	} 


/*
*****************************************************
*      3) CUSTOM POST LIST IN ADMIN
*****************************************************
*/
	/*
	* Registration of the table columns
	*
	* $Cols = ARRAY [array of columns]
	*/
	if ( ! function_exists( 'sp_deals_cp_columns' ) ) {
		function sp_deals_cp_columns( $columns ) {
			
			$columns = array(
				'cb'                   	=> '<input type="checkbox" />',
				'title'                	=> __( 'Name', 'sptheme_admin' ),
				'deal-category' 	=> __( 'Category', 'sptheme_admin' ),
				'date' 					=> __( 'Date', 'sptheme_admin' ),
				'author' 				=> __( 'Created By', 'sptheme_admin' )
			);

			return $columns;
		}
	} // /deals_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'sp_deals_cp_custom_column' ) ) {
		function sp_deals_cp_custom_column( $column ) {
			global $post;
			
			switch ( $column ) {
				case "deal-category":

					$terms = get_the_terms( $post->ID, 'deal-category' );

					if ( empty( $terms ) )
						break;
		
						$output = array();
		
						foreach ( $terms as $term ) {
							
							$output[] = sprintf( '<a href="%s">%s</a>',
								esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'deal-category' => $term->slug ), 'edit.php' ) ),
								esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'deal-category', 'display' ) )
							);
		
						}
		
						echo join( ', ', $output );

				break;				
				default:
				break;
			}
		}
	} // /sp_deals_cp_custom_column
	
	