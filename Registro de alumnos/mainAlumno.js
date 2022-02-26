var generarIdUnicoFecha = ()=>{
    let fecha = new Date();
    return Math.floor(fecha.getTime()/1000).toString(16);
};
var appSistemaAcademico = new Vue({
    el: '#appSistemaAcademico',
    data: {
        forms:{
            'alumno':{mostrar:false},
            'matricula':{mostrar:false},
            'materia':{mostrar:false},
            
            
        }
    },
});
document.addEventListener('DOMContentLoaded', e=>{
    let formularios = document.querySelectorAll('.mostrar').forEach(formulario=>{
        formulario.addEventListener('click', evento=>{
            let formulario = evento.target.dataset.form;
            appSistemaAcademico.forms[formulario].mostrar = true;
        });
    });
});