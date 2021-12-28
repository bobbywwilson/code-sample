
    <div class="container container-w98" id="contract-details">
        <div class="row row-w80" id="back-results">
            <div class="col-3 no-padding respond-50">
                <a href="#">
                    <input class="btn btn-primary btn-sm mb-2 grey-button back-button" id="submit-button" type="submit" value="Back to Results">
                </a>
            </div>
            <div class="col-3 no-padding hide-on-mobile"></div>
        </div>

        <div class="row row-w80 button-margin">
            <div class="col-12 no-padding" id="user-details">
                <div class="card no-border-radius primary-white">
                    <h4 class="card-title text-uppercase">User Details</h4>
                    <form action="/admin/user/user-details/" method="post" name="view-user-form" id="view-user-form">
                        <input type="hidden" name="view-id" id="view-id" value="">
                    </form>
                    <form action="/admin/user/delete-user/" method="post" name="delete-user-form" id="delete-user-form">
                        <input type="hidden" name="delete-id" id="delete-id" value="">
                    </form>
                    <div class="card-body table-responsive">
                        <table class="table table-sm table-responsive table-responsive-width">
                            <thead class="navbar-light bg-light">
                                <tr>
                                    <th scope="col" class="user-name">Name</th>
                                    <th scope="col" class="user-username">Username</th>
                                    <th scope="col" class="user-role">Role</th>
                                    <th scope="col" class="user-email">Email</th>
                                    <th scope="col" class="user-login">Last Login</th>
                                    <th scope="col" colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo htmlspecialchars($user[0]['first_name'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($user[0]['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user[0]['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user[0]['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo ucwords(htmlspecialchars($user[0]['role'], ENT_QUOTES, 'UTF-8')); ?></td>
                                    <td><?php echo date("F j, Y", strtotime(htmlspecialchars($user[0]['last_login'], ENT_QUOTES, 'UTF-8'))); ?></td>
                                    <td><a href="/" onclick="edit_user('<?php echo htmlspecialchars($user[0]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">Edit</a></td>
                                    <td><a href="/" onclick="delete_user('<?php echo htmlspecialchars($user[0]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">Delete</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 no-padding mt-20 mb-20">
                <div class="card no-border-radius primary-white mt-20">
                    <h4 class="card-title text-uppercase">Companies</h4>
                    <form action="/admin/company/company-details/" method="post" name="view-company-form" id="view-company-form">
                        <input type="hidden" name="view-id" id="view-id" value="">
                    </form>
                    <form action="/admin/company/delete-company/" method="post" name="delete-company-form" id="delete-company-form">
                        <input type="hidden" name="delete-company-id" id="delete-company-id" value="">
                    </form>
                    <div class="card-body table-responsive">
                        <table class="table table-sm table-responsive table-responsive-width">
                            <thead class="navbar-light bg-light">
                                <tr>
                                    <th scope="col" class="company-name">Company</th>
                                    <th scope="col" class="company-contact">Contact</th>
                                    <th scope="col" class="contact-phone">Phone</th>
                                    <th scope="col" class="contact-email">Email</th>
                                    <th scope="col" colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($companies) > 0) : ?>
                                    <?php for ($i = 0; $i < count($companies); $i++) : ?>
                                        <tr>
                                            <td><?php echo  htmlspecialchars($companies[$i]['company_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo  htmlspecialchars($companies[$i]['company_contact'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo  htmlspecialchars($companies[$i]['contact_phone'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo  htmlspecialchars($companies[$i]['contact_email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><a href="/" onclick="view_company('<?php echo htmlspecialchars($companies[$i]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">View</a></td>
                                            <td><a href="/" onclick="edit_company('<?php echo htmlspecialchars($companies[$i]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">Edit</a></td>
                                            <td><a href="/" onclick="delete_company('<?php echo htmlspecialchars($companies[$i]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">Delete</a></td>
                                        </tr>
                                    <?php endfor; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" >There are no companies to display</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>