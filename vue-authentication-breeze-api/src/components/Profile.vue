<!-- components/Profile.vue -->
<template>
  <div class="w-1/2 mx-auto">
    <div>
      <h2>Image Upload</h2>

      <!-- Display Uploaded Image -->
      <div v-if="imageUrl">
        <img :src="imageUrl" alt="Uploaded Image" style="max-width: 300px; max-height: 300px;">
      </div>


    </div>


    <h2 class="text-2xl text-center text-green-500">User Profile</h2>


    <!-- Display User Information -->
    <div v-if="user">
      <p><strong>Name:</strong> {{ user.name }}</p>
      <p><strong>Email:</strong> {{ user.email }}</p>
    </div>

    <!-- Edit Form -->
    <div v-if="editMode">
      <form @submit.prevent="saveProfile">
        <label for="name">Name:</label>
        <input v-model="editedUser.name" type="text" id="name" required>

        <label for="email">Email:</label>
        <input v-model="editedUser.email" type="email" id="email" required>

        <!-- File Input and Upload Button -->
        <input type="file" @change="handleImageChange">

        <button type="submit">Save</button>
        <button @click="cancelEdit">Cancel</button>
      </form>
    </div>

    <!-- Toggle Edit Mode Button -->
    <button v-if="!editMode" @click="enterEditMode">Edit Profile</button>
  </div>
</template>

<script>
import axios from 'axios';
import {useAuthStore} from "../stores/auth.js";


export default {
  data() {
    return {
      user: null,
      editedUser: {
        name: '',
        email: '',


      },
      editMode: false,
      imageUrl: null,
      selectedImage: null,
    };
  },
  async mounted() {

    this.user = await useAuthStore().user;
    console.log(this.user);
  },
  methods: {
    handleImageChange(event) {
      // Handle file selection for the profile image
      this.selectedImage = event.target.files[0];
    },
    enterEditMode() {
      // Switch to edit mode
      this.editMode = true;
    },
    cancelEdit() {
      // Cancel edit mode
      this.editMode = false;
      // Reset editedUser with current user data
      this.editedUser = {...this.user};
    },
    async saveProfile() {
      try {
        // Create FormData object and append user data
        const formData = new FormData();
        formData.append('id', this.user.id);

        formData.append('name', this.editedUser.name);
        formData.append('email', this.editedUser.email);

        // Append the profile image if selected
        if (this.selectedImage) {
          formData.append('image', this.selectedImage);
        }

        // Make API request to update user information
        const response = await axios.put('/api/user/update', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        // Handle success (e.g., display a success message)
        console.log('User updated successfully:', response.data);

        // Optionally, you can reset the form or perform other actions
        // ...

      } catch (error) {
        // Handle errors (e.g., display an error message)
        console.error('Error updating user:', error);
      }

    },

    async uploadImage() {
      if (!this.selectedFile) {
        alert('Please select an image before uploading.');
        return;
      }

      // Create a FormData object and append the selected file
      const formData = new FormData();
      formData.append('image', this.selectedFile);

      try {
        // Make an API request to upload the image
        const response = await axios.post('/api/upload', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        // Assuming the API returns the URL of the uploaded image
        this.imageUrl = response.data.imageUrl;

        // Reset the file input
        this.$refs.fileInput.value = null;
      } catch (error) {
        console.error('Error uploading image:', error);
      }
    },
  },
}


</script>

