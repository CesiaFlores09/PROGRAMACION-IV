Vue.component('autor',{
    data:()=>{
        return {
            buscar:'',
            autores:[],
            autor:{
                accion : 'nuevo',
                mostrar_msg : false,
                msg : '',
                idAutor : '',
                codigo: '',
                nombre: '',
                pais:'',
                telefono:'',
            }
        }
    },
    methods:{
        buscandoAutor(){
            this.obtenerautores(this.buscar);
        },
        eliminarAutor(autor){
            if( confirm(`Esta seguro de eliminar el autor ${autor.nombre}?`) ){
                this.autor.accion = 'eliminar';
                this.autor.idAutor = autor.idAutor;
                this.guardarAutor();
            }
            this.nuevoAutor();
        },
        modificarAutor(datos){
            this.autor = JSON.parse(JSON.stringify(datos));
            this.autor.accion = 'modificar';
        },
        guardarAutor(){
            this.obtenerautores();
            let autores = JSON.parse(localStorage.getItem('autores')) || [];
            if(this.autor.accion=="nuevo"){
                this.autor.idAutor = generarIdUnicoFecha();
                autores.push(this.autor);
            } else if(this.autor.accion=="modificar"){
                let index = autores.findIndex(autor=>autor.idAutor==this.autor.idAutor);
                autores[index] = this.autor;
            } else if( this.autor.accion=="eliminar" ){
                let index = autores.findIndex(autor=>autor.idAutor==this.autor.idAutor);
                autores.splice(index,1);
            }
            localStorage.setItem('autores', JSON.stringify(autores));
            this.nuevoAutor();
            this.obtenerautores();
            this.autor.msg = 'Autor procesado con exito';
        },
        obtenerautores(valor=''){
            this.autores = [];
            let autores = JSON.parse(localStorage.getItem('autores')) || [];
            this.autores = autores.filter(autor=>autor.nombre.toLowerCase().indexOf(valor.toLowerCase())>-1);

            
            
        },
        nuevoAutor(){
            this.autor.accion = 'nuevo';
            this.autor.msg = '';
            this.autor.idAutor = '';
            this.autor.codigo = '';
            this.autor.nombre = '';
            this.autor.pais = '';
            this.autor.telefono = '';
        }
    },
    created(){
        this.obtenerautores();
    },
    template:`
        <div id="appAutor">
            <div class="card text-white" id="carAutor">
                <div class="card text-white bg-secondary ">
                    Registro de autores

                    <button type="button" class="btn-close text-end" data-bs-dismiss="alert" data-bs-target="#carAutor" aria-label="Close"></button>
                </div>
                <div class="card-body text-dark">
                    <form method="post" @submit.prevent="guardarAutor" @reset="nuevoAutor">
                        <div class="row p-1">
                            <div class="col col-md-2">Codigo:</div>
                            <div class="col col-md-2">
                                <input title="Ingrese el codigo" v-model="autor.codigo" pattern="[0-9]{3,10}" required type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col col-md-2">Nombre:</div>
                            <div class="col col-md-3">
                                <input title="Ingrese el nombre" v-model="autor.nombre" pattern="[A-Za-zñÑáéíóúü ]{3,75}" required type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                        <div class="col col-md-2">Pais:</div>
                        <div class="col col-md-3">
                            <input title="Ingrese el Pais" v-model="autor.pais" pattern="[A-Za-zñÑáéíóúü ]{3,75}" required type="text" class="form-control">
                        </div>
                    </div>
                       <div class="row p-1">
                       <div class="col col-md-2">Telefono:</div>
                    <div class="col col-md-3">
                        <input title="Ingrese el Telefono" v-model="autor.telefono" pattern="[0-9]{4}-[0-9]{4}" required type="text" class="form-control">
                    </div>
                         </div>
                        <div class="row p-1">
                            <div class="col col-md-5 text-center">
                                <div v-if="autor.mostrar_msg" class="alert alert-primary alert-dismissible fade show" role="alert">
                                    {{ autor.msg }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col col-md-5 text-center">
                                <input class="btn btn-secondary" type="submit" value="Guardar">
                                <input class="btn btn-success" type="reset" value=" Nuevo">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card text-white" id="carBuscarAutor">
                <div class="card text-white bg-secondary ">
                    Busqueda de autores

                    <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#carBuscarAutor" aria-label="Close"></button>
                </div>
                <div class="card-body">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    Buscar: <input @keyup="buscandoAutor" v-model="buscar" placeholder="Buscar" class="form-control" type="text" >
                                </th>
                            </tr>
                            <tr>
                                <th>CODIGO</th>
                                <th>NOMBRE</th>
                                <th>PAIS</th>
                                <th>TELEFONO</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in autores" @click='modificarAutor( item )' :key="item.idAutor">
                                <td>{{item.codigo}}</td>
                                <td>{{item.nombre}}</td>
                                <td>{{item.pais}}</td>
                                <td>{{item.telefono}}</td>
                                <td>
                                    <button class="btn btn-danger" @click="eliminarAutor(item)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
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