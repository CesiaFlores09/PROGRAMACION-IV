var db_A = openDatabase('db_A', '1.0', 'Sistema de Registro', 5 * 1024 * 1024);
        if( !db_A ){
            alert('Lo siento, el navagador no soporta BD offline');
        }
        var app = new Vue({
            el: '#appAcademica',
            data:{
                buscar:'',
                materias:[],
                alumnos:[],
                inscripciones:[],
                inscripcion:{
                    accion : 'nuevo',
                    mostrar_msg : false,
                    msg : '',
                    alumno : '',
                    materias : []
                }
            },
            methods:{
                buscandoInscripcion(){
                    this.obtenerInscripciones(this.buscar);
                },
                eliminarInscripcion(inscripcion){
                    if( confirm(`Esta seguro de eliminar la inscripcion de ${inscripcion.alumno}?`) ){
                        this.inscripcion.idInscripcion = inscripcion.idInscripcion;
                        this.inscripcion.accion = 'eliminar';
                        this.guardarInscripcion();
                    }
                },
                modificarInscripcion(datos){
                    console.log(datos);
                    this.inscripcion.accion = 'modificar';
                    this.inscripcion.idInscripcion = datos.idInscripcion;
                    this.inscripcion.alumno = datos.idAlumno;
                    this.inscripcion.idAlumno = datos.idAlumno;
                    this.inscripcion.materias = datos.idMateria;
                    this.inscripcion.nombre_alumno = datos.alumnos;
                },
                guardarInscripcion(){
                    let sql = '',
                        parametros = [];
                    if(this.inscripcion.accion=="nuevo"){
                        sql = 'INSERT INTO inscripciones (idAlumno, idMateria) VALUES (?,?)';
                        for(let i=0; i<this.inscripcion.materias.length; i++){
                            parametros.push([this.inscripcion.alumno, this.inscripcion.materias[i]]);
                        }
                    } else if(this.inscripcion.accion=="modificar"){
                        db_A.transaction(tx => {
                            tx.executeSql('DELETE FROM inscripciones WHERE idAlumno=?', [this.inscripcion.idAlumno]);
                        });
                        sql = 'INSERT INTO inscripciones (idAlumno, idMateria) VALUES (?,?)';
                        for(let i=0; i<this.inscripcion.materias.length; i++){
                            parametros.push([this.inscripcion.alumno, this.inscripcion.materias[i]]);
                        }
                    } else if(this.inscripcion.accion=="eliminar"){
                        sql = 'DELETE FROM inscripciones WHERE idAlumno=?';
                        parametros.push([this.inscripcion.idAlumno]);
                    }
                    console.log(parametros);
                    db_A.transaction(tx=>{
                        for(let i=0; i<parametros.length; i++){
                            tx.executeSql(sql, parametros[i], (tx, res)=>{
                                this.nuevaInscripcion();
                                this.obtenerAlumnos();
                                this.obtenerInscripciones();
                                this.inscripcion.mostrar_msg = true;
                                this.inscripcion.msg = 'Inscripción procesado con exito';
                            }, (tx, err)=>{
                                this.inscripcion.mostrar_msg = true;
                                this.inscripcion.msg = `Error al guardar la inscripción: ${err.message}`;
                            });
                        }
                    });
                },
                obtenerMaterias(valor=''){
                    let respuesta = db_A.transaction(tx=>{
                        tx.executeSql(`SELECT * FROM materias WHERE nombre like "%${valor}%" OR codigo like "%${valor}%" ORDER BY nombre`, [], (index, datos)=>{
                            this.materias = [];
                            for(let i=0; i<datos.rows.length; i++){
                                this.materias.push(datos.rows[i]);
                            }
                        });
                    });
                },
                obtenerAlumnos(valor=''){
                    let respuesta = db_A.transaction(tx=>{
                        tx.executeSql(`SELECT * FROM alumnos WHERE idAlumno NOT IN (SELECT idAlumno FROM inscripciones) ORDER BY nombre`, [], (index, datos)=>{
                            this.alumnos = [];
                            for(let i=0; i<datos.rows.length; i++){
                                this.alumnos.push(datos.rows[i]);
                            }
                        });
                    });
                },
                obtenerInscripciones(valor=''){
                    let respuesta = db_A.transaction(tx=>{
                        tx.executeSql(`SELECT GROUP_CONCAT(m.nombre) AS materias, GROUP_CONCAT(i.idMateria) AS idMateria, a.nombre AS alumnos, i.idAlumno FROM inscripciones i INNER JOIN materias m ON m.idMateria = i.idMateria INNER JOIN alumnos a ON a.idAlumno = i.idAlumno WHERE a.nombre like "%${valor}%" GROUP BY i.idAlumno ORDER BY a.nombre`, [], (index, datos)=>{
                            this.inscripciones = [];
                            console.log(datos);
                            for(let i=0; i<datos.rows.length; i++){
                                this.inscripciones.push(datos.rows[i]);
                            }
                            for(let i=0; i<this.inscripciones.length; i++){
                                this.inscripciones[i].materias = this.inscripciones[i].materias.split(',');
                                this.inscripciones[i].idMateria = this.inscripciones[i].idMateria.split(',');
                            }
                        });
                    });
                },
                nuevaInscripcion(){
                    this.inscripcion.accion = 'nuevo';
                    this.inscripcion.msg = '';
                    this.inscripcion.mostrar_msg = false;
                    this.inscripcion.alumno = '';
                    this.inscripcion.materias = [];
                }
            },
            created(){
                db_A.transaction(tx=>{
                    tx.executeSql('CREATE TABLE IF NOT EXISTS inscripciones (idInscripcion INTEGER PRIMARY KEY AUTOINCREMENT, idAlumno INTEGER, idMateria INTEGER, FOREIGN KEY(idAlumno) REFERENCES alumnos(idAlumno), FOREIGN KEY(idMateria) REFERENCES materias(idMateria))', [], (tx, res)=>{
                        this.obtenerInscripciones();
                    });
                }, err=>{
                    console.log(err);
                });
                this.obtenerMaterias();
                this.obtenerAlumnos();
                this.obtenerInscripciones();
            }
        });