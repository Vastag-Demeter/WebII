<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
</head>

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
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require './fuggvenyek.php';
    
    
    //Email, nem lehet üres
    $email_errors = check_data("email|required");
    if($email_errors)
    {
        $email = clear($_POST["email"]);
    }
    else {
       echo "Az email megadása kötelező! <br>";
     
    }
    
    //Név, nem lehet üres
    $name_errors = check_data("name|required");
    if($name_errors)
    {
       $name = clear($_POST["name"]);
    }
    else{
          echo "A név megadása kötelező! <br>";
      
    }

    //Jelszó, nem lehet üres és a megfelelő formátumban kell lennie ([A-Za-z0-9])
    $password_errors = check_data("password|required,password_correct_format");
    if($password_errors)
    {
         $password = clear($_POST["password"]);
    }
    else{
          echo "A jelszó nem lehet üres és csak az Angol ABC nagy- és kisbetűit tartalmazhatja, valamint számjegyeket!<br>";
  
    }
    
    //Születési idő, nem lehet üres, az év alapján számolt életkor nem lehet kisebb,
    //mint 18
    $birth_errors = check_data("birth_date|required,adult");
        if($birth_errors)
    {
         $birth = clear($_POST["birth_date"]);
    }
    else{
          echo "A születési dátum megadása kötelező, valamint el kell múljon 18! <br>";
     
    }
    
    //Ha minden adatra a visszatérési érték megfelel ("OK"), akkor elmenthetem őket a fájlba
    if($email_errors && $name_errors && $password_errors && $birth_errors)
    {
        //Az írás metódusa, "w", ha a fájl nem létezik,
        // "ra", ha a fájl lézezik
        $method = "";
        //Ez a sor, amivel kiegészítem a fájlt
        $line = PHP_EOL.$email . ";" . $name . ";" . $password . ";" . $birth;
         //Ha nem létezik a fájl, akkor nem olvasok semmit, hanem 
        //létrehozom és beleírom az adatot.
        //Ha létezik, akkor megnézem, szerepel-e már benne ilyen
        //email és ha nem, akkor egészítem csak ki.
        if(file_exists("data.csv"))
            $method = "ra+";
        else 
            $method = "w";

        $file = fopen("./data.csv", $method);

        if(!$file)
        {
            echo "A fájlt nem lehet megnyitni!";
        }

        if($method == "ra+")
        {
            //Ebbe mentem el, ha az email létezik
            $existing_email = false;
            while(!feof($file))
            {
                //Beolvasok egy sort
                $row = fgets($file);
                //Kiszedem a whitespace-t
                $row = trim($row);
                //Felbontom a beolvasott sort email;nev;jelszo;szulido
                $fields = explode(';', $row);
                //Csak az emailt kell ellenőriznem
                $field_email = $fields[0];
                if($field_email == $email)
                {
                    $existing_email = true;
                    break;
                }
            }


            //Ha nincs benne az email, akkkor 
            //a fájl végét bővítem a megadott adatokkal
            //Ha benne van, akkor tájékoztatom a felhasználót
            if(!$existing_email)
            {
                fputs($file, $line);
            }
            else 
            {
                echo "A megadott email cím már szerepel!";
            }
        }
        else 
        {
            fwrite($file, $line);
            echo "Írok a fájlba";
        }

        //Lezárom a fájlt
        fclose($file);       
    }

}

?>

</html>