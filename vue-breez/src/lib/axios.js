import Axios from 'axios'

const axios = Axios.create({
    baseURL: import.meta.env.VITE_PUBLIC_BACKEND_URL,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
    withCredentials: true,
})

export default axios

// axios.defaults.withCredentials=true;
// axios.defaults.baseUrl="http://localhost:8000";
// export default axios
