
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
        
        <div class="row row-w80">
            <div class="col-12 no-padding">
                <div class="card no-border-radius primary-white no-padding-mobile card-mb-mobile">
                    <div class="card-body">
                        <h4 class="card-title text-uppercase hide-on-mobile">View Users</h4>
                        <fieldset class="form-group">
                            <legend class="fieldset-legend">Customers</legend>
                            <form action="/admin/user/user-details/" method="post" name="view-user-form" id="view-user-form">
                                <input type="hidden" name="view-id" id="view-id" value="">
                            </form>
                            <form action="/admin/user/delete-user/" method="post" name="delete-user-form" id="delete-user-form">
                                <input type="hidden" name="delete-id" id="delete-id" value="">
                            </form>
                            <div class="col-12 no-padding table-responsive">
                                <table class="table table-sm table-responsive table-responsive-width">
                                    <thead class="navbar-light bg-light">
                                        <tr>
                                            <th scope="col" class="user-name">Name</th>
                                            <th scope="col" class="user-username">Username</th>
                                            <th scope="col" class="user-role">Role</th>
                                            <th scope="col" class="user-email">Email</th>
                                            <th scope="col" class="user-login">Last Login</th>
                                            <th scope="col" colspan="3"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($users['customers']) && count($users['customers']) > 0) : ?>
                                            <?php for ($i = 0; $i < count($users['customers']); $i++) : ?>
                                                <?php if ($users['customers'][$i]['role'] == "customer") : ?>
                                                    <tr>
                                                        <th scope="row"><?php echo htmlspecialchars($users['customers'][$i]['first_name'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($users['customers'][$i]['last_name'], ENT_QUOTES, 'UTF-8'); ?></th>
                                                        <td><?php echo htmlspecialchars($users['customers'][$i]['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo ucwords(htmlspecialchars($users['customers'][$i]['role'], ENT_QUOTES, 'UTF-8')); ?></td>
                                                        <td><?php echo htmlspecialchars($users['customers'][$i]['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo date("F j, Y", strtotime(htmlspecialchars($users['customers'][$i]['last_login'], ENT_QUOTES, 'UTF-8'))); ?></td>
                                                        <td class="action-links"><a href="/" onclick="view_user('<?php echo htmlspecialchars($users['customers'][$i]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">View</a></td>
                                                        <td class="action-links"><a href="/" onclick="edit_user('<?php echo htmlspecialchars($users['customers'][$i]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">Edit</a></td>
                                                        <td class="action-links"><a href="/" onclick="delete_user('<?php echo htmlspecialchars($users['customers'][$i]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">Delete</a></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="6" >There are no customers to display</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- <nav aria-label="Users Pagination">
                                <ul class="pagination pagination-sm justify-content-end">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav> -->
                        </fieldset>
                    </div>
                </div>

                <div class="card no-border-radius primary-white no-padding-mobile card-mb-mobile">
                    <div class="card-body">
                        <fieldset class="form-group">
                            <legend class="fieldset-legend">Dealers</legend>
                            <div class="col-12 no-padding table-responsive">
                                <table class="table table-sm table-responsive table-responsive-width">
                                    <thead class="navbar-light bg-light">
                                        <tr>
                                            <th scope="col" class="user-name">Name</th>
                                            <th scope="col" class="user-username">Username</th>
                                            <th scope="col" class="user-role">Role</th>
                                            <th scope="col" class="user-email">Email</th>
                                            <th scope="col" class="user-login">Last Login</th>
                                            <th scope="col" colspan="3"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($users['dealers']) && count($users['dealers']) > 0) : ?>
                                            <?php for ($i = 0; $i < count($users['dealers']); $i++) : ?>
                                                <?php if ($users['dealers'][$i]['role'] == "dealers") : ?>
                                                    <tr>
                                                        <th scope="row"><?php echo htmlspecialchars($users['dealers'][$i]['first_name'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($users['dealers'][$i]['last_name'], ENT_QUOTES, 'UTF-8'); ?></th>
                                                        <td><?php echo htmlspecialchars($users['dealers'][$i]['dealers'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo ucwords(htmlspecialchars($users['dealers'][$i]['role'], ENT_QUOTES, 'UTF-8')); ?></td>
                                                        <td><?php echo htmlspecialchars($users['dealers'][$i]['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo date("F j, Y", strtotime(htmlspecialchars($users['dealers'][$i]['last_login'], ENT_QUOTES, 'UTF-8'))); ?></td>
                                                        <td><a href="/" onclick="view_user('<?php echo htmlspecialchars($users['dealers'][$i]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">View</a></td>
                                                        <td><a href="/" onclick="edit_user('<?php echo htmlspecialchars($users['dealers'][$i]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">Edit</a></td>
                                                        <td><a href="/" onclick="delete_user('<?php echo htmlspecialchars($users['dealers'][$i]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">Delete</a></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="6" >There are no customers to display</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- <nav aria-label="Users Pagination">
                                <ul class="pagination pagination-sm justify-content-end">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav> -->
                        </fieldset>
                    </div>
                </div>

                <div class="card no-border-radius primary-white no-padding-mobile card-mb-mobile">
                    <div class="card-body">
                        <fieldset class="form-group">
                            <legend class="fieldset-legend">Admins</legend>
                            <div class="col-12 no-padding table-responsive">
                                <table class="table table-sm table-responsive table-responsive-width">
                                    <thead class="navbar-light bg-light">
                                        <tr>
                                            <th scope="col" class="user-name">Name</th>
                                            <th scope="col" class="user-username">Username</th>
                                            <th scope="col" class="user-role">Role</th>
                                            <th scope="col" class="user-email">Email</th>
                                            <th scope="col" class="user-login">Last Login</th>
                                            <th scope="col" colspan="3"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($users['dealers']) && count($users['admins']) > 0) : ?>
                                            <?php for ($i = 0; $i < count($users['admins']); $i++) : ?>
                                                <?php if ($users['admins'][$i]['role'] == "admins") : ?>
                                                    <tr>
                                                        <th scope="row"><?php echo htmlspecialchars($users['admins'][$i]['first_name'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($users['admins'][$i]['last_name'], ENT_QUOTES, 'UTF-8'); ?></th>
                                                        <td><?php echo htmlspecialchars($users['admins'][$i]['admins'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo ucwords(htmlspecialchars($users['admins'][$i]['role'], ENT_QUOTES, 'UTF-8')); ?></td>
                                                        <td><?php echo htmlspecialchars($users['admins'][$i]['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo date("F j, Y", strtotime(htmlspecialchars($users['admins'][$i]['last_login'], ENT_QUOTES, 'UTF-8'))); ?></td>
                                                        <td><a href="/" onclick="view_user('<?php echo htmlspecialchars($users['admins'][$i]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">View</a></td>
                                                        <td><a href="/" onclick="edit_user('<?php echo htmlspecialchars($users['admins'][$i]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">Edit</a></td>
                                                        <td><a href="/" onclick="delete_user('<?php echo htmlspecialchars($users['admins'][$i]['id'], ENT_QUOTES, 'UTF-8'); ?>'); event.preventDefault();">Delete</a></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="6" >There are no customers to display</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- <nav aria-label="Users Pagination">
                                <ul class="pagination pagination-sm justify-content-end">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav> -->
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>