<?php
/**
 * Created by PhpStorm.
 * User: Horváth András Máté
 * Date: 2019. 05. 04.
 * Time: 17:54
 */

$form_class= "";
$form_id= "";
$input_normal = array();
$input_normal[0] = array(
    "type" => "text",
    'name'  => 'statistics_name',
    'id'    => 'statistics_name',
    'placeholder' => 'Statistics name', // todo lang "Statistics name" to language
    'class' => ''
);
$input_normal[1] = array(
    "type" => "number",
    'name'  => 'statistics_type',
    'id'    => 'statistics_type',
    'placeholder' => 'Statistics type ID', // todo lang "Statistics name" to language
    'class' => ''
);
$input_normal[2] = array(
    "type" => "number",
    'name'  => 'source_table',
    'id'    => 'source_table',
    'placeholder' => 'Source Table ID', // todo lang "Statistics name" to language
    'class' => ''
);
$input_normal[3] = array(
    "type" => "text",
    'name'  => 'selected_columns',
    'id'    => 'selected_columns',
    'placeholder' => 'Selected Columns Separated with ONLY ,', // todo lang "Statistics name" to language
    'class' => ''
);
$input_normal[4] = array(
    "type" => "text",
    'name'  => 'selected_columns',
    'id'    => 'selected_columns',
    'placeholder' => 'Selected Columns Separated with ONLY ,', // todo lang "Statistics name" to language
    'class' => ''
);
$input_options = array(

);
echo form_open("statistics/add", "class='".$form_class."' id='".$form_id."'");
foreach ($input_normal as $key => $value){
    echo form_input($value);
}
?>


