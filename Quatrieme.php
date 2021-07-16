<?php 
    session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
     integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Quiz | Quiz Setup</title>
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
    
<?php if(!isset($_SESSION['username']) || !isset($_SESSION['userid']))header('Location:./index.php'); ?>
<div style="position:absolute;top:20px;right:20px;"><h4><a href="./actions/logout.php">Log Out</a></h4></div>
    <h1>Quiz Settings</h1>
    <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
        
        <div class="form-group">
            <label for="exampleFormControlSelect1">Language Choice</label>
            <select class="form-control" id="exampleFormControlSelect1" name="choicelan">
                <option value="1">HTML</option>
                <option value="2">JavaScript</option>
                <option value="3">PHP</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="exampleFormControlSelect1">Difficulty Choice</label>
            <select class="form-control" id="exampleFormControlSelect1" name="choicedif">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
        </div>

        <a href="./Sixieme.php" style="padding-bottom:2rem;">Check user's results</a>
    
        <button type="submit" class="btn btn-primary">Start</button>

    </form>

    <?php 
        if(isset($_POST['choicedif'])){
            if($_POST['choicedif']!="1"){
                $con = mysqli_connect('localhost', 'root', '', 'web_quiz');
                $level=(int)$_POST['choicedif'] -1;
                $sqlcheck = 'SELECT MAX(note) AS n FROM test t WHERE
                idlangage="'.(int)$_POST['choicelan'].'" AND niveau="'.$level.'" AND idabonne="'.(int)$_SESSION['userid'].'";';
                $rescheck= mysqli_query($con, $sqlcheck);
                echo mysqli_num_rows($rescheck);
                while($row = mysqli_fetch_array($rescheck)){
                   $note = $row['n'];
                }
                
                if(mysqli_num_rows($rescheck)==0){
                    echo "  <script>alert('You must first pass the previous levels');</script>";
                }
                else if((int)$note<4){
                    echo "  <script>alert('You must have a grade greater than 3 In order to take this level');</script>";
                }
                else{
                    $_SESSION["langage"]=$_POST["choicelan"];
                    $_SESSION["difficulty"]=$_POST["choicedif"];
                    header('Location:./Cinquieme.php?n='.$_POST["choicedif"].'&l='.$_POST["choicelan"].'');
                }
            }
            else{
                $_SESSION["langage"]=$_POST["choicelan"];
                $_SESSION["difficulty"]=$_POST["choicedif"];
                header('Location:./Cinquieme.php?n='.$_POST["choicedif"].'&l='.$_POST["choicelan"].'');
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