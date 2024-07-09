import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                rojo: {
                    50: "#fff1f1",
                    100: "#ffe0e1",
                    200: "#ffc6c8",
                    300: "#ff9ea1",
                    400: "#ff666b",
                    500: "#fe353c",
                    600: "#ec1d24", //original
                    700: "#c60f15",
                    800: "#a41015",
                    900: "#871519",
                    950: "#4a0507",
                },
                azul: {
                    50: "#f2f7fd",
                    100: "#e4ecfa",
                    200: "#c4d9f3",
                    300: "#8fb9ea",
                    400: "#5494dc",
                    500: "#2e77c9",
                    600: "#1c559d", //original
                    700: "#1a4a8a",
                    800: "#194073",
                    900: "#1a3760",
                    950: "#112340",
                },
            },
        },
    },

    plugins: [forms],
};
