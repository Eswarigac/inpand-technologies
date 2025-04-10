<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Fast2SMS API Key and the number to send the SMS to
    $apiKey = "YOUR_FAST2SMS_API_KEY";  // Replace with your Fast2SMS API key
    $number = "7904483093";  // The phone number to receive the SMS

    // Compose the message
    $fullMessage = "New Contact:\nName: $name\nEmail: $email\nSubject: $subject\nMessage: $message";

    // Prepare the data to be sent to Fast2SMS API
    $data = array(
        "sender_id" => "FSTSMS",  // You can use your own sender ID if it's registered with Fast2SMS
        "message"   => $fullMessage,
        "language"  => "english",
        "route"     => "p",  // Promotional route, you can use transactional for more reliable delivery
        "numbers"   => $number,  // The number to send the SMS to
    );

    // Initialize cURL and send the request
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            "authorization: $apiKey",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
        ),
    ));

    // Execute the request
    $response = curl_exec($curl);
    $err = curl_error($curl);

    // Close the cURL connection
    curl_close($curl);

    // Handle errors or success
    if ($err) {
        echo "cURL Error #: " . $err;
    } else {
        echo "Message sent successfully!";
    }
} else {
    echo "Invalid request.";
}
?>
