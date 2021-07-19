<template>
  <div class="small-container">
    <h2>Tất cả sản phẩm</h2>
		<div v-if="products != null">
			<div class="row">
				<div class="col-4" v-for="(product, index) in products.data" :key="index" @click="directToProduct(product.id)">
					<img :src="'/uploads/imagesProduct/'+product.thumbnail">
					<h4>{{ product.name }}</h4>
					<p><b> {{formatPrice(product.price)+'đ'}} </b></p>
				</div>
			</div>
		</div>
		
		<div class="page-btn">
			<span v-show="current_page > 1" @click="current_page = current_page - 1">&#8592;</span>
			<span v-for="i in last_page" :key="i" @click="current_page = i">
				<a v-if="i == current_page" class="current_page">{{ i }}</a>
				<a v-if="i != current_page" class="page">{{ i }}</a>				
			</span>
			<span v-show="current_page < last_page" @click="current_page = current_page + 1">&#8594;</span>
		</div>
  </div>
</template>
<script>
		export default {
    data(){
        return {
			products: {},
			thumbnail:[],
			current_page: 1,
			last_page: 1,
      }
    },

	mounted() {
      axios.get('/api/products')
      .then(response => {
        this.products = response.data;
		this.last_page =this.products.last_page;
		//console.log(JSON.parse(this.products.data[0].image));
      })
      .catch(function(error){
        console.log(error);
      });
	
	 
	},

	watch: {
		current_page(){
			axios.get('/api/products?page='+this.current_page)
      .then(response => {
        this.products = response.data;
		//this.last_page = response.last_page;
		console.log(products)
      })
      .catch(function(error){
        console.log(error);
      });
		}
	},
	methods:{
		formatPrice(value) {
        let val = (value/1).toFixed(0).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    },
	directToProduct(id){
		this.$router.push('/product/' + id);
	},
}
		}
</script>

<style>
    @import "../css/css_products.css";
    @import url("https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css");
</style>