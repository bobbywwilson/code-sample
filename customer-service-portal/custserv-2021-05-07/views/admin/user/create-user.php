
    <div class="container container-w98" id="contract-details">
        <div class="row row-w80" id="back-results">
            <div class="col-3 no-padding respond-50">
                <a href="#">
                    <input class="btn btn-primary btn-sm mb-2 grey-button back-button small-button" id="back-button" type="submit" value="Back">
                </a>
            </div>
            <div class="col-6 no-padding padding-right respond-50">
                <h4 class="text-center text-uppercase hide-on-mobile inline-text"></h4>
            </div>
            <div class="col-3 no-padding hide-on-mobile"></div>
        </div>

        <form action="/admin/user/create-user/" method="post" name="create-user-form" id="create-user-form" onsubmit="return validateCreateUserForm();">
            <div class="row row-w80">
                <div class="col-12 no-padding">
                    <div class="card no-border-radius primary-white no-padding-mobile card-mb-mobile">
                        <div class="card-body table-responsive">
                            <h4 class="card-title text-uppercase hide-on-mobile">Create User</h4>
                            <div class="col-12 no-padding">
                                <table class="table table-sm">
                                    <thead class="navbar-light bg-light hide-on-mobile">
                                        <tr>
                                            <th scope="col" class="current-amount">
                                                <?php if (isset($user["errors"])) : ?>
                                                    <?php for ($i = 0; $i < count($user["errors"]); $i++) : ?>
                                                        <span>
                                                            <p class="error-text"><?php echo $user["errors"][$i]; ?></p>
                                                        </span>
                                                    <?php endfor; ?>
                                                <?php elseif (isset($user["success"])) : ?>
                                                    <?php $message = []; ?>
                                                    <?php for ($i = 0; $i < count($user["success"]); $i++) : ?>
                                                        <span>
                                                            <p class="success-text"><?php echo $user["success"][$i]; ?></p>
                                                        </span>
                                                    <?php endfor; ?>
                                                <?php else : ?>
                                                    <span class="invisible">Form</span>
                                                <?php endif; ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="padding-top-only no-border">
                                                <fieldset class="form-group">
                                                    <legend class="fieldset-legend">User Details</legend>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="role">Role</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend prepend-lg hide-on-mobile">
                                                                    <span class="input-group-text" for="role">Options</span>
                                                                </div>
                                                                <select class="custom-select custom-select-sm custom-select-sm select-lg" name="role" id="role">
                                                                    <option selected>Select One</option>
                                                                    <option value="1">Customer</option>
                                                                    <option value="2">Dealer</option>
                                                                    <option value="3">Admin</option>
                                                                    <option value="4">Super Admin</option>    
                                                                </select>
                                                                <div class="invalid-feedback" id="role-error-message"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="username">Username</label>
                                                            <input type="text" class="form-control form-control-sm required" name="username" id="username" aria-describedby="usernameHelp" value="<?php echo isset($message['username']) ? htmlspecialchars($message['username'], ENT_QUOTES, 'UTF-8') : ''; ?>" autocomplete="off">
                                                            <div class="invalid-feedback" id="username-error-message"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="first-name">First Name</label>
                                                            <input type="text" class="form-control form-control-sm required" name="first-name" id="first-name" aria-describedby="firstNameHelp" value="<?php echo isset($message['first-name']) ? htmlspecialchars($message['first-name'], ENT_QUOTES, 'UTF-8') : ''; ?>" autocomplete="off">
                                                            <div class="invalid-feedback" id="first-name-error-message"></div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="last-name">Last Name</label>
                                                            <input type="text" class="form-control form-control-sm required" name="last-name" id="last-name" aria-describedby="lastNameHelp" value="<?php echo isset($message['last-name']) ? htmlspecialchars($message['last-name'], ENT_QUOTES, 'UTF-8') : ''; ?>" autocomplete="off">
                                                            <div class="invalid-feedback" id="last-name-error-message"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="email">Email Address</label>
                                                            <input type="text" class="form-control form-control-sm required" name="email" id="email" aria-describedby="emailHelp" value="<?php echo isset($message['email']) ? htmlspecialchars($message['email'], ENT_QUOTES, 'UTF-8') : ''; ?>" autocomplete="off">
                                                            <div class="invalid-feedback" id="email-error-message"></div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="confirm-email">Confirm Email Address</label>
                                                            <input type="text" class="form-control form-control-sm required" name="confirm-email" id="confirm-email" aria-describedby="confirmEmailHelp" value="<?php echo isset($message['confirm-email']) ? htmlspecialchars($message['confirm-email'], ENT_QUOTES, 'UTF-8') : ''; ?>" autocomplete="off">
                                                            <div class="invalid-feedback" id="confirm-email-error-message"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="password">Password</label>
                                                            <input type="password" class="form-control form-control-sm required" name="password" id="password" aria-describedby="passwordHelp" value="<?php echo isset($message['password']) ? htmlspecialchars($message['password'], ENT_QUOTES, 'UTF-8') : ''; ?>" autocomplete="off">
                                                            <div class="invalid-feedback" id="password-error-message"></div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="confirm-password">Confirm Password</label>
                                                            <input type="password" class="form-control form-control-sm required" name="confirm-password" id="confirm-password" aria-describedby="confirmPasswordHelp" value="<?php echo isset($message['confirm-password']) ? htmlspecialchars($message['confirm-password'], ENT_QUOTES, 'UTF-8') : ''; ?>" autocomplete="off">
                                                            <div class="invalid-feedback" id="confirm-password-error-message"></div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card no-border-radius primary-white no-margin-bottom no-padding-mobile">
                        <div class="card-body table-responsive">
                            <div class="col-12 no-padding">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="padding-top-only no-border">
                                                <fieldset class="form-group">
                                                    <legend class="fieldset-legend">Company Details</legend>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="company-name">Company Name</label>
                                                            <input type="text" class="form-control form-control-sm required" name="company-name" id="company-name" aria-describedby="companyNameHelp" value="<?php echo isset($message['company-name']) ? htmlspecialchars($message['company-name'], ENT_QUOTES, 'UTF-8') : ''; ?>" autocomplete="off">
                                                            <div class="invalid-feedback" id="company-name-error-message"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="company-contact">Contact Name</label>
                                                            <input type="text" class="form-control form-control-sm required" name="company-contact" id="company-contact" aria-describedby="companyContactHelp" value="<?php echo isset($message['company-contact']) ? htmlspecialchars($message['company-contact'], ENT_QUOTES, 'UTF-8') : ''; ?>" autocomplete="off">
                                                            <div class="invalid-feedback" id="company-contact-error-message"></div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="contact-phone">Contact Phone</label>
                                                            <input type="text" class="form-control form-control-sm required" name="contact-phone" id="contact-phone" aria-describedby="contactPhoneHelp" value="<?php echo isset($message['contact-phone']) ? htmlspecialchars($message['contact-phone'], ENT_QUOTES, 'UTF-8') : ''; ?>" autocomplete="off">
                                                            <div class="invalid-feedback" id="contact-phone-error-message"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="contact-email">Contact Email Address</label>
                                                            <input type="text" class="form-control form-control-sm required" name="contact-email" id="contact-email" aria-describedby="contactEmailHelp" value="<?php echo isset($message['contact-email']) ? htmlspecialchars($message['contact-email'], ENT_QUOTES, 'UTF-8') : ''; ?>" autocomplete="off">
                                                            <div class="invalid-feedback" id="contact-email-error-message"></div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="confirm-contact-email">Confirm Contact Email Address</label>
                                                            <input type="text" class="form-control form-control-sm required" name="confirm-contact-email" id="confirm-contact-email" aria-describedby="confirmContactEmailHelp" value="<?php echo isset($message['confirm-contact-email']) ? htmlspecialchars($message['confirm-contact-email'], ENT_QUOTES, 'UTF-8') : ''; ?>" autocomplete="off">
                                                            <div class="invalid-feedback" id="confirm-contact-email-error-message"></div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-w80">
                <div class="col-12 no-padding respond-50">
                    <a href="#">
                        <input class="btn btn-primary btn-sm mb-2 grey-button edit-button small-button" name="create-user" id="submit-button" type="submit" value="Submit">
                    </a>
                </div>
            </div>
        </form>
    </div>