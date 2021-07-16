<?php
    $con = mysqli_connect('localhost', 'root', '', 'web_quiz');
    $note=0;
    foreach($_GET as $key => $value) {
        $sql='SELECT * FROM reponse WHERE noquestion='.$key.' AND noreponse='.$value.';';
        $res = mysqli_query($con,$sql);
        $result = mysqli_fetch_row($res);
        if(htmlspecialchars($result[2], ENT_COMPAT,'ISO-8859-1', true)=="1"){
            $note+=1;
        }
        
    }  
   header('Location:../Cinquieme.php?note='.$note.'');
?>