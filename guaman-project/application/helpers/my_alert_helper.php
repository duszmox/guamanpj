<?php
/**
 * Created by PhpStorm.
 * User: horva
 * Date: 2019.03.14.
 * Time: 18:13
 */

/**
 * @param string $text The text to alert
 * @param string $redirect_url The browser will redirect the user after clicking the ok button
 */
function js_alert($text = "", $redirect_url = "")
{
    die("<script>
	alert('" . $text . "');
    window.location.href = '" . $redirect_url . "';
</script>");


}

function json_error($message){
    $output = array("error" => $message);
    json_output($output);
}

function json_output($data){
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($data));
}