<div class="container bg-white shadow">
    <h2>Statistics</h2> <!--todo lang-->
    <?php
    //todo gyulus gui az adott array alapján $data
    echo "<table class='table'>";
    foreach ($data as $key => $value) {
        echo "<tr>\n";
        foreach ($value as $key2 => $value2) {
            echo "<th class='col'>" . $key2 . " \n";
        }
        echo "</tr>";
        break;
    }
    foreach ($data as $key => $value) {

        echo "<div id='getStatistics" . $value["id"] . "'>\n<tr>\n";
        foreach ($value as $key2 => $value2) {
            echo "<td class='col'>\n" . $value2 . " \n";
        }
        echo "</tr></div>\n";
    }//todo error van
    ?>

</div>
<script>

    <?php

    foreach ($data as $key => $value) {
        echo "$(\"#getStatistics".$value[$id]."\").on(\"click\", function(){
        window.location.href = \"".base_url('statistics/view/'.$value[$id])."\";
    });";
    }
    ?>
</script>