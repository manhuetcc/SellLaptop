<template>
<div>
	<div class="row" id="banner">
		<div class="col-2">
			<h1>Những sản phẩm công nghệ<br> chất lượng hàng đầu.!</h1>
			<router-link to="/products" class="btn">Bắt đầu thôi &#8594;</router-link>
		</div>
		<div class="col-2">
			<img src="/./images/macbook.jpg">
		</div>
	</div>
	<!-- Thể loại -->
	<div class="categories">
            <div class="small-container">
                <h2 class="title">Danh mục sản phẩm</h2>
                <div class="row">
                <div class="col-4">
                    <router-link to="/category/1">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/MacBook_logo.svg/1200px-MacBook_logo.svg.png">
                    </router-link>
                </div>
                <div class="col-4">
                    <router-link to="/category/2">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/48/Dell_Logo.svg/1200px-Dell_Logo.svg.png"> 
                    </router-link>
                </div>
                <div class="col-4">
                    <router-link to="/category/1">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/de/AsusTek-black-logo.png">
                    </router-link>
                </div>
				<div class="col-4">
                    <router-link to="/category/4">
                        <img src="https://www.lifewire.com/thmb/fu17x_8w2CbvvxUzUWX25PvZrsQ=/790x442/filters:fill(auto,1)/MSSurfacelogo-91f7990892484b0390d2b14ed16f92d3.jpg">
                    </router-link>
                </div>
            </div>
            </div>
        </div>
		<!-- SP hot -->
		<div class="small-container">
            <h2 class="title">Sản phẩm được ưa chuộng</h2>
            <div class="row">
                <div v-for="(product, index) in topProduct" :key="index" class="col-4" @click="goToProduct(product.id)">
                    <img :src="'/uploads/imagesProduct/' + product.thumbnail">
                    <h4>{{ product.name }}</h4>
                    <p><b>{{ formatPrice(product.price) }}</b></p>
                </div>
            </div>
            <h2 class="title">Sản phẩm mới nhất</h2>
            <div class="row">
                <div class="col-4" v-for="(product, index) in newProduct" :key="index" @click="goToProduct(product.id)">
                    <img :src="'/uploads/imagesProduct/' + product.thumbnail">
                    <h4>{{ product.name }}</h4>
                    <p><b>{{ formatPrice(product.price) }}</b></p>
                </div>
            </div>
        </div>
</div>
</body>
</div>
</template>
<script>
export default {
    data(){
        return {
        isUser: 'false',
        newProduct:[],
        category:[],
        topProduct:[],
      }
    },
	mounted() {
		axios.get('/api/topproduct')
		.then(respond =>
		{
			this.topProduct = respond.data;
		})
		.catch(function(err){
            console.log(err);
        });

        axios.get('/api/newproduct')
		.then(respond =>
		{
			this.newProduct = respond.data;
		})
		.catch(function(err){
                  console.log(err);
                });
	    },
	methods: {
		goToProduct(id){
			this.$router.push('/product/' + id)
		},
        formatPrice(value){
          let val = (value/1).toFixed(0).replace('.', ',')
          return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+'đ'
      },
	},
}
</script>
<style>
    @import "../css/css_home.css";
</style>