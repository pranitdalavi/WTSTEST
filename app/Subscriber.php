<?php

namespace App;


class Subscriber extends ObjectModel
{

    protected $table = 'subscribers';
    protected $fillable = [ 'name', 'email'];
    protected $rules = [ ];

    public function __construct()
    {


    }


    public function addNewSubscriber($email)
    {
        $_POST["name"] = "unknown";
        $_POST["email"] = $email;

        $current = $this->execute("SELECT * FROM subscribers WHERE email = '". $email ."'", [] );

        if(count($current) > 0){

            return redirect( DOMAIN . "?subscribe=existing");
        }
        else{
            parent::add();

            return redirect( DOMAIN . "?subscribe=success" );
        }

    }





}
