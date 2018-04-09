<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                {{ client.name }}
                <span class="badge">{{ used }}</span>
            </h3>
        </div>
        <div class="panel-body">
            <div class="text-center">
                <h1 class="title">00:00:00</h1>
            </div>
            <div class="text-center">
                <button 
                    class="btn btn-success"
                    @click="startWatch"
                    :id="'client-'+client.id">
                    Iniciar
                </button>
                <button
                    class="btn btn-warning"
                    @click="stopWatch"
                    :disabled="status === 0">
                    Pausar
                </button>
                <button
                    class="btn btn-info"
                    @click="resetWatch">
                    Reiniciar
                </button>
                <!-- <div class="btn-group">
                    <button :disabled="status === 1" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cogs"></i>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" @click="addHour">+1 Hora</a></li>
                        <li><a href="#" @click="removeHour">-1 Hora</a></li>
                    </ul>
                </div> -->
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
            used: 0,
            status: 0
        }),

        beforeMount() {
            axios.get(`time/${this.client.id}`)
            .then(response => {
                console.log(response.data)
                this.used = response.data.time
            })
            .catch(error => console.warn(error))
        },

        methods: {
            startWatch() {
                this.status = 1
                this.runClock = setInterval(() => {
                    document.querySelector('.title').innerHTML = moment().hour(0).minute(0).second(this.counter++).format('HH:mm:ss');
                }, 1000);
            },

            stopWatch() {
                this.status = 0
                clearInterval(this.runClock);
            },

            resetWatch() {
                this.counter = 0;
                this.runClock = null,
                document.querySelector('.title').innerHTML = "00:00:00"
            }
        }
    };
</script>

<style scoped>
    .title {
        margin: 1rem;
    }
</style>
