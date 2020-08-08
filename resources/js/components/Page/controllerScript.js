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
        deleteTodo(todoId) {
            this.loading = true
            this.todos = this.todos.filter(function(item) {
                return item.id != todoId
            })

            fetch("http://127.0.0.1:8000/api/todo/" + todoId, {
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
            this.todos.map(function(item) {
                if (item.id == todo.id) {
                    item.completed = !todo.completed;
                }
            })

            this.updateTodo(todo);

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
        // fetch("http://127.0.0.1:8000/api/todo", {
        //         method: "GET"
        //     }).then(res => { return res.json() })
        //     .then(data => {
        //         this.todos = data.data;
        //     }).catch(err => { console.log(err) })
        getData();
        this.loading = false;
    },
}