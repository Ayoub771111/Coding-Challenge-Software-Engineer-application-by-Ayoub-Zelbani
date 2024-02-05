<template>
    <div>
      <h1>Create Product</h1>
      <form @submit.prevent="submitForm">
        <div>
          <label for="name">Name:</label>
          <input id="name" v-model="product.name" type="text" required>
        </div>
        
        <div>
          <label for="description">Description:</label>
          <textarea id="description" v-model="product.description" required></textarea>
        </div>
        
        <div>
          <label for="price">Price:</label>
          <input id="price" v-model="product.price" type="number" step="0.01" required>
        </div>
        
        <div>
          <label for="image">Image:</label>
          <input id="image" @change="handleFileUpload" type="file" accept="image/*">
        </div>
        
        <div>
          <label for="categories">Categories:</label>
          <select id="categories" v-model="product.categories" multiple>
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>
        
        <button type="submit">Create Product</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        product: {
          name: '',
          description: '',
          price: null,
          categories: [],
          image: null,
        },
        categories: [],
      };
    },
    methods: {
      fetchCategories() {
        axios.get('/api/categories')
          .then(response => {
            this.categories = response.data;
          })
          .catch(error => {
            console.error("There was an error fetching the categories:", error);
          });
      },
      handleFileUpload(event) {
        this.product.image = event.target.files[0];
      },
      submitForm() {
        const formData = new FormData();
        formData.append('name', this.product.name);
        formData.append('description', this.product.description);
        formData.append('price', this.product.price);
        formData.append('image', this.product.image);
        this.product.categories.forEach(category => {
          formData.append('categories[]', category);
        });
        
        axios.post('/api/products', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(response => {
          console.log("Product created:", response.data);
          this.$router.push('/');
        })
        .catch(error => {
          console.error("There was an error creating the product:", error);
        });
      }
    },
    created() {
      this.fetchCategories();
    }
  };
  </script>
  