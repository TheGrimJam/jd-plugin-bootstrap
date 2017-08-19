<?php

// At the moment this is just for example purposes


// Remove dashboard widgets
function remove_dashboard_meta() {
	if ( ! current_user_can( 'manage_options' ) ) {
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
	}
}
add_action( 'admin_init', 'remove_dashboard_meta' ); 


function wpexplorer_remove_menus() {
	remove_menu_page( 'themes.php' );          // Appearance
	remove_menu_page( 'plugins.php' );         // Plugins
	remove_menu_page( 'tools.php' );           // Tools
	remove_menu_page( 'options-general.php' ); // Settings
}
//add_action( 'admin_menu', 'wpexplorer_remove_menus' );


/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function wpexplorer_add_dashboard_widgets() {
	wp_add_dashboard_widget(
		'wpexplorer_dashboard_widget', // Widget slug.
		'Supercytes Quick Links', // Title.
		'wpexplorer_dashboard_widget_function' // Display function.
	);

	wp_add_dashboard_widget(
		'wpexplorer_dashboard_widget_2', // Widget slug.
		'Recent School Registrations', // Title.
		'wpexplorer_dashboard_widget_function_2' // Display function.
	);

	wp_add_dashboard_widget(
		'wpexplorer_dashboard_widget_3', // Widget slug.
		'Testimonials', // Title.
		'wpexplorer_dashboard_widget_function_3' // Display function.
	);
}
//add_action( 'wp_dashboard_setup', 'wpexplorer_add_dashboard_widgets' );

/**
 * Create the function to output the contents of your Dashboard Widget.
 */
function wpexplorer_dashboard_widget_function() {
	echo "Schools to be reviewed, approved, and declined: <br /> <a class='button button-primary button-large' href='/approve'>Approve</a><br /> <br />";
	echo "The current excel document with supercytes quiz details:<br /> <a class='button button-primary button-large' href='/excel'>Download Excel</a>";
}

/**
 * Create the function to output the contents of your Dashboard Widget.
 */
function wpexplorer_dashboard_widget_function_2() {
	global $post;
		$sc_posts = get_posts(array(
			'posts_per_page'	=> 25,
			'post_status' => array('publish', 'draft'),
			'post_type'			=> 'Supercyte'
		));

		if( $sc_posts ) { 
			?>
			<ul>

			<?php
			foreach ($sc_posts as $sc_post) {
				$status =  'awaiting';
				if ($sc_post->post_status == 'publish') { $status = "approved"; }
				?>
				<li>
				<b><?php echo get_field('popup-title', $sc_post->ID); ?></b>

				<i class="<?php echo $status ?>">(<?php echo $status; ?>)</i>
				</li>
				<?php
			}
			wp_reset_postdata();
			?>
				</ul>
			<?php
		}
}


/* Testimonials */
function wpexplorer_dashboard_widget_function_3() {
	global $post;
		$t_posts = get_posts(array(
			'posts_per_page'	=> 25,
			'post_status' => 'publish',
			'post_type'			=> 'testimonial'
		));

		if( $t_posts ) { 
			?>
			<ul>

			<?php
			foreach ($t_posts as $t_post) {
				?>
					<li> 
				<?php echo "<b>" . $t_post->post_content . "</b><br />"; ?>
				<?php echo $t_post->post_title; ?>
				</li>
				<?php
			}
			wp_reset_postdata();
			?>
				</ul>
			<?php
		}
}