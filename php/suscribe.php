<?php
  include_once('connectdb.php');
  function chargerClasse($classe){
		require 'classes/'.$classe.'.class.php';
	}
	spl_autoload_register('chargerClasse') ;
  switch(htmlspecialchars($_POST['opt'])){
    case 'pseudo':
        $req=$bdd->prepare('SELECT count(*) as n FROM user WHERE uname=?');
        $req->execute(array(htmlspecialchars($_POST['pseudo'])));
        $data=$req->fetch();
        if($data['n']==0) echo 'ok';
        else echo 'fail';
      break;
    case 'ok':
        $u = new User();
        $u->setNom(htmlspecialchars($_POST['nom']));
        $u->setPrenom(htmlspecialchars($_POST['prenom']));
        $u->setUname(htmlspecialchars($_POST['uname']));
        $u->setPassword(sha1(md5(htmlspecialchars($_POST['password']))));
        $u->setContact(htmlspecialchars($_POST['contact']));
        $u->setEmail(htmlspecialchars($_POST['mail']));
        //$u->setPhoto("");
        $u->create($bdd);
      break;
    
    case 'connect':
        $user = new User();
        $user->setUname(htmlspecialchars($_POST['uname']));
        $user->setPassword(sha1(md5(htmlspecialchars($_POST['password']))));
        if($user->auth($bdd)==1){
          session_start();
          $_SESSION['uname']=$user->getUname();
          $_SESSION['uid']=$user->getId();
          echo 'success';
        }else{
          echo 'error';
        }
      break;
    case 'update':
        session_start();
        $user = new User();
        $user->setId($_SESSION['uid']);
        $user->read($bdd);
        if(htmlspecialchars($_POST['password']!='')){
          if($user->getPass()==sha1(md5(htmlspecialchars($_POST['password'])))){
            $user->setNom(htmlspecialchars($_POST['nom']));
            $user->setPrenom(htmlspecialchars($_POST['prenom']));
            $user->setPass(htmlspecialchars($_POST['newpass']));
            $user->setEmail(htmlspecialchars($_POST['mail']));
            $user->setUname(htmlspecialchars($_POST['uname']));
            $user->setContact(htmlspecialchars($_POST['contact']));
            $user->userUpdate($bdd, $user->getId());
            echo 'ok';
          }else{
            echo 'mdp';
          }
        }
        else{
          $user->setNom(htmlspecialchars($_POST['nom']));
          $user->setPrenom(htmlspecialchars($_POST['prenom']));
          $user->setEmail(htmlspecialchars($_POST['mail']));
          $user->setUname(htmlspecialchars($_POST['uname']));
          $user->setContact(htmlspecialchars($_POST['contact']));
          $user->userUpdate($bdd, $user->getId());
          echo 'ok';
        }

      break;
    /*case 'uppseudo':
        session_start();
        $u = new User();
        $u->setId($_SESSION['uid']);
        $u->userName($bdd);
        $req=$bdd->prepare('SELECT count(*) as n FROM user WHERE uname=? AND uname!=?');
        $req->execute(array(htmlspecialchars($_POST['pseudo']), $u->getUname()));
        $data=$req->fetch();
        if($data['n']==0) echo 'ok';
        else echo 'fail';
      break;*/
  }

?>
