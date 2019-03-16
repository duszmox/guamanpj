<?php
function css_url($css_file)
{
    return base_url("/assets/css/" . $css_file);
}

function js_url($js_file)
{
    return base_url("/assets/js/" . $js_file);
}

function img_url($img_file)
{
	return base_url("/assets/img/" . $img_file);
}


?>
