<form class="container" method="post">
    <h2><?php echo lang("move_row_title");?></h2>

    <p>Forrás tábla: <?php /** @var string $from_table_title */ echo $from_table_title; ?></p>
    <label><?php /** @var int $id */ echo $id; echo ". ".lang("move_row_full_label");?></label>

    <select name="to_table" class="form-control d-inline-block" style="width: auto">
        <?php

        /** @var array $compatible_tables */
        foreach ($compatible_tables as $key => $compatible_table) {
            echo "<option value='$key'>" . htmlspecialchars($compatible_table, ENT_QUOTES) . "</option>";
        }

        ?>
    </select>
    <input value="<?php echo lang("move_row_title");?>" type="submit" class="btn btn-primary mt-2 d-block">

</form>