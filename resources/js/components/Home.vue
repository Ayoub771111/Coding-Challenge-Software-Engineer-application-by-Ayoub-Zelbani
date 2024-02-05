<template>
    <div>
      <h1>Products</h1>
      <div>
        <label for="category">Filter by Category:</label>
        <select id="category" v-model="selectedCategory" @change="fetchProducts">
          <option value="">All</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
  
        <label for="sort">Sort by Price:</label>
        <select id="sort" v-model="sortByPrice" @change="fetchProducts">
          <option value="asc">Ascending</option>
          <option value="desc">Descending</option>
        </select>
      </div>
      
      <ul>
        <li v-for="product in products" :key="product.id">
          {{ product.name }} - {{ product.price }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        products: [],
        categories: [],
        selectedCategory: '',
        sortByPrice: 'asc',
      };
    },
    methods: {
      fetchProducts() {
        let url = `/api/products?sort_by_price=${this.sortByPrice}`;
        if (this.selectedCategory) {
          url += `&category_id=${this.selectedCategory}`;
        }
        axios.get(url)
          .then(response => {
            this.products = response.data;
          })
          .catch(error => {
            console.error("There was an error fetching the products:", error);
          });
      },
      fetchCategories() {
        axios.get('/api/categories')
          .then(response => {
            this.categories = response.data;
          })
          .catch(error => {
            console.error("There was an error fetching the categories:", error);
          });
      }
    },
    created() {
      this.fetchProducts();
      this.fetchCategories();
    }
  };
  </script>
  