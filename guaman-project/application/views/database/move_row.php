<form class="container" method="post">
    <h2>Áthelyezés</h2>    <!-- TODO language fájlba átrakni -->

    <p>Forrás tábla: <?php /** @var string $from_table_title */ echo $from_table_title; ?></p>
    <label><?php /** @var int $id */ echo $id; ?>. sor áthelyezése ebbe a táblába:</label>    <!-- TODO language fájlba átrakni -->

    <select name="to_table" class="form-control d-inline-block" style="width: auto">
        <?php

        /** @var array $compatible_tables */
        foreach ($compatible_tables as $key => $compatible_table) {
            echo "<option value='$key'>" . htmlspecialchars($compatible_table, ENT_QUOTES) . "</option>";
        }

        ?>
    </select>
    <input value="Áthelyezés" type="submit" class="btn btn-primary mt-2 d-block">
    <!-- TODO language fájlba átrakni -->
</form>