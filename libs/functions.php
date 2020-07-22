<?php
// Подключения БД
require_once ('Db.php');


// Debug всех массивов
function dd($arr)
{
    echo "<pre>";
        print_r($arr);
    echo "</pre>";
}

// Регистрация нового контакта
function regUser($email,$password)
{
    // Подключение к БД
    $pdo = pdo();

    // Если email and password то уже работаем
    if(!empty($email) and !empty($password))
    {
        $email = htmlspecialchars($email);
        //$password = password_hash($password,PASSWORD_DEFAULT);
        $password = md5(md5($password));

        $data = [
            'email' => $email,
            'password' => $password
        ];

        $user_exist = checkUser($email);
        if($user_exist != $email)
        {
            $sql = "INSERT INTO user_secure (email,password) VALUES (:email,:password)";


            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
            $user_id =  $pdo->lastInsertId();
        }

    }

    return $user_id;
}

// Редактировать профиль контакта
function setUserInfo($username = '', $second_name = '', $login = '', $phone = '', $user_id)
{
    // Подключение к БД
    $pdo = pdo();

    if(!empty($user_id))
    {
        $username = htmlspecialchars($username);
        $second_name = htmlspecialchars($second_name);
        $login = htmlspecialchars($login);
        $phone = htmlspecialchars($phone);

        $data = [
            'username' => $username,
            'second_name' => $second_name,
            'login' => $login,
            'phone' => $phone,
            'user_id' => $user_id
        ];


        $sql = "INSERT INTO user_profile (user_id) VALUES (:user_id);";
        $sql .= "UPDATE user_profile SET 
                            username =:username, 
                            second_name =:second_name, 
                            login =:login, 
                            phone =:phone
                            WHERE user_id =:user_id;";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

    }
}

// Редактировать аватар контакта
function setUserAvatar($files = '', $user_id)
{
    // Подключения к БД
    $pdo = PDO();

    // Если user_id то уже работаем
    if(!empty($user_id) and !empty($files))
    {

        $orig_name = $files['name'];
        $tmp_name = $files['tmp_name'];
        $type = $files['type'];
        $size = $files['size'];


        if($type == 'image/jpeg' and $size <= 1024 * 1024)
        {
            $split = explode('.',strtolower($orig_name));
            $name = $split[0];
            $ext = $split[1];
            $changed_name = $name . uniqid() . '.'. $ext;
            $dist = 'uploads/'. $changed_name;

            $data = [
                'dist' => $dist,
                'user_id' => $user_id,
            ];

            $sql = "INSERT INTO user_photo (user_id) VALUES (:user_id);";
            $sql .= "UPDATE user_photo SET avatar =:dist WHERE user_id =:user_id;";

            $stmt= $pdo->prepare($sql);
            $stmt->execute($data);

            move_uploaded_file($tmp_name,$dist);
        }

    }
}

// Проверка на существования контакта в БД
function checkUser($email)
{
    // Подключения к БД
    $pdo = PDO();

    $stmt = $pdo->prepare("SELECT email FROM user_secure WHERE email=:email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetchColumn();

    return $user;
}



// Редактировать пароль контакта
function setUserPass($email, $password, $user_id)
{
    // code here
}

function userAuth($email,$password)
{
    // Подключения к БД
    $pdo = PDO();

    if(!empty($email) and !empty($password))
    {
        // Получаем данные из past
        $email = $email;
        $password = md5(md5($password));

        // Выборка и извлечение данных из БД
        $stmt = $pdo->prepare("SELECT email,password FROM user_secure WHERE email=:email");
        $stmt->execute(['email' => $email]);
        $userInfo = $stmt->fetchObject();

        // Проверка на совпадение данных
        if(($userInfo->email == $email) and ($userInfo->password == $password))
        {
            return $password;
        }
    }

}

// Выход из системы
function exitUser($get)
{
    if($get === 'logout')
    {
        unset($_SESSION['pass']);

        return true;
    }
}