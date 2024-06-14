<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Felhasználó törlése</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <h1>Jelszó megváltoztatása</h1>
    <form action="" method="post">
        <label>Email cím: </label>
        <input type="text" name="email" class="user_input">

        <button type="submit" class="sumbit_button">Felhasználó törlése</button>
    </form>


    <?php


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once './fuggvenyek.php';
        $email_correct = check_data("email|required");
        if ($email_correct)
            $email = clear($_POST['email']);
        else {
            echo "Az email megadása kötelező!";
            exit();
        }

        echo "Az email: " . $email . "<br>";

        if ($email_correct) {


            $file = fopen('./data.csv', 'rw+');
            $user_deleted = false;
            $correct_records = [];
            if ($file) {
                while (!feof($file)) {

                    $row = fgets($file);
                    $splitted_row = explode(';', $row);

                    if ($email == $splitted_row[0]) {
                        $user_deleted = true;
                    } else {
                        $correct_records[] = $row;
                    }


                }
                if ($user_deleted) {
                    file_put_contents('./data.csv', $correct_records);
                    echo "Felhasználó törölve!";
                } else
                    echo "Nincs ilyen email címmel rendelkező felhasználó!";

            }
        }

    }





    ?>
</body>

</html>