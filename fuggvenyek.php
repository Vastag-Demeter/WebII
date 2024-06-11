<?php 
    
    function clear($value){
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
    }


    //Jelszó ellenzőrzés: Az angol ABC nagy- és kisbetűi, valamint 0-9-ig a számjegyek
    function password_correct_format($value){
    if (!preg_match('/[A-Za-z0-9]/', $value))
        return false;
    return true;
    }

    function notEmpty($value)
    {
        if(empty($value))
            return false;

        return true;
    }

    //A paraméterben megadott életkor nagyobb, mint 18 (Csak az évet veszi figyelembe)
    function adult($value){
        $current_year = date('Y');
        $user_birth_year = explode('-', $value)[0];
        if((int)$current_year - (int)$user_birth_year < 18)
            return false;
        return true;        

    }




    function check_data(string $input) 
    {
        $input_datas = explode('|', $input); // Egy tömbbe tárolom az input adatait
        $input_name = $input_datas[0]; // A kulcs a $_POST tömbben
        $input_rules = explode(',',$input_datas[1]); //Az szabályok tömbje az adott kulcsra
        
        if(array_key_exists($input_name, $_POST))
            {
                $input_name = clear($input_name); // Ez a param. neve, amit ellenőrzök.
          
              foreach($input_rules as $rule)
              {
                if(!$rule($_POST[$input_name]))
                {
                    //A megadott függvény visszatérési értéke "false",
                    //szóval az adott szabálynak nem felelt meg.
                    $errors[] = $rule . " NEM OK"; 
                }
              }
             
            }

        if(isset($hibak))
        {
            return $errors;
        }
        return "OK";
        
    }












?>