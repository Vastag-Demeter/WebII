<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelszó megváltoztatása</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav>
        <p><a href="login.php">Bejelentkezés</a></p>
        <p><a href="registration.php">Regisztráció</a></p>
        <p><a href="modify_password.php">Jelszó módosítása</a></p>
    </nav>

    <form action="" method="post">
        <h1>Jelszó megváltoztatása</h1>
        <label>Email cím: </label> <br>
        <input type="text" name="email" class="user_input">
        <label>Új jelszó: </label>
        <input type="password" name="password" class="user_input">
        <button type="submit">Jelszó megváltoztása</button>
    </form>
</body>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once './fuggvenyek.php';
    $email_correct = check_data("email|required");
    if ($email_correct)
        $email = clear($_POST['email']);
    else
        $error[] = "Az email megadása kötelező!";


    $new_password_correct = check_data("password|required,password_correct_format");
    if ($new_password_correct)
        $new_password = clear($_POST['password']);
    else
        $error[] = "A jelszó nem megfelelő!";



    if ($email_correct && $new_password_correct) {
        $file = fopen('./data.csv', 'rw+');
        if ($file) {
            $password_changed = false;
            $records = [];

            while (!feof($file)) {
                $row = fgets($file);

                $row_splitted = explode(';', $row);

                $row_record = [
                    'email' => $row_splitted[0],
                    'name' => $row_splitted[1],
                    'password' => $row_splitted[2],
                    'birth' => $row_splitted[3]
                ];

                if ($row_record['email'] == $email) {
                    $row_record['password'] = $new_password;
                    $password_changed = true;
                }

                $line = $row_record['email'] . ";" . $row_record['name'] . ";" . $row_record['password'] . ";" . $row_record['birth'];
                $records[] = $line;
            }

            if ($password_changed) {
                file_put_contents('./data.csv', $records);
            } else
                $error[] = "Nem találtunk ilyen email címet!";

        }

        fclose($file);
    }
}


?>



<?php if (isset($error)): ?>
    <div class="server_error_message">
        <?php for ($i = 0; $i < count($error); $i++): ?>
            <p><?= $error[$i] ?></p>
        <?php endfor; ?>
    </div>


<?php endif; ?>

</html>