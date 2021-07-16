<?php
    if(isset($_GET['reponse'])){
        $con = mysqli_connect('localhost', 'root', '', 'web_quiz');
        $sql='UPDATE reponse SET texte="'.$_GET['reponse'].'" WHERE noquestion ="'.$_GET["idq"].'" AND correct=1;';
        $res=mysqli_query($con,$sql);
        $sql2='UPDATE question SET enonce="'.$_GET["question"].'" WHERE noquestion ="'.$_GET["idq"].'";';  
        $res2=mysqli_query($con,$sql2);
        header('Location:../troisieme.php');
    }
?>