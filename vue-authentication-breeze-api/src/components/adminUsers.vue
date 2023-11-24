<template>
  <div class="w-1/2 mx-auto">
    <div class="w-full ">
      <h1 class="text-green-500 text-2xl text-center my-3 py-2 px-2">User List</h1>
      <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
        <tr>
          <th class="px-4 py-3">ID</th>
          <th class="px-4 py-3">Name</th>
          <th class="px-4 py-3">Email</th>
          <th class="px-4 py-3">suspend</th>
          <th class="px-4 py-3">action</th>


          <!-- Add more columns as needed -->
        </tr>
        </thead>
        <tbody>
        <tr v-for="user in users" :key="user.id" class="border-b">
          <td class="px-4 py-3 font-medium text-gray-900">{{ user.id }}</td>
          <td class="px-4 py-3 font-medium text-gray-900">{{ user.name }}</td>
          <td class="px-4 py-3 font-medium text-gray-900">{{ user.email }}</td>
          <td class="px-4 py-3 font-medium text-gray-900">{{ user.suspend }}</td>

          <template v-if="user.suspend==1">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded
                disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none "
                @click="unsuspend(user.id)"

            >
              unsuspend
            </button>
          </template>
          <template v-else>
            <button
                class="bg-orange-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-1"
                @click="suspend(user.id)"
            >

              suspend
            </button>
          </template>

          <!-- Add more columns as needed -->
        </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script>

import axios from 'axios';

export default {
  data() {
    return {
      users: [],
    };
  },
  mounted() {
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      await axios.get('/api/admin/users')
          .then(response => {
            this.users = response.data;
            // console.log(this.users);
          })
          .catch(error => {
            console.error('Error fetching users:', error);
          });
    },
    unsuspend(userId) {
      try {
        axios.put(`/api/admin/user/unsuspend/${userId}`);
        // console.log(response.data);
        // await this.router.push("/admin-users");
        this.fetchUsers();
        return response.data; // Assuming the API returns the updated user data
      } catch (error) {
        console.error('Error updating user:', error);
        throw error; // Rethrow the error for the calling code to handle
      }

    },
    suspend(userId) {
      try {
        axios.put(`/api/admin/user/suspend/${userId}`);
        // console.log(response.data);
        // await this.router.push("/admin-users");
        this.fetchUsers();

        return response.data; // Assuming the API returns the updated user data
      } catch (error) {
        console.error('Error updating user:', error);
        throw error; // Rethrow the error for the calling code to handle
      }

    },
  },

};

</script>
