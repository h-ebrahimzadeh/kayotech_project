import {defineStore} from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        authUser: null,
        authRole: null,
        authErrors: [],
        authStatus: null,
        authMsg:null,


    }),
    getters: {
        user: (state) => state.authUser,
        role:(state) => state.authUserRole,
        errors: (state) => state.authErrors,
        status: (state) => state.authStatus,
        msg: (state) => state.authMsg,

    },
    actions: {
        async getToken() {
            await axios.get("/sanctum/csrf-cookie");
        },
        async getUser() {
            await this.getToken();
            const data = await axios.get("/api/user");
            this.authUser = data.data.user;
            this.authUserRole = data.data.role;

        },
        async handleLogin(data) {
            this.authErrors = [];
            await this.getToken();

            try {
                await axios.post("/login", {
                    email: data.email,
                    password: data.password,
                }).then(response => {
                    // Handle the successful response
                    this.authMsg=response.data;
                    console.log('Response from server:', response.data);
                    // Perform any actions based on the response
                });

                if( this.authMsg.msg==="login successfully."){
                    await this.router.push("/");
                }



            } catch (error) {
                if (error.response.status === 422) {
                    this.authErrors = error.response.data.errors;
                }
            }
        },
        async handleRegister(data) {
            this.authErrors = [];
            await this.getToken();
            try {
                await axios.post("/register", {
                    name: data.name,
                    email: data.email,
                    password: data.password,
                    password_confirmation: data.password_confirmation,
                });
                await this.router.push("/");
            } catch (error) {
                if (error.response.status === 422) {
                    this.authErrors = error.response.data.errors;
                }
            }
        },
        async handleLogout() {
            await axios.post("/logout");
            this.authUser = null;
        },
        async handleForgotPassword(email) {
            this.authErrors = [];
            this.getToken();
            try {
                const response = await axios.post("/forgot-password", {
                    email: email,
                });
                this.authStatus = response.data.status;
            } catch (error) {
                if (error.response.status === 422) {
                    this.authErrors = error.response.data.errors;
                }
            }
        },
        async handleResetPassword(resetData) {
            this.authErrors = [];
            try {
                const response = await axios.post("/reset-password", resetData);
                this.authStatus = response.data.status;
            } catch (error) {
                if (error.response.status === 422) {
                    this.authErrors = error.response.data.errors;
                }
            }
        },
    },
});
