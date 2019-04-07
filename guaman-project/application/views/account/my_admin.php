<div class="px-4 py-4 bg-white shadow">
    <table>
        <tr>
            <th><?php echo lang("add_admin_label"); ?></th>

            <td>
                <form method="post">
                    <select name="username">
                        <?php

                        foreach ($users_not_admin as $key => $value) {

                            $active = $key == '0' ? "selected" : "";
                            echo "<option selected='" . $active . "' value=" . $value . ">" . $value . "</option>\n";
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

                        foreach ($users_admin as $key => $value) {
                            $active = $key == '0' ? "selected" : "";
                            echo "<option selected='" . $active . "' value=" . $value . ">" . $value. "</option>\n";
                        }

                        ?>
                        <input value="OK" name="submit_remove" type="submit">
                    </select>
                </form>
            </td>

        </tr>
        <tr>
            <td>
                <a href="<?php echo base_url("account/give_permissions")?>"><?php echo lang("give_permissions_title")?> <i class="fas fa-external-link-alt"></i></a>
            </td>
        </tr>
    </table>
</div>




