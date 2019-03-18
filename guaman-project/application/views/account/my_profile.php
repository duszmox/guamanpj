<?php
/**
 * Created by PhpStorm.
 * User: horva
 * Date: 2019.03.14.
 * Time: 20:00
 *
 * @var $username               string
 * @var $user_id                int
 * @var $rank                   int
 * @var $email                  string
 * @var $phone_number           string
 * @var $is_phone_number_public boolean
 */
?>
<div class="px-4 py-4 bg-white shadow">
	<table>
		<tr>
			<th><?php echo lang("username_label") ?></th>
			<td><?php echo $username; ?></td>
		</tr>
		<tr>
			<th><?php echo lang("email_label") ?></th>
			<td><?php echo $email; ?></td>
			<!--td><?php echo lang("public"); ?> <input type="checkbox" checked disabled></td-->
		</tr>
		<tr>
			<th><?php echo lang("rank_label") ?></th>
			<td><?php echo Statuses::get_nice_name($rank); ?></td>
		</tr>
		<tr>
			<th><?php echo lang("password_label") ?></th>
			<td>******** <a
					href="<?php echo base_url("account/change_password"); ?>"><?php echo lang("change_password_button"); ?>
					<i class="fas fa-external-link-alt"></i></a></td>
		</tr>
		<!--tr>
            <th><?php echo lang("phone_number_label"); ?></th>
            <td><?php echo $phone_number; ?></td>
            <td><?php echo lang("public"); ?><input
                        type="checkbox" <?php echo($is_phone_number_public ? "checked" : "") ?>>
            </td>
        </tr-->


	</table>
</div>
</div>
