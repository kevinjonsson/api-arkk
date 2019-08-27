<?php
class Booking{
 
    // database connection and table name
    private $conn;
    private $table_name = "booking";
 
    // object properties
    public $booking_id;
    public $number_of_guests;
    public $date;
    public $time;
    public $name;
    public $email;
    public $phone_number;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function read(){
 
    // select all query
    $query = "SELECT * FROM `booking`";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
             number_of_guests=:number_of_guests, date=:date, time=:time, name=:name, email=:email, phone_number=:phone_number";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->number_of_guests=htmlspecialchars(strip_tags($this->number_of_guests));
    $this->date=htmlspecialchars(strip_tags($this->date));
    $this->time=htmlspecialchars(strip_tags($this->time));
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->phone_number=htmlspecialchars(strip_tags($this->phone_number));
 
    // bind values
    $stmt->bindParam(":number_of_guests", $this->number_of_guests);
    $stmt->bindParam(":date", $this->date);
    $stmt->bindParam(":time", $this->time);
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":phone_number", $this->phone_number);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// update the product
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
            number_of_guests=:number_of_guests, 
            date=:date, 
            time=:time, 
            name=:name, 
            email=:email, 
            phone_number=:phone_number
            WHERE
                booking_id = :booking_id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->number_of_guests=htmlspecialchars(strip_tags($this->number_of_guests));
    $this->date=htmlspecialchars(strip_tags($this->date));
    $this->time=htmlspecialchars(strip_tags($this->time));
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->phone_number=htmlspecialchars(strip_tags($this->phone_number));
    $this->booking_id=htmlspecialchars(strip_tags($this->booking_id));
 
    // bind new values
    $stmt->bindParam(':number_of_guests', $this->number_of_guests);
    $stmt->bindParam(':date', $this->date);
    $stmt->bindParam(':time', $this->time);
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':phone_number', $this->phone_number);
    $stmt->bindParam(':booking_id', $this->booking_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE booking_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->booking_id=htmlspecialchars(strip_tags($this->booking_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->booking_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
}