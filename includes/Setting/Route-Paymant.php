<?php

<<<<<<< HEAD
use Yoast\WP\SEO\Content_Type_Visibility\Application\Content_Type_Visibility_Watcher_Actions;

function IQ_get_payment_inquiry()
{
    $url = "https://api.instapago.com/payment?KeyId=19125576-6987-4DEB-8CE1-6AFF6384D193&PublicKeyId=60a27a4d7858d1b25a9579415c0b874c&Id=f2317ad2-b304-47b5-b267-31a9cbb1b544";

    $reponse = wp_remote_get($url);

    if(is_wp_error($reponse)){
        error_log("Error: ".$reponse->get_error_message());
        return false;
    }

    $body = wp_remote_retrieve_body($reponse);

    $data = json_decode($body);

    return $data;

}

function IQ_post_create_payment(){
    $url = "https://api.instapago.com/payment";

    $datos = array(
        'KeyId'=> '19125576-6987-4DEB-8CE1-6AFF6384D193',
        'PublicKeyId' => '60a27a4d7858d1b25a9579415c0b874c',
        'Amount'=> 200.00,
        'Description'=>'numero de orden valido',
        'CardHolder'=>'DEIVISON JIMENEZ',
        'CardHolderID'=>'15475957',
        'CardNumber'=> '5105105105105100',
        'CVC'=>'431',
        'ExpirationDate'=> '05/2026',
        'StatusId'=> '1',
        'IP'=>'200.20.20.20',
        'OrderNumber'=>'20021'





    );

    $respuesta = wp_remote_post($url, array(
        'method' => 'POST',
        'body'=> json_encode($datos),
                'header'=> array(
                    'Content_Type'=> 'application/json')
                ));

    return $respuesta;

}



=======
>>>>>>> 9982e63521184c51977645d841aa1b0541fd75b6
?>




