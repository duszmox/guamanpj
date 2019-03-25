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

        <li class="nav-item <?php if(!has_permission( "admin")){ echo "invisible";}?>">
            <a class="nav-link <?php if ($page_active == 'admin') {
                echo "active";
            } ?>" href="<?php echo base_url("account/admin") ?>"><?php echo lang("admin_title") ?></a>
        </li>
	</ul>
