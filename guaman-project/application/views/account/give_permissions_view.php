
<div class="px-4 py-4 bg-white shadow">
    <table>
        <form method="post">

            <?php
            echo lang('username_label');
            echo "<select name='username'>";
                foreach($users as $key => $value){
                    $selected = ($value['username'] == $active_user)? "selected" :"";
                    echo "<option ".$selected." value='".$value['username']."'>".$value['username']."</option>>";
                }
             echo "</select>";

            ?>
            <input type="submit"  value="OK">

                <br><input type="submit" name="submit_permissions" value="OK">
                <?php
                if(isset($permission_name) && isset($permission_nice_name) && isset($user_permission)) {
                    foreach ($permission_name as $key => $value) {
                        echo "<tr><td><input class=\"form-check-input\" id='" . $value['permission_name'] . "' name='" . $value['permission_name'] . "' value='" . $value['permission_name'] . "' type='checkbox' ";
                        foreach ($user_permission as $key_user => $value_user) {
                            if ($value_user['permission_name'] == $value['permission_name']) {
                                echo "checked";
                            }
                        }

                        echo "> <label class=\"form-check-label\" for='" . $value['permission_name'] . "'>" . $permission_nice_name[$key]['permission_nice_name'] . "</label></td></tr>\n";
                    }
                }
                ?>
            <input class="invisble" name="done" value="<?php echo $active_user;?>">

        </form>
    </table>
</div>
</div>
