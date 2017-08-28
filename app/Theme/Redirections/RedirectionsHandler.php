<?php
/**
 * WP Backend System - Redirections Handler
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Redirections;

use App\Theme\Posts\PostGetter as PostGetter;

/******************************************/
/********** REDIRECTIONS HANDLER **********/
/******************************************/

class RedirectionsHandler implements Handler
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var PostGetter $_postGetter object that gets posts
     * @var Array $_redirections array of redirections to add
     */

    private $_postGetter;
    private $_redirections = [];

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /*
     * @param PostGetter $postGetter object that gets posts
     */

    public function __construct(PostGetter $postGetter)
    {
        $this->_setValues($postGetter);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** SETTERS **********/
    /*****************************/

    /**********/
    /********** SET VALUES **********/
    /**********/

    /*
     * @param PostGetter $postGetter object that gets posts
     */

    private function _setValues(PostGetter $postGetter)
    {
        $this->_setPostGetter($postGetter);
    }

    /**********/
    /********** POST GETTER **********/
    /**********/

    /*
     * @param PostGetter $postGetter object that gets posts
     */

    private function _setPostGetter(PostGetter $postGetter)
    {
        $this->_postGetter = $postGetter;
    }

    /**********/
    /********** REDIRECTIONS **********/
    /**********/

    /*
     * @param Array $redirections array of redirections to add
     */

    private function _setRedirections(array $redirections)
    {
        $this->_redirections = $redirections;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** REDIRECTIONS **********/
    /**********/

    /*
     * @param Array
     */

    public function getRedirections(): array
    {
        return $this->_redirections;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** PARSE FIELDS **********/
    /**********************************/

    /*
     * @param Array $fields redirection fields
     * @return Array
     */

    private function _parseFields($fields): array
    {
        $array = [];

        foreach ($fields as $f => $field) {
            $fieldObject = get_field_object($f);
            $array[$fieldObject['name']] = $field;
        }

        return $array;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** PREPARE REDIRECTION **********/
    /*****************************************/

    /*
     * @param Array $fields redirection settings
     * @return Array
     */

    private function _prepareRedirection(array $fields): array
    {
        $array = [];

        $settings = $this->_parseFields($fields);

        foreach ($settings as $s => $setting) {
            
            $fieldName = str_replace('custom_redirections_redirections_', '', $s);
            $array[$fieldName] = $setting;

        }

        return $array;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** PARSE REDIRECTIONS **********/
    /****************************************/

    /*
     * @return Array
     */

    private function _parseRedirections()
    {
        $redirections = [];
        $redirections['backend'] = [];
        $redirections['frontend'] = [];

        $redirect404 = false;
        $redirectAttachements = false;
        
        $this->_postGetter->setArgs([
                                'posts_per_page'   => -1,
                                'post_type'        => 'acf-field-group',
                            ]);

        $groups = $this->_postGetter->queryPost('get');

        if (empty($groups)|| !is_array($groups) || !$groups) {
            return false;
        }

        foreach ($groups as $group) {

            $groupInfo = maybe_unserialize($group->post_content)['location'][0][0];
            $param = $groupInfo['param'];
            $value = $groupInfo['value'];

            if ($param === 'options_page' && $value === 'acf-options-redirections') {

                $fields = acf_get_fields($group->post_name);

                if (!empty($fields[0]) && is_array($fields[0])) {

                    foreach ($fields as $f => $field) {

                        $fieldName = str_replace('custom_redirections_', '', $field['name']);

                        switch ($fieldName) {

                            case 'redirection_subscribers_wp_admin':
                                $redirections['backend']['redirect_subscribers'] = get_field('custom_redirections_redirection_subscribers_wp_admin', 'option');
                                break;

                            case 'redirect_404_bool':
                                $redirect404 = get_field('custom_redirections_redirect_404_bool', 'option');
                                break;

                            case '404_redirection':
                                if ($redirect404) {
                                    array_push($redirections['frontend'], ['template' => '404', 'target' => $field['value'], 'condition' => 'both']);
                                }
                                break;

                            case 'attachements_bool':
                                $redirectAttachements = get_field('custom_redirections_redirect_attachements_bool', 'option');
                                break;

                            case 'attachements_redirection':
                                if ($redirect404) {
                                    array_push($redirections['frontend'], ['template' => 'attachements', 'target' => $field['value'], 'condition' => 'both']);
                                }
                                break;

                            case 'redirections':

                                if (have_rows($field['name'], 'option')) {
                                
                                    while (have_rows($field['name'], 'option')) {
                                        the_row();
                                        array_push($redirections['frontend'], $this->_prepareRedirection(get_row()));
                                    }
            
                                }
                                break;
                        }
                    }
                }
            }
        }

        $this->_setRedirections($redirections);
        return $redirections;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** EXECUTE REDIRECTION **********/
    /*****************************************/

    /*
     * @param String $target where to redirect
     */

     private function _executeRedirection($target = null) 
     {
         wp_redirect(home_url($target));
         exit;
     }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** REDIRECT SUBSCRIBERS **********/
    /******************************************/

    private function _redirectSubscribers()
    {
        $class = $this;
        add_action('admin_init', function() use ($class) {
            if (!current_user_can('delete_posts') && strpos($_SERVER['PHP_SELF'], 'wp-admin/admin-ajax.php') === false) {
                $class->_executeRedirection();
            }
        });
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** REDIRECT 404 **********/
    /**********************************/

    /*
     * @param Array $redirection redirection setting
     */

    private function _redirect404($redirection)
    {
        $class = $this;
        add_action('template_redirect', function() use ($class, $redirection) {
            if (is_404()) {
                $class->_executeRedirection($redirection['target']);
            }
        });
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** REDIRECT ATTACHEMENTS **********/
    /*******************************************/

    /*
     * @param Array $redirection redirection setting
     */

     private function _redirectAttachements($redirection)
     {
         $class = $this;
         add_action('template_redirect', function() use ($class, $redirection) {
             if (is_attachment()) {
                 $class->_executeRedirection($redirection['target']);
             }
         });
     }
 
    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** GENERATE REDIRECTION **********/
    /******************************************/

    /*
     * @param Array $redirection redirection setting
     */

    private function _generateRedirection($redirection)
    {
        $class = $this;
        add_action('template_redirect', function() use ($class, $redirection) {

            if ($redirection['condition'] === 'is_logged') {

                if (is_user_logged_in() && is_page_template($redirection['template'])) {
                    $class->_executeRedirection($redirection['target']);
                }

            } elseif ($redirection['condition'] === 'not_logged') {

                if (!is_user_logged_in() && is_page_template($redirection['template'])) {
                    $class->_executeRedirection($redirection['target']);
                }

            } else {

                if (is_page_template($redirection['template'])) {
                    $class->_executeRedirection($redirection['target']);
                }

            }

        });
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************************/
    /********** ADD BACKEND REDIRECTIONS **********/
    /**********************************************/

    private function _addBackendRedirections()
    {
        if (is_admin()) {

            if (!empty($this->_redirections['backend']) && is_array($this->_redirections['backend'])) {
                foreach ($this->_redirections['backend'] as $r => $redirection) {
                    switch ($r) {
                        case 'redirect_subscribers':
                            $this->_redirectSubscribers();
                            break;
                    }
                }
            }
            
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************************/
    /********** ADD FRONTEND REDIRECTIONS **********/
    /***********************************************/

    private function _addFrontendRedirections()
    {
        if (!empty($this->_redirections['frontend']) && is_array($this->_redirections['frontend'])) {
            foreach ($this->_redirections['frontend'] as $r => $redirection) {
                if ($redirection['template'] == '404') {
                    $this->_redirect404($redirection);
                } elseif ($redirection['template'] == 'attachements') {
                    $this->_redirectAttachements($redirection);
                } else {
                    $this->_generateRedirection($redirection);
                }            
            }
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** ADD REDIRECTIONS **********/
    /**************************************/

    private function _addRedirections()
    {
        $this->_addBackendRedirections();
        $this->_addFrontendRedirections();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET UP REDIRECTIONS **********/
    /*****************************************/

    public function setUpRedirections()
    {
        try {
            $this->_parseRedirections();
            $this->_addRedirections();
        } catch (\Exception $e) {
            return false;
        }
    }

}