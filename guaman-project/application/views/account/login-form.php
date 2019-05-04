<div class="container">

	<!-- Outer Row -->
	<div class="row justify-content-center">

		<div class="col-xl-10 col-lg-12 col-md-9">

			<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="card-body p-0">
					<!-- Nested Row within Card Body -->
					<div class="row">
						<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
						<div class="col-lg-6">
							<div class="p-5">
								<div class="text-center">
									<h1 class="h4 text-gray-900 mb-4"><?php echo lang("login_message"); ?></h1>
								</div>
								<form class="user" method="post">
									<div class="form-group">
										<input type="text" class="form-control form-control-user" id="exampleInputEmail"
										       name="username" aria-describedby="emailHelp"
										       placeholder="<?php echo lang("username_placeholder"); ?>">
									</div>
									<div class="form-group">
										<input type="password" class="form-control form-control-user"
										       id="exampleInputPassword" name="password"
										       placeholder="<?php echo lang("password_placeholder"); ?>">
									</div>
                                    <input type="hidden" name="url" value="<?php /** @var $url $url */
                                    echo $url?>">

									<input type="submit" class="btn btn-primary btn-user btn-block"
									       value="<?php echo lang("send_login_message") ?>">


								</form>
								<hr>

								<div class="text-center">
									<?php
									if ($this->config->item("allow_registration")) {
										echo "<a href=\"" . base_url("account/register") . "\">" . lang("create_account_message") . " </a>";
									}
									?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>

</div>
