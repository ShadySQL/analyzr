<?php
/**
 * Class and Function List:
 * Function list:
 * Classes list:
 */
return array(
    /*
    |--------------------------------------------------------------------------
    | HybridAuth Social network essentials
    |--------------------------------------------------------------------------
    |
    |
    |
    |
    |
    */
    
    "base_url" => URL::to('user/social/auth') ,
    "providers" => array(
        "Google" => array(
            "enabled" => true,
            "keys" => array(
                "id" => "667508165338-u4f17rre6vhqdda4o3m0it31uk15lknm.apps.googleusercontent.com",
                "secret" => "2ucUzhWErni0PsrCD_HbAA_n"
            ) ,
        ) ,
        "Facebook" => array(
            "enabled" => true,
            "keys" => array(
                "id" => "602946523149734",
                "secret" => "09e7507d10ba50ce8c088bfcd806762a"
            ) ,
        ) ,
        "LinkedIn" => array(
            "enabled" => true,
            "keys" => array(
                "key" => "75xqpctq9drir4",
                "secret" => "M4T3DQcHiA6Vf178"
            ) ,
        ) ,
        "GitHub" => array(
            "enabled" => true,
            "keys" => array(
                 "id" => "15b65cf0ff9241b31a8b",
                "secret" => "2b6a7f31e175d00bb5872413bff71aae2234129f"
            ),
            "wrapper" => array(
                    'class'=>'Hybrid_Providers_GitHub',
                    'path' => app_path() . '/../vendor/hybridauth/hybridauth/additional-providers/hybridauth-github/Providers/GitHub.php'
                )
        ),
    ) ,
);
