<div class="container">
	<h2><?php echo lang("change_password_title"); ?></h2>

	<form class="form-horizontal">
		<fieldset>
			<!-- Password input-->
			<div class="form-group row">
				<label class="col-md-2 control-label"
				       for="currentPassword"><?php echo lang("current_password_label") ?></label>
				<div class="col-md-4">
					<input id="currentPassword" name="current_password" type="password"
					       class="form-control input-md">
				</div>
			</div>

			<!-- Password input-->
			<div class="form-group row">
				<label class="col-md-2 control-label"
				       for="newPassword"><?php echo lang("new_password_label") ?>
				</label>
				<div class="col-md-4">
					<input id="newPassword" name="new_password" type="password"
					       class="form-control input-md">
				</div>
			</div>

			<!-- Password input-->
			<div class="form-group row">
				<label class="col-md-2 control-label"
				       for="newPasswordAgain"><?php echo lang("again_password_label") ?>
				</label>
				<div class="col-md-4">
					<input id="newPasswordAgain" name="new_password_again" type="password"
					       class="form-control input-md">
				</div>
			</div>

			<!-- Button -->
			<div class="form-group row">
				<label class="col-md-2 control-label" for="submitButton"></label>
				<div class="col-md-4">
					<button id="submitButton" name="submitButton" type="submit"
					        class="btn btn-primary"><?php echo lang("submit_change_password_button"); ?></button>
				</div>
			</div>

		</fieldset>
	</form>

</div>


