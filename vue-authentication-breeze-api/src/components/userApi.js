// userApi.js
import axios from 'axios';

const baseURL = '/api/users'; // Adjust the API endpoint based on your Laravel API routes

export const handleActiveUser = async (userId, updatedUserData) => {
    try {
        const response = await axios.put(`/api/admin/user/${userId}`, updatedUserData);
        return response.data; // Assuming the API returns the updated user data
    } catch (error) {
        console.error('Error updating user:', error);
        throw error; // Rethrow the error for the calling code to handle
    }
};