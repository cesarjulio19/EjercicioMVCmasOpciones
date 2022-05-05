<?php

class Main extends Controller{

    function __construct(){
        parent::__construct();
        $this->view->datos = [];
    }
     //visualiza la tabla con todas las series
    function render(){
        session_start();
        $sesion = $_SESSION['usuario']??"";
        if($sesion == ""){
            $this->view->render('login/index');
        }else{
           $serie = $this->model->get();
           $this->view->series=$serie;
           $this->view->render('main/index');
        }

    }
     //visualiza la serie con id = x
    function verSerie($param = null){
        session_start();
        $sesion = $_SESSION['usuario']??"";

        if($sesion == ""){
            $this->view->render('login/index');
        }else{

            $idSerie = $param[0];
            $serie = $this->model->getById($idSerie);
            $generoserie = $this->model->genser($idSerie);
    
            $this->view->serie = $serie;
            $this->view->generos = $generoserie;
    
            
            $this->view->render('main/info');

        }

   }
   
    //visualiza el formulario para editar la serie
   function verEditarSerie($param = null){
       session_start();
       $sesion = $_SESSION['usuario']??"";

       if($sesion == ""){
        $this->view->render('login/index');
       }else{

        $idSerie = $param[0];
        $serie = $this->model->getById($idSerie);
        $generoserie = $this->model->genser($idSerie);

        $this->view->serie = $serie;
        $this->view->generos = $generoserie;

        
        $this->view->render('main/editar');

       }

    }

   // edita la serie y vuelve a la pagina principal
   function editarSerie(){
       session_start();
       $sesion = $_SESSION['usuario']??"";

       if($sesion == ""){
        $this->view->render('login/index');
       }else{

        $ids=$_POST['ids'];
       //echo $_POST['fecha'];
       $fecha=date('Y-m-d', strtotime($_POST['fecha']));
       $temporadas=$_POST['temporadas'];
       $puntuacion=number_format($_POST['puntuacion'], 2, '.', '');
       $argumento=$_POST['argumento'];
       //echo $fecha;
       
       if($this->model->editar($ids,$fecha,$temporadas,$puntuacion,$argumento)){
        $serie = $this->model->get();
        $this->view->series=$serie;
        $this->view->render('main/index');
       }else{
           echo "no se ha actualizado correctamente";
       }
       


       }
       
    }

    //nos manda a la pagina para gestionar los generos
   function gestionarGenero($param = null){
    session_start();
    $sesion = $_SESSION['usuario']??"";
    if($sesion == ""){
        $this->view->render('login/index');
    }else{

         $idSerie = $param[0];
         $generoserie = $this->model->genser($idSerie);
         $nogeneroserie = $this->model->noGenser($idSerie);
         $serie = $this->model->getById($idSerie);
         $this->view->nogeneros = $nogeneroserie;
         $this->view->generos = $generoserie;
         $this->view->serie = $serie;
         $this->view->render('main/generos');

       }

   }



    //elimina un genero de una serie
   function eliminarGenero($param = null){

    session_start();
    $sesion = $_SESSION['usuario']??"";

    if($sesion == ""){
        $this->view->render('login/index');
    }else{

        $idSerie = $param[1];
      $idGenero = $param[0];
      if($this->model->eliminarGen($idSerie,$idGenero)){
        $serie = $this->model->get();
        $this->view->series=$serie;
        $this->view->render('main/index');
      }else{
          echo "no se ha eliminado correctamente";
      }

    }
   }

    //añade genero existente
   function anadirGen(){

    session_start();
    $sesion = $_SESSION['usuario']??"";

    if($sesion == ""){
        $this->view->render('login/index');
    }else{

        $idSerie = $_POST['serie'];
        $idGenero = $_POST['genero'];
       if($_POST['genero']=="-1"){

        $idSerie = $_POST['serie'];
        $generoserie = $this->model->genser($idSerie);
        $nogeneroserie = $this->model->noGenser($idSerie);
        $serie = $this->model->getById($idSerie);
        $this->view->nogeneros = $nogeneroserie;
        $this->view->generos = $generoserie;
        $this->view->serie = $serie;
        $this->view->render('main/generos2');

       }else{
        $idSerie = $_POST['serie'];
        $idGenero = $_POST['genero'];
        
        if($this->model->anadirG($idSerie,$idGenero)){

            $idSerie = $_POST['serie'];
            $generoserie = $this->model->genser($idSerie);
            $nogeneroserie = $this->model->noGenser($idSerie);
            $serie = $this->model->getById($idSerie);
            $this->view->nogeneros = $nogeneroserie;
            $this->view->generos = $generoserie;
            $this->view->serie = $serie;
            $this->view->render('main/generos');

          }else{
              echo "no se ha añadido correctamente";
          }
       }

    }
   }

   //añade un nuevo genero 
   function anadirGenN(){

        session_start();
        $sesion = $_SESSION['usuario']??"";

        if($sesion == ""){
            $this->view->render('login/index');
        }else{
            $serie = $_POST['serie'];
            $genero = $_POST['nombre'];

        if($this->model->anadirGn($serie,$genero)){

            $idSerie = $_POST['serie'];
            $generoserie = $this->model->genser($idSerie);
            $nogeneroserie = $this->model->noGenser($idSerie);
            $serie = $this->model->getById($idSerie);
            $this->view->nogeneros = $nogeneroserie;
            $this->view->generos = $generoserie;
            $this->view->serie = $serie;
            $this->view->render('main/generos');
            
        }else{
            echo "no se ha añadido correctamente";
        }
        }

   }
   //añade una nueva serie
   function nuevaSerie(){
    session_start();
    $sesion = $_SESSION['usuario']??"";

    if($sesion == ""){
        $this->view->render('login/index');
    }else{

       $titulo = $_POST['titulo'];
       $fecha = $_POST['fecha'];
       $temporadas = $_POST['temporadas'];
       $plataforma = $_POST['plataforma'];
       $generos = $_POST['generos']??"";
       $poster = $_FILES['poster']['tmp_name'];
       $argumento = $_POST['argumento'];

       if($poster == null){
          $poster = "https://dummyimage.com/350x525/000/fff	";
       }else{
          $foto = $_FILES['poster']['name'];
          $ruta = $_FILES['poster']['tmp_name'];
          $destino = "fotos/".$foto;
          copy($ruta,$destino);
          $poster = "fotos/".$foto;
       }

       if($this->model->aSerie($titulo,$fecha,$temporadas,$argumento,$plataforma,$poster)){
           if($generos!=""){
            foreach ($generos as $row) {
                if($row != -1){
                    $this->model->genTit($row,$titulo);
                }
            }
    
            foreach($generos as $row){
                if($row == -1){
                    $n = $this->model->idTit($titulo);
                    header("Location: http://localhost/misseries/main/gestionarGenero/$n");
                }
            }

           }

        $serie = $this->model->get();
        $this->view->series=$serie;
        $this->view->render('main/index');


       }else{
           echo "no se ha podido añadir la serie correctamente";
       }
        
    }
       
       
   }
   //puntua la serie
   function puntuar($param = null){

    session_start();
    $sesion = $_SESSION['usuario']??"";

    if($sesion == ""){
        $this->view->render('login/index');
    }else{
        $puntuacion=number_format($_POST['puntuacion'], 2, '.', '');
        $idSerie = $param[0];
        echo  $idSerie;
        if($this->model->puntuarSerie($puntuacion,$idSerie)){
            header("Location: http://localhost/misseries/main/verSerie/$idSerie");
        }else{
            echo "no se ha podido puntuar correctamente";
        }

    }
   }
   //demuestra si la serie que has escrito existe o no
   function existeT(){
       $titulo = $_REQUEST["titulo"];
       if($this->model->existeTitulo($titulo)){
           echo "La serie ya existe, pruebe con otra.";
       }else{
           echo "";
       }
   }





   function anadir(){

    session_start();
    $sesion = $_SESSION['usuario']??"";

    if($sesion == ""){
        $this->view->render('login/index');
    }else{
        $generos = $this->model->generos();
        $this->view->generos = $generos;
        $this->view->render('main/anadirSerie');
    }

    }








}