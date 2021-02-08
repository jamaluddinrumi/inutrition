require("./bootstrap");
require("moment");

import Vue from "vue";
import Vuex from "vuex";
import { InertiaApp, plugin as InertiaPlugin } from "@inertiajs/inertia-vue";
import { InertiaForm } from "laravel-jetstream";
import { InertiaProgress } from "@inertiajs/progress";
import PortalVue from "portal-vue";
import vuetify from "@/Plugins/vuetify";
import { i18n } from "@/Plugins/vuetify";
import Title from "@/Mixins/Title";

InertiaProgress.init({
    delay: 0,
    color: "#424242",
    includeCSS: true,
    showSpinner: false
});

Vue.use(InertiaPlugin);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(Vuex);
Vue.mixin({ methods: { route } });
Vue.mixin(Title);

const store = new Vuex.Store({
    state: {
        count: 0
    },
    mutations: {
        INCREMENT(state) {
            state.count++;
        }
    },
    actions: {}
});

// store.commit("increment");
const app = document.getElementById("app");

new Vue({
    i18n,
    store,
    vuetify,
    render: h =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: name => require(`./Pages/${name}`).default
            }
        })
}).$mount(app);
