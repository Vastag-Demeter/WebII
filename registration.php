<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
</head>
<?php
    




    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require './fuggvenyek.php';
    
    
    //Email, nem lehet üres
    $email_errors = check_data("email|notEmpty");
    if($email_errors == "OK")
    {
        $email = clear($_POST["email"]);
    }
    else {
       echo "Az email hibás! <br>";
       foreach($email_errors as $error)
            echo $error;
        echo "<br>";
    }
    
    //Név, nem lehet üres
    $name_errors = check_data("name|notEmpty");
    if($name_errors == "OK")
    {
       $name = clear($_POST["name"]);
    }
    else{
          echo "A név hibás! <br>";
       foreach($name_errors as $error)
            echo $error;
        echo "<br>";
    }

    //Jelszó, nem lehet üres és a megfelelő formátumban kell lennie ([A-Za-z0-9])
    $password_errors = check_data("password|notEmpty,password_correct_format");
    if($password_errors == "OK")
    {
         $password = clear($_POST["password"]);
    }
    else{
          echo "A jelszó hibás! <br>";
       foreach($password_errors as $error)
            echo $error;
        echo "<br>";
    }
    
    //Születési idő, nem lehet üres, az év alapján számolt életkor nem lehet kisebb,
    //mint 18
    $birth_errors = check_data("birth_date|notEmpty,adult");
        if($birth_errors == "OK")
    {
         $birth = clear($_POST["birth_date"]);
    }
    else{
          echo "A születési dátum hibás! <br>";
       foreach($birth_errors as $error)
            echo $error;
        echo "<br>";
    }
    
    //Ha minden adatra a visszatérési érték megfelel ("OK"), akkor elmenthetem őket a fájlba
    if($email_errors == "OK" && $name_errors == "OK" && $password_errors == "OK" && $birth_errors == "OK")
    {
        echo "Minden pacek!";
        echo $email."<br>";
        echo $name."<br>";
        echo $password."<br>";
        echo $birth."<br>";
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