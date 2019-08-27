<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';
 
// instantiate booking object
include_once '../objects/booking.php';
 
$database = new Database();
$db = $database->getConnection();
 
$booking = new Booking($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->number_of_guests) &&
    !empty($data->date) &&
    !empty($data->time) &&
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->phone_number)
){
 
    // set booking property values
    $booking->number_of_guests = $data->number_of_guests;
    $booking->date = $data->date;
    $booking->time = $data->time;
    $booking->name = $data->name;
    $booking->email = $data->email;
    $booking->phone_number = $data->phone_number;
    
 
    // create the booking
    if($booking->create()){

        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => $db->lastInsertId()));
    }   
 
    // if unable to create the booking, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create booking."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create booking. Data is incomplete."));
}
?>