<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/booking.php';
 
// instantiate database and booking object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$booking = new Booking($db);
 
// query bookings
$stmt = $booking->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // bookings array
    $bookings_arr=array();
    $bookings_arr["bookings"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $booking_object=array(
            "booking_id" => $booking_id,
            "number_of_guests" => $number_of_guests,
            "date" => $date,
            "time" => $time,
            "name" => $name,
            "email" => $email,
            "phone_number" => $phone_number
        );
 
        array_push($bookings_arr["bookings"], $booking_object);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show bookings data in json format
    echo json_encode($bookings_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no bookings found
    echo json_encode(
        array("message" => "No bookings found.")
    );
}
?>