<?php
include('../../db/DB.php');
EXTRACT($_REQUEST);

$class_materia =  new materia($conexion);
$datos = isset($datos) ? $datos : '[]';
print_r(json_encode($class_materia>$accion($datos)));

class materia{
    private $datos=[], $db;
    public $respuesta = ['msg'=>'correcto'];

    public function materia($db=''){
        $this->db = $db;
    }
    public function recibir_datos($materia=''){
        $this->datos = json_decode($materia, true);
        return $this->validar_datos();
    }
    private function validar_datos(){
        if( empty(trim($this->datos['alumno'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el alumno';
        }
        if( empty(trim($this->datos['materia1'])) ){
            $this->respuesta['msg'] = 'Por favor el nombre de ingrese el materia1';
        }
        if( empty(trim($this->datos['materia2'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el nombre de la fecha de materia';
        }
        if( empty(trim($this->datos['materia3'])) ){
            $this->respuesta['msg'] = 'Por favor el nombre de ingrese la  materia';
        }
        if( empty(trim($this->datos['materia4'])) ){
            $this->respuesta['msg'] = 'Por favor el nombre de ingrese la  materia';
        }
        if( empty(trim($this->datos['materia5'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el nombre de la  materia';
        }
       
        return $this->almacenar_datos();
    }
    private function almacenar_datos(){
        if( $this->respuesta['msg']=='correcto' ){
            if( $this->datos['accion']=='nuevo' ){
                $this->db->consultas('INSERT INTO db_sistema_alumno.materias(idMateria, alumno, materia1, materia2, materia3, materia4, materia5) 
                    VALUES(?,?,?,?,?,?,)',
                    $this->datos['idMateria'], $this->datos['alumno'],$this->datos['materia1'],
                    $this->datos['materia2'],$this->datos['materia3'],$this->datos['materia4'],$this->datos['materia5'],
                );
                return $this->db->obtenerUltimoId();
            }else if( $this->datos['accion']=='modificar' ){
                $this->db->consultas('UPDATE db_sistema_alumno.materias SET alumno=?, materia1=?, materia2=?, materia3=?, materia4=?, materia5=?
                    WHERE idMateria=?',
                    $this->datos['alumno'],$this->datos['materia1'],
                    $this->datos['materia2'], $this->datos['materia3'], $this->datos['materia4'],$this->datos['materia5'], $this->datos['idMateria']
                );
                return $this->datos['idMateria'];
            }else if( $this->datos['accion']=='eliminar' ){
                $this->db->consultas('DELETE FROM db_sistema_alumno.materias WHERE idMateria=?', $this->datos['idMateria']);
                return $this->datos['idMateria'];
            }
        } else{
            return $this->respuesta;
        }
    }
    public function obtener_datos(){
        $this->db->consultas('SELECT * FROM db_sistema_alumno.materias');
        return $this->db->obtener_datos();
    }
}
?>