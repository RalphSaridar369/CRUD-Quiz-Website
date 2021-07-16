<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
     integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Quiz | Login</title>
    <style>
        input,select{
            min-width:300px!important;
            max-width:400px!important;
        }
        select{
            width:300px!important;
        }
        form{
            width:100vw;
            display: flex;
            align-items: center;
            flex-direction:column;
        }
        h1{
            text-align:center;
            padding-top:2rem;
            padding-bottom:10rem;
        }
        body{
            height: 100vh; 
            background: linear-gradient(to right,  rgba(0,0,0,0), rgba(255,255,255,1)), url("./bg.jpg") no-repeat center; 
            background-size: cover; 
        }
    </style>
</head>
<body>

    <h1>Login Page</h1>
    <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
        
        <div class="form-group">
            <label for="exampleFormControlSelect1">Sign in as:</label>
            <select class="form-control" id="exampleFormControlSelect1" name="choice">
                <option value="user" selected>User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control" id="exampleInputUsername1"
             aria-describedby="usernameHelp" placeholder="Username" name="username" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
        </div>
    
        <button type="submit" class="btn btn-primary">Login</button>

    </form>

    <?php
        if(isset($_POST['username'])){
            $con = mysqli_connect('localhost', 'root', '', 'web_quiz');
            if($_POST['choice'] =="admin"){
                $sql='SELECT count(*) FROM `admin` WHERE `username`="'.$_POST['username'].'" AND `password`="'.$_POST['password'].'"';
	            $res=mysqli_query($con,$sql);     
	            $numberRows=mysqli_fetch_row($res);
                $data=mysqli_fetch_assoc($res);

	            if($numberRows[0]=="1"){
                    $sql='SELECT * FROM `admin` WHERE `username`="'.$_POST["username"].'" AND `password`="'.$_POST["password"].'"';
                    $res=mysqli_query($con,$sql);
                    $data=mysqli_fetch_assoc($res);
                  
                    $_SESSION["admin"]=$data["username"];
                    $_SESSION["id"]=$data["idadmin"];
                    header("location:./Deuxieme.php");
                    exit();
                }
                else{
                    echo '<script>alert("error in username/password");</script>';
                }
            }
            if($_POST['choice']=="user"){
                $sql='SELECT count(*) FROM `abonne` WHERE `username`="'.$_POST['username'].'" AND `password`="'.$_POST['password'].'"';
	            $res=mysqli_query($con,$sql);     
	            $numberRows=mysqli_fetch_row($res);
    
	            if($numberRows[0]>0){
                    $sql='SELECT * FROM `abonne` WHERE `username`="'.$_POST["username"].'" AND `password`="'.$_POST["password"].'"';
                    $res=mysqli_query($con,$sql);
                    $data=mysqli_fetch_assoc($res);
                    $_SESSION["username"]=$data["username"];
                    $_SESSION["userid"]=$data["idabonne"];
                    header("location:./Quatrieme.php");
                    exit();
            
                }
                else{
                    echo '<script>alert("error in username/password");</script>';
                }
            }
            
        }
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>