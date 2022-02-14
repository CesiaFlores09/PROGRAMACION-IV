var db_A = openDatabase('db_A', '1.0', 'Sistema de Registro', 5 * 1024 * 1024);
if(!db_A){
    alert('Lo siento tu navegado NO soporta BD locales.');
}
var app = new Vue({
    el: '#appMateria',
    data: {
        inscripciones:[],
        buscar:'',
        inscripcion: {
            accion: 'nuevo',
            msg : '',
            idInscripcion: '',
            codigo: '',
            nombre:'',
            nombrem1: '',
            nombrem2: '',
            nombrem3: '',
            fechai:'',
         

        },
    
    },
    methods: {
        buscarInscripcion(){
        
            this.obtenerInscripciones(this.buscar);
        },

        guardarInscripciones(){
            let sql = '',
            parametros = [];
        if(this.inscripcion.accion == 'nuevo'){
            sql = 'INSERT INTO inscripciones (codigo, nombre, nombrem1, nombrem2, nombrem3, fechai) VALUES (?,?,?,?,?,?)';
            parametros = [this.inscripcion.codigo, this.inscripcion.nombre,this.inscripcion.nombrem1,this.inscripcion.nombrem2,this.inscripcion.nombrem3,this.inscripcion.fechai];
        }else if(this.inscripcion.accion == 'modificar'){
            sql = 'UPDATE inscripciones SET codigo=?, nombre=?, nombrem1=?, nombrem2=?, nombrem3=?, fechai=? WHERE idInscripcion=?';
            parametros = [this.inscripcion.codigo,this.inscripcion.nombre,this.inscripcion.nombrem1,this.inscripcion.nombrem2,this.inscripcion.nombrem3,this.inscripcion.fechai,this.inscripcion.idInscripcion];
        }else if(this.inscripcion.accion == 'eliminar'){
            sql = 'DELETE FROM inscripciones WHERE idInscripcion=?';
            parametros = [this.inscripcion.idInscripcion];
        }
        db_A.transaction(tx=>{
            tx.executeSql(sql,
                parametros,
            (tx, results)=>{
                this.inscripcion.msg = 'Inscripcion procesada con exito';
                this.nuevaInscripcion();
                this.obtenerInscripciones();
            },
            (tx, error)=>{
                switch(error.code){
                    case 6:
                        this.inscripcion.msg='El codigo de incripcion ya existe, por favor digite otro ';
                    
                        break;
                       
                    default:
                        this.inscripcion=`Error al procesar la inscripcion: ${error.message}`;

                }
                
            });
        });
    },
    modificarInscripcion(data){
        this.inscripcion = data;
        this.inscripcion.accion = 'modificar';
    },
    eliminarInscripcion(data){
        if( confirm(`¿Esta seguro de eliminar la inscripcion de ${data.nombre}?`) ){
            this.inscripcion.idInscripcion = data.idInscripcion;
            this.inscripcion.accion = 'eliminar';
            this.guardarInscripciones();
        }
    },
    obtenerInscripciones(busqueda=''){
        db_A.transaction(tx=>{
            tx.executeSql(`SELECT * FROM inscripciones WHERE codigo like "%${busqueda}%" OR nombre like "%${busqueda}%"`, [], (tx, results)=>{
                this.inscripciones = results.rows;
             
            });
        });
    },
        nuevaInscripcion(){
            this.inscripcion.accion = 'nuevo';
            this.inscripcion.idInscripcion = '';
            this.inscripcion.codigo = '';
            this.inscripcion.nombre= '';
            this.inscripcion.nombrem1 = '';
            this.inscripcion.nombrem2 = '';
            this.inscripcion.nombrem3 = '';
            this.inscripcion.fechai = '';
           
            console.log(this.inscripcion)
        }
    },
    created(){
        db_A.transaction(tx=>{
            tx.executeSql('CREATE TABLE IF NOT EXISTS inscripciones (idInscripcion INTEGER PRIMARY KEY AUTOINCREMENT, '+
                'codigo char(10) unique, nombre char(75),nombrem1 char(75), nombrem2 char(75), nombrem3 char(75), fechai date)');
        }, err=>{
            console.log('Error al crear la tabla de inscripcion', err);
        });
        this.obtenerInscripciones();
    }
});