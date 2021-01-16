import "vuetify/dist/vuetify.min.css";
import Vue from "vue";
import Vuetify from "vuetify";
import VueI18n from "vue-i18n";
import { messages } from "@/Locales/index.js";

Vue.use(Vuetify);
Vue.use(VueI18n);

const i18n = new VueI18n({
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
                anchor: "#1976D2"
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
