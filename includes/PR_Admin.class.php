<?php

class PR_Admin {
    
    const STATUS_MESSAGE_UPDATED = 'updated';
    const STATUS_MESSAGE_ERROR = 'error';
    const STATUS_MESSAGE_SUCCESS = 'success';
    
    public $Messages = array();

    public function __construct()

    {

        //Add settings page to Admin menu
        add_action('admin_menu', array( $this, 'PR_menue' ) );
        //Load scripts in MGL Instagram Admin panel
        add_action('admin_enqueue_scripts', array( $this, 'loadSettingsPageCSS' ) );
        

    }

    public function PR_menue() {  
        add_options_page( 
            'Protected Registration Panel',
            'Protected Registreation',
            'manage_options', 
            'pr-registration', 
                  array( $this , 'PR_panel') 
        );
    }

    public function loadSettingsPageCSS() {
        if ( 'settings_page_pr-registration' == get_current_screen()->id) {
            wp_enqueue_style("PR_admin", PR_BATH . "/css/admin.css", false, "1.0", "all" );
            wp_enqueue_script('PR_admin', PR_BATH. 'js/admin.js' , false, "1.0", "all" );

        }
    }
    
    public function PR_panel() {  

        if( isset($_POST['submit']) )  $this->updateSettings();

             require_once( 'panel.php' );

        if( isset($_GET['delete_instagram_account']) ) $this->removeInstagramApplication();
        if( isset($_GET['code'])) $this->validateApplicationWithInstagramServer();


    }//showInstagramGallerySettingsPage END

    public function updateSettings(){
        $updated = false;

        if( isset( $_POST['pr-single-password'] ) ){
            update_option( 'pr-single-password', md5($_POST['pr-single-password']) );
            $updated = true;
        }

        if( isset( $_POST['pr-baw-invitation'] ) ){
            update_option( 'pr-baw-invitation', $_POST['pr-baw-invitation'] );
            $updated = true;
        }

        if( isset( $_POST['pr-loggedin-redirect'] ) ){

            if(!filter_var($_POST['pr-loggedin-redirect'] , FILTER_VALIDATE_URL) AND !empty($_POST['pr-loggedin-redirect'])) {

                $messageSettingsSaved = __('Login redirect should be a valid <strong>Url</strong>.', MGL_INSTAGRAM_GALLERY_DOMAIN );
                $this->addFlashMessage( $messageSettingsSaved, self::STATUS_MESSAGE_ERROR );
                
                $updated = false;

            } else {
                    update_option( 'pr-loggedin-redirect', $_POST['pr-loggedin-redirect'] );
                    $updated = true; 
            }
        }

        if($updated == true) {
            $messageSettingsSaved = __('Settings saved', MGL_INSTAGRAM_GALLERY_DOMAIN );
            $this->addFlashMessage( $messageSettingsSaved, self::STATUS_MESSAGE_UPDATED );
        }

         $this->renderMessages();

    }//updateSettings END

    public function addFlashMessage( $message, $messageType ){
        $this->Messages[] = array( $messageType => $message );
    }//addFlashMessage END

    public function renderMessages(){
        foreach( $this->Messages as $flashMessage ){
            foreach( $flashMessage as $messageType => $message ){
                ?>
                    <div class="<?php echo $messageType; ?>"> 
                        <p><strong><?php echo $message ?></strong></p>
                    </div>
                <?php
            }
        }
        $this->Messages = array();
    }
 }

    $PR_Admin = new PR_Admin; 