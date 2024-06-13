<?php


//Megvizsgálja, hogy megtalálható az elfogadható erőforrások
//közül legalább 1, de lehet hogy több a $_GET tömbben.
function get_res(array $values)
{
    foreach ($values as $val) {
        if (array_key_exists($val, $_GET))
            return "OK";

        return "NEM OK";
    }

}