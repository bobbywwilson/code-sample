<?php

class AuthController {
    private $auth;
    private $session;
    private $redirect;
		
    public function __construct() {
        $this->auth = new Auth();
        $this->session = new Session();
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

    /**
     * Decode Authorization Token
     * 
     * @param String $token
     * @return Array $decode_payload
    */
    private function decodeToken($token) {
        try {
            if (! isset($token)) {
                exit('Please provide a token to decode');
            }

            $token_parts = explode('.', $token);
            $payload = base64_decode($token_parts[1]);

            $decode_payload = json_decode($payload, true);

            return $decode_payload;
        } catch (PDOException $exception) {	
            echo "Unable to compete request: " . $exception->getMessage();
                
            exit();
        }
    }

    private function userLogin(Request $request) {
        $page = 'Login';
        
        if (! empty($request->input('login'))) {
            $token = $this->authenticateUser($request);
            
            if (! empty($token)) {
                if ($this->validToken($token)) {
                    $this->redirect->route('/customer/contract-search');

                    exit();
                } else {
                    $this->session->delete_session('token');
    
                    include($_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php');
                    include($_SERVER['DOCUMENT_ROOT'] . '/views/auth/login.php');
                    include($_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php');
                }
            } else {
                $this->session->delete_session('token');

                $login_error = 'The Username or Password was incorrect.';
                
                include($_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php');
                include($_SERVER['DOCUMENT_ROOT'] . '/views/auth/login.php');
                include($_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php');
            }
        } else {
            if ($this->session->key_exists('token')) {
                $this->session->delete_session('token');
            }

            include($_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php');
            include($_SERVER['DOCUMENT_ROOT'] . '/views/auth/login.php');
            include($_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php');
        }
    }

    private function userLogout() {
        $page = 'Logout';

        if ($this->session->key_exists('token')) {
            $this->session->delete_session('token');
        }

        $this->redirect->route('/');
    }

    private function authenticateUser(Request $request) {
        if (! empty($request->input('login'))) {
            try {
                $credentials = [
                    'username' => $request->input('username'),
                    'password' => $request->input('password')
                ];
    
                $user = $this->auth->authenticate_user($credentials);
                
                if (count($user) > 0) {
                    if ($this->session->key_exists('token')) {
                        $token = $this->session->get_session('token');
                    } else {
                        $token = $this->auth->get_token($user);

                        $this->session->set_session('token', $token);
                    }
                    
                    return $token;
                }
            } catch (PDOException $exception) {	
                echo "Unable to compete request: " . $exception->getMessage();
                    
                exit();
            }
        }

        // include($_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php');
        // include($_SERVER['DOCUMENT_ROOT'] . '/views/auth/login.php');
        // include($_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php');
    }

    /**
     * Validate Authorization Token
     * 
     * @param String $token
     * @return Boolean $valid
    */
    private function validToken($token) {
        try {
            if (! isset($token)) {
                exit('Please provide a key to verify');
            }

            $valid_token = $this->auth->valid_token($token);

            return $valid_token;
        } catch (PDOException $exception) {	
            echo "Unable to retrieve record(s): " . $exception->getMessage();
                
            exit();
        }
    }

    /** 
     * Public Decode Token Interface
     * 
     * @param String $token
     * @return String $decode_payload
    */
    public function decode_token($token) {
        return $this->decodeToken($token);
    }

    /** 
     * Public Login Interface
     * 
     * @return Void
    */
    public function user_login($request) {
        return $this->userLogin($request);
    }

    /** 
     * Public Logout Interface
     * 
     * @return Void
    */
    public function user_logout() {
        return $this->userLogout();
    }

    /** 
     * Public Authenticate User Interface
     * 
     * @param Request $request
     * @return User $token
    */
    public function authenticate_user($request) {
        return $this->authenticateUser($request);
    }

    /** 
     * Public Valid Token Interface
     * 
     * @param String $token
     * @return Boolean $valid
    */
    public function valid_token($token) {
        return $this->validToken($token);
    }
}
