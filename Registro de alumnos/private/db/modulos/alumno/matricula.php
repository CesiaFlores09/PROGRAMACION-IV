<?php
include('../../db/DB.php');
EXTRACT($_REQUEST);

$class_matricula =  new matricula($conexion);
$datos = isset($datos) ? $datos : '[]';
print_r(json_encode($class_matricula->$accion($datos)));

class matricula{
    private $datos=[], $db;
    public $respuesta = ['msg'=>'correcto'];

    public function matricula($db=''){
        $this->db = $db;
    }
    public function recibir_datos($matricula=''){
        $this->datos = json_decode($matricula, true);
        return $this->validar_datos();
    }
    private function validar_datos(){
        if( empty(trim($this->datos['alumno'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el alumno';
        }
        if( empty(trim($this->datos['ciclo'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese el ciclo';
        }
        if( empty(trim($this->datos['fecha_m'])) ){
            $this->respuesta['msg'] = 'Por favor ingrese la fecha de matricula';
        }
        
        return $this->almacenar_datos();
    }
    private function almacenar_datos(){
        if( $this->respuesta['msg']=='correcto' ){
            if( $this->datos['accion']=='nuevo' ){
                $this->db->consultas('INSERT INTO db_sistema_alumno.matriculas(idMatricula, alumno, ciclo, fecha_m) 
                    VALUES(?,?,?,?)',
                    $this->datos['idMatricula'], $this->datos['alumno'],$this->datos['ciclo'],
                    $this->datos['fecha_m']
                );
                return $this->db->obtenerUltimoId();
            }else if( $this->datos['accion']=='modificar' ){
                $this->db->consultas('UPDATE db_sistema_alumno.matriculas SET alumno=?, ciclo=?, fecha_m=?
                    WHERE idMatricula=?',
                    $this->datos['alumno'],$this->datos['ciclo'],
                    $this->datos['fecha_m'], $this->datos['idMatricula']
                );
                return $this->datos['idMatricula'];
            }else if( $this->datos['accion']=='eliminar' ){
                $this->db->consultas('DELETE FROM db_sistemaalumno.matriculas WHERE idMatricula=?', $this->datos['idMatricula']);
                return $this->datos['idMatricula'];
            }
        } else{
            return $this->respuesta;
        }
    }
    public function obtener_datos(){
        $this->db->consultas('SELECT * FROM db_sistema_alumno.matriculas');
        return $this->db->obtener_datos();
    }
}
?>