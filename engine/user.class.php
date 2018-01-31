<?php
class User
{
    public function __construct()
    {
        if (isset($_POST['signin'])) {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE);
            return User::signIn($name, $password);
        }
        
        if (isset($_POST['reg_user'])) {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE);
            $passwordr = filter_input(INPUT_POST, 'passwordr', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE);
            return User::regUser($name, $password, $passwordr);
        }

        if (isset($_GET['logout']) && $_GET['logout'] == true) {
            User::logOutUser();
        }
    }

    public static function regUser($name, $password, $passwordr)
    {
        global $DB;

        if (count(preg_grep('/^[a-zA-Z0-9_]{4,}$/', [$name, $password, $passwordr])) == 3) {
            if ($password === $passwordr) {
                $password = md5(md5($password));
                $result = $DB->query('INSERT INTO users (name, password) VALUES ("' . $name . '","' . $password . '")');
                if (!$result) {
                    return "Ошибка базы данных";
                } else {
                    User::signIn($name, $passwordr);
                    header('Location: /');
                }
            }
        }
    }

    public static function signIn($name, $password)
    {
        global $DB;
        if ($name && $password) {
            $password = md5(md5($password));
            $result = $DB->query('SELECT id, name, type FROM users WHERE name="' . $name . '" AND password="' . $password . '"');
            if ($result->num_rows) {
                $_SESSION['user_data'] = $result->fetch_assoc();
            }
        } else {
            return 'Введите все данные';
        }
    }

    public static function logOutUser()
    {
        if (isset($_SESSION['user_data'])) {
            unset($_SESSION['user_data']);
            header('Location: /');
        }
    }

    public static function getCurrUserData($field)
    {
        if (isset($_SESSION['user_data'][$field])) {
            return $_SESSION['user_data'][$field];
        }
        return false;
    }

    public static function isUserSignedIn()
    {
        if (isset($_SESSION['user_data'])) {
            return true;
        }
        return false;
    }

    public static function getUserDataByID($user_id, $field)
    {
        global $DB;
        
        $result = $DB->query('SELECT ' . $field . ' FROM users WHERE id=' . $user_id);
        if ($result->num_rows) {
            return $result->fetch_assoc()[$field];
        }
        return false;
    }
}

$USER = new User();
