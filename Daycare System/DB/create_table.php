<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include 'connect_to_db.php';

$db_name = 'Daycare';

$conn = get_db_connection($db_name);

// sql to create table
$table1 = "CREATE TABLE employee (
    EmployeeID INT NOT NULL AUTO_INCREMENT, 
    username VARCHAR(50) NOT NULL , 
    EmployeeFirstName VARCHAR(255) NOT NULL , 
    EmployeeLastName VARCHAR(255) NOT NULL ,
    Employee_phoneNumber TEXT NOT NULL , 
    Employee_Email VARCHAR(255) NOT NULL , 
    Employee_Address VARCHAR(255) NOT NULL , 
    Position VARCHAR(255) Not NULL, 
    Employee_Date_of_Birth DATE NOT NULL ,
    Employee_Password VARCHAR(255) NOT NULL ,
    PRIMARY KEY (EmployeeID, username) 
)";

$table2 = "CREATE TABLE Parent (
    ParentID INT NOT NULL AUTO_INCREMENT, 
    username VARCHAR(50) NOT NULL , 
    ParentFirstName VARCHAR(255) NOT NULL , 
    ParentLastName VARCHAR(255) NOT NULL ,
    Parent_email VARCHAR(255) NOT NULL , 
    Parent_Date_of_Birth DATE NOT NULL ,  
    Parent_Password VARCHAR(255) NOT NULL ,  
    PRIMARY KEY (ParentID, username)
)";

$table3 = "CREATE TABLE child (
    childID INT NOT NULL AUTO_INCREMENT,
    childFirstName VARCHAR(255) NOT NULL , 
    childLastName VARCHAR(255) NOT NULL , 
    child_sex VARCHAR(255) NOT NULL ,
    medicalRecord LONGBLOB ,
    child_Date_of_Birth DATE NOT NULL ,
    EmployeeID INT , 
    ParentID INT NOT NULL , 
    PRIMARY KEY (childID),
    FOREIGN KEY (EmployeeID) REFERENCES employee(EmployeeID),
    FOREIGN KEY (ParentID) REFERENCES Parent(ParentID)
)";

$table4 = "CREATE TABLE Shift_Schedule (
    Shift_Date DATE NOT NULL , 
    Shift_time Time NOT NULL , 
    EmployeeID INT NOT NULL ,
    MinutesWorked Time , 
    PRIMARY KEY (Shift_Date,Shift_time),
    FOREIGN KEY (EmployeeID) REFERENCES employee(EmployeeID)
)";

$tables = [$table1, $table2, $table3, $table4];
$n=1;
foreach($tables as $k => $sql)
{
    if($n==4){
        break;
    }
    echo $sql;
    echo "<br><br>";
    //$query = @$conn->query($sql);
    $query = mysqli_query($conn, $sql);
    
    if(!$query)
    {
       $errors[] = "Table $k : Creation failed ($conn->error)";
    }
    else
    {
       $errors[] = "Table $k : Creation done";
    }
    $n++;
}

if ($conn->query($sql) === TRUE) {
    echo "Tables created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();

?>