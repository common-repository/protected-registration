<h2><?php _e('Settings'); ?>:</h2>
<div class="pr-col-left">
    <form method="post" action="<?php echo site_url().'/wp-admin/options-general.php?page=pr-registration'; ?>"> 

        <input type="hidden" name="submit" value="1"> 
        <table class="form-table">
       
         <?php  if(is_plugin_active( 'baw-invitation-codes/baw-eic.php' )) : ?>

            <tr valign="top"> 
                <th scope="row"><?php _e('Use Invitations Plugin'); ?></th>
                <td>
                    <p class="description"> 
                        <input type="checkbox" id="pr-baw-invitation" name="pr-baw-invitation" <?php if(get_option('pr-baw-invitation', false) == true) { echo 'checked="checked"'; } ?> />

                        <?php _e('When checked, the system will automatically get codes from Invitation Codes plugin installed on your wordpress.'); ?>
                    </p>
                </td>
            </tr>

         <?php endif; ?>

             <tr valign="top"> 
                <th scope="row"><?php _e('Redirect logged in users'); ?></th>
                <td>
                    <p class="description"> 
                        <input type="url" name="pr-loggedin-redirect" value="<?php echo get_option('pr-loggedin-redirect'); ?>" />
                        <?php _e('When user visits login or register page when he is already logged in, Leave it empty to disable redirect.'); ?>
                    </p>
                </td>
             </tr>

             <tr class="pr_customs" valign="top"> 
                <th scope="row"><?php _e('Single Password Protection'); ?></th>
                <td>
                    <p class="description"> 
                        <input type="password" name="pr-single-password" value="xxxxxxxx" />
                    </p>
                </td>
             </tr>
 
        </table> 
        <p class="submit">
            <input class="button" type="submit" name="Submit" value="<?php _e('Save settings') ?>" />  
        </p>
    </form> 
</div>
<div class="pr-col-right">
    <p>This Plugin was created by Mostafa Kassem (<a class="mgl_banner" href="https://www.facebook.com/Zanzofily" title="Follow me on facebook" target="_blank">Zanzofily</a>) </p>
   
</div>