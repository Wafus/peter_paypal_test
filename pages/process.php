<?php 
// ici juste pour le test paypal je crée moi même un tableau de fruit à payer
$legume =Array(
    array(
    "name"=>"tomate",
    "price"=>50.0,
    "prixTVA"=>12.0,
    "cont"=>1
   ),
    array(
    "name"=>"oignon",
    "price"=>25.5,
    "prixTVA" =>10.0,
    "cont"=>2
    )
);
$total= 100.0;
$totalttc= 110.0;
$port =10.0;
$paypal = "#";
$username= "falcon91_api1.yahoo.fr";
$password = "CGUL6WWXBHZFSE4K";
$signature ="A57RPoLg7Zke0ZkYEJCGp5XiZ.niARaQplmmN87Zlcqa2CfiMFbzzIws";

$params = array(
    'METHOD'=>'GETExpressCheckOutDetails',
    'VERSION'=>'74.0',
    'USER'=>$username,
    'TOKEN'=>$_GET['token'],
    'SIGNATURE'=>$signature,
    'PWD'=>$password,
);

$params = http_build_query($params);
$endpoint = 'https://api-3T.sandbox.paypal.com/nvp';
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $endpoint,
    CURLOPT_POST=>1,
    CURLOPT_POSTFIELDS=>$params,
    CURLOPT_RETURNTRANSFER =>1,
    CURLOPT_SSL_VERIFYPEER =>false,
    CURLOPT_SSL_VERIFYHOST =>false,
    CURLOPT_VERBOSE =>1
));
$response = curl_exec($curl);
$responseArray =array();
parse_str($response,$responseArray);

if(curl_errno($curl)){
var_dump(curl_error($curl));
curl_close($curl);
die();

}
else{
      if($responseArray['ACK'] == 'succes'){

      }else{
        //var_dump($responseArray);
        //die();
      }
    curl_close($curl);
}
var_dump($responseArray);

?>