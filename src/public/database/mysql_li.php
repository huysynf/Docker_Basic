<?php
$servername = "mysql";
$username = "root";
$password = "root";

// Create connection
$conn = null;
if(is_null($conn)){
    $conn = new mysqli($servername, $username, $password,'phpcurd');
}
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['create'])) {

   $status = createUser($_POST);
   if($status) {
       header('location: /');
       $_SESSION['message'] = "Address saved";

   }
}
function createUser($request)
{
        $name = $request['name'];
        $password = md5($request['password']);
        $address = $request['address'];
        $email = $request['email'];
        $gender = $request['gender'];
        $sql ="INSERT INTO users (name,gender,email,password,address) VALUES ('$name','$gender','$email','$password','$address')";
        return queryRaw($sql);
}

function updateUser($request){
    $id = $request['$id'];
    $name = $request['name'];
    $password = md5($request['password']);
    $address = $request['address'];
    $email = $request['email'];
    $gender = $request['gender'];
    $sql ="UPDATE info SET name='$name',email='$email',gender='$gender',$password='$password',address='$address' WHERE id=$id";
    return queryRaw($sql);
}

function delete($request){
    $id = $request['$id'];
    $sql ="DELETE FROM users WHERE id=$id";
    return queryRaw($sql);
}


function queryRaw($sql)
{
   return $GLOBALS['conn']->query($sql);
}


