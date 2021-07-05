<template>
<div>
	<div class="header">
		<div class="container">
			<div class="navbar">
				<div class="logo">
					<a href="index.html"><img src="/../images/banner.jpg" width="100px"></a>
				</div>
				<nav>
					<ul>
						<li><a href="index.html">Home</a></li>
						<li><a href="products.html">Product</a></li>
						<li><a href="#" @click="isShow =! isShow">Account</a></li>
                        <li><a href="#" @click.prevent="logout()">Logout</a></li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	

	<div class="small-container userprofile-page">
		<div class="row">
			<div class="col2">
				<h4>Ảnh đại diện</h4>
				<img class="avatar" src="../images/cart.png">
				<br>
			<button >Upload Images</button>
			</div>
			<div class="col2">
				<h2>Thông tin người dùng</h2>
				<hr>
				<h4>Họ tên:</h4>
				<p>{{user[0].name}}</p>
				<h4>Địa chỉ:</h4>
				<p>bac ninh</p>
				<h4>Email:</h4>
				<p>{{user[0].email}}</p>
				<h4>Được tạo ngày:</h4>
				<p>{{user[0].created_at}}</p>
			</div>
		</div>
	</div>

	<!-----footer---->
	<div class="footer">
		<div class="container">
			<div class="row">
				<div class="footer-col-1">
					<h3>Web ban laptop</h3>
				</div>
				<div class="footer-col-2">
					<h3>San pham cua</h3>
				</div>
			</div>
		</div>
	</div>
</div>
</template>
<script>
export default {
    data() {
        return {
			user:[], 
			email:"",
			created_at:"",
            isShow:"False",
		}
	},
	mounted() {
		axios.get('/api/profile')
		.then(respond => {
			this.user = respond.data;
		})
		 .catch(function(){
                    console.log('Loi tai user');
                });
	},
    methods: {
       logout() {
                axios.post('api/logout')
                    .catch(error => {
                       window.location.href = '/login';
                });
            }
}
}
</script>
<style scoped>
    @import "../css/cssprofile.css";
</style>