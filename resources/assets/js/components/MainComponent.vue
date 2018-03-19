<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5" v-for="client in clients" v-bind:key="client.id">
                <timer :client="client"></timer>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import Timer from './TimerComponent'

    export default {
        components: { Timer },
        data () {
            return {
                clients: []
            }
        },
        beforeMount(){
            axios.get('api/clients')
            .then(response => {
                response.data.forEach(client => this.clients.push(client))
            })
            .catch(error => {
                console.error(error);
            })
        }
    }
</script>

<style scoped>
    .col-md-5 {
        margin-bottom: 1rem;
    }
</style>

