import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter)

import Home from '../pages/Home'
import Favorites from '../pages/Favorites'
import Profile from '../pages/Profile'

const router = new VueRouter({
    routes: [
        { path: '/', component: Home, name: 'home' },
        { path: '/favorites', component: Favorites, name: 'favorites' },
        { path: '/profile', component: Profile, name: 'profile' },
    ],
    linkExactActiveClass: 'is-active',
    mode: 'history'
})

export default router