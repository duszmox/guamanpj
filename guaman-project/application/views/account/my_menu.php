<div class="container">
   <ul class="nav nav-tabs">
        <li <?php if ($page_active == "settings") echo "class='active'"; ?>><a data-toggle="tab"
                                                                               href="#settings"><?php echo lang("settings_title") ?></a>
        </li>
        <li><a data-toggle="tab" href="#profile"><?php echo lang("profile_title") ?></a></li>
    </ul>

    <div class="tab-content">
        <div id="settings" class="tab-pane fade in <?php if ($page_active == "settings") echo "active"; ?>">


        </div>
        <div id="profile" class="tab-pane fade">


        </div>
    </div>


    <?php
    //todo Gyuszinak kell itt megscsinálnia a tabrendszert
    ?>
</div>
