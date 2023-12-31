<?php



    function checkname($name) {
        try {
            $bdd = connectDb();
            $sql = "SELECT * FROM users WHERE name = :name";
            $query = $bdd->prepare($sql);
            $query->execute(array(
                'name' => $name
            ));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $bdd = null;
            if ($result) {
                return true;
            }
            else {
                return false;
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        
        }
    }

    function checkemail($email) {
        try {
            $bdd = connectDb();
            $sql = "SELECT * FROM users WHERE email = :email";
            $query = $bdd->prepare($sql);
            $query->execute(array(
                'email' => $email
            ));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $bdd = null;
            if ($result) {
                return true;
            }
            else {
                return false;
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        
        }

    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once __DIR__.'/../queries/connectDb.php';
        $bdd = connectDb();
        
        if (isset($_POST['name']) && isset($_POST['birthday']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2'])) {
            if (empty($_POST['name']) || empty($_POST['birthday']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password2'])) {
                echo 'Please complete all fields';
                
            }
            else {
                if (checkname($_POST['name']) == true) {
                    echo 'Username already exists';
                }
                    elseif (checkemail($_POST['email']) == true){
                        echo 'Email already exists';
                    }
                
                else{
            $name = $_POST["name"];
            $birthday = $_POST["birthday"];
            $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
            if ($email === false) {
                echo 'Veuillez fournir une adresse e-mail valide';
            }
                                
                $confirmpassword =  $_POST['password2'];
                $password = $_POST['password'];
                if ($password != $confirmpassword){
                    header('Location: /index.php/User');
                    
                }
                else {
                    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            }

            
            

            $sql = "INSERT INTO users (name, birthday, email, password) VALUES (:name, :birthday, :email, :password)";
            $query = $bdd->prepare($sql);
            $query->execute(array(
                'name' => $name,
                'birthday' => $birthday,
                'email' => $email,
                'password' => $password
            ));
            header('Location: /');
            $bdd = null;
            }
        }
    }
}

else {
    header('Location: /');
}
?>















<!-- <?php

    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     require_once __DIR__.'/../queries/connectDb.php';
    //     $bdd = connectDb();
        

    // if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2'])) {

    //     //vérifier récupérer les données du form 
    //     $username = $_POST['name'];
//         $password = $_POST['password'];
//         $confirmpassword =  $_POST['password2'];
//         $passwordlen = strlen($password);
//         $min = 7;
//         //validation des champs du form
//         $usernameErr = empty($username) ? "* Email is required" : (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL) ? "Invalid email" : "");
//         $passwordErr =  empty($password) ? " Password is required" : ($passwordlen < $min ? "Password should have min 7 characters" : "");
//         $passwordConfirmErr = empty($confirmpassword) ? " Password is required" : ($password != $confirmpassword ? "*password doesn't match" : "");

//         //si erreurs de validation, retounrer un tableau d'erreurs 
//         return array(
//             "username" => $usernameErr,
//             "password" => $passwordErr,
//             "password2" => $passwordConfirmErr

//         );
//     }

//             }
//              else {
//                 $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            
//             $sql = "INSERT INTO users (name, birthday, email, password) VALUES (:name, :birthday, :email, :password)";
//             $query = $bdd->prepare($sql);
//             $query->execute(array(
//                 'name' => $name,
//                 'birthday' => $birthday,
//                 'email' => $email,
//                 'password' => $password
//             ));
//             header('Location: /');
//             $bdd = null;
//             }
//         }
    

// else {
//     header('Location: /');
// }
?> -->