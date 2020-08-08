<template>
    <div>
        <h3> Completed Task </h3>
        <b-alert dismissible v-if="alertMessage" show :variant="alertVariant">{{alertMessage}}</b-alert>
            <b-list-group-item v-for="todo in todos" :key="todo.id" class="d-flex">
                    <h3>
                        <strike>
                {{todo.task}}
                        </strike>

                    </h3>
                <span class="justify-content-end ml-auto">
                    <b-button pill variant="danger"
                    @click="deleteTodo(todo)"
                    >Delete</b-button>
                </span>
                </b-list-group-item>
                <div v-if="loading" class="loader">
            <div class="spinner-box">
                <div class="configure-border-1">
                    <div class="configure-core"></div>
                </div>
                <div class="configure-border-2">
                    <div class="configure-core"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            todos: null,
            alertMessage: null,
            alertVariant: null,
            loading: true,
        }
    },
    methods: {
        deleteTodo(todo) {
            this.loading = true
            this.todos = this.todos.filter(function(item) {
                return item.id != todo.id
            })

            fetch("http://127.0.0.1:8000/api/todo/" + todo.id, {
                    method: "Delete"
                }).then(res => { return res.json() })
                .then(data => {
                    if (data.status && data.status == 200) {
                        this.alertMessage = data.message;
                        this.alertVariant = 'success';
                    };
                    this.loading = false;
                }).catch(err => { console.log(err) })
        },
    },
    filters: {

    },
    created() {
        this.loading = true;
        fetch("http://127.0.0.1:8000/api/todo/completed", {
                method: "GET"
            }).then(res => { return res.json() })
            .then(data => {
                this.todos = data.data;
            }).catch(err => { console.log(err) })
        this.loading = false;
    },
}
</script>
