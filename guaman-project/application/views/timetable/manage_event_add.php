<link rel="stylesheet" type="text/css" href="<?php echo css_url("table.css"); ?>">

<?php
//inputs variables
$form_class = "";
$form_id = "";

$inputs_array = array();
$inputs_array[0] = array(
    "type" => "text",
    'name' => 'event_title',
    'id' => 'event_title',
    'placeholder' => lang('event_title'),
    'class' => 'rounded-2 event-title',
    'value' => ''
);
$inputs_array[1] = array(
    "type" => "text",
    'name' => 'event_place',
    'id' => 'event_place',
    'placeholder' => lang('event_place'),
    'class' => 'rounded-2-date',
    "list" => "event_place_list"
);

$inputs_options[0] = array(
    "TRUE" => lang('event_true'),
    "FALSE" => lang('event_false'),
);

$inputs_options[1] = array(array());
$inputs_array[2] = array(
    "type" => "datetime-local",
    'name' => 'event_start',
    'id' => 'event_start',
    'value' => date("Y-m-d") . "T" . date("H:i"),
    'class' => 'rounded-2-date',
    'placeholder' => lang('event_start')
);

$inputs_array[3] = array(
    "type" => "datetime-local",
    'name' => 'event_end',
    'id' => 'event_end',
    'value' => date("Y-m-d") . "T" . date("H:i"),
    'class' => 'rounded-2-date',
    'placeholder' => lang('event_end')
);

$inputs_array[4] = array(
    "type" => "text",
    'name' => 'event_comment',
    'id' => 'event_comment',
    'placeholder' => lang('event_comment'),
    'class' => 'rounded-2'
);

$submit_value = (!empty($data)) ? lang("event_edit") : lang("event_add");
$submit_name = (!empty($data)) ? "submit_edit" : "submit_add";
$input_submit = array(
    "type" => "submit",
    'name' => "submit_button",
    'id' => "submit_button",
    'value' => $submit_value,
    'class' => 'btn btn-primary'
);
//------------------------
foreach ($event_types as $key => $value) {

    $inputs_options[1][$value['nice_name']] = $value['nice_name'];

}
echo "<datalist id='event_place_list'>";
foreach ($event_places as $key => $value) {
    echo "<option value='" . $value . "'>";
}
echo "</datalist>";
echo "<div class='card statistics-add-card container'>";
echo "<div class='card-body'>";
echo "<h2 class='h2-title-manage'>" . lang('manage_event_title') . "</h2>";
echo form_open("timetable/manage_event_upload_add", "class='" . $form_class . "' id='" . $form_id . "'");


foreach ($inputs_array as $key2 => $value2) {

    if ($value2['name'] == "event_place") {

        $var_all_day = (!empty($data)) ? $data['event_type'] : "";

        echo lang('all_day_label') . form_dropdown('all_day', $inputs_options[0], $var_all_day, array("class" => "rounded-2-date")) . "<br>";

        echo lang('event_type_label').form_dropdown('event_type', $inputs_options[1], "", array("class" => "rounded-2-date")) . "<br>";

    }
    echo $value2['placeholder'] . form_input($value2) . "<br>";

}
echo form_input($input_submit);
echo form_close();
echo "</div>";
echo "</div>";

