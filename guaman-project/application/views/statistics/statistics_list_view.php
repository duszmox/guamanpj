<div class="container bg-white shadow">
    <h2>
        <?php echo lang("statistics_title") ?>
        <?php
        if (has_permission("admin")) {
            echo "<button class='adds_statistics btn btn-primary float-right' href='" . base_url("statistics/add") . "'> " . lang("add_statistics") . " </button>";

            }
        ?>
    </h2>
    <?php
    // todo gyulus gui az adott array alapján $data
    echo "<table class='table'>";
    foreach ($data as $key => $value) {
        echo "<thead><tr>\n";
        foreach ($value as $key2 => $value2) {
            echo "<th class='col'>" . $key2 . " </th>\n";
        }
        echo "</tr></thead>";
        break;
    }
    foreach ($data as $key => $value) {

        echo "\n<tr  id='getStatistics" . $value["id"] . "'>\n";
        foreach ($value as $key2 => $value2) {
            echo "<td class='col'>" . $value2 . " </td>\n";
        }
        echo "</tr>\n";
    }//todo error van
    echo "</tbody></table>";
    ?>

</div>
<script>

    <?php

    foreach ($data as $key => $value) {
        echo "$(\"#getStatistics" . $value["id"] . "\").on(\"click\", function(){
        window.location.href = \"" . base_url('statistics/view/' . $value["id"]) . "\";
    });";
    }
    ?>
</script>
<style>


    <?php

    foreach ($data as $key => $value) {
        echo "#getStatistics".$value["id"].":hover{
            background-color:#F8F8F8;
        }";
    }
    ?>
</style>