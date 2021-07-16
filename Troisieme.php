<?php
    session_start();
    if(!isset($_SESSION['admin']) || !isset($_SESSION['id']))header('location:./index.php');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
     integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Quiz Questions</title>
    <style>
        select{
            min-width:300px!important;
            max-width:400px!important;
        }
        select{
            width:300px!important;
        }
        .form{
            width:100vw;
            display: flex;
            align-items: center;
            flex-direction:column;
        }
        h1,h3,h4{
            text-align:center;
            padding:2rem 0;
        }
        .question{
            margin:1rem 0;
            padding:1rem;
            text-align:center;
            border:1px solid gray;
            border-radius:10px;
            width:300px;
            max-width:300px;
        }
        h3{
            border:1px solid gray;
        }
    </style>
    <script>
        function update(el){
            var element =el.nextSibling;
            element.nextElementSibling.disabled=false;  
            var input1 =el.parentElement.previousElementSibling;
            var input2 =input1.previousElementSibling.previousElementSibling;
            input1.disabled=false;
            input2.disabled=false;
        }

    </script>
</head>
<body style="overflow-x:hidden;">
        
<div style="position:absolute;top:20px;right:20px;"><h4><a href="./actions/logout.php">Log Out</a></h4></div>
    <h1>Quiz Questions</h1>
    <h4><a href="./deuxieme.php">Create Questions</a></h4>
    <form class="form" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
        
        <div class="form-group">
            <label for="exampleFormControlSelect1">Language</label>
            <select class="form-control" id="exampleFormControlSelect1" name="choice">
                <option value="All">All</option>
                <?php

                    $con = mysqli_connect('localhost', 'root', '', 'web_quiz');
                    $sql='SELECT * FROM `langage`';
                    $res=mysqli_query($con,$sql);
                    $index=1;
                    while($row = mysqli_fetch_array($res)){
                        echo '<option value="'.$index.'">'.$row['nomlangage'].'</option>';
                        $index+=1;
                    } 
                    
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>

    </form>

    <h1 style="margin:2rem 0;">Questions</h1>
    <div style="display:grid;grid-template-columns:33% 33% 33%;margin-left:12rem;">
    <?php
        if(isset($_POST['choice'])){
            if($_POST['choice']!=="All")
                    $sql='SELECT * FROM question q, reponse r WHERE
                    q.idlangage="'.$_POST['choice'].'" AND q.noquestion = r.noquestion AND r.correct=1;';
            else{
                $sql='SELECT * FROM question q, reponse r WHERE q.noquestion = r.noquestion AND r.correct=1;';
            }
            $con = mysqli_connect('localhost', 'root', '', 'web_quiz');
            $res=mysqli_query($con,$sql);
            while($row = mysqli_fetch_array($res)){
                echo '
                <form method="GET" action="./actions/update.php">
                    <div class="question">
                        <input type="label" value='.$row['noquestion'].' id="idq"
                        style="width:50px;margin:10px 0;text-align:center;"  readonly name="idq"/><br>
                        <label for="q">Question: </label>
                        <textarea type="text" id="q" disabled name="question">'.$row['enonce'].'</textarea>
                        <label for="r">Answer: </label>
                        <textarea id="r" disabled name="reponse">'.$row['texte'].'</textarea>
                        <div style="margin:1rem 0;">
                            <button type="button" onclick="update(this)" style="margin:0 10px" class="btn btn-secondary">Update</button>
                            
                            <button type="submit" style="margin:0 10px" class="btn btn-primary" disabled>Submit</button>
                        </div>
                    </div>
                </form>
                ';
                } 
        }
        else{
            $con = mysqli_connect('localhost', 'root', '', 'web_quiz');
            $sql='SELECT * FROM question q, reponse r WHERE q.noquestion = r.noquestion AND r.correct=1;';
            $res=mysqli_query($con,$sql);
            while($row = mysqli_fetch_array($res)){
                echo '
                <form method="GET" action="./actions/update.php">
                    <div class="question">
                        <input type="label" value='.$row['noquestion'].' id="idq"
                        style="width:50px;margin:10px 0;text-align:center;"  readonly name="idq"/><br>
                        <label for="q">Question: </label>
                        <textarea type="text" id="q" disabled name="question">'.$row['enonce'].'</textarea>
                        <label for="r">Answer: </label>
                        <textarea id="r" disabled name="reponse">'.$row['texte'].'</textarea>
                        <div style="margin:1rem 0;">
                            <button type="button" onclick="update(this)" style="margin:0 10px" class="btn btn-secondary">Update</button>
                            
                            <button type="submit" style="margin:0 10px" class="btn btn-primary" disabled>Submit</button>
                        </div>
                    </div>
                </form>
                ';
                } 
        }
    ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>