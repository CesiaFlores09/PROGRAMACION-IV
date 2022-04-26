var generarIdUnicoFecha = ()=>{
    let fecha = new Date();
    return Math.floor(fecha.getTime()/1000).toString(16);

}, db;
var appSistemaAcademico = new Vue({
    el: '#appSistemaAcademico',
    data: {
        forms:{
            'alumno':{mostrar:false},
            'matricula':{mostrar:false},
            'materia':{mostrar:false},
           
        }
    },
    methods: {
        abrirBd(){
           
            let indexDb = indexedDB.open('db_sistemaAcademico1', 1);
            indexDb.onupgradeneeded = e=>{
                let db = e.target.result;
                tblalumno = db.createObjectStore('alumno', {keyPath:'idAlumno'});
                tblmatricula = db.createObjectStore('matricula', {keyPath:'idMatricula'});
                tblmateria = db.createObjectStore('materia', {keyPath:'idMateria'});
               

                tblalumno.createIndex('idAlumno', 'idAlumno', {unique:true});
                tblalumno.createIndex('codigo', 'codigo', {unique:false});

                tblmatricula.createIndex('idMatricula', 'idMatricula', {unique:true});
                tblmatricula.createIndex('codigo', 'codigo', {unique:false});

                tblmateria.createIndex('idMateria', 'idmateria', {unique:true});
                tblmateria.createIndex('codigo', 'codigo', {unique:false});
            };
            indexDb.onsuccess = e=>{
                db = e.target.result;
            };
            indexDb.onerror = e=>{
                console.log(e.target.error);
            };
        },
    },
    created(){
        this.abrirBd();
    }
});
function abrirStore(store, modo){
    return db.transaction(store, modo).objectStore(store);
}
document.addEventListener('DOMContentLoaded', e=>{
    let formularios = document.querySelectorAll('.mostrar').forEach(formulario=>{
        formulario.addEventListener('click', evento=>{
            let formulario = evento.target.dataset.form;
            appSistemaAcademico.forms[formulario].mostrar = true;
            appSistemaAcademico.$refs[formulario].obtenerDatos();
        });
    });
}); 