<?php
/**
 * WP Backend System - Main Transient Administrator
 *
 * @since       15.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Transients;

/********************************************/
/********** MAIN TAXONOMIE CREATOR **********/
/********************************************/

class MainTransientAdministrator implements TransientAdministrator
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /********************************/
    /********** HARD RESET **********/
    /********************************/

    /*
     * @return Bool
     */

    private function _hardReset(): bool
    {
        if (self::clearTransients()) {
            update_option('transients_list', []);
            return true;
        }
        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** GENERATE VIEW **********/
    /***********************************/

    private function _generateView()
    {
        if (is_admin()) {
            $class = $this;
            add_action('admin_menu', function() use ($class) {
                add_menu_page('Cache', 'Cache', 'manage_options', 'cache', function() use ($class) {

                    if (!current_user_can('manage_options'))  {
                        wp_die(__( 'You do not have sufficient pilchards to access this page.'));
                    }
                    
                    if (isset($_POST['clear_cache']) && check_admin_referer('clear_cache_clicked')) {
                        $clearCache = $class::clearTransients();
                        if ($clearCache) {
                            echo '<p>Cache cleared!</p>';
                        } else {
                            echo '<p>There was a problem during the process. Please retry!</p>';
                        }
                    }

                    if (isset($_POST['destroy_cache']) && check_admin_referer('destroy_cache_clicked')) {
                        $clearCache = $class->_hardReset();
                        if ($clearCache) {
                            echo '<p>Hard reset made!</p>';
                        } else {
                            echo '<p>There was a problem during the process. Please retry!</p>';
                        }
                    }
                    
                    echo '<div class="wrap">';
                        echo '<h2>Cache</h2>';
                        echo '<h3>Clear cache</h3>';
                        echo '<form action="admin.php?page=cache" method="post">';
                            wp_nonce_field('clear_cache_clicked');
                            echo '<input type="hidden" value="true" name="clear_cache" id="clear_cache" />';
                                submit_button('Clear cache');
                            echo '</form>';
                        echo '</form>';
                        echo '<hr />';
                        echo '<h3>Hard reset</h3>';
                        echo '<form action="admin.php?page=cache" method="post">';
                            wp_nonce_field('destroy_cache_clicked');
                            echo '<input type="hidden" value="true" name="destroy_cache" id="destroy_cache" />';
                                submit_button('Hard reset');
                            echo '</form>';
                        echo '</form>';
                    echo '</div>';

                }, 'dashicons-image-rotate');
            });
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** GENERATE BACKEND VIEW **********/
    /*******************************************/

    public function generateBackendView()
    {
        $this->_generateView();
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /**************************************/
    /********** CLEAR TRANSIENTS **********/
    /**************************************/

    public static function clearTransients(): bool
    {
        global $wpdb;

        $registeredTransients = get_option('transients_list');

        if (empty($registeredTransients) || !is_array($registeredTransients)) {
            return false;
        }

        $query = "DELETE FROM " . $wpdb->prefix . "options WHERE `option_name` IN ( ";

        $arraySize = count($registeredTransients);
        $arrayToUse = array();

        foreach ($registeredTransients as $t => $transient) {
            $query .= "%s, %s, ";
            array_push($arrayToUse, "_transient_" . $transient, "_transient_timeout_" . $transient);
        }   

        $query = substr($query, 0, -2);
        $query .= " )";

        $wpdb->query($wpdb->prepare($query, $arrayToUse));

        return true;
    }

}