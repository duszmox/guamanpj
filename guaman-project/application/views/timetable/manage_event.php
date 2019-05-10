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
    'value' => date("Y-m-d") . "T" . date("H:i"),
    'class' => ''
);

$inputs_array[3] = array(
    "type" => "datetime-local",
    'name' => 'event_end',
    'id' => 'event_end',
    'value' => date("Y-m-d") . "T" . date("H:i"),
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

foreach ($event_types as $key2 => $value2) {
    $inputs_options[1][$value2] = $value2;
}


echo form_open("timetable/manage_event", "class='" . $form_class . "' id='" . $form_id . "'");
if (!empty($data)) {
    $possible_data = array("event_title", "event_place", "event_comment", "event_start", "event_end");

    foreach ($inputs_array as $key => $value) {
        foreach ($possible_data as $key2 => $value2) {
            if ($inputs_array[$key]['name'] == "event_start" || $inputs_array[$key]['name'] == "event_end") {
                if ($value2 == "event_start" || $value2 == "event_end") {
                    if (strlen($data[$value2]) == 15) {
                        $data[$value2] = str_replace(" ", "T0", $data[$value2]);
                    } else {
                        $data[$value2] = str_replace(" ", "T", $data[$value2]);
                    }
                    $inputs_array[$key]['value'] = $data[$value2];

                }
            }

            if ($value['name'] == $value2) {

                $inputs_array[$key]['value'] = $data[$value2];

            }
        }
    }
}
foreach ($inputs_array as $key2 => $value2) {

    if ($value2['name'] == "event_place") {

        $var_event_type = (!empty($data)) ? $data['event_type'] : "";
        $var_all_day = (!empty($data)) ? $data['event_type'] : "";

        echo form_dropdown('event_type', $inputs_options[1], $var_event_type, array("class" => "chosen")) . "<br>";
        echo form_dropdown('all_day', $inputs_options[0], $var_all_day) . "<br>";

    }
    echo form_input($value2) . "<br>";

}
echo form_input($input_submit);
