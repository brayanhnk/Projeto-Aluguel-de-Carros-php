<?php 

    class LogoutController {

        public static function logout() {

            unset($_SESSION["logado"]);

            session_destroy();
            header("Location: ?p=login");
            exit();
        }
    }

?>
