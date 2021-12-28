
    <div class="container container-w98" id="login-container">
        <div class="row">
            <div class="no-padding center-row">
                <div class="card no-border-radius primary-white">
                    <div class="card-body">
                        <div class="row sub-row">
                            <div class="col-3 no-padding hide-on-mobile hide-on-medium-desktop"></div>
                            <div class="col-6 col-6-mobile no-padding medium-desktop-100">
                                <form action="/" method="post" name="login-form" id="login-form" onsubmit="return validateLoginForm();">
                                    <input type="hidden" name="error-message" id="error-message" value="<?php echo isset($login_error) ? 'has-error' : ''; ?>">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="username" class="w-100">Username</label>
                                            <input type="text" class="form-control form-control-sm required <?php echo isset($login_error) ? 'is-invalid' : ''; ?>" name="username" id="username" autocomplete="off" aria-describedby="usernameHelp" value="<?php echo ! empty($request->input('username')) ? $request->input('username') : ''; ?>">
                                            <div class="invalid-feedback <?php echo ! empty($request->input('username')) ? 'hide' : ''; ?>" id="username-error-message">
                                                Username is required.
                                            </div>
                                            <div class="login-error <?php echo ! isset($login_error) ? 'hide' : ''; ?>" id="username-error-message">
                                                <?php echo $login_error; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="password" class="w-100">Password</label>
                                            <input type="password" class="form-control form-control-sm required <?php echo isset($login_error) ? 'is-invalid' : ''; ?>" name="password" id="password" autocomplete="off" aria-describedby="passwordHelp" value="<?php echo ! empty($request->input('password')) ? $request->input('password') : ''; ?>">
                                            <div class="invalid-feedback <?php echo ! empty($request->input('password')) ? 'hide' : ''; ?>" id="password-error-message">
                                                Password is required.
                                            </div>
                                            <div class="login-error <?php echo ! isset($login_error) ? 'hide' : ''; ?>" id="password-error-message">
                                                <?php echo $login_error; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-left submit-button-div">
                                        <div class="form-row">
                                            <div class="col-3"></div> 
                                            <div class="form-group col-md-6">
                                                <input class="btn btn-primary btn-sm mb-2 grey-button" name="login" id="submit-button" type="submit" value="Login">
                                            </div>
                                            <div class="col-3"></div> 
                                        </div>
                                    </div>
                                </form>
                            </div> 
                            <div class="col-3 no-padding hide-on-mobile hide-on-medium-desktop"></div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>