<?php

include 'dbconfig.php';
session_start();

if (isset($_POST['amount']) && is_numeric($_POST['amount'])) {
    // Include PayPal SDK
    require '../vendor/autoload.php';

    // Set up PayPal API credentials
    $clientId = 'AaX2PqUvwBDmrc9IOdEG3O4nltQkkTq3xt0M8fR_rFirlPVntATRqk748C_Ttm4yclLNRJ6u-e335L8Q';
    $clientSecret = 'AaX2PqUvwBDmrc9IOdEG3O4nltQkkTq3xt0M8fR_rFirlPVntATRqk748C_Ttm4yclLNRJ6u-e335L8Q';

    // Create PayPal API object
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential($clientId, $clientSecret)
    );

    // Set API context settings
    $apiContext->setConfig([
        'mode' => 'sandbox', // Use sandbox environment
        'log.LogEnabled' => true,
        'log.FileName' => 'PayPal.log',
        'log.LogLevel' => 'DEBUG'
    ]);

    // Create payment object
    $payment = new \PayPal\Api\Payment();
    $payment->setIntent('sale')
        ->setPayer(new \PayPal\Api\Payer(['payment_method' => 'paypal']))
        ->setTransactions([
            (new \PayPal\Api\Transaction())
                ->setAmount(new \PayPal\Api\Amount(['total' => $_POST['amount'], 'currency' => 'USD']))
        ]);

    try {
        // Create payment
        $createdPayment = $payment->create($apiContext);
        
        // Get approval link
        $approvalLink = $createdPayment->links[1]->href; // Assuming the approval link is at index 1
        
        // Return approval link
        echo json_encode(['redirect_url' => $approvalLink]);
    } catch (Exception $e) {
        // Handle error
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    // If amount is not set or not numeric
    http_response_code(400);
    echo json_encode(['error' => 'Invalid amount']);
}
?>
