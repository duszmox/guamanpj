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

function js_alert_close_tab($text = "")
{
    die("<script>
	alert('" . $text . "');
    window.close();

</script>");
}

function json_error($message)
{
    $output = array("error" => $message);
    json_output($output);
}

function json_output($data)
{
    header('Content-Type: application/json');
    die (json_encode($data));
}