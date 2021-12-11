<?php
include 'activoFijo.php';

class Activo_fijo_informacion{
    private $con;

    public function __construct(){
    }

    public function conectar(){
        $serverName = "DESKTOP-VAIT65I\SQLEXPRESS";
        $basedatos="ACTIVO";
        try{
           
            //DECLARANDO CANEDA DE CONEXION
            $this->con = new PDO("sqlsrv:Server=$serverName;Database=$basedatos","","");
            
            //preparamos a la libreria PDO para mandar
            //excepsiones en caso de errores
            $this->con->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        }catch(PDOException $error){
            //MOSTRANDO ERROR
            echo $error->getMessage();
        }
    
    }

    public function desconectar($respuesta){
        $this->con=null;
        $respuesta->closeCursor();//dependiendo de la lib es obligatorio o no.
        $respuesta=null;
    }

    public function prueba(){
        $this->conectar();
        $sql = "SELECT *FROM Activo";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute();
            $data = $respuesta->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    // public function mostrarActivoFijoInfo(){
    //     $this->conectar();
    //     $sql = "SELECT a.*, b.tipo_activo_nombre as nombre_activo FROM Activo a 
    //     INNER JOIN Tipo_Activo b 
    //     ON a.Activo_tipo = b.tipo_activo_id
    //     ";
    //     $respuesta = $this->con->prepare($sql);
    //     $tabla = "
    //     <table id='activoInformacion' name='activoInformacion' class='table table-striped dt-responsive nowrap' style='width:100%; text-align: center'>
    //     <thead>
    //         <tr>
    //             <th>Id</th>
    //             <th>Empresa</th>
    //             <th>Departamento</th>
    //             <th>F.F.</th>
    //             <th>Área</th>
    //             <th>Tipo de activo</th>
    //             <th>Referencia</th>
    //             <th>Serie</th>
    //             <th>Descripción</th>
    //             <th>Responsable</th>
    //             <th>Fecha de compra</th>
    //             <th>Fecha de adquisición</th>
    //             <th>Fecha de caducación</th>
    //             <th>Opciones</th>
    //         </tr>
    //     </thead>
    //     <tbody>
    //     ";
    //     try{
    //         $respuesta->execute();
    //         while($fila = $respuesta->fetch(PDO::FETCH_ASSOC)){
    //             $tabla .= "<tr>";
    //             $tabla .= "<td>".$fila["Activo_id"]."</td>";
    //             $tabla .= "<td>".$fila["Empresa_id"]."</td>";
    //             $tabla .= "<td>".$fila["Estructura1_id"]."</td>";
    //             $tabla .= "<td>".$fila["Estructura2_id"]."</td>";
    //             $tabla .= "<td>".$fila["Estructura3_id"]."</td>";
    //             $tabla .= "<td>".$fila["nombre_activo"]."</td>";
    //             $tabla .= "<td>".$fila["Activo_referencia"]."</td>";
    //             $tabla .= "<td>".$fila["numero_serie"]."</td>";
    //             $tabla .= "<td>".$fila["Activo_descripcion"]."</td>";
    //             $tabla .= "<td>".$fila["Responsable_codigo"]."</td>";
    //             $tabla .= "<td>".$fila["fecha_compra"]."</td>";
    //             $tabla .= "<td>".$fila["Activo_fecha_adq"]."</td>";
    //             $tabla .= "<td>".$fila["Activo_fecha_caduc"]."</td>";
    //             $tabla .= "<td>".
    //                             "<button type='button' class='btn btn-info'>Modificar 
    //                             <span class='btn-icon-right'><i class='fa fa-pencil'></i></span>
    //                             </button>"." ".
    //                             "<button type='button' class='btn btn-success'>Historial 
    //                             <span class='btn-icon-right'><i class='fa fa-history'></i></span>
    //                             </button>"." ".
    //                             "<button type='button' class='btn btn-danger'>Eliminar 
    //                             <span class='btn-icon-right'><i class='fa fa-close'></i></span>
    //                             </button>"
    //                     ."</td>";
    //             $tabla .= "</tr>";
    //         }
    //         $tabla .= "
    //         </tbody>
    //         <tfoot>
    //             <tr>
    //             <th>Id</th>
    //             <th>Empresa</th>
    //             <th>Departamento</th>
    //             <th>F.F.</th>
    //             <th>Área</th>
    //             <th>Tipo de activo</th>
    //             <th>Referencia</th>
    //             <th>Serie</th>
    //             <th>Descripción</th>
    //             <th>Responsable</th>
    //             <th>Fecha de compra</th>
    //             <th>Fecha de adquisición</th>
    //             <th>Fecha de caducación</th>
    //             <th>Opciones</th>
    //             </tr>                             
    //         </tfoot>
    //         </table>
    //         ";
    //         return $tabla;
    //     }catch(PDOException $error){
    //         return $error->getMessage();
    //     }
    // }

}

?>