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
    die("<html>
<head>
    <title>Alert</title>
    <meta charset='utf8'>
</head>
<body>
<script charset='utf8'>
    alert('" . $text . "'); 
    window.location.href = '" . $redirect_url . "'
</script>
</body>
</html>");


}
