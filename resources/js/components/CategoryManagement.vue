<template>
    <div>
      <h1>Manage Categories</h1>
      <form @submit.prevent="submitForm">
        <div>
          <label for="name">Category Name:</label>
          <input id="name" v-model="newCategory.name" type="text" required>
        </div>
        
        <div>
          <label for="parent">Parent Category:</label>
          <select id="parent" v-model="newCategory.parent_id">
            <option value="">No Parent</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>
        
        <button type="submit">Add Category</button>
      </form>
      
      <h2>Existing Categories</h2>
      <ul>
        <li v-for="category in categories" :key="category.id">
          {{ category.name }} (Parent: {{ category.parent ? category.parent.name : 'None' }})
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        categories: [],
        newCategory: {
          name: '',
          parent_id: null,
        },
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
      submitForm() {
        axios.post('/api/categories', this.newCategory)
          .then(response => {
            console.log("Category added:", response.data);
            this.categories.push(response.data);
            this.newCategory = { name: '', parent_id: null }; // Reset form
          })
          .catch(error => {
            console.error("There was an error adding the category:", error);
          });
      }
    },
    created() {
      this.fetchCategories();
    }
  };
  </script>
  