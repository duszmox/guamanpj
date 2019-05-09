<?php
//inputs
$form_class = "";
$form_id = "";

$inputs_array = array();
$inputs_array[0] = array(
    "type" => "text",
    'name' => 'event_title',
    'id' => 'event_title',
    'placeholder' => lang('event_title'),
    'class' => ''
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
    'value' => date("Y-m-d")."T".date("G:i"),
    'class' => ''
);
$inputs_array[3] = array(
    "type" => "datetime-local",
    'name' => 'event_end',
    'id' => 'event_end',
    'value' => date("Y-m-d")."T".date("G:i"),
    'class' => ''
);
$inputs_array[4] = array(
    "type" => "text",
    'name' => 'event_comment',
    'id' => 'event_comment',
    'placeholder' => lang('event_comment'),
    'class' => ''
);

$inputs_options[1] = array(
);
foreach($event_types as $key => $value){
    $inputs_options[1][$value] = $value;
}
$input_submit = array(
    "type" => "submit",
    'name'  => 'submit_add',
    'id'    => 'submit_add',
    'value' => lang('event_add'),
    'class' => ''
);



if (empty($data)) {
    echo "I'm adder";


} else {
    echo "I'm editor of " . $data['event_title'];

    foreach($inputs_array as $key => $value){
        if($value['name'] == "event_title"){
            $value['placeholder'] = $data['event_title'];
            echo "asd";

        }
    }
}



echo form_open("timetable/manage_event", "class='" . $form_class . "' id='" . $form_id . "'");

echo "<div>";

foreach ($inputs_array as $key => $value) {
    if($value['name'] == "event_start"){
        echo lang("event_start");
    }
    if($value['name'] == "event_end"){
        echo lang("event_end");
    }
    if($value['name'] == "event_title"){
        echo lang("event_title");
    }

    //normal
    echo form_input($value) . "<br>";


    if($value['name'] == "event_place"){
        $var = (isset($data['all_day']))?$data['all_day']:"";
        echo form_dropdown('all_day', $inputs_options[0], $var)."<br>";
        //todo doesnt work, make it okay (searchbar-autocomplete)
        $var = (isset($data['event_type']))?$data['event_type']:"";
        echo form_dropdown('event_type', $inputs_options[1], $var, array("class" => "chosen"))."<br>";
    }
}



echo form_input($input_submit);


?>
