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
    'class' => '',
    'value' => ''
);
$inputs_array[1] = array(
    "type" => "text",
    'name' => 'event_place',
    'id' => 'event_place',
    'placeholder' => lang('event_place'),
    'class' => ''
);

$inputs_options[0] = array(
    "TRUE" => lang('event_true'),
    "FALSE" => lang('event_false'),
);
$inputs_array[2] = array(
    "type" => "datetime-local",
    'name' => 'event_start',
    'id' => 'event_start',
    'value' => date("Y-m-d") . "T" . date("G:i"),
    'class' => ''
);

$inputs_array[3] = array(
    "type" => "datetime-local",
    'name' => 'event_end',
    'id' => 'event_end',
    'value' => date("Y-m-d") . "T" . date("G:i"),
    'class' => ''
);

$inputs_array[4] = array(
    "type" => "text",
    'name' => 'event_comment',
    'id' => 'event_comment',
    'placeholder' => lang('event_comment'),
    'class' => ''
);

$inputs_options[1] = array();
$submit_placeholder = (!empty($data)) ? lang("event_edit") : lang("event_add");
$input_submit = array(
    "type" => "submit",
    'name' => 'submit_add',
    'id' => 'submit_add',
    'value' => $submit_placeholder,
    'class' => ''
);
//------------------------

foreach ($event_types as $key => $value) {
    $inputs_options[1][$value] = $value;
}


echo form_open("timetable/manage_event", "class='" . $form_class . "' id='" . $form_id . "'");
if (!empty($data)) {
    $possible_data = array("event_title", "event_place", "event_start", "event_start", "event_end");

    foreach ($inputs_array as $key2 => $value2) {
        foreach ($possible_data as $key => $value) {
            if ($value2['name'] == "event_start" || $value2['name'] == "event_end") {
                continue;
            }
            if($inputs_array[$key]['name'] == "event_start" || $inputs_array[$key2]['name'] == "event_end"){
                $data[$value] = str_replace(" ", "T", $data[$value]);
                $inputs_array[$key2]['value'] = "asd";
            }
            echo $data[$value]."<br>";
            if ($value2['name'] == $value) {

                $inputs_array[$key2]['value'] = $data[$value];
                echo $data[$value]."<br>";
                echo $inputs_array[$key2]['value'];

            }
        }
    }
}
foreach ($inputs_array as $key => $value) {

    if ($value['name'] == "event_place") {

        $var_event_type = (!empty($data))?$data['event_type']:"";
        $var_all_day = (!empty($data))?$data['event_type']:"";

        echo form_dropdown('event_type', $inputs_options[1], $var_event_type, array("class" => "chosen")) . "<br>";
        echo form_dropdown('all_day', $inputs_options[0], $var_all_day) . "<br>";

    }
    echo form_input($value) . "<br>";

}
echo form_input($input_submit);
?>

