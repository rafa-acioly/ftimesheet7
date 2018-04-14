<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                {{ client.name }}
                <span class="badge">{{ hasUsed }}</span>
            </h3>
        </div>
        <div class="panel-body">
            <div class="text-center">
                <h1 class="title" :id="client.id">00:00:00</h1>
            </div>
            <div class="text-center">
                <button 
                    class="btn btn-success"
                    @click="startWatch"
                    :id="'client-'+client.id"
                    :disabled="status === 1">
                    Iniciar
                </button>
                <button
                    class="btn btn-warning"
                    @click="finishWatch"
                    :disabled="status === 0">
                    Parar
                </button>
                <button
                    class="btn btn-info"
                    @click="resetWatch">
                    Resetar
                </button>
                <div class="btn-group">
                    <button 
                        :disabled="status === 0" 
                        type="button" 
                        class="btn btn-default dropdown-toggle" 
                        data-toggle="dropdown" 
                        aria-haspopup="true" 
                        aria-expanded="false">
                        <i class="fa fa-cogs"></i>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" @click="addHour">+1 Hora</a></li>
                        <li><a href="#" @click="removeHour">-1 Hora</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import axios from 'axios'
    import swal from 'sweetalert2'
    import { mapGetters, mapActions } from 'vuex'
    import moment from 'moment'
    
    export default {
        name: "Timer",
        props: {
            client: {
                Type: Object,
                default: () => ({})
            }
        },

        data: () => ({
            counter: 0,
            runClock: null,
            status: 0,
            used: 0
        }),

        beforeMount() {
            axios.get(`time/${this.client.id}`)
            .then(response => {
                this.used = response.data.time
            })
            .catch(error => console.warn(error))
        },

        computed: {
            hasUsed () {
                return moment().hour(0).minute(0).second(this.used).format('HH:mm:ss');
            }
        },

        methods: {
            startWatch() {
                this.status = 1
                this.runClock = setInterval(() => {
                    document.getElementById(this.client.id).innerHTML = moment().hour(0).minute(0).second(this.counter++).format('HH:mm:ss');
                }, 1000);

                let startBTN = document.querySelector('#client-'+this.client.id);
                startBTN.innerHTML = 'Continuar';
            },

            stopWatch() {
                this.status = 0
                clearInterval(this.runClock);
            },

            resetWatch() {
                this.stopWatch();
                this.counter = 0;
                this.runClock = null;
                document.getElementById(this.client.id).innerHTML = "00:00:00";
                document.querySelector('#client-'+this.client.id).innerHTML = "Iniciar";
            },

            addHour() {
                this.counter += 3600;
            },

            removeHour() {
                if (this.counter < 3600) {
                    return;
                }
                this.counter -= 3600;
            },

            finishWatch() {
                this.stopWatch();
                let time = document.getElementById(this.client.id).innerHTML;
                let dataAPI = {
                    'client_id': this.client.id,
                    'duration': time,
                };

                swal.queue([{
                    type: 'info',
                    title: 'Gravar tempo?',
                    text: 'Ao gravar o tempo o mesmo será resetado automaticamente',
                    confirmButtonText: 'Sim, gravar!',
                    cancelButtonText: 'Não, cancelar!',
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return axios.post('time/add', dataAPI)
                        .then(response => {
                            swal.insertQueueStep({
                                type: 'success',
                                title: 'Pronto',
                                html: `Você gravou <strong>${time}</strong> para o cliente <strong>${this.client.name}</strong>`
                            });
                            let startBTN = document.querySelector('#client-'+this.client.id)
                            startBTN.innerHTML = 'Iniciar'
                            this.used += this.counter;
                            this.$store.commit('stop', false);
                            this.resetWatch();
                        })
                        .catch(error => {
                            swal.insertQueueStep({
                              type: 'error',
                              title: 'Ops! algo deu errado',
                              text: 'entre em contato com o administrador'
                            })
                            console.warn(error)
                        })
                    }
                }])
            },
        }
    };
</script>

<style scoped>
    .title {
        margin: 1rem;
    }
</style>
