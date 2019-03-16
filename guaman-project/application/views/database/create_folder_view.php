<form method="post">
    <h2><?php echo lang("create_folder_title"); ?></h2>
    <?php echo lang("folder_name_title"); ?>
    <input type="text" name="folder_name">
    <?php echo lang("folder_destination_title"); ?>
    <select name="parent_folder">
        <?php
        foreach ($folder_array as $key => $folder) {
            echo "<option value='".$folder['parent_folder']."'>".$folder['folder_title']."</option>";
        }
        ?>
    </select>
    <input type="submit" value="OK">
</form>
