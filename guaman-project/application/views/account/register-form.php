<body class="bg-gradient-primary">

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><?php echo lang("create_account_message")?></h1>
                        </div>
                        <form class="user" method="post">
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="nice_username" id="exampleFirstName" placeholder="<?php echo lang("nice_username_placeholder");?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="username" id="exampleFirstName" placeholder="<?php echo lang("username_placeholder");?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" name="email" id="exampleInputEmail" placeholder="<?php echo lang("email_placeholder");?>">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" name="password" id="exampleInputPassword" placeholder="<?php echo lang("password_placeholder");?>">
                                </div>

                            </div>
                            <input value="<?php echo lang("send_registration_message")?>" type="submit" class="btn btn-primary btn-user btn-block">




                        </form>
                        <hr>

                        <div class="text-center">
                            <a class="small" href="<?php echo base_url("account/login")?>"><?php echo lang("already_have_an_account_message")?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
