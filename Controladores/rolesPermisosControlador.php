<?php
include_once "../Modelos/rolesDao.php";
include_once "../Modelos/menuDao.php";
include_once "../Modelos/accionesDao.php";
include_once "../Modelos/rolAccionesDao.php";
include_once "../Modelos/rolMenuDao.php";
if(isset($_POST["key"])){
    $key=$_POST["key"];
    switch($key){
        case "obtenerRoles":
           $rDao = new RolesDao();
           echo json_encode($rDao->obtenerRoles());
        break;
        case "obtenerMenu":
            $mDao = new MenuDao();
            echo json_encode($mDao->obtenerMenu());
        break;
        case "obtenerAcciones":
            $aDao = new AccionesDao();
            echo json_encode($aDao->obtenerAcciones());
        break;
        case "insertarRol":
            //variables de objetos y auxiliares
            $rDao = new RolesDao();
            $rAccRolDao = new RolAccionesDao();
            $rMenuDao = new RolMenuDao();
            $countRolAccInser =0;
            $countRolMenuInser =0;

            //obtenemos obj rol
            $oRol= cargarObjetoRol($_POST["nombreRol"],$_POST["descRol"]);
           
            //insertamos el rol
            $insertRol = $rDao -> insertarRol($oRol);

            //si el insert da verdadero, insertamos las acciones de este nuevo rol
            if($insertRol){
                //obtenemos el max id de la tabla roles (sería el último insertado, ya que es autoincrementable 1 en 1)
                $maxIdRol= $rDao->obtenerMaxIdRol();

                //obtenemos obj acciones
                $accionesArray = $_POST["accionesArray"];
                //recorremos el objeto para insertar cada valor en tabla rol_accion
                for ($i=0; $i <count($accionesArray) ; $i++) { 
                    //cargamos obj rolAcciones
                    $oAcc = cargarObjetoRolAcciones($maxIdRol, $accionesArray[$i]);
                    //insertamos la accion index actual (0,1,2 etc)
                    $insertRolAcc= $rAccRolDao->insertarRolAcciones($oAcc);
                    //si fue exitoso
                    if($insertRolAcc){
                        //incrementamos el contador de insert hechos
                        $countRolAccInser++;
                    }else{
                        //por cualquier fallo en el insert se imprime el error
                        echo json_encode($insertRolAcc);
                        //y se detiene para que sea revisado
                        die;
                    }
                }

                //evaluamos que la cant de insertAcc sea igual al tamaño de los elementos del arrayAcc
                if($countRolAccInser == count($accionesArray)){
                    //si es igual es que todos los insert se realizaron
                    //obtenemos obj menu
                    $menuArray = $_POST["menuArray"];
                    //recorremos el objeto para insertar cada valor en tabla rol_menu
                    for ($j=0; $j <count($menuArray) ; $j++) { 
                        //cargamos obj rolMenu
                        $oMenu = cargarObjetoRolMenu($maxIdRol,$menuArray[$j]);

                        //insertamos el menu index actual (0,1,2 etc)
                        $insertRolMenu=$rMenuDao ->insertarRolMenu($oMenu);
                        //si fue exitoso
                        if($insertRolMenu){
                            //incrementamos el contador de insert hechos
                            $countRolMenuInser++;
                        }else{
                            //por cualquier fallo en el insert se imprime el error
                            echo json_encode($insertRolMenu);
                            //y se detiene para que sea revisado
                            die;
                        }
                        
                    }
                    
                    if($countRolMenuInser == count($menuArray)){
                        echo json_encode(true);
                    }
                }
             }else{
                //caso contrario mandamos el error
                echo json_encode($insertRol);
            }
           
        break;
    }
}

function cargarObjetoRol($nombre,$desc){
    $objRol = new Roles();
    $objRol->setNombreROl($nombre);
    $objRol->setDescripcionRol($desc);

    return $objRol;
}

function cargarObjetoRolAcciones($idRol,$idAccion){
    $objAcciones = new RolAcciones();
    $objAcciones->setIdRol($idRol);
    $objAcciones->setIdAccion($idAccion);

    return $objAcciones;
}

function cargarObjetoRolMenu($idRol, $idMenu){
    $objMenu = new RolMenu();
    $objMenu->setIdRol($idRol);
    $objMenu->setIdMenu($idMenu);

    return $objMenu;
}
?>