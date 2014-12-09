<?php
/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($req_fields) {

    $error = false;
    $error_fields = "";
    $request_params = $_REQUEST ;
    $required_fields = explode(",",$req_fields);

    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["status"] = false;
        $response["result"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        push(400, $response);
        $app->stop();
    }
}

/**
 * Validating email address
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["status"] = false;
        $response["result"] = 'Email '.$email.' address is not valid';
        push(400, $response);
        $app->stop();
    }
}


/**
 * Echoing json response to client
 * @param Int $status_code Http response code
 * @param Array $response Json response
 */
function push($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);
    // setting response content type to json
    $app->contentType('application/json');
    echo json_encode($response);
}

// Call this function incase apache_request_header is not working
// Authentication can only be gotten with post request
// Add line to httaccess for authorization to show
if( !function_exists('apache_request_headers') ) {
    function apache_request_headers() {
        $arh = array();
        $rx_http = '/\AHTTP_/';

        foreach($_SERVER as $key => $val) {
            if( preg_match($rx_http, $key) ) {
                $arh_key = preg_replace($rx_http, '', $key);
                // do some nasty string manipulations to restore the original letter case
                // this should work in most cases
                $rx_matches = explode('_', $arh_key);
                if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
                    foreach($rx_matches as $ak_key => $ak_val) {
                        $rx_matches[$ak_key] = ucfirst($ak_val);
                    }
                    $arh_key = implode('-', $rx_matches);
                }

                $arh[$arh_key] = $val;
            }
        }
        return( $arh );
    }
}


/**
 * Middle later authentication
 * to allow only calls from
 * same origin, i.e prevent external
 * sources from getting data from this place
 */
function originAuth(){
    /* request from the same server don't have a HTTP_ORIGIN header */
    if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
        $response = array();
        if($_SERVER['HTTP_ORIGIN'] !== 'http://'.$_SERVER['SERVER_NAME'] && APP_MODE == 'Production' ){
            $response["status"] = false ;
            $response["result"] = "Request from server " . $_SERVER['HTTP_ORIGIN'] . " is not allowed";
            push(401,$response);
            $app = \Slim\Slim::getInstance();
            $app->stop();
        }
    }
}

/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function userAuth() {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();

    global $UID ;
    global $APIKEY ;

    // Verifying Authorization Header
    if (isset($headers['AUTHORIZATION'])) {
        $user = new userModel() ;
        // get the api key
        $APIKEY =  $headers['AUTHORIZATION'];
        // validating api key
        $result = $user->isValidApiKey($APIKEY) ;
        if ($result == false) {
            // api key is not present in user table
            $response["status"] = false;
            $response["result"] = "Access Denied. Invalid Api key";
            push(401, $response);
            $app->stop();
        }else{
            $UID = $result ;
        }
    } else {
        // api key is missing in header
        $response["status"] = false;
        $response["result"] = "Api key is misssing";
        push(401, $response);
        $app->stop();
    }
}


function verifyUserId($uid){
    global $UID ;
    if($uid !== $UID){
        $app = \Slim\Slim::getInstance();
        $response["status"] = false;
        $response["result"] = "Access denied, Invalid user";
        push(401, $response);
        $app->stop();
    }
}


