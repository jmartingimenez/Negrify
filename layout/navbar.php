<nav class="blue">
  <div class="nav-wrapper container">
    <a href="./index.php" class="brand-logo left"><img src="./img/logo.png" alt="Negrify" id="logo"/></a>

    <div class="right">
      <?php
      // ----------------- USUARIO NO LOGUEADO -----------------
      if (!isset($_SESSION['user']) && !isset($_SESSION['usernoverificado'])) { ?>
        <ul id="nav-mobile" class="right hide-on-down">
        <li><a href="login.php">Iniciar sesión</a></li>
        <li><a href="registro.php">Registrarse</a></li>
        </ul>
      <?php
      }else{
        // ----------------- USUARIO LOGUEADO -----------------
        $id = (isset($_SESSION['user'])) ? $_SESSION['user'] : $_SESSION['usernoverificado'];?>

        <ul class="right">
          <li><a class="dropdown-button white-text" href="http://localhost/profile.php?id=<?php echo $id;?>" data-beloworigin="true" data-activates="dropdown1">
            <?php
            echo $id;
            ?>
            <i class="material-icons right">arrow_drop_down</i>
          </a></li>
        </ul>
        <ul id="dropdown1" class="dropdown-content">
          <li>
            <a class="blue-text" href="http://localhost/profile.php?id=<?php echo $id; ?>">
            <i class="material-icons">person</i>
            <span>Perfil</span></a>
          </li>
          <li>
            <a class="blue-text" href="http://localhost/subircancion.php">
            <i class="material-icons">add</i>
            <span>Canción</span></a>
          </li>
          <li>
            <a class="blue-text" href="http://localhost/nuevaplaylist.php">
            <i class="material-icons">add</i>
            <span>Playlist</span></a>
          </li>
          <li>
            <a class="blue-text" href="http://localhost/importarplaylist.php">
            <i class="material-icons">cloud_upload</i>
            <span>Playlist</span></a>
          </li>
          <?php
          if(isset($_SESSION["admin"])){
          echo '<li class="divider"></li>';
          echo '<li><a class="green-text" href="http://localhost/admin.php"><i class="material-icons">supervisor_account</i><span>Admin</span></a></li>';
          }?>
          <li class="divider"></li>
          <li>
            <a class="red-text" href="http://localhost/logout.php">
            <i class="material-icons">close</i>
            <span>Salir</span></a>
          </li>
        </ul>

        <!--- SEARCHBOX !----------------->
      </div>
      <div class="right hide-on-small-only">
        <div class="right" id="searchInicial">
          <i class="material-icons">search</i>
        </div>
        <div class="right" id="searchbox">
              <div class="input-field" id="inputSearch">
                <input id="search" type="search">
                <label for="search"><i class="material-icons">search</i></label>
                <i class="material-icons" id="closeSearch">close</i>
              </div>
        </div>
      <?php
      }?>
      </div>


  </div>
</nav>
