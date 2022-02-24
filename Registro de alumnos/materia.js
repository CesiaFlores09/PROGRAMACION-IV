var db_A = openDatabase('db_A', '1.0', 'Sistema de Registro', 5 * 1024 * 1024);
        if( !db_A ){
            alert('Lo siento, el navagador no soporta BD offline');
        }
        var app = new Vue({
            el: '#appMateria',
            data:{
                buscar:'',
                dias: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],
                materias:[],
                materia:{
                    accion : 'nuevo',
                    mostrar_msg : false,
                    msg : '',
                    codigo : '',
                    nombre : '',
                    docente : '',
                    de : '',
                    a : '',
                    dia : '',
                    aula : ''
                }
            },
            methods:{
                buscandoMateria(){
                    this.obtenerMaterias(this.buscar);
                },
                eliminarMateria(materia){
                    if( confirm(`Esta seguro de eliminar el materia ${materia.nombre}?`) ){
                        this.materia.idMateria = materia.idMateria;
                        this.materia.accion = 'eliminar';
                        this.guardarMateria();
                    }
                },
                modificarMateria(datos){
                    this.materia = JSON.parse(JSON.stringify(datos));
                    this.materia.accion = 'modificar';
                },
                guardarMateria(){
                    let sql = '',
                        parametros = [];
                    if(this.materia.accion=="nuevo"){
                        sql = 'INSERT INTO materias (codigo, nombre, docente, de, a, dia, aula) VALUES (?,?,?,?,?,?,?)';
                        parametros = [this.materia.codigo, this.materia.nombre, this.materia.docente, this.materia.de, 
                            this.materia.a, this.materia.dia, this.materia.aula];
                    } else if(this.materia.accion=="modificar"){
                        sql = 'UPDATE materias SET codigo=?, nombre=?, docente=?, de=?, a=?, dia=?, aula=? WHERE idMateria=?';
                        parametros = [this.materia.codigo, this.materia.nombre, this.materia.docente, this.materia.de, 
                            this.materia.a, this.materia.dia, this.materia.aula, this.materia.idMateria];
                    } else if(this.materia.accion=="eliminar"){
                        sql = 'DELETE FROM materias WHERE idMateria=?';
                        parametros = [this.materia.idMateria];
                    }
                    console.log(sql, parametros);
                    db_A.transaction(tx=>{
                            tx.executeSql(sql,
                            parametros,
                            (tx, res)=>{
                                this.nuevaMateria();
                                this.obtenerMaterias();
                                this.materia.mostrar_msg = true;
                                this.materia.msg = 'Materia procesado con exito';
                            },
                            (tx, err)=>{
                                this.materia.mostrar_msg = true;
                                this.materia.msg = `Error al guardar la materia: ${err.message}`;
                            });
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
                nuevaMateria(){
                    this.materia.accion = 'nuevo';
                    this.materia.msg = '';
                    this.materia.mostrar_msg = false;
                    this.materia.codigo = '';
                    this.materia.nombre = '';
                    this.materia.docente = '';
                    this.materia.de = '';
                    this.materia.a = '';
                    this.materia.dia = '';
                    this.materia.aula = '';
                }
            },
            created(){
                db_A.transaction(tx=>{
                    tx.executeSql('CREATE TABLE IF NOT EXISTS materias(idMateria INTEGER PRIMARY KEY AUTOINCREMENT, codigo char(10), nombre char(100), docente char(100), de char(100), a char(100), dia char(100), aula char(100))');
                }, err=>{
                    console.log(err);
                });
                this.obtenerMaterias();
            }
        });