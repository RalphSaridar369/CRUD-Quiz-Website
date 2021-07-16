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
        h1,h4{
            text-align:center;
            padding-top:2rem;
        }
        .container{
            display:flex;
            flex-direction:column;
            justify-content:center;
            margin-top:4rem;
        }
        .span{
            width:50%;
            margin:2rem auto;
            padding:2rem 0;
            background:rgba(255,255,255,0.8);
            padding:6rem 2rem;
            text-align:center;
            border:1px solid black;
            border-radius:30px;
            z-index:99;
            display:flex;
            flex-direction:column;
            align-items:center;
            flex:1;
        }
        .answer{
            margin:4px 0;
            width:300px;
        }
        .image-cf{
            width:20px;
            height:20px;
        }
    </style>
    <script>
    </script>
</head>
<body>
    
<?php if(!isset($_SESSION['username']) || !isset($_SESSION['userid']))header('Location:./index.php'); ?>
    <div style="position:absolute;top:20px;right:20px;"><h4><a href="./actions/logout.php">Log Out</a></h4></div>
    <h1>Quiz</h1>
    <h4><a href="./quatrieme.php" style="padding-bottom:2rem;">Back to Quiz Settings</a></h4>

    <span class="container">
        <form method="GET" action="./actions/note.php">
        <?php
            if(isset($_GET['l'])){
                $note= 0;
                $con = mysqli_connect('localhost', 'root', '', 'web_quiz');
                $sql='SELECT * FROM question q WHERE q.noquestion AND
                q.idlangage="'.$_GET['l'].'" AND q.niveau="'.$_GET['n'].'" ORDER BY RAND()  LIMIT 5;';
                $res=mysqli_query($con,$sql);
                while($row=mysqli_fetch_array($res)){
                    echo '
                    <div class="span">
                    <h3 style="padding-bottom:2rem;" name='.$row['idlangage'].'>'.htmlspecialchars($row['enonce'], ENT_COMPAT,'ISO-8859-1', true).'</h3>
                    <select name="'.$row['noquestion'].'">
                    ';
                    $sql2='SELECT * FROM reponse WHERE noquestion="'.$row['noquestion'].'";';
                    $res2=mysqli_query($con,$sql2);
                    while($row2=mysqli_fetch_array($res2)){
                        $data=htmlspecialchars($row2['texte'], ENT_COMPAT,'ISO-8859-1', true);
                        echo '<option value='.$row2['noreponse'].'>'.$data.'</option>';
                    }
                    echo'</select></div>';
                }
               echo' <button type="submit" class="btn btn-primary" style="margin:2rem 32rem;">Submit</button> ';
            }
            else{
                $con = mysqli_connect('localhost', 'root', '', 'web_quiz');
                $sql2 = 'INSERT INTO test(note,datetest,idlangage,niveau,idabonne)
                VALUES("'.$_GET['note'].'","'.date("Ymd").'","'.$_SESSION['langage'].'","'.$_SESSION['difficulty'].'","'.$_SESSION['userid'].'")';
                $res2=mysqli_query($con,$sql2);
                echo '<h4>Note Final: '.$_GET['note'].'/5</h4>'; 
            }
            ?>
        </form>
    </span>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>