<?php
    //Verifica che la data inserita sia valida
    function is_valid_date($date) 
    {
        list($year, $month, $day) = explode('-', $date);
        return checkdate($month, $day, $year);
    }

    function is_valid_phone($phone) 
    {
        return if(strlen($phone) == 10, true, false);
    }

    function is_valid_cap($cap) 
    {
        return if(strlen($cap) == 5, true, false);
    }