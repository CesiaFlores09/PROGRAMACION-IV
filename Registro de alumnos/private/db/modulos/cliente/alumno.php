<?php
include('../../db/DB.php');
EXTRACT($_REQUEST);

$class_alumno =  new alumno($conexion);
$datos = isset($datos) ? $datos : '[]';
print_r(json_encode($class_alumno->$accion($datos)));

class alumno{
    private $datos=[], $db;
    public $respuesta = ['msg'=>'correcto'];

    public function alumno($db=''){
        $this->db = $db;
    }
    public function recibir_datos($alumno=''){
        $this->datos = json_decode($alumno, true);
        return $this->validar_datos();
    }
    private function validar_datos(){
        if( empty(trim($this->datos['Codigo'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el Codigo';
        }
        if( empty(trim($this->datos['Nombre'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el Nombre';
        }
        if( empty(trim($this->datos['Apellido'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el Apellido';
        }
        if( empty(trim($this->datos['Direccion'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese la Direccion';
        }
        if( empty(trim($this->datos['Telefono'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el Telefono';
        }
        if( empty(trim($this->datos['Email'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el Email';
        }
            if( empty(trim($this->datos['Fecha Nacimiento'])) ){
                $this->respuesta['msg'] = 'Por favor ingrese la fecha de nacimiento';
        }
        return $this->almacenar_datos();
    }
    private function almacenar_datos(){
        if( $this->respuesta['msg']=='correcto' ){
            if( $this->datos['accion']=='nuevo' ){
                $this->db->consultas('INSERT INTO db_sistema_alumno.alumnos(idalumno, Codigo, Nombre, Apellido, Direccion, Telefono, Email, Fecha Nacimiento) 
                    VALUES(?,?,?,?,?,?,?,?)',
                    $this->datos['idalumno'], $this->datos['Codigo'],$this->datos['Nombre'],$this->datos['Apellido'],
                    $this->datos['Direccion'], $this->datos['Telefono'], $this->datos['Email'], $this->datos['Fecha Nacimiento']
                );
                return $this->db->obtenerUltimoId();
            }else if( $this->datos['accion']=='modificar' ){
                $this->db->consultas('UPDATE db_sistema_alumno.alumnos SET Codigo=?, Nombre=?, Apellido=?, Direccion=?, Telefono=?, Email=?, Fecha Nacimmiento=?
                    WHERE idalumno=?',
                    $this->datos['Codigo'],$this->datos['Nombre'],$this->datos['Apellido'],
                    $this->datos['Direccion'], $this->datos['Telefono'], $this->datos['Email'], $this->datos['Fecha Nacimiento'], $this->datos['idalumno']
                );
                return $this->datos['idalumno'];
            }else if( $this->datos['accion']=='eliminar' ){
                $this->db->consultas('DELETE FROM db_sistema_alumno.alumnos WHERE idalumno=?', $this->datos['idalumno']);
                return $this->datos['idalumno'];
            }
        } else{
            return $this->respuesta;
        }
    }
    public function obtener_datos(){
        $this->db->consultas('SELECT * FROM db_sistema_alumno.alumnos');
        return $this->db->obtener_datos();
    }
}
?>