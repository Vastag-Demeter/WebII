<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Felhasználók a rendszerben</title>
    <link rel="stylesheet" href="style.css">
</head>
<?php
//Ebbe a tömbbe fogom eltárolni a beolvasott adatokat 
$records = [];
$file = fopen('./data.csv', 'r');
if ($file) {
    while (!feof($file)) {
        //Elkezdem beolvasni a sorokat és azokat elmentem
        //a tömbbe

        $row = fgets($file);
        $fields = explode(';', $row);
        $field_records = [
            'email' => $fields[0],
            'username' => $fields[1],
            'password' => $fields[2],
            'birth' => $fields[3]
        ];

        //Hozzáadom a mezőket a tömbhöz
        $records[] = $field_records;
    }
}
?>

<body>
    <table style="border: 1px solid black;">
        <tr>
            <th>Email cím</th>
            <th>Felhasználónév</th>
            <th>Jelszó</th>
            <th>Születési Dátum </th>
        </tr>
        <?php for ($i = 0; $i < count($records); $i++): ?>
            <tr>
                <td><?= $records[$i]['email'] ?></td>
                <td><?= $records[$i]['username'] ?></td>
                <td><?= $records[$i]['password'] ?></td>
                <td><?= $records[$i]['birth'] ?></td>
            </tr>
        <?php endfor; ?>
    </table>
</body>

</html>