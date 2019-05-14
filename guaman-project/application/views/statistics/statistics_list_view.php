<div class="container bg-white shadow">
    <h2 class="statistics-h2">
        <p style="display: inline-block"><?php echo lang("statistics_label") ?></p>
    </h2>
        <?php
        if (has_permission("admin")) {
            echo "<a class='adds_statistics btn btn-primary float-right' href='" . base_url("statistics/add") . "'> " . lang("add_statistics") . " </a>";

            }
        ?>

    <?php
    echo "<div class='statistics-div'><table class='table'>";
    foreach ($data as $key => $value) {
        echo "<thead class='statistics-table'><tr>\n";
        foreach ($value as $key2 => $value2) {
            echo "<th class='col'>" . $key2 . " </th>\n";
        }
        echo "</tr></thead><tbody >";
        break;
    }
    foreach ($data as $key => $value) {

        echo "\n<tr class='' id='getStatistics" . $value["id"] .  "'>
        \n";
        foreach ($value as $key2 => $value2) {
            echo "<td class='col'>" . $value2 . " </td>\n";
        }
        echo "</tr>\n";
    }
    echo "</tbody></table></div>";
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
            background-color:#F5F5F5	;
            
        }";
    }
    ?>
</style>