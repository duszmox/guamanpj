<form method="post">
    <h2><?php echo lang("create_table_title"); ?></h2>
    <h2><?php echo lang("create_table_name_title"); ?></h2>
    <input type="text" name="table_name" value="<?php echo $table_name; ?>" placeholder="TABLE NAME">
    <input type="number" name="current_input" value="<?php echo $current_input; ?>" placeholder="ROW NUMBER">
    <?php
    for ($i = 0; $i < $current_input; $i++) {

        echo "<br>OSZLOP: <input type=\"text\" name=\"table_row_" . $i . "\" value=\"" . $table_row[$i] . "\" placeholder=\"ROW NAME\"> 
    ";

        echo "<br>";
    }
    ?>
    <input type="submit" name="submit_name" value="OK"">
    <?php
    if ($submit_name) {
        echo "<br>PARENT FOLDER: <input type=\"text\" name=\"parent_folder\" value=\"\" placeholder=\"PARENT FOLDER\"><br>";
        echo "<input type=\"submit\" name=\"save\" value=\"MENTÉS\"\">
    ";
    }
    ?>
</form>