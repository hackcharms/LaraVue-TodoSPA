<template>
    <div>
        <b-alert dismissible v-if="alertMessage" show :variant="alertVariant">{{alertMessage}}</b-alert>
            <b-list-group-item v-for="todo in todos" :key="todo.id" class="d-flex">
                    <h3>
                    <input type="text" form-input v-if="editingMode && activeTodoId==todo.id" v-model="todo.task" style="font-size:1.5rem;width:90%"
                    @blur="editingModeDisable(todo)"
                    />
                    <span v-else
                    @dblclick="editingModeEnable(todo)"
                    >
                <input type="checkbox"
                @change="toggleStatus(todo)"
                />
                {{todo.task}}
                </span>
                    </h3>
                <span class="justify-content-end ml-auto">
                    <b-button pill variant="danger"
                    @click="deleteTodo(todo)"
                    >Delete</b-button>
                </span>
                </b-list-group-item>
                <b-list-group-item class="d-flex">
                    <b-form-input v-model="newTask" @keyup.enter="addTodo" placeholder="Enter your name"></b-form-input>
                    <span class="justify-content-end ml-auto">
                    <b-button pill variant="success"
                    @click="addTodo"
                    >Add</b-button>
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
            newTask: null,
            alertMessage: null,
            alertVariant: null,
            editingMode: false,
            activeTodoId: null,
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
        toggleStatus(todo) {
            // console.log(todo.completed= !todo.completed);
            this.loading=true
            this.todos.map(function(item) {
                if (item.id == todo.id) {
                    item.completed = !todo.completed;
                }
            })
            this.updateTodo(todo);
            this.todos = this.todos.filter(function(item) {
                return item.id != todo.id
            })
            this.loading=false

        },

        addTodo() {
            // console.log(this.newTask);
            this.loading = true
            fetch("http://127.0.0.1:8000/api/todo", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        task: this.newTask,
                        completed: false
                    })
                }).then(res => { return res.json() })
                .then(data => {
                    // console.log(data);
                    if (data.status && data.status == 200) {
                        this.alertMessage = data.message;
                        this.alertVariant = 'success';
                        this.todos.push(data.data);
                        this.newTask = '';
                    };
                    this.loading = false

                }).catch(err => { console.log(err) })
        },
        updateTodo(todo) {
            this.loading = true;
            fetch("http://127.0.0.1:8000/api/todo/" + todo.id, {
                    method: "PATCH",
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        task: todo.task,
                        completed: todo.completed
                    })
                }).then(res => { return res.json() })
                .then(data => {
                    // console.log(data);
                    if (data.status && data.status == 200) {
                        this.alertMessage = data.message;
                        this.alertVariant = 'success';
                        // this.todos.map(function(todo))
                    };
                    this.loading = false
                }).catch(err => { console.log(err) })

        },
        editingModeEnable(todo) {
            this.editingMode = true
            this.activeTodoId = todo.id
            return 0;
        },
        editingModeDisable(todo) {
            // alert('editingModeDisable')
            this.editingMode = false
            this.updateTodo(todo)
            return 0;
        },
    },
    filters: {

    },
    created() {
        this.loading = true;
        fetch("http://127.0.0.1:8000/api/todo/incomplete", {
                method: "GET"
            }).then(res => { return res.json() })
            .then(data => {
                this.todos = data.data;
            }).catch(err => { console.log(err) })
        // getData();
        this.loading = false;
    },
}
</script>
