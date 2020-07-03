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
        $password = password_hash($password,PASSWORD_DEFAULT);

        $data = [
            'email' => $email,
            'password' => $password
        ];

        $sql = "INSERT INTO user_secure (email,password) VALUES (:email,:password)";


        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        $user_id =  $pdo->lastInsertId();

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
    if(!empty($user_id))
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

// Проверка на существования контакта
function checkUser($email, $password)
{
    // code here
}



// Редактировать пароль контакта
function setUserPass($email, $password, $user_id)
{
    // code here
}

// Выход из системы
function exitUser()
{
    // code here
}