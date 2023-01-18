/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './../public/build/app.css'

// start the Stimulus application
import './bootstrap';



import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router';
// import the root component App from a single-file component.
import App from './App.vue'
import Axios from 'axios';
// other vue components 
import Atm from './components/Atm.vue'
import Profile from './components/Profile.vue'
import Balance from  './components/Balance.vue'
import Login from './components/public/Login.vue'
import Register from './components/public/Register.vue'
import Dashboard from "./components/private/Dashboard.vue";



const router = createRouter({
    history: createWebHistory(),
    // mode: "history",
    routes: [
        {
            path: '/app/login',component: Login
        },
        {
            path: '/app/register',component: Register
        },
        {
            path: '/app/dashboard/:id', component: Dashboard
        }
    ]
})

const app = createApp(App)

// Register component here 
// app.component('login',Login)
// app.component('register',Register)
app.component('atm',Atm)
app.component('profile',Profile)
app.component('balance',Balance)

app.use(router)
app.config.globalProperties.$http = Axios; // Allow axios in all components this.$http.get
app.config.globalProperties.API_BASEURL = 'http://localhost:8000';
app.mount('#app')