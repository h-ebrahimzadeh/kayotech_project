import {defineStore} from "pinia";
import axios from "axios";

export const useAdminStore = defineStore("admin", {
    state: () => ({
        users: null,

    }),
    getters: {
        users: (state) => state.dataUsers,

    },
    actions: {
        async getToken() {
            await axios.get("/sanctum/csrf-cookie");
        },
        async getUsers() {
            await this.getToken();
            const data = await axios.get("/api/admin/users");
            this.dataUsers = data.data;


        },

    },
});
