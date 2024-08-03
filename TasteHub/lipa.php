<?php
if (isset($_POST['submit'])) {
    // Retrieve the amount and phone number from the form
    $amount = $_POST['amount'];
    $phone = $_POST['phone'];

    // Configuration
    $consumerKey = '4pmVEhKGxFKS5gnDGIeMf5gZItHSKlYCPQDdbMzHU4LuvSwE'; // Replace with your actual Consumer Key
    $consumerSecret = 'P8sjimgB5mAoYVRw91KES03Kl7xkdUM1amhZkV0inkcatKgBMP47HYUbSqLKCn0C'; // Replace with your actual Consumer Secret
    $shortcode = '174379'; // Replace with your actual Shortcode
    $lipaNaMpesaOnlinePasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'; // Replace with your Lipa Na Mpesa Online Passkey
    $callbackUrl = 'https://yourdomain.com/mpesa_callback.php'; // Replace with your actual callback URL
    $timestamp = date("YmdHis");
    $password = base64_encode($shortcode . $lipaNaMpesaOnlinePasskey . $timestamp);

    // Get the OAuth token
    $oauthUrl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $credentials = base64_encode($consumerKey . ':' . $consumerSecret);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $oauthUrl);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl);
    $json_response = json_decode($curl_response);
    $access_token = $json_response->access_token;
    curl_close($curl);

    // Initiate STK Push
    $stkPushUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $headers = [
        'Authorization: Bearer ' . $access_token,
        'Content-Type: application/json'
    ];
    $data = [
        'BusinessShortCode' => $shortcode,
        'Password' => $password,
        'Timestamp' => $timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $amount,
        'PartyA' => $phone,
        'PartyB' => $shortcode,
        'PhoneNumber' => $phone,
        'CallBackURL' => $callbackUrl,
        'AccountReference' => 'TasteLogic',
        'TransactionDesc' => 'Payment for order'
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $stkPushUrl);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    // Handle the response
    $responseDecoded = json_decode($response);
    if ($responseDecoded->ResponseCode == '0') {
        $redirectUrl = "success.php"; // Redirect URL
        echo "<script>
            alert('Check Mpesa Pop Up In your Phone');
            window.location.href = '$redirectUrl'; // Redirect to success.php
        </script>";
    } else {
        echo "<script>alert('Transaction Failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lipa na Mpesa</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        body {
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #ffd700;
            padding: 1rem;
        }
        .navbar .holder1 small {
            font-weight: bold;
            color: #333;
        }
        .host {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .subhost1 {
            flex: 1;
            text-align: center;
        }
        .hero {
            font-size: 2rem;
            color: #00796b;
        }
        .subhost2 {
            flex: 1;
            display: flex;
            justify-content: center;
        }
        .card {
            width: 100%;
            max-width: 400px;
        }
        .mpesa span {
            font-size: 1.5rem;
            color: #00796b;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="holder1">
            <small>TasteLogic</small>
        </div>
    </div>
    
    <div class="subhost2">
        <div class="card mt-5 px-3 py-4">
            <div class="d-flex flex-row justify-content-around">
                <div class="mpesa"><span>Mpesa</span></div>
            </div>
            <div class="media mt-4 pl-2">
                <img src="images/mpesa.png" class="mr-3" height="75" />
                <div class="media-body">
                    <h6 class="mt-1">Enter Amount & Number</h6>
                </div>
            </div>
            <div class="media mt-3 pl-2">
                <form class="row g-3" action="" method="POST">
                    <div class="col-12">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" class="form-control" name="amount" placeholder="Enter Amount" required>
                    </div>
                    <div class="col-12">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone" placeholder="Enter Phone Number" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success" name="submit" value="submit">PAY</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
