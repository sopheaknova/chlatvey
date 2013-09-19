<?php
/*
*****************************************************
* Quizzes custom post
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
		add_action( 'init', 'sp_quizzes_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'sp_quizzes_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-quizzes_columns', 'sp_quizzes_cp_columns' );




/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'sp_quizzes_cp_init' ) ) {
		function sp_quizzes_cp_init() {
			global $cp_menu_position;

			$role     = 'post'; // page
			$slug     = 'quizzes';
			$supports = array('title'); // 'title', 'editor', 'thumbnail', 'post-formats'

			/*if ( $smof_data['sp_newsticker_revisions'] )
				$supports[] = 'revisions';*/

			$args = array(
				'query_var'           => 'quizzes',
				'capability_type'     => $role,
				'public'              => true,
				'show_ui'             => true,
				'show_in_nav_menus'	  => false,
				'exclude_from_search' => false,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => $slug ),
				'menu_position'       => $cp_menu_position['quizzes'],
				'menu_icon'           => SP_ASSETS_ADMIN . 'images/icon-quiz.png',
				'supports'            => $supports,
				'labels'              => array(
					'name'               => __( 'Quizzes', 'sptheme_admin' ),
					'singular_name'      => __( 'Question', 'sptheme_admin' ),
					'add_new'            => __( 'Add new', 'sptheme_admin' ),
					'add_new_item'       => __( 'Add new question', 'sptheme_admin' ),
					'new_item'           => __( 'New questions', 'sptheme_admin' ),
					'all_items' 		 => __('All questions', 'sptheme_admin'),
					'edit_item'          => __( 'Edit question', 'sptheme_admin' ),
					'view_item'          => __( 'View question', 'sptheme_admin' ),
					'search_items'       => __( 'Search question', 'sptheme_admin' ),
					'not_found'          => __( 'No question found', 'sptheme_admin' ),
					'not_found_in_trash' => __( 'No question found in trash', 'sptheme_admin' ),
					'parent_item_colon'  => ''
				)
			);
			register_post_type( 'quizzes' , $args );
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
	if ( ! function_exists( 'sp_quizzes_cp_columns' ) ) {
		function sp_quizzes_cp_columns( $columns ) {
			
			$columns = array(
				'cb'                   	=> '<input type="checkbox" />',
				'title'                	=> __( 'Name', 'sptheme_admin' ),
				//'quizzes-category' 	=> __( 'Category', 'sptheme_admin' ),
				'date' 					=> __( 'Date', 'sptheme_admin' ),
				'author' 				=> __( 'Created By', 'sptheme_admin' )
			);

			return $columns;
		}
	} // /quizzes_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'sp_quizzes_cp_custom_column' ) ) {
		function sp_quizzes_cp_custom_column( $column ) {
			global $post;
			
			switch ( $column ) {
				case "quizzes-category":

					$terms = get_the_terms( $post->ID, 'quizzes-category' );

					if ( empty( $terms ) )
						break;
		
						$output = array();
		
						foreach ( $terms as $term ) {
							
							$output[] = sprintf( '<a href="%s">%s</a>',
								esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'quizzes-category' => $term->slug ), 'edit.php' ) ),
								esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'quizzes-category', 'display' ) )
							);
		
						}
		
						echo join( ', ', $output );

				break;				
				default:
				break;
			}
		}
	} // /sp_quizzes_cp_custom_column
	
	