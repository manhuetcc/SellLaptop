<template>
  <div>
    <h2>Danh mục sản phẩm: {{ category.name }} ({{ products.from }}-{{ products.to }} trong số {{ products.total }})</h2>
    <div class="row">
			<div class="col-4" v-for="(product, index) in products.data" :key="index" @click="goToProduct(product.id)">
				<img :src="'/uploads/imagesProduct/' + product.thumbnail">
				<h4>{{ product.name }}</h4>
				<p><b>{{ formatPrice(product.price) }}</b></p>
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
    props:['id',],
    data() {
        return {
            category: {},
            products: {},
            current_page: 1,
			last_page: 1,
        }
    },
    mounted() {
            axios.get('/api/categories/' + this.id)
                .then(response => {
                    this.category = response.data;
                    // console.log(this.category);
                })
                .catch(function(err){
                  console.log(err);
                });
            axios.get('/api/category/' + this.id)
                .then(response => {
                    this.products = response.data;
                    this.last_page = response.data.last_page;
                    // console.log(this.products.data);
                })
                .catch(function(err){
                  console.log(err);
                });
        },
        methods: {
          formatPrice(value){
          let val = (value/1).toFixed(0).replace('.', ',')
          return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+'đ'
      },
      goToProduct(id){
        this.$router.push('/product/'+id);
      },
        },
}
</script>