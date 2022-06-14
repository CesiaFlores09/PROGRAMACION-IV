<template>
    <div class="card">
        <div class="card-header center-content">
            <p>Chat</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                    <div class="row">
                        <div v-for="mensaje in mensajes" class="col-md-12 d-flex justify-content-around" :key="mensaje._id">
                            <div v-if="mensaje.by == usuario.id" class="col-md-12 d-flex justify-content-end">
                                    <p>{{ mensaje.mensaje }}</p>
                            </div>
                            <div v-else class="col-md-12 d-flex justify-content-start">
                                    <p>{{ mensaje.mensaje }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <input type="text" class="form-control" v-model="mensaje" @keyup.enter="enviarMensaje">
                            <button class="btn btn-primary" @click="enviarMensaje">Enviar</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script async defer>
    export default {
        props: ['usuario', 'match'],
        data() {
            return {
                mensaje: '',
                mensajes: []
            }
        },
        methods: {
            enviarMensaje() {
                if (this.mensaje.length > 0) {
                    socketio.emit('sendMsg', {
                        mensaje: this.mensaje,
                        by: this.usuario.id,
                        to: this.match.id
                    });
                    this.mensajes.push({
                        mensaje: this.mensaje,
                        by: this.usuario.id,
                        to: this.match.id
                    });
                    this.mensaje = ''
                }
            },
            recibirMensaje() {
                socketio.emit('chat', {
                    to: this.match.id,
                    by: this.usuario.id
                });
                let ids = [this.usuario.id, this.match.id].sort((a, b) => a - b)
                socketio.on('chat_' + ids[0] + '_' + ids[1], (data) => {
                    this.mensajes = data;
                });
            }
        },
        mounted() {
            this.recibirMensaje();
            console.log(this.match);

            socketio.on('sendMsg_' + this.match.id + '_' + this.usuario.id, (data) => {
                this.mensajes.push(data);
            });
        }
    }
</script>

<style>
.actual {
    fill: #00a8ff;
    stroke: #00a8ff;
}
.hover-container:hover {
    background-color: #b0b0b0;
}
</style>