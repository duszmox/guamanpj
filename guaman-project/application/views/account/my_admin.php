<div class="px-4 py-4 bg-white shadow">
    <table>
        <tr>
            <th><?php echo lang("add_admin_label"); ?></th>

            <td>
                <form method="post">
                <select>
                    <?php
                    //todo andrás foreach az összes nevet kiírja és kilehessen változtatni, amikor visszaküldi, akkor meg adjon neki admin jogot, ha már nincs neki
                    echo '<option value=""></option>';
                    foreach ($users as $key => $value) {
                        $active = $key == '0' ? "selected" : "";
                        echo "<option selected='" . $active . "' value=" . $value['username'] . ">" . $value['username'] . "</option>\n";
                    }

                    ?>
                    <input value="OK" name="submit" type="submit">
                </select>
                </form>
            </td>

        </tr>
    </table>
</div>




