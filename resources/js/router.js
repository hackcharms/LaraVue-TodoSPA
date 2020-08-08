import Vue from 'vue';
import Router from 'vue-router'
Vue.use(Router)
import IncompleteTodo from './components/Page/IncompleteTodo'
import CompletedTodo from './components/Page/CompletedTodo'
const routes = [{
        name: 'incomplete-todo',
        path: '/home/incomplete-todo',
        component: IncompleteTodo,

    },
    {
        name: 'completed-todo',
        path: '/home/completed-todo',
        component: CompletedTodo
    }
];
export default new Router({
    mode: 'history',
    routes
})