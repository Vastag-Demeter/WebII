<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
</head>
<?php
    

    function clear($value){
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
    }

    function password_correct_format($value){
    if (!preg_match('/[A-Za-z0-9]/', $value))
        return false;
    return true;
    }



    $connected = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(array_key_exists('name', $_POST))
    {
        $name = clear($_POST['name']);
        if (empty($name))
            $hibak[] = "A név nem lehet üres!";
        
    } else
        $hibak[] = "A név megadása kötelező!";

    if(array_key_exists('email', $_POST))
    {
        $email = clear($_POST['email']);
        if (empty($email))
            $hibak[] = "Az email cím nem lehet üres!";
    } else
        $hibak[] = "Az email cím megadása kötelező!";


    if(array_key_exists('password', $_POST))
    {
        $password = clear($_POST['password']);
        if(!empty($password))
        {
            if (!password_correct_format($password))
                $hibak[] = "A jelszó csak számot, valamint az angol ABC kis és nagy betűit tartalmazhaja!";
        } else
            $hibak[] = "A jelszó nem lehet üres!";
    } else
        $hibak[] = "A jelszó megadása kötelező!";

    if(array_key_exists('birth_date',$_POST))
    {
        $birth = clear($_POST['birth_date']);
        if(!empty($birth))
        {
            $current_year = date('Y');
            if (date('Y-M-DD') - $birth < 18)
                $hibak[] = "Még nem töltötte be a 18-at";
            

        } else
            $hibak[] = "A születési dátum nem lehet üres!";
    } else
        $hibak[] = "A születési dátum megadása kötelező";





    if (isset($hibak))
        var_dump($hibak);
    else {

    if(file_exists("data.csv"))
    {
        $method = "a";
    }
    else{
        $method = "w";
    }
    $data = fopen("data.csv", $method);
        $row = $email.";".$name . ";" . $password . ";" . $birth . "\n";
    fputs($data, $row);
    fclose($data);
    }
}


?>
<body>
    <h1>Regisztráció</h1>
    <form action="" method="post">
    <label>Email:</label> <input type="email" name="email">
    <label>Név:</label> <input type="text" name="name">
    <label>Jelszó:</label> <input type="password" name="password">
    <label>Születési Dátum:</label> <input type="date" name="birth_date">
    <button type="submit">Regisztráció</button>
    </form>

    
    
</body>
</html>