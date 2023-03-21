<?php
require_once(APPROOT.'libraries/Controller.php');
class Doctors extends Controller {
    public function __construct() {
        $this->loadModel('Doctor');
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $loginInfo = [
                "email" => $_POST['email'],
                "password" => $_POST['password'],
                "email_error" => false,
                "password_error" => false
            ];
            $email = $loginInfo['email'];
            if (!$this->model->findDoctorbyEmail($email)) {
                echo "Wrong email or user not exists";
                $loginInfo['email_error'] = true;
                $this -> render("/doctors/login");
                return;
            }
            $password = $loginInfo(['password']);
            $result = $this->model->login($email, $password);
            if (!$result) {
                $loginInfo['password_error'] = true;
                $this -> render("/doctors/login");
                return;
            }
            $this->createDoctorSession(compact('result'));
        }
        else {
            $this -> render("/doctor/login", $data = ["Hello", "I am superhero"]);
        }
    }

    function createDoctorSession($doctor){
        $_SESSION['doctor_id'] = $doctor['id'];
        $_SESSION['doctor_name'] = $doctor['name'];
        $_SESSION['doctor_email'] = $doctor['email'];
        //$this->render("")
    }
}
?>