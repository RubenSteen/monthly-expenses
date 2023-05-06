import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mixin({ methods: { route } });

        // Still have to add this to SSR
        app.config.globalProperties.$filters = {
            // Call this in a component with {{ $filters.currency('1505.50') }}
            currency(value) {
                return new Intl.NumberFormat("nl-NL", {
                    style: "currency",
                    currency: "EUR",
                }).format(value);
            },
            // Put the rest of your filters here
        };

        app.mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
