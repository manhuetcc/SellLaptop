<template>
<div>
<body>
	<div class="header">
		<div class="container">
			<div class="navbar">
				<div class="logo">
					<a href="index.html"><img src="images/logo.png" width="100px"></a>
				</div>
				<nav>
					<ul>
						<li><a href="">Home</a></li>
						<li><router-link to="/product"><a>Product</a></router-link></li>
						<li <router-link to="/Profile">Profile </router-link></li>
						<li><a>Account</a></li>
					</ul>
				</nav>
				<a href="cart.html"><img src="images/macbook.jpg" width="30px" height="30px"></a>
			</div>
			<div class="row">
				<div class="col-2">
					<h1>Sản phẩm<br> Laptop!</h1>
					<p>web công nghệ</p>
					<router-link to="/product"><a class="btn">link toi trang products &#8594;</a></router-link>
				</div>
				<div class="col-2">
					<img src="images/laptop.png">
				</div>
			</div>
		</div>
	</div>
	

	<div class="categories">
		<div class="small-container">
			<h2 class="title">Thể loại</h2>
			<div class="row">
			<div class="col-3">
				<img src="images/asusrog.jpg">
			</div>
			<div class="col-3">
				<img src="images/laptop.jpg">
			</div>
			<div class="col-3">
				<img src="images/macbook.jpg">
			</div>
		</div>
		</div>
	</div>
	

	<div class="small-container">
		<h2 class="title">Sarn phẩm hot</h2>
		<div class="row">
			<div class="col-4">
				<a href="product_details.html"><img src="images/laptop.jpg"></a>
			    <h4>Laptop Asus</h4>
			    <p>10.000.000 VND</p>
			</div>
			<div class="col-4">
				<img src="images/laptop.jpg">
			    <h4>Laptop Dell</h4>
			    <p>10.000.000 VND</p>
			</div>
			<div class="col-4">
				<img src="images/laptop.jpg">
			    <h4>Laptop Mac</h4>
			    <p>10.000.000 VND</p>
			</div>
			<div class="col-4">
				<img src="images/laptop.jpg">
			    <h4>Laptop Asus</h4>
			    <p>10.000.000 VND</p>
			</div>
		</div>
		<h2 class="title">San pham moi nhat</h2>
		<div class="row">
			<div class="col-4">
				<img src="images/laptop.jpg">
			    <h4>Laptop Asus</h4>
			    <p>10.000.000 VND</p>
			</div>
			<div class="col-4">
				<img src="images/laptop.jpg">
			    <h4>Laptop Asus</h4>
			    <p>10.000.000 VND</p>
			</div>
			<div class="col-4">
				<img src="images/laptop.jpg">
			    <h4>Laptop Asus</h4>
			    <p>10.000.000 VND</p>
			</div>
			<div class="col-4">
				<img src="images/laptop.jpg">
			    <h4>Laptop Asus</h4>
			    <p>10.000.000 VND</p>
			</div>
		</div>
	</div>

	<!-----footer---->
	<div class="footer">
		<div class="container">
			<div class="row">
				<div class="footer-col-1">
					<h3>Web bán laptop</h3>
				</div>
				<div class="footer-col-2">
					<h3>San pham cua Nguyen Huy Manh</h3>
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
        critProduct:[],
        category:[],
        hotProduct:[],
      }
    }

}
</script>
<style>
    @import "../css/css_home.css";
</style>