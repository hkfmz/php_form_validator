<?php

$bdd=new PDO('mysql:host=localhost;dbname=espace_membre','root','');
if(isset($_POST['forminscription']))
{
      $pseudo = htmlspecialchars($_POST['pseudo']);
      $mail = htmlspecialchars($_POST['mail']);
      $mail2 = htmlspecialchars($_POST['mail2']);

      $mdp = sha1($_POST['mdp']);
      $mdp2 = sha1($_POST['mdp2']);

      $mdp = sha1($mdp);
      $mdp2 = sha1($mdp2);

     if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
     {

     	$pseudolength = strlen($pseudo);

     	$maillength=strlen($mail);
     	$mail2length=strlen($mail2);
        
if($pseudolength <= 255 )
{
      $sav=preg_match("#^[A-Za-z '-]+$#",$pseudo);
 if($sav)
 {

  if($maillength <= 255 || $mail2length <= 255)
  {
      if ($mail == $mail2)
      {
         if(filter_var($mail, FILTER_VALIDATE_EMAIL))
         {

          $reqmail = $bdd->prepare('SELECT * FROM membres WHERE mail= ?');
          $reqmail->execute(array($mail));

          $mailexiste=$reqmail->rowCount();

          if($mailexiste == 0)
          {

      	   if ($mdp == $mdp2)
              {
              	    $insertmbr= $bdd->prepare('INSERT INTO membres (pseudo, mail, motdepasse) VALUES (?,?,?)');

                   $insertmbr->execute(array($pseudo,$mail,$mdp));

                   $erreur="Nouveau membre inscrit avec success !";
              }
              else
              {
              	 $erreur="Vos mots de passe ne correspondent pas !";
              }
           }
           else
           {
              $erreur="Email déjà utilisé !";
           }

          }else{
            $erreur="Email non valide !";
          }
      }
      else
      {
      	 $erreur="Vos adresses mail ne correspondent pas !";
      }
  }
  else{
  	$erreur="Vous ne devez pas depasser 255 caractères !";
  }
          }else
          {
           $erreur="Vous ne devez pas utilisé des chiffres ou caractères indésirable comme pseudo !";
          }
 
}
else
{
$erreur="Vous ne devez pas depasser 255 caractères!";
}


}
else
{
$erreur="Tous les champs doivent être remplis !";
}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Formulaire</title>
</head>
<body style="zoom: 150%;">
   <div align="center">
   	<h2>Inscription</h2>
   	 <br><br>
   	 <form method="POST" action="">

   	 	 <table>
   	 	 <!--Nom-->
   	 	 	<tr>
   	 	 		<td align="right">
   	 	 			<label for="pseudo">Pseudo:</label>
   	 	 		</td>

   	 	 		<td>
   	 	 			<input type="text" id="pseudo" name="pseudo" placeholder="Votre pseudo" style="width: 210px;" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>">
   	 	 		</td>
   	 	 	</tr>
           <!--Mail-->
   	 	 	<tr>
   	 	 		<td align="right">
   	 	 			<label for="mail">Mail:</label>
   	 	 		</td>

   	 	 		<td>
   	 	 			<input type="email" id="mail" name="mail" placeholder="Votre mail" style="width: 210px;" value="<?php if(isset($mail)) { echo $mail; } ?>">
   	 	 		</td>
   	 	 	</tr>

   	 	 	<!--Mail2-->
   	 	 	<tr>
   	 	 		<td align="right">
   	 	 			<label for="mail2">Confirmation du mail:</label>
   	 	 		</td>

   	 	 		<td>
   	 	 			<input type="email" id="mail2" name="mail2" placeholder="Réecrire votre mail" style="width: 210px;" value="<?php if(isset($mail2)) { echo $mail2; } ?>">
   	 	 		</td>
   	 	 	</tr>

   	 	 	<!--Mot de passe-->
   	 	 	<tr>
   	 	 		<td align="right">
   	 	 			<label for="mdp">Mot de passe:</label>
   	 	 		</td>

   	 	 		<td>
   	 	 			<input type="password" id="mdp" name="mdp" placeholder="Votre mot de passe" style="width: 210px;">
   	 	 		</td>
   	 	 	</tr>

   	 	 	<!--Mot de passe 2-->
   	 	 	<tr>
   	 	 		<td align="right">
   	 	 			<label for="mdp">Confirmation mot de passe:</label>
   	 	 		</td>

   	 	 		<td>
   	 	 			<input type="password" id="mdp2" name="mdp2" placeholder="Confirmer votre mot de passe" style="width: 210px;">
   	 	 		</td>
   	 	 	</tr>
               
               <tr><br><td></td><td><br><input type="submit" value="S'inscrire" name="forminscription"></td></tr>

   	 	 </table> 	 
               
   	 </form>

    <?php if(isset($erreur))
     
     {

     	echo $erreur;
     }
     
     ?>

   </div>
</body>
</html>