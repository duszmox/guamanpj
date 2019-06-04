<link rel="stylesheet" type="text/css" href="<?php echo css_url("table.css");?>">
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
    'placeholder' => lang('statistics_name'),
    'class' => 'rounded-2 '
);
$input_normal[1] = array(
    "type" => "number",
    'name'  => 'statistics_type',
    'id'    => 'statistics_type',
    'placeholder' => lang('statistics_type_id'),
    'class' => 'rounded-2'
);
$input_normal[2] = array(
    "type" => "number",
    'name'  => 'source_table',
    'id'    => 'source_table',
    'placeholder' => lang('source_table_id'),
    'class' => 'rounded-2'
);
$input_normal[3] = array(
    "type" => "text",
    'name'  => 'selected_columns',
    'id'    => 'selected_columns',
    'placeholder' => lang('selected_columns_only'),
    'class' => 'rounded-2'
);
$input_normal[4] = array(
    "type" => "text",
    'name'  => 'order_by',
    'id'    => 'order_by',
    'placeholder' => lang('columns_order_by'),
    'class' => 'rounded-2'
);
$input_normal[6] = array(
    "type" => "text",
    'name'  => 'statistics_config',
    'id'    => 'statistics_config',
    'placeholder' => lang('statistics_config_json'),
    'class' => 'rounded-2'
);
$input_submit = array(
    "type" => "submit",
    'name'  => 'submit',
    'id'    => 'submit',
    'value' => "+" .  lang('event_add'),
    'class' => 'btn btn-primary add-ok'
);

$input_options = array(
    "ASC" => "ASC",
    "DESC" => "DESC",
);

echo form_open("statistics/add", "class='".$form_class."' id='".$form_id."'");
echo "<div class='card statistics-add-card container'>";
echo "<div class='card-body'>";
echo "<h2 class='add-statistics-h2'>" . lang('statistics_add') . "</h2>";
foreach ($input_normal as $key => $value){

    echo form_input($value) . "<br>";
}
echo form_dropdown('order', $input_options, 'ASC', array("class" => "list rounded-2-list"))."<br>";

echo form_input($input_submit);
echo "</div>";
echo "</div>";
echo "<form>";
?>


