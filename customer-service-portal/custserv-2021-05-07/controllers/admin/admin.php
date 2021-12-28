<?php

class AdminController {
    private $redirect;
		
    public function __construct() {
        $this->redirect = new Redirect();
    }

    public function __destruct() {
        $this->conn = null;
    }
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function view_users() {
        $page = "View Users";

        $users = new UserController();

        $users = $users->get_users();

        $customers = [];
        $dealers = [];
        $admins = [];
        $super_admins = [];

        if (count($users) > 0) {
            for ($i = 0; $i < count($users); $i++) {
                if ($users[$i]['role'] == "customer") {
                    array_push($customers, $users[$i]);
                }

                if ($users[$i]['role'] == "dealer") {
                    array_push($dealers, $users[$i]);
                }

                if ($users[$i]['role'] == "admin") {
                    array_push($admins, $users[$i]);
                }

                if ($users[$i]['role'] == "super_admin") {
                    array_push($super_admins, $users[$i]);
                }
            }

            $users['users'] = [
                'customers' => $customers,
                'dealers' => $dealers,
                'admins' => $admins,
                'super_admins' => $super_admins
            ];
        } else {
            $users['users'] = [];

            $users = $users['users'];
        }

        if (isset($users['users'])) {
            $users = $users['users'];
        } else {
            $users = [];
        }
        
        
        include($_SERVER["DOCUMENT_ROOT"] . "/views/layouts/header.php");
        include($_SERVER['DOCUMENT_ROOT'] . '/views/admin/user/view-users.php');
        include($_SERVER["DOCUMENT_ROOT"] . "/views/layouts/footer.php");
    }

    public function user_details(Request $request) {
        if (! empty($request->input('view-id'))) {
            $page = "User Details";

            $user = new UserController();
            $company = new CompanyController();

            $id = $request->input('view-id');

            $user = $user->get_user($id);

            $companies = $company->get_customer_companies($id);

            if (count($user) > 0) {
                $user_details['user'] = [
                    'user' => $user,
                    'companies' => $companies
                ];
            } else {
                $user_details['user'] = [];
            }

            $user = $user_details['user']['user'];
            $companies = $user_details['user']['companies'];

            include($_SERVER["DOCUMENT_ROOT"] . "/views/layouts/header.php");
            include($_SERVER['DOCUMENT_ROOT'] . '/views/admin/user/user-details.php');
            include($_SERVER["DOCUMENT_ROOT"] . "/views/layouts/footer.php");
        } else {
            $this->redirect->route('/admin/user/view-users');
        }
    }

    public function create_user() {
        $page = "Create User";

        if (isset($_SESSION["success"])) {
            $message['success'] = $_SESSION['success'];
            
            $user['success'] = [];

            array_push($user['success'], $message['success'][0]);

            unset($_SESSION['success']);
        } elseif (isset($_SESSION["errors"])) {
            $message['errors'] = $_SESSION['errors'];
            
            $user['errors'] = [];

            for ($i = 0; $i < count($message['errors']); $i++) {
                array_push($user['errors'], $message['errors'][$i]);
            }

            unset($_SESSION['errors']);
        }

        include($_SERVER["DOCUMENT_ROOT"] . "/views/layouts/header.php");
        include($_SERVER['DOCUMENT_ROOT'] . '/views/admin/user/create-user.php');
        include($_SERVER["DOCUMENT_ROOT"] . "/views/layouts/footer.php");
    }

    public function store_user($request) {
        $user = new UserController();

        $user = $user->create_user($request->fields()); 

        if (isset($user["success"])) {
            $_SESSION = $user;
        } elseif (isset($user["errors"])) {
            $_SESSION = $user;
        }

        header('refresh: 0');
    }

    public function delete_user(Request $request) {
        if (! empty($request->input('delete-id'))) {
            $user = new UserController();
            $users = new UserController();

            $id = $request->input("delete-id");

            $user = $user->delete_user($id);

            $users = $users->get_users();

            if (count($users) > 0) {
                $remaining_users['users'] = $users;
    
                $users = $remaining_users['users'];
            } else {
                $remaining_users['users'] = [];
    
                $users = $remaining_users['users'];
            }

            if (! empty($request->input("success"))) {
                $remaining_users['user'] = [
                    'user' => $users,
                    'message' => $user
                ];
            } 
        }
        
        $this->redirect->route('/admin/user/view-users');
    }

    public function delete_company(Request $request) {
        if (! empty($request->input('delete-company-id'))) {
            $company = new CompanyController();
            $companies = new CompanyController();

            $id = $request->input("delete-company-id");

            $company = $company->delete_company($id);

            $companies = $companies->get_customer_companies($id);

            if (count($companies) > 0) {
                $remaining_companies['companies'] = $companies;
    
                $companies = $remaining_companies['companies'];
            } else {
                $remaining_companies['companies'] = [];
    
                $companies = $remaining_companies['companies'];
            }

            if (isset($user["success"])) {
                $remaining_companies['company'] = [
                    'company' => $companies,
                    'message' => $company
                ];
            } 
        }
        
        $this->redirect->route('/admin/user/view-users');
    }
}