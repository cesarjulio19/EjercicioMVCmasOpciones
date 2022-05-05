<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script>
      window.addEventListener("load",inicio);
      function inicio(){
        document.getElementById("titulo").addEventListener("keyup",existeTitulo);
      }

      function existeTitulo(e){
        var cadena = e.target.value;

        if(cadena.length==0){
          document.getElementById("error").innerHTML = "";
        }else{

          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function(){
            if(this.readyState==4 && this.status==200){
              document.getElementById("error").innerHTML = this.responseText;
            }
          }
          xhr.open("POST","<?php echo constant('URL') . 'main/existeT' ?>",true);
          xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
          xhr.send("titulo="+cadena);
        }
      }
    </script>
</head>
<body style="position : absolute;">

<div style = "margin: 50px">
<H1 style="text-align: center">mis Series</H1>

<form class="row g-4" method="post" action="<?php echo constant('URL') . 'main/nuevaSerie' ?>" enctype="multipart/form-data">

  <div class="col-md-8">
    <label for="titulo" class="form-label"><b>Título</b></label>
    <input type="text" class="form-control" id="titulo" name="titulo" required>
    <p><span id = "error" style="color: red"></span></p>
  </div>

  <div class="col-md-4">
    <label for="fecha" class="form-label"><b>Fecha de estreno</b></label>
    <input type="date" class="form-control" id="fecha" name="fecha" required>
  </div>

  <div class="col-md-3">
    <label for="temporadas" class="form-label"><b>Temporadas</b></label>
    <input type="number" class="form-control" id="temporadas" name="temporadas" value="1" min="1" required>
  </div>

  <div class="col-md-9">
    <label for="plataforma" class="form-label"><b>Plataforma</b></label>
    <select class="form-select" aria-label="Default select example" name="plataforma">
      <option value="Netflix">Netflix</option>
      <option value="HBO">HBO</option>
      <option value="Amazon Prime">Amazon Prime</option>
      <option value="Movistar">Movistar</option>
      <option value="Disney+">Disney+</option>
      <option value="Apple TV">Apple TV</option>
    </select>
  </div>
  
  <div class="col-12">
    <label for="poster" class="form-label"><b>Póster</b></label>
    <input type="file" class="form-control"  id="poster" placeholder="Selecciona archivo de imagen" name= "poster" accept="image/png, image/jpeg">
  </div>

  <div class="col-12">
    <label for="generos" class="form-label"><b>Géneros</b></label>
    <select class="form-select" multiple  name="generos[]">
    <?php
        include_once 'models/genero.php';
        foreach($this->generos as $row){
            $generos = new genero();
            $generos = $row;
                
        ?>
        <option  value="<?php echo $generos->idg?>"><?php echo $generos->genero?></option>
        <?php
         }
        ?>
        <option  value="-1">Nuevo Género</option>
    </select>
  </div>

  <div class="col-12">
  <label for="argumento" class="form-label"><b>Argumento</b></label>
  <textarea type="text" class="form-control" id="argumento" name="argumento" rows="10" required></textarea>
  </div>

  <button type="submit" class="btn btn-primary" style="width: 300px; height: 50px; margin-left: 300px">Guardar</button>

</form>

<a class="btn btn-danger btn-lg" role="button" aria-disabled="true" style="width: 300px; position: relative; top: -48px; left: 650px" href="<?php echo constant('URL') . 'main/render' ?>"><span>Cancelar</span></a>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
