<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://juan.com
 * @since      1.0.0
 *
 * @package    Iq_I
 * @subpackage Iq_I/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap"> 
    <h2>IQ Settings</h2>
    <?php settings_errors(); ?>  
    <form method="POST" action="options.php">  
        <?php 
            settings_fields( 'iq_settings' );
            do_settings_sections( 'iq_settings' ); 
        ?>             
        <?php submit_button(); ?>  
    </form> 
</div>