<?php 
	
	add_action( 'login_head', 'pr_login_head', 1, 0 );
	/**
	  * Login page headers
	  *
	  * Redirect if logged in 
	  *
	  * @return mixed
	  */
		function pr_login_head() {

		$redirect = get_option('pr-loggedin-redirect', false);
		 
		 if( !isset( $_SESSION['invitation'] ) || empty( $_SESSION['invitation']) ) 
				 wp_enqueue_style("PR_fronted", PR_BATH . "/css/front-end.css", false, "1.0", "all" );

		 if(!empty($redirect)) {

		 	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';


			if( is_user_logged_in() || isset($_SESSION['registered']) AND $action == 'register' ) {

				header("Location: {$redirect}");

			}

		 }

		}	

		function pr_is_plugin_active( $plugin ) {
		    return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
		}
		 
    if( !isset( $_SESSION['invitation'] ) || empty( $_SESSION['invitation']) ) {

			add_action( 'login_init', 'pr_remove_forms', 1, 0 );

			function pr_remove_forms() {
					
					remove_all_actions('register_form');
					
					// Password Form
				  	add_action('register_form', 'protected_registreation_form' , 10);


				  	remove_all_actions('registration_errors');

					    //2. Add validation. In this case, we make sure first_name is required.
					    add_filter( 'registration_errors', 'pr_errors', 10 , 3 );
		    

			}
			

			function protected_registreation_form() {

		        ?>
		        <p>
		            <span title="Powered by Protected Registreation">Invitation Code*</span><br>
		                <input type="text" name="invitation_code" id="invitation_code" class="input" size="25" /></label>
		                <style>.baweic_fields_text_link{font-style:italic;position:relative;top:-15px}</style>
		                <span id="baweic_fields_text_link" class="baweic_fields_text_link">Need an invitation code? <a href="mailto:<?=get_bloginfo('admin_email');?>">Contact us!</a></span>
		        </p>
		        <?php
		    }
		    

		    function pr_errors( $errors, $sanitized_user_login, $user_email ) {
		        
		    	 $invitation_code = isset( $_POST['invitation_code'] ) ? strtoupper( $_POST['invitation_code'] ) : '';

		    	 if( pr_is_plugin_active( 'baw-invitation-codes/baw-eic.php' )) {

						$baweic_options = get_option( 'baweic_options' );

						if (  array_key_exists( $invitation_code, $baweic_options['codes'] ) && $baweic_options['codes'][ $invitation_code ]['leftcount'] ) {
						  	  $_SESSION['invitation'] = trim($invitation_code);
							 add_action( 'login_footer' , 'pr_register_footer');
						}
							
				 }else{

						if( get_option('pr-single-password') )
			    				 $_SESSION['invitation'] = true;

		    	}

		    		if ( !isset($_SESSION['invitation']) ) {
		    			return new WP_Error( 'authentication_failed', __( '<strong>ERROR</strong>: This Invitation Code is Invalid or Over.' ) );
		    		}  else{
		    			?> <style> #login_error{ display:none } </style> <?php
		    			return new WP_Error();
		    		}

		    }


   }


    function pr_register_footer() {
    	?>
    		<script type="text/javascript">
    		function getClosest(el, tag) {
				  // this is necessary since nodeName is always in upper case
				  tag = tag.toUpperCase();
				  do {
				    if (el.nodeName === tag) {
				      // tag name is found! let's return it. :)
				      return el;
				    }
				  } while (el = el.parentNode);

				  // not found :(
				  return null;
				}

				(function() {
					document.getElementById('invitation_code').value = '<?php echo $_SESSION['invitation']; ?>';
					var inv = document.getElementById('invitation_code').parentNode;
					getClosest(inv, 'p').style.display = 'none';
				})();
    		</script>
    	<?php
    }


   if( isset($_SESSION['invitation']) AND !empty($_SESSION['invitation'])) {
   	 
   	 if( pr_is_plugin_active( 'baw-invitation-codes/baw-eic.php' ) ) {

   	 		 add_action( 'login_footer' , 'pr_register_footer');

	 } 

	 add_filter( 'registration_errors', 'pr_remove_session', 21, 3 ); 
		function pr_remove_session( $errors, $sanitized_user_login, $user_email ) {
			
			if( count( $errors->errors ) ) {
				return $errors;
			}
	 		
	 			unset($_SESSION['invitation']);
	 			$_SESSION['registered'] = true;

			return $errors;
		}
 
   }

?>