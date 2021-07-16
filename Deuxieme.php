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
    <title>Quiz | Question Creation</title>
    <style>
        input,select, .input-group{
            min-width:300px!important;
            max-width:400px!important;
        }
        .input-group{
            margin:2rem 0;
        }
        select{
            width:300px!important;
        }
        h4{
            text-align: center;
        }
        .answer{
            margin:2px 0;
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
        .input-container{
            margin:1rem 0;
        }
    </style>
</head>
<body style="overflow-x :hidden">
<div style="position:absolute;top:20px;right:20px;"><h4><a href="./actions/logout.php">Log Out</a></h4></div>
<?php if(!isset($_SESSION['admin']) || !isset($_SESSION['id'])){
        header('Location:./index.php');
    }

    ?>
    <h1>Question Creation</h1>
    <h4><a href="./troisieme.php">Modify Questions</a></h4>
    <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" style="margin:2rem 5rem;display:grid;grid-template-columns:50% 50%">
        
        <div style="">
            <div class="form-group">
                <label for="exampleFormControlSelect1">Language</label>
                <select class="form-control" id="exampleFormControlSelect1" name="choicelan">
                <?php
            
                    $con=mysqli_connect('localhost', 'root', '', 'web_quiz');
                    $sql='SELECT * FROM `langage`';
                    $res=mysqli_query($con,$sql);
                    $index=1;
            
                    if(isset($_GET['langage'])){
                        while($row = mysqli_fetch_array($res)){
                            if($_GET['langage']==$index){
                                echo '<option value="'.$index.'" selected>'.$row['nomlangage'].'</option>';
                                $index+=1;
                            }
                            else{
                                echo '<option value="'.$index.'">'.$row['nomlangage'].'</option>';
                                $index+=1;
                            }
                        }
                    }
                    else{
                        while($row = mysqli_fetch_array($res)){
                            echo '<option value="'.$index.'">'.$row['nomlangage'].'</option>';
                            $index+=1;
                        }
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Difficulty</label>
                <select class="form-control" id="exampleFormControlSelect1" name="choicedif">
                    <?php
                        if(isset($_GET['niveau'])){
                            for($i=1;$i<4;$i++){
                                if($_GET['niveau']==$i)echo
                                    '<option value="'.$i.'" selected>'.$i.'</option>';
                                else echo
                                '<option value="'.$i.'">'.$i.'</option>';
                            }
                        }
                        else{
                            for($i=1;$i<4;$i++){
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Question</span>
                </div>
                <textarea class="form-control" aria-label="With textarea" name="question" required></textarea>
            </div>
        </div>
        
        <div>
            
            <div class="form-group" style="display:flex;flex-direction:column;">
                <div class="input-container" style="display:flex;">
                    <input type="text" class="form-control answer" id="exampleInputtext1"
                     placeholder="Answer" name="answer1" required> <input type="radio" name="pressed" value="1"/>
                </div>
                <div class="input-container" style="display:flex;">
                    <input type="text" class="form-control answer" id="exampleInputtext1"
                     placeholder="Answer" name="answer2" required> <input type="radio" name="pressed" value="2"/>
                </div>
                <div class="input-container" style="display:flex;">
                    <input type="text" class="form-control answer" id="exampleInputtext1"
                     placeholder="Answer" name="answer3" required> <input type="radio" name="pressed" value="3"/>
                </div>
                <div class="input-container" style="display:flex;">
                    <input type="text" class="form-control answer" id="exampleInputtext1"
                     placeholder="Optional Answer" name="answer4" value=""> <input type="radio" name="pressed" value="4"/>
                </div>
                <div class="input-container" style="display:flex;">
                    <input type="text" class="form-control answer" id="exampleInputtext1"
                     placeholder="Optional Answer" name="answer5" value=""> <input type="radio" name="pressed" value="5"/>
                </div>
            </div>
        </div>

        <?php

            if(isset($_POST['question'])){

                $con = mysqli_connect('localhost', 'root', '', 'web_quiz');
                $que=$_POST['question'];
                $lan=$_POST['choicelan'];
                $sql='INSERT INTO `question`(`enonce`,`niveau`,`idlangage`,`idadmin`)
                VALUES("'.mysqli_real_escape_string($con,$que).'","'.$_POST['choicedif'].'","'.$lan.'","'.$_SESSION['id'].'")';
                $res=mysqli_query($con,$sql); 
                echo '<script>alert("question added");</script>';

                $sql2='SELECT MAX(`noquestion`) FROM `question`';
                $res2=mysqli_query($con,$sql2); 

                while($row=mysqli_fetch_array($res2)) $num=$row[0];


                for($i=1;$i<6;$i++){
                    $pressed=0; 
                    if(isset($_POST['pressed']) && (int)$_POST['pressed'] == $i)$pressed=1;
                    if($_POST['answer'.$i]!=""){
                        $sql2='INSERT INTO `reponse`(`texte`,`correct`,`noquestion`) 
                        VALUES("'.mysqli_real_escape_string($con,$_POST['answer'.$i]).'","'.$pressed.'","'.(int)$num.'")';
                        $res=mysqli_query($con,$sql2); 
                        $pressed=0;
                    }
                    header('Location:Deuxieme.php?niveau='.$_POST["choicedif"].'&langage='.$_POST["choicelan"].'');
                }

            }
        ?>
    
        <button type="submit" class="btn btn-primary" style="width:200px">Submit</button>

    </form>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>