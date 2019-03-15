<div class="container">

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link <?php if ($page_active == 'settings') {
                echo "active";
            } ?>"
               href="<?php echo base_url("account/settings") ?>"><?php echo lang("settings_title") ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if ($page_active == 'profile') {
                echo "active";
            } ?>" href="<?php echo base_url("account/profile") ?>"><?php echo lang("profile_title") ?></a>
        </li>
    </ul>
    </a>
    </li>
    </ul>
</div>
