<?php
 $link = mysqli_connect('localhost', 'root', '') or 
       die(mysqli_connect_errno()." : ".mysqli_connect_error());
       mysqli_query($link, "create database web_quiz") 
         or die(" Erreur de creation de base de donnees");
       mysqli_select_db($link, 'web_quiz')or die("erreur de selection BD");
 
       $req = "create table abonne(idabonne int primary key, ";
	   $req .= " nom varchar(15) not null, prenom varchar(15) not null, "; 
	   $req .= " username varchar(8) not null, password varchar(8) not null)";
	   mysqli_query($link, $req);
	   
       $req = "create table admin(idadmin int primary key, ";
	   $req .= " nom varchar(15) not null, prenom varchar(15) not null, "; 
	   $req .= " username varchar(8) not null, password varchar(8) not null)";
	   mysqli_query($link, $req);
	   
	   $req = "create table langage(idlangage int primary key, ";
	   $req .= " nomlangage varchar(15) not null)"; 
	   mysqli_query($link, $req);
	   
	   $req = "create table question(noquestion int auto_increment primary key, ";
	   $req .= " enonce varchar(60) not null, niveau tinyint(1) not null, ";
	   $req .= " idlangage int not null references langage (idlangage), "; 
	   $req .= " idadmin int not null references admin(idadmin))";
	   mysqli_query($link, $req);

	   $req = "create table reponse(noreponse int auto_increment primary key, ";
	   $req .= " texte varchar(60) not null, correct boolean not null, ";
	   $req .= " noquestion int not null references question (idquestion)) "; 
	   mysqli_query($link, $req);


	   $req = "create table test(notest int auto_increment primary key, ";
	   $req .= " note tinyint(1) not null, datetest date not null, ";
	   $req .= " idlangage int not null references langage (idlangage), "; 
	   $req .= " niveau tinyint(1) not null, idabonne int not null references abonne(idabonne))";
	   mysqli_query($link, $req);


	   mysqli_query ($link, "insert into langage values(1, 'HTML')");
	   mysqli_query ($link, "insert into langage values(2, 'JavaScript')");
	   mysqli_query ($link, "insert into langage values(3, 'PHP')");
	  

	  mysqli_query ($link, "insert into admin values(1, 'Karim', 'Karam', 'admin1', 'admin1')");
	  mysqli_query ($link, "insert into admin values(2, 'Salim', 'Salem', 'admin2', 'admin2')");

	 
	  mysqli_query ($link, "insert into abonne values(1, 'Rim', 'Karam', 'abonne1', 'abonne1')");
	  mysqli_query ($link, "insert into abonne values(2, 'Sami', 'Sam', 'abonne2', 'abonne2')");
      mysqli_query ($link, "insert into abonne values(3, 'Joe', 'Fadi', 'abonne3', 'abonne3')");
	  mysqli_query ($link, "insert into abonne values(4, 'Kamil', 'Kim', 'abonne4', 'abonne4')");
	
	  echo "bd cree";
	  mysqli_close($link);	  
?>