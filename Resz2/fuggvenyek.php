<?php


//Megvizsgálja, hogy megtalálható az elfogadható erőforrások
//közül legalább 1, de lehet hogy több a $_GET tömbben.
function get_res(array $values)
{
    $count = 0;
    foreach ($values as $val) {
        //Ebbe fogom elmenteni az egyezések számát, majd ezzel térek vissza
        if (array_key_exists($val, $_GET))
            $count = $count + 1;

    }
    return $count;
}


//A születési évnek a megfelelő formátumban kell lenni (YYYY.MM.DD)
//És csak az évet számolva, el kell múljon a felhasználó 18
function birth_date_is_correct($birth_date)
{
    $birth_date;
    //Nem lehet '.' alapján 4 komponensre bontani
    $birth_date_components = explode('.', $birth_date);
    if (count($birth_date_components) != 3)
        return false;


    $birth_month = $birth_date_components[1];
    $birth_day = $birth_date_components[2];


    if ($birth_day < 1 || $birth_day > 31)
        return false;
    else if ($birth_month < 0 || $birth_month > 12)
        return false;

    return true;
}


function user_is_adult($birth_date)
{
    $birth_date_components = explode('.', $birth_date);
    $current_year = date('Y');
    $birth_year = $birth_date_components[0];
    if ($current_year - $birth_year < 18)
        return false;
    return true;
}





