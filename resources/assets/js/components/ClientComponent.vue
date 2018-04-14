<template>
    <div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Relatórios por clientes
                    </div>
                </div>
                <form action="#" @submit="send">
                    <div class="panel-body">
                        <div class="col-md-6">
                            <label for="">Usuario</label>
                            <select name="" id="" class="form-control" v-model="clientID">
                                <option :value="null" disabled selected>Selecione o cliente</option>
                                <option v-for="client in clients" :value="client.id" v-bind:key="client.id">{{ client.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">
                                Inicio
                                <input type="date" class="form-control" name="start" v-model="start">
                            </label>
                            <label for="">
                                Fim
                                <input type="date" class="form-control" name="end" v-model="end">
                            </label>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <div>
                           <strong> Total no periodo: {{ total }}</strong>
                        </div>
                        <button class="btn btn-info" v-bind:disabled="isLoading || start === null || end === null || clientID === null">
                            <div v-if="isLoading">
                                <i class="fa fa-spinner fa-fw is-loading"></i>
                            </div>
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import chart from 'tui-chart';
    import axios from 'axios';
    import moment from 'moment';
    import swal from 'sweetalert2';
    export default {
        data: () => ({
            clients: [],
            clientID: null,
            start: null,
            end: null,
            total: 0,
            isLoading: false,
        }),
        mounted() {
            axios.get('api/clients')
            .then(response => {
                response.data.forEach(client => this.clients.push(client))
            })
            .catch(error => {
                console.error(error);
            });
        },

        methods: {
            send(event) {
                event.preventDefault();
                this.isLoading = true
                axios.post('api/client/report', {
                    id: this.clientID,
                    start: this.start,
                    end: this.end
                })
                .then(response => {
                    this.total = response.data.time
                    this.isLoading = false
                })
                .catch(error => {
                    swal({
                        title: 'Ops!',
                        text: 'Não foi possivel emitir o relatório, tente novamente.',
                        type: 'info',
                    })
                    this.isLoading = false
                })
            }
        }
    }
</script>


<style scoped>
    .panel-footer {
        display: flex;
        justify-content: space-between;
    }

    .is-loading {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {transform:rotate(0deg);}
        to {transform:rotate(360deg);}
    }
</style>

