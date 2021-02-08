import "@mdi/font/css/materialdesignicons.css";
import "@fortawesome/fontawesome-free/css/all.css";
import "vuetify/dist/vuetify.min.css";
import Vue from "vue";
import Vuetify from "vuetify";
import VueI18n from "vue-i18n";
import { messages } from "@/Locales/index.js";

Vue.use(Vuetify);
Vue.use(VueI18n);

export const i18n = new VueI18n({
    locale: process.env.VUE_APP_I18N_LOCALE || "id",
    fallbackLocale: process.env.VUE_APP_I18N_FALLBACK_LOCALE || "en",
    messages
});

const opts = {
    theme: {
        themes: {
            light: {
                primary: "#0057ff",
                secondary: "#424242",
                accent: "#82B1FF",
                error: "#FF5252",
                info: "#2196F3",
                success: "#4CAF50",
                warning: "#FFC107",
                anchor: "#424242"
            },
            dark: {
                anchor: "#ffffff"
            }
        },
        options: {
            icons: { iconfont: "fa" }
        }
    },
    lang: {
        t: (key, ...params) => i18n.t(key, params)
    }
};

export default new Vuetify(opts);
