<?php
    //Verifica che la data inserita sia valida
    function is_valid_date($date) 
    {
        list($year, $month, $day) = explode('-', $date);
        return checkdate($month, $day, $year);
    }

    function is_valid_phone($phone) 
    {
        if(strlen($phone) == 10)
        {
            return true;
        }
        return false;
    }

    function is_valid_cap($cap) 
    {
        if(strlen($cap) == 5)
        {
            return true;
        }
        return false;
    }