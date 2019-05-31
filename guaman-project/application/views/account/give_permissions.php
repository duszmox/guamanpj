<div class="bg-white m-4 p-4 shadow">
    <h2><?php echo lang("manage_permissions") ?></h2>
    <label>
        Felhasználó:
        <select name="username" id="select-user" class="form-control w-auto d-inline-block selectpicker"
                data-live-search="true">
            <option disabled hidden selected value="">...</option>
            <?php /** @var array $users */
            foreach ($users as $user) { ?>
                <option value="<?php echo $user["id"]; ?>"><?php echo $user["nice_username"];
                    ?></option>
            <?php } ?>
        </select>
    </label>
    <form id="edit-permissions-form">
        <div id="permissions-container">

        </div>
    </form>
</div>
<script>
    base_url = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo js_url("edit_permissions.js"); ?>"></script>
