<?php


/**
 * Class LanguageLoader
 */
class LanguageLoader
{
    /**
     * Init lang
     */
    function initialize()
    {
        $ci =& get_instance();
        $ci->load->helper('language');
        $site_lang = $ci->session->userdata('site_lang');
        if ($site_lang) {
            $ci->lang->load('information', $site_lang);
        } else {
            $ci->lang->load('information', 'hungarian');
        }
    }
}
