<?php
    session_start();
    if(!isset($_SESSION['username']) || !isset($_SESSION['userid']))header('location:./Premiere.php');
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
     integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Quiz | <?php echo $_SESSION['username']."'s" ?> Results</title>
    <style>
        h1{
            text-align:center;
            padding-top:2rem;
            padding-bottom:1rem;
        }
        .table{
            width:80vw!important;
            margin:auto;
        }
        a{
            padding:auto;
        }
        .link{
            text-align:center;
            margin:1rem 0;
            padding-bottom:10rem;
        }
        body{
            height: 100vh; 
            background: linear-gradient(to right,  rgba(0,0,0,0), rgba(255,255,255,1)), url("./bg2.jpg") no-repeat center; 
            background-size: cover; 
        }
    </style>
</head>
<body>

<div style="position:absolute;top:20px;right:20px;"><h4><a href="./actions/logout.php">Log Out</a></h4></div>
    <h1>Results</h1>
    <div class="link">
        <a href="./Quatrieme.php">Go back to Quiz Settings</a>
    </div>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">Test Id</th>
            <th scope="col">Test Date</th>
            <th scope="col">Language</th>
            <th scope="col">Difficulty</th>
            <th scope="col">Grade</th>
            </tr>
        </thead>
        <tbody>
    <?php

        $con = mysqli_connect('localhost', 'root', '', 'web_quiz');
        $sql = 'SELECT `idabonne` FROM `abonne` WHERE username="'.$_SESSION['username'].'"';
        $res=mysqli_query($con,$sql);

        while($row=mysqli_fetch_array($res)) $num=$row[0];

        $sql2='SELECT * FROM abonne As a, test AS t, langage AS l WHERE t.idabonne="'.$_SESSION['userid'].'" AND t.idlangage=l.idlangage GROUP BY t.notest; ';
        $res2=mysqli_query($con,$sql2);

        while($row2=mysqli_fetch_array($res2)){
           echo' <tr>
                <th scope="row">'.$row2['notest'].'</th>
                <td>'.$row2['datetest'].'</td>
                <td>'.$row2['nomlangage'].'</td>
                <td>'.$row2['niveau'].'/3</td>
                <td>'.$row2['note'].'/5</td>
            </tr>';
        }
        echo '</tbody></table>';
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>