<?php

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Construct the Google verification API request link.
    $params = array();
    $params['secret'] = '6LcQ9S4UAAAAAIFpvWZS4-aJleleIHrQBgAvsfxt'; // Secret key
    if (!empty($_POST) && isset($_POST['g-recaptcha-response'])) {
        $params['response'] = urlencode($_POST['g-recaptcha-response']);
    }
    $params['remoteip'] = $_SERVER['REMOTE_ADDR'];

    $params_string = http_build_query($params);
    $requestURL = 'https://www.google.com/recaptcha/api/siteverify?' . $params_string;



    $response = @json_decode($response, true);

    if ($response["success"] == true) {
        echo '<h3 class="alert alert-success">Login Successful</h3>';
    } else {
        echo '<h3 class="alert alert-danger">Login failed</h3>';
    }
}

?>