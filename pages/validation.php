<?php include '../layout/header.php'; ?>
<?php 
// ici juste pour le test paypal je crée moi même un tableau de fruit à payer
$legume =Array(
    array(
    "name"=>"tomate",
    "price"=>50.0,
    "prixTVA"=>12.0,
    "count"=>1
   ),
    array(
    "name"=>"oignon",
    "price"=>25.5,
    "prixTVA" =>10.0,
    "count"=>2
    )
);
$total= 75.5;
$totalttc= 110.0;
$port =10.0;
$paypal = "#";
$user ="falcon91_api1.yahoo.fr";
$password ="CGUL6WWXBHZFSE4K";
$signature ="A57RPoLg7Zke0ZkYEJCGp5XiZ.niARaQplmmN87Zlcqa2CfiMFbzzIws";
//initialisation des paramètres
$params=array(
    'METHOD' => 'SetExpressCheckout',
    'VERSION' => '74.0',
    'USER'=>$user,
    'SIGNATURE'=>$signature,
    'PWD'=>$password,
    'RETURNURL'=>'http://localhost/PeterPaypal/pages/process.php',
    'CANCELURL'=>'http://localhost/PeterPaypal/pages/process.php',

    'PAYMENTREQUEST_0_AMT'=>$totalttc + $port,
    'PAYMENTREQUEST_0_CURRENCYCODE'=>'EUR',
    'PAYMENTREQUEST_0_SHIPPINGAMT' =>$port,
    'PAYMENTREQUEST_0_ITEMAMT' =>$totalttc
    );
foreach($legume as $k =>$legumes){
    $Params["L_PAYMENTREQUEST_0_NAME$k"] = $legumes['name'];
    $params["L_PAYMENTREQUEST_0_DESC$k"] = '';
    $params["PAYMENTREQUEST_0_AMT$k"] = $legumes['prixTVA'];
    $params["PAYMENTREQUEST_0_QTY$k"] = $legumes['count'];
}
// fin des paramètres
$params = http_build_query($params);
//var_dump($params); 
$endpoint ='https://api-3T.sandbox.paypal.com/nvp';
$curl =curl_init();
curl_setopt_array($curl,array(
   CURLOPT_URL => $endpoint,
   CURLOPT_POST => 1,
   CURLOPT_POSTFIELDS => $params,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_SSL_VERIFYPEER => false,
   CURLOPT_SSL_VERIFYHOST => false,
   CURLOPT_VERBOSE =>  1
));
$response = curl_exec($curl);
$responseArray = array();
parse_str($response,$responseArray);
//var_dump($responseArray);
if(curl_errno($curl)){
    //var_dump(curl_error($curl)); 
    curl_close();
    //die();
}else{
     if($responseArray['ACK'] == 'Success'){

     }else{
        var_dump($responseArray);
        //die();
     }
    
    curl_close($curl);
}
//curl_close($curl);
$paypal = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token='.$responseArray['TOKEN'];
?>
	<div class="container">
		<div class="row">
                <?php include '../layout/col-left.php'; ?>
				<div class="span9">
                    <h2>Valider mon parnier</h2>
                    <form>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Références</th>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                                <th>Total HT</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($legume as $k =>$legumes):?>
                            <tr>
                              <td><?= $legumes['name'];?></td> 
                              <td><?= $legumes['price'];?></td> 
                              <td><?= $legumes['prixTVA'];?></td> 
                              <td><?= $legumes['count'];?></td> 
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </form>
    
                <dl class="dl-horizontal pull-right">
                    <dt>Total HT :</dt>
                    <dd>799,99€</dd>
                    
                    <dt>TVA :</dt>
                    <dd>200€</dd>
    
                    <dt>Total:</dt>
                    <dd><?= $total; ?>€</dd>
                </dl>
                <div class="clearfix"></div>
                <a href="<?= $paypal ?>" class="btn btn-success pull-right">Payer</a>
            </div>
		
		</div>
	</div>
<?php include '../layout/footer.php'; ?>