<div class="px-4 py-4 bg-white shadow">
    <table>
        <tr>
            <th><?php echo lang("add_admin_label"); ?></th>

            <td>
                <form method="post">
                    <select name="username">
                        <?php

                        foreach ($users as $key => $value) {
                            $active = $key == '0' ? "selected" : "";
                            echo "<option selected='" . $active . "' value=" . $value['username'] . ">" . $value['username'] . "</option>\n";
                        }

                        ?>
                        <input value="OK" name="submit_add" type="submit">
                    </select>
                </form>
            </td>

        </tr>
        <tr>
            <th><?php echo lang("remove_admin_label"); ?></th>

            <td>
                <form method="post">
                    <select name="username">
                        <?php

                        foreach ($users as $key => $value) {
                            $active = $key == '0' ? "selected" : "";
                            echo "<option selected='" . $active . "' value=" . $value['username'] . ">" . $value['username'] . "</option>\n";
                        }

                        ?>
                        <input value="OK" name="submit_remove" type="submit">
                    </select>
                </form>
            </td>

        </tr>
    </table>
</div>




