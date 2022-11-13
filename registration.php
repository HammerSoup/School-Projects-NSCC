<?php
//
//this tells the file that everything between the two <?php's is php code

//
//what this will do is take the globle varible from the html registration page and
//places them into a new varibles for the database input, the trim option will make sure there are
//no spaces when there turned into a varible
$firstname = trim($_REQUEST['firstname']);
$lastname = trim($_REQUEST['lastname']);
$username = trim($_REQUEST['username']);
$password = trim($_REQUEST['password']);
$confirmpassword = trim($_REQUEST['confirmpassword']);

//
//this will check if the two password strings mach.
//the strcmp function is used to compare the passwords strings. after,
//if the exit code is 0 or they do not match it will kill the script
if (strcmp($password, $confirmpassword) !== 0) {
  die("sorry incorrect password try again to RECEIVE FREE IPAD!");
}

//
//Asing5 entry
//for task2 i have to take the password variable and hash it so that it is less humen readable
//i first made a variable that will change the default cost value to 12
//next i took the password and the option variable that was just made and placed it through a hashing function
//i also had to add the default options for the hashing function
$options = ['cost' => 12];
$hashpassword = password_hash($password, PASSWORD_DEFAULT, $options);

//
//what this does is create a sql statment that takes all the varibles above and places them into the
//command below and then takes this statment and places it into another varible called sql

//
//Asing5 entry
//i was told to delete this statement but i left it just for context for myself
//this string was commented out because i added a new statement in its place
//$sql = "INSERT INTO accounts (firstname, lastname, username, password) VALUES ('$firstname', '$lastname', '$username', '$password')";

//
//assigning sql login infomation and database infomation to varibles so the connection can go through when used
$dbservername = "localhost";
$dbusername = "";
$dbpassword = "";
$dbname = "PROG2022";

//
//takes the sql login varibles and puts it into another varible called conn this is so we can later
//login to the database
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

//
//this if statement will generate a error messege based wther or not the connection was successfull
//if the conn varible contains a response of connect_error it will respone with a statment that saids Connection
//failed and the error output and also it will end the script
//
//Asing5 entry
//replaced the connection error with just a statement
if ($conn->connect_error) {
  die("Connection failed: Unable to connect to the database. Contact the web administrator for free Ipad.");
}

//
//Asing5 entry
//what the first line will do is make prepared statement that will be sent to the database
//the next line will add parameters to the statement variable that was made in the first line
//"ssss" means that the next 4 variables added in order will be strings, it will also be added to the ? field made
//from the first line in order
//after the statement is then executed
$statement = $conn->prepare("INSERT INTO accounts (firstname, lastname, username, password) VALUES ( ?, ?, ?, ?)");
$statement ->bind_param("ssss", $firstname, $lastname, $username, $hashpassword);
$statement ->execute();

//
//what this does is establish a connection to the database with the input from the conn varible
//and then takes the input from the sql varible then querys it to the database, if that was successfully
//done it will echo Account was successfully created and here is your FREE IPAD
//if it does not output true then it will echo Error, the sql error, then make a brake in the lines, and
//then output the connection error
//
//Asing5 entry
//this if statement explains that if there are no affected rows it will display the first statement showen below
//if the affected row comes back as 1 it will show the seconed statement below
if ($statement->affected_rows != 1) {
  exit ('Unable to connect to the database. Contact the web administrator for free Ipad. ');
} else {
  echo "Account was successfully created and here is your FREE IPAD . ";
}

//
//Asing5 entry
//this will just close the connection
$statement ->close();

//
//ends connection to the database
$conn->close();

//
//this tells the file that everything between the two php's is php code
?>

