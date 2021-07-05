<template>
<div>
	<div class="header">
		<div class="container">
			<div class="navbar">
				<div class="logo">
					<img src="images/logo.png" width="100px">
				</div>
				<nav>
					<ul>
						<li><a href="">Home</a></li>
						<li><a href="">Product</a></li>
						<li><a href="">Profile</a></li>
						<li><a href="">Account</a></li>
					</ul>
				</nav>
				<img src="images/cart.png" width="30px" height="30px">
			</div>
			
		</div>
	</div>
		
	<!--chi tiet 1 san pham-->
	<div class="small-container product-details-page">
		<h1>Thông tin sản phẩm</h1>
		<div class="row">
			<div class="col2">
				<img src="images/image1.png" width="100%" id="ProductImg">
				<div class="small-img-row">
					<div class="small-img-col">
						<img src="#" width="100%" class="small-img">
					</div>
					<div class="small-img-col">
						<img src="#" width="100%" class="small-img">
					</div>
					<div class="small-img-col">
						<img src="#" width="100%" class="small-img">
					</div>
					<i class="fas fa-plus"></i>
				</div>

			</div>
			<div class="col2">
				<h1>Iphone 12 pro max</h1>
				<p>10000$</p>
				<a href="" class="btn">Mua ngay</a>
			</div>
		</div>
	</div>
	<!--Mo ta, danh gia, binh luan-->
	<div class="small-container">
		<h2>Thông số kỹ thuật</h2>
		<table>
			<tr>
				<th>Thuộc tính</th>
				<th>Mô tả</th>
			</tr>
			<tr>
				<td>Ram</td>
				<td>1GB</td>
			</tr>
		</table>
		<h2>Bình luận</h2>
		<div>
			<h4>Bởi: unname</h4>
			<p>comment</p>
			<div class="input-comment">
				<textarea name="comments" cols="50" rows="5" class="html-text-box" placeholder="nhập bình luận của bạn tại đây..."></textarea>
				<br>
				<button class="btn">Gửi</button>
			</div>
		</div>
	</div>

	<!--title-->
	<div class="small-container">
		<div class="row row-2">
			<h2>San pham lien quan</h2>
			<p>xem them</p>
		</div>
	</div>

	<!-----footer---->
	<div class="footer">
		<div class="container">
			<div class="row">
				<div class="footer-col-1">
					<h3>Web nay rat xin</h3>
				</div>
				<div class="footer-col-2">
					<h3>San pham cua</h3>
				</div>
			</div>
		</div>
	</div>
</div>
</template>
	<!----js---->

<script>
		export default {
    data(){
        return {
        msg,
        Product: [],
      }
    },

    async created() {
      axios.get('/api/product')
      .then(response => {
        this.Product= response.data;
      })
      .catch(function(){
        console.log('Loi san pham');
      });
    },
    
}
</script>

<style>
    @import "../css/product_details.css";
    @import url("https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css");
</style>