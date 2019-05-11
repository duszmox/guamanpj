<link rel="stylesheet" type="text/css" href="<?php echo css_url("table.css");?>">

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

$inputs_array[2] = array(
    "type" => "text",
    'name' => 'event_type',
    'id' => 'event_type',
    'placeholder' => "Event type", //todo lang
    'class' => 'rounded-2-date',
    "list" => "event_type_list"
);
$inputs_array[3] = array(
    "type" => "datetime-local",
    'name' => 'event_start',
    'id' => 'event_start',
    'value' => date("Y-m-d") . "T" . date("H:i"),
    'class' => 'rounded-2-date'
);

$inputs_array[4] = array(
    "type" => "datetime-local",
    'name' => 'event_end',
    'id' => 'event_end',
    'value' => date("Y-m-d") . "T" . date("H:i"),
    'class' => 'rounded-2-date'
);

$inputs_array[5] = array(
    "type" => "text",
    'name' => 'event_comment',
    'id' => 'event_comment',
    'placeholder' => lang('event_comment'),
    'class' => 'rounded-2'
);

$submit_placeholder = (!empty($data)) ? lang("event_edit") : lang("event_add");
$submit_name = (!empty($data)) ? "submit_edit" : "submit_add";
$input_submit = array(
    "type" => "submit",
    'name' => $submit_name,
    'id' => $submit_name,
    'value' => $submit_placeholder,
    'class' => 'btn btn-primary'
);
//------------------------
echo "<datalist id='event_type_list'>";
foreach ($event_types as $key2 => $value2) {
    echo "<option value='".$value2."'>";
}
echo "</datalist>";
echo "<datalist id='event_place_list'>";
foreach ($event_places as $key2 => $value2) {
    echo "<option value='".$value2."'>";
}
echo "</datalist>";
echo "<div class='card statistics-add-card container'>";
echo "<div class='card-body'>";
echo "<h2 class='h2-title-manage'>" . lang('manage_event_title') . "</h2>";
echo form_open("timetable/manage_event", "class='" . $form_class . "' id='" . $form_id . "'");

if (!empty($data)) {
    $possible_data = array("event_title", "event_place", "event_comment", "event_start", "event_end", "event_type");

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

        echo form_dropdown('all_day', $inputs_options[0], $var_all_day, array("class" => "rounded-2-date")) . "<br>";

    }
    echo form_input($value2) . "<br>";

}
echo form_input($input_submit);
echo "</div>";
echo "</div>";
