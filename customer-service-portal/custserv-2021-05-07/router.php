<?php
session_start();

include($_SERVER["DOCUMENT_ROOT"] . "/config.php");

$auth = true;

$session = new Session();
$redirect = new Redirect();
$request = new Request();

if ($session->key_exists('token')) {
    $auth = new AuthController();
    
    $token = $session->get_session('token');

    if ($auth->valid_token($token)) {
        $auth = true;
    } else {
        $session->delete_session('token');
    }
}

if ($auth) {
    switch (rtrim($_SERVER['REQUEST_URI'], '/')) {
        case '':
            $redirect->route('/customer/contract-search');
        
            break;
        case '/logout':
            $auth = new AuthController();
            $auth->user_logout();
    
            break;
        case '/customer/contract-search':
            $customer = new CustomerController();
            $customer->contract_search();
    
            break;
        case '/customer/search-results':
            $customer = new CustomerController();
            $customer->contract_list();
    
            break;
        case '/customer/contract-details':
            $customer = new CustomerController();
            $customer->contract_details();
    
            break;
        case '/admin/user/view-users':
            $admin = new AdminController();
            $admin->view_users();
    
            break;
        case '/admin/user/create-user':
            $admin = new AdminController();
            
            if (! empty($request->input('create-user'))) {
                $admin->store_user($request);
            } else {
                $admin->create_user();
            }
    
            break;
        case '/admin/user/user-details':
            $admin = new AdminController();
            $admin->user_details($request);
    
            break;
        case '/admin/user/delete-user':
            $admin = new AdminController();
            $admin->delete_user($request);
    
            break;
        case '/admin/company/delete-company':
            $admin = new AdminController();
            $admin->delete_company($request);
    
            break;
        default:
            echo "No Route";
    }
} else {
    $session->delete_session('token');

    $auth = new AuthController();
    $auth->user_login($request);
}