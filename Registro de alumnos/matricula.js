Vue.component('v-select-alumno',VueSelect.VueSelect);
Vue.component('matricula',{
    data:()=>{
        return {
            buscar:'',
            matriculas:[],
            matricula:{
                accion : 'nuevo',
                mostrar_msg : false,
                msg : '',
                alumno:{
                    id: '',
                    label:'',

                },
                idMatricula : '',
                alumn: '',
                ciclo: '',
                fecha_m:'',
                
            }
        }
    },
    methods:{
        buscandomatricula(){
            this.obtenermatriculas(this.buscar);
        },
        eliminarmatricula(matricula){
            if( confirm(`Esta seguro de eliminar la Matricula ${matricula.alumn}?`) ){
                this.matricula.accion = 'eliminar';
                this.matricula.idMatricula = matricula.idMatricula;
                this.guardarmatricula();
            }
            this.nuevomatricula();
        },
        modificarmatricula(datos){
            this.matricula = JSON.parse(JSON.stringify(datos));
            this.matricula.accion = 'modificar';
        },
        guardarmatricula(){
            this.obtenermatriculas();
            let matriculas = JSON.parse(localStorage.getItem('matriculas')) || [];
            if(this.matricula.accion=="nuevo"){
                this.matricula.idMatricula = generarIdUnicoFecha();
                matriculas.push(this.matricula);
            } else if(this.matricula.accion=="modificar"){
                let index = matriculas.findIndex(matricula=>matricula.idMatricula==this.matricula.idMatricula);
                matriculas[index] = this.matricula;
            } else if( this.matricula.accion=="eliminar" ){
                let index = matriculas.findIndex(matricula=>matricula.idMatricula==this.matricula.idMatricula);
                matriculas.splice(index,1);
            }
            localStorage.setItem('matriculas', JSON.stringify(matriculas));
            this.nuevomatricula();
            this.obtenermatriculas();
            this.matricula.msg = 'Matricula procesado con exito';
        },
        obtenermatriculas(valor=''){
            this.matriculas = [];
            let matriculas = JSON.parse(localStorage.getItem('matriculas')) || [];
            this.matriculas = matriculas.filter(matricula=>matricula.alumn.toLowerCase().indexOf(valor.toLowerCase())>-1);
        
            this.alumnos =[];
            let alumnos = JSON.parse(localStorage.getItem('alumnos')) || [];
            this.alumnos = alumnos.map(alumno =>{
                return{
                    id: alumno.idAlumno,
                    label: alumno.nombre,
                }
            });
        },
        nuevomatricula(){
            this.matricula.accion = 'nuevo';
            this.matricula.msg = '';
            this.matricula.idMatricula = '';
            this.matricula.alumno = '';
            this.matricula.ciclo = '';
            this.matricula.fecha_m = '';
          
        }
    },
    created(){
        this.obtenermatriculas();
    },
    template:`
        <div id="appSistema">
            <div class="card text-white" id="carmatricula">
                <div class="card text-white bg-danger">
                    Registro de matriculas

                    <button type="button" class="btn-close text-end" data-bs-dismiss="alert" data-bs-target="#carmatricula" aria-label="Close"></button>
                </div>
                <div class="card-body text-dark">
                    <form method="post" @submit.prevent="guardarmatricula" @reset="nuevomatricula">
                        <div class="row p-1">
                          <div class ="col col-md-2">
                             Alumno:

                           </div>
                          <div class ="col col-md-3">
                             <v-select-alumno v-model="matricula.alumno"
                                  :options="alumnos" placeholder ="Seleccione un Alumno"/>
                         
                            </div>

                        </div>
                        <div class="row p-1">
                        <div class="col col-md-2">Ciclo:</div>
                        <div class="col col-md-3">
                            <input title="Ingrese el ciclo" v-model="matricula.ciclo" pattern="[A-Za-zñÑáéíóúü ]{3,100}" required type="text" class="form-control">
                        </div>
                    </div>
                   
                  
                            
                       
                     
                
                        <div class="row p-1">
                        <div class="col col-md-2">Fecha Matricula:</div>
                        <div class="col col-md-3">
                            <input title="Ingrese la Fecha de Matricula" v-model="matricula.fecha_m" required type="date" class="form-control">
                        </div>
                    </div>
               
                        <div class="row p-1">
                            <div class="col col-md-5 text-center">
                                <div v-if="matricula.mostrar_msg" class="alert alert-primary alert-dismissible fade show" role="alert">
                                    {{ matricula.msg }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col col-md-5 text-center">
                               <button class="btn btn-success" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
                               <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                               <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                             </svg> Guardar</button>
                                
                                  <button class="btn btn-primary" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                  <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                  <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>Nuevo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card text-white" id="carBuscarmatricula">
                <div class="card text-white bg-danger">
                    Busqueda de matriculas

                    <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#carBuscarmatricula" aria-label="Close"></button>
                </div>
                <div class="card-body">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    Buscar: <input @keyup="buscandomatricula" v-model="buscar" placeholder="Buscar" class="form-control" type="text" >
                                </th>
                            </tr>
                            <tr>
                            
                               
                                <th>CICLO</th>
                                <th>FECHA MATRICULA</th>
                             
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in matriculas" @click='modificarmatricula( item )' :key="item.idMatricula">
                                
                                <td>{{item.ciclo}}</td>
                                <td>{{item.fecha_m}}</td>
                              
                                
                                <td>
                                    <button class="btn btn-danger" @click="eliminarmatricula(item)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                  </svg> Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `
});