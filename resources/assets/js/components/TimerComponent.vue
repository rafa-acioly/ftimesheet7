<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                {{ client.name }}
                <span class="badge">{{ usedTime }}</span>
            </h3>
        </div>
        <div class="panel-body">
            <div class="text-center">
                <h1 class="title">{{ hours }} : {{ minutes }} : {{ seconds }}</h1>
            </div>
            <div class="text-center">
                <button 
                    class="btn btn-success"
                    @click="start($event)"
                    :id="'client-'+client.id">
                    Iniciar
                </button>
                <button
                    class="btn btn-warning"
                    @click="finish"
                    :disabled="status === 0">
                    Pausar
                </button>
                <button
                    class="btn btn-info"
                    @click="reset"
                    :disabled="sec === 0">
                    Reiniciar
                </button>
                <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    
    export default {
        name: "Timer",
        props: {
            client: {
                Type: Object,
                default: () => ({})
            }
        },

        data: () => ({
            status: 0,
            time: 0,
            used: 0,
            hour: 0,
            min: 0,
            sec: 0,
            mSec: 0
        }),

        beforeMount() {
            axios.get(`time/${this.client.id}`)
            .then(response => {
                this.used = response.data.time
            })
            .catch(error => console.warn(error))
        },

        computed: {
            full () {
                return this.hours + ":" + this.minutes + ":" + this.seconds
            },

            seconds () {
                let lapsed = this.time;
                let sec = Math.floor((lapsed / 100) % 60)
                return sec >= 10 ? sec : "0" + sec
            },

            minutes () {
                let lapsed = this.time
                let min = Math.floor((lapsed / 100) / 60)
                if (min >= 60) return min - 60
                return min
            },

            hours () {
                let lapsed = this.time
                let hrs = Math.floor(lapsed / 100 / 60 / 60);
                return hrs >= 10 ? hrs : "0" + hrs
            },

            usedTime () {
                return this.usedHours + ":" + this.usedMinutes + ":" + this.usedSeconds
            },

            usedHours () {
                let lapsed = this.used
                let hrs = Math.floor(lapsed / 100 / 60 / 60);
                return hrs >= 10 ? hrs : "0" + hrs
            },

            usedMinutes () {
                let lapsed = this.used
                let min = Math.floor(lapsed / 100 / 60)
                return min >= 10 ? min : "0" + min
            },

            usedSeconds () {
                let lapsed = this.used;
                let sec = Math.floor((lapsed / 100) % 60)
                return sec >= 10 ? sec : "0" + sec
            }
        },

        methods: {
            start(event) {
                if (this.$store.state.running && this.$store.state.client !== this.client.name) {
                    let clientUsingCounter = this.$store.state.client
                    swal({
                        title: 'Contador em execução!',
                        html: `Finalize o contador do cliente <u><strong>${clientUsingCounter}</strong></u> antes de iniciar um novo`,
                        type: 'warning',
                    });
                    return
                } else {
                    let btn = document.querySelector('#client-'+this.client.id)
                    btn.setAttribute('disabled', true)
                    this.$store.commit('run', this.client.name)
                }
                this.status = 1;
                this.timer();
            },

            pause(event) {
                var startBTN = document.querySelector('#client-'+this.client.id)
                startBTN.innerHTML = 'Continuar'
                startBTN.removeAttribute('disabled')
                this.status = 0;
            },

            reset() {
                this.used += this.time
                this.time = 0;
                this.status = 0;
                this.sec = 0;
                this.mSec = 0;
                this.min = 0;
                this.hour = 0;
                let startBTN = document.querySelector('#client-'+this.client.id)
                startBTN.innerHTML = 'Iniciar'
                startBTN.removeAttribute('disabled')
                this.$store.commit('stop', false);
            },

            finish() {
                this.pause()
                let dataAPI = {
                    'client_id': this.client.id,
                    'duration': this.full,
                }

                swal.queue([{
                    type: 'info',
                    title: 'Gravar tempo?',
                    text: 'Ao gravar o tempo o mesmo será resetado automaticamente',
                    confirmButtonText: 'Sim, gravar!',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return axios.post('time/add', dataAPI)
                        .then(response => {
                            swal.insertQueueStep({
                                type: 'success',
                                title: 'Pronto',
                                html: `Você gravou <strong>${this.full}</strong> para o cliente <strong>${this.client.name}</strong>`
                            });
                            let startBTN = document.querySelector('#client-'+this.client.id)
                            startBTN.innerHTML = 'Iniciar'
                            this.$store.commit('stop', false);
                            this.reset();
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

            timer() {
                if (this.status === 1) {
                    setTimeout(() => {
                        this.time++

                        this.min  = Math.floor(this.time/100/60)
                        this.sec  = Math.floor(this.time/100)
                        this.mSec =  this.time % 100
                        
                        this.timer()

                    }, 10);
                }
            },

            addHour() {
                this.time += 360000
                this.hour += 1
            },

            removeHour() {
                if (this.hour <= 0) {
                    return
                }
                this.time -= 360000
                this.hour -= 1
            }
        }
    };
</script>

<style scoped>
    .title {
        margin: 1rem;
    }
</style>
