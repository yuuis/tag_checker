<?php

namespace App\Http\Model;

use Exception;

class ValidateTestDAO
{
    public function __construct()
    {
    }

    public function register($inputs)
    {
        $where["pass"] = $inputs["pass"];
        $where["mail"] = $inputs["mail"];
        try {
            \DB::insert("INSERT INTO user_table(mail, pass) values(?, ?)", [$where["mail"], $where["pass"]]);
            $results = "success";
        } catch (Exception $e) {
            $results = "failed";
        }
        return $results;
    }

    public function selectUser($inputs)
    {
        $results = \DB::select("SELECT * FROM user_table");
        return $results;
    }
}


