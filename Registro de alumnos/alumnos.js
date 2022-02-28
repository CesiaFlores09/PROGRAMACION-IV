Vue.component('alumno',{
    data:()=>{
        return {
            buscar:'',
            alumnos:[],
            alumno:{
                accion : 'nuevo',
                mostrar_msg : false,
                msg : '',
                idAlumno : '',
                codigo: '',
                nombre: '',
                direccion: '',
                telefono: '',
                fecha_nacimiento:'',
            }
        }
    },
    methods:{
        buscandoAlumno(){
            this.obtenerAlumnos(this.buscar);
        },
        eliminarAlumno(alumno){
            if( confirm(`Esta seguro de eliminar el alumno ${alumno.nombre}?`) ){
                this.alumno.accion = 'eliminar';
                this.alumno.idAlumno = alumno.idAlumno;
                this.guardarAlumno();
            }
            this.nuevoAlumno();
        },
        modificarAlumno(datos){
            this.alumno = JSON.parse(JSON.stringify(datos));
            this.alumno.accion = 'modificar';
        },
        guardarAlumno(){
            this.obtenerAlumnos();
            let alumnos = JSON.parse(localStorage.getItem('alumnos')) || [];
            if(this.alumno.accion=="nuevo"){
                this.alumno.idAlumno = generarIdUnicoFecha();
                alumnos.push(this.alumno);
            } else if(this.alumno.accion=="modificar"){
                let index = alumnos.findIndex(alumno=>alumno.idAlumno==this.alumno.idAlumno);
                alumnos[index] = this.alumno;
            } else if( this.alumno.accion=="eliminar" ){
                let index = alumnos.findIndex(alumno=>alumno.idAlumno==this.alumno.idAlumno);
                alumnos.splice(index,1);
            }
            localStorage.setItem('alumnos', JSON.stringify(alumnos));
            this.nuevoAlumno();
            this.obtenerAlumnos();
            this.alumno.msg = 'Alumno procesado con exito';
        },
        obtenerAlumnos(valor=''){
            this.alumnos = [];
            let alumnos = JSON.parse(localStorage.getItem('alumnos')) || [];
            this.alumnos = alumnos.filter(alumno=>alumno.nombre.toLowerCase().indexOf(valor.toLowerCase())>-1);
        },
        nuevoAlumno(){
            this.alumno.accion = 'nuevo';
            this.alumno.msg = '';
            this.alumno.idAlumno = '';
            this.alumno.codigo = '';
            this.alumno.nombre = '';
            this.alumno.direccion = '';
            this.alumno.telefono = '';
            this.alumno.fecha_nacimiento = '';
        }
    },
    created(){
        this.obtenerAlumnos();
    },
    template:`
        <div id="appSistema">
            <div class="card text-white" id="carAlumno">
                <div class="card text-white bg-danger">
                    Registro de Alumnos

                    <button type="button" class="btn-close text-end" data-bs-dismiss="alert" data-bs-target="#carAlumno" aria-label="Close"></button>
                </div>
                <div class="card-body text-dark">
                    <form method="post" @submit.prevent="guardarAlumno" @reset="nuevoAlumno">
                        <div class="row p-1">
                            <div class="col col-md-2">Codigo:</div>
                            <div class="col col-md-2">
                                <input title="Ingrese el codigo" v-model="alumno.codigo" pattern="[0-9]{3,10}" required type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col col-md-2">Nombre:</div>
                            <div class="col col-md-3">
                                <input title="Ingrese el nombre" v-model="alumno.nombre" pattern="[A-Za-zñÑáéíóúü ]{3,75}" required type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col col-md-2">Direccion:</div>
                            <div class="col col-md-3">
                                <input title="Ingrese la direccion" v-model="alumno.direccion" pattern="[A-Za-zñÑáéíóúü ]{3,100}" required type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col col-md-2">Telefono:</div>
                            <div class="col col-md-2">
                                <input title="Ingrese el telelefono" v-model="alumno.telefono" pattern="[0-9]{4}-[0-9]{4}" required type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                        <div class="col col-md-2">Fecha Nacimiento:</div>
                        <div class="col col-md-2">
                            <input title="Ingrese la fecha de nacimiento" v-model="alumno.fecha_nacimiento" required type="date" class="form-control">
                        </div>
                    </div>
                       
                        <div class="row p-1">
                            <div class="col col-md-5 text-center">
                                <div v-if="alumno.mostrar_msg" class="alert alert-primary alert-dismissible fade show" role="alert">
                                    {{ alumno.msg }}
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
            <div class="card text-white" id="carBuscarAlumno">
                <div class="card text-white bg-danger">
                    Busqueda de Alumnos

                    <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#carBuscarAlumno" aria-label="Close"></button>
                </div>
                <div class="card-body">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    Buscar: <input @keyup="buscandoAlumno" v-model="buscar" placeholder="Buscar" class="form-control" type="text" >
                                </th>
                            </tr>
                            <tr>
                                <th>CODIGO</th>
                                <th>NOMBRE</th>
                                <th>DIRECCION</th>
                                <th>TELEFONO</th>
                                <th>FECHA NACIMIENTO</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in alumnos" @click='modificarAlumno( item )' :key="item.idAlumno">
                                <td>{{item.codigo}}</td>
                                <td>{{item.nombre}}</td>
                                <td>{{item.direccion}}</td>
                                <td>{{item.telefono}}</td>
                                <td>{{item.fecha_nacimeinto}}</td>
                                <td>
                                    <button class="btn btn-danger" @click="eliminarAlumno(item)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
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
