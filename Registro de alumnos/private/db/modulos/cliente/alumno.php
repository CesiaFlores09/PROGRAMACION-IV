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
        if( empty(trim($this->datos['codigo'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el codigo';
        }
        if( empty(trim($this->datos['nombre'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el nombre';
        }
        if( empty(trim($this->datos['direccion'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese la direccion';
        }
        if( empty(trim($this->datos['telefono'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el telefono';
        }
            if( empty(trim($this->datos['fecha_nacimiento'])) ){
                $this->respuesta['msg'] = 'Por favor ingrese la fecha de nacimiento';
        }
        return $this->almacenar_datos();
    }
    private function almacenar_datos(){
        if( $this->respuesta['msg']=='correcto' ){
            if( $this->datos['accion']=='nuevo' ){
                $this->db->consultas('INSERT INTO db_sistema_alumno.alumnos(idalumno, codigo, nombre, direccion, telefono, fecha_nacimiento) 
                    VALUES(?,?,?,?,?,?,)',
                    $this->datos['idalumno'], $this->datos['codigo'],$this->datos['nombre'],
                    $this->datos['direccion'], $this->datos['telefono'], $this->datos['fecha_nacimiento']
                );
                return $this->db->obtenerUltimoId();
            }else if( $this->datos['accion']=='modificar' ){
                $this->db->consultas('UPDATE db_sistema_alumno.alumnos SET codigo=?, nombre=?, direccion=?, telefono=?, Fecha Nacimmiento=?
                    WHERE idalumno=?',
                    $this->datos['codigo'],$this->datos['nombre'],
                    $this->datos['direccion'], $this->datos['telefono'], $this->datos['fecha_nacimiento'], $this->datos['idalumno']
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