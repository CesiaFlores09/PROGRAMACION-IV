var db_alumno = openDatabase('dbAlumno', '1.0', 'Sistema de Registro', 5 * 1024 * 1024);
if(!db_alumno){
    alert('Lo siento tu navegado NO soporta BD locales.');
}
var app = new Vue({
    el: '#appAlumno',
    data: {
        alumno: {
            accion: '',
            msg : '',
            idAlumno: '',
            codigo: '',
            nombre: '',
            apellido: '',
            direccion: '',
            telefono: '',
            email: '',
            fechan:'',
            matricula:'',
            idMatricula:'',
            carrera:'',
            fechai:'',

        },
    
    },
    methods: {
        guardarAlumno(){
            db_alumno.transaction(tx=>{
                tx.executeSql('INSERT INTO alumnos (codigo, nombre, apellido, direccion, telefono,email, fechan) VALUES (?,?,?,?,?,?,?)',
                [this.alumno.codigo, this.alumno.nombre, this.alumno.apellido ,this.alumno.direccion, this.alumno.telefono, 
                    this.alumno.email,this.alumno.fechan],
                (tx, results)=>{
                    this.alumno.msg = 'Alumno guardado con exito';
                    this.nuevoAlumno();
                },
                (tx, error)=>{
                    this.alumno.msg = `Error al guardar el Alumno ${error.message}`;
                });
            });
        },
        nuevoAlumno(){
            this.alumno.accion = 'nuevo';
            this.alumno.idAlumno = '';
            this.alumno.codigo = '';
            this.alumno.nombre = '';
            this.alumno.apellido = '';
            this.alumno.direccion = '';
            this.alumno.telefono = '';
            this.alumno.email = '';
            this.alumno.fechan='';
        }
    },
    created(){
        db_alumno.transaction(tx=>{
            tx.executeSql('CREATE TABLE IF NOT EXISTS alumnos (idAlumno INTEGER PRIMARY KEY AUTOINCREMENT, '+
                'codigo char(10), nombre char(75), apellido char(75), direccion TEXT, telefono char(10), email char(75), fechan date)');
        }, err=>{
            console.log('Error al crear la tabla de alumnos', err);
        });
    }
});