<template>
<div>
	<div class="header">
		<div class="container">
			<div class="navbar">
				<div class="logo">
					<a href="/index"><img src="/../images/Banner.jpg" width="90px"></a>
				</div>
				<nav>
					<ul>
						<li><router-link to="/index">Home</router-link></li>
						<li><router-link to="/products">Product</router-link></li>
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
				<img class="mainavatar" :src="'/../uploads/avatar/'+user[0].avatar" width="230px" height="200px" @click="editAvatar = 'True'">
				<br>
				<h4>Ảnh đại diện</h4>
				<input type="file" id="file" name="file" ref="file" @change="handleFileUpload()" v-if="editAvatar">
			</div>
			<div>
				<button class="btn-cancel" v-if="editAvatar" @click="editAvatar = false">Hủy</button>
				<button class="btn-save" v-if="editAvatar" @click="saveAvt()">Lưu</button>
			</div>
			<div class="col2">
				<h2>Thông tin người dùng</h2>
				<hr>
				<h4>Họ tên:</h4>
				<p v-if="editDetail==false">{{user[0].name}}</p>
				<input type="text" name="fullname" v-model="user[0].name" v-if="editDetail"></input>
				<h4>Địa chỉ:</h4>
				<p>bắc ninh</p>
				<h4>Email:</h4>
				<p>{{user[0].email}}</p>
				<h4>Được tạo ngày:</h4>
				<p>{{user[0].created_at}}</p>
				<div>
					<button  @click="editDetail = true">Chỉnh sửa thông tin</button>
					<button class="btn-cancel" v-if="editDetail" @click="editDetail = false">Hủy</button>
					<button class="btn-save" v-if="editDetail" @click='updateDetail()'>Lưu</button>
				</div>
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
	props: ['csrf',],

    data() {
        return {
			user:[], 
			editAvatar: false,
			editDetail: false,
		}
	},
	mounted() {
		axios.get('/api/profile')
		.then(respond => {
			this.user = respond.data;
			//this.cacheUser = Object.assign({}, this.user[0]);
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
        },

		saveAvt() {
			const config = {
			headers: {
				'Content-Type': 'multipart/form-data',
				}
			}
			//form data
			let formData = new FormData();
			formData.append('file', this.file);
			axios.post('/api/profile/avatar', formData, config)
			.then(response => {
				console.log('ok');
				console.log(response.data);
				this.user[0].avatar = response.data;
				//this.cacheUser.avatar = response.data;
			}) 
			.catch(function(){
				console.log('fail');
			});
				this.editAvatar = false;
		},

		handleFileUpload(){
			this.file = this.$refs.file.files[0];
		},

		updateDetail(){
			var saveUser = this.user[0];
			axios.put('api/profile', saveUser, {
				headers: {
					'Authorization': `token ${this.csrf}`
				}
			}).then( response => {
				console.log(response);
			} );
			this.editDetail = false;
		}
		
}
}
</script>
<style scoped>
    @import "../css/cssprofile.css";
</style>