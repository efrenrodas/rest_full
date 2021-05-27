<?php
#validar un ISBN pasado por get 
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['isbn']))
    {
     // validar isbn
     $isbn=$_GET['isbn'];
      $arreglo=str_split($isbn);
      $j=0;
      $s=10;
      $suma=0;
      $largo=count($arreglo);
      $largo=count($arreglo);
         for($i=$largo;$i>=1;$i-- ){
           $multiplo=$arreglo[$j]*$s;
           $j=$j+1;
           $s=$s-1;
           $suma=$multiplo+$suma;
         }

    $res=fmod($suma,11);
    if($res==0)
    {
      $isb=0;
    }
    else
    {
     $isb=$res-11;

    }
    if($isb==0 || $isb==$arreglo[$largo-1])
    {
     $chek="El isbn ".$isbn." es correcto"; 
    }
    else{
      $chek="El isbn ".$isbn." es InCorrecto"; 
    } 
      echo json_encode($chek);
      exit();
	  }
    else {
      //si no se ha enviado ISBN
      header("HTTP/1.1 400 Bad Request");
      exit();
	}
}