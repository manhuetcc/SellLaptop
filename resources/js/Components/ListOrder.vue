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
                  <li><router-link to="/index">Trang chủ</router-link></li>
                  <li><router-link to="/products">Sản phẩm</router-link></li>
                  <li v-if="isuser == false"><a href="/login">Đăng nhập</a></li>
                  <li>
                    <form @submit="search($event)">
                      <input type="text" v-model="keyword" placeholder="Tìm kiếm sản phẩm..." />
                      <button type="submit"><i class="fa fa-search"></i>>></button>
                    </form>
                  </li>
                </ul>
              </nav>
              <router-link to="/listorder" v-if="isuser == true"><img src="/../images/cart.png" width="30px" height="30px"></router-link>
              <div class="account">
                  <img v-if="isuser == true && user[0].avatar == null" class="avatar" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS1CfdSF5Sdj53VRzQtJe8dgcoDLSyH5tK_sGgyhlfs91uiPe4FAg0u_nsBPDIGovorvso&usqp=CAU" width="30px" height="30px" @click="show_profile = !show_profile">
                        <img v-if="isuser == true && user[0].avatar != null" class="avatar" :src="'/uploads/avatar/' + user[0].id+'/'+user[0].avatar" width="30px" height="30px" @click="show_profile = !show_profile">
                  <div class="dropdown-menu" v-show="show_profile == true">
                       <p v-if="user[0] != null"><b>{{ user[0].name }}</b></p>
                      <hr>
                      <router-link to="/profile">Hồ sơ</router-link>
                      <a v-if="isAdmin==2" href="/admin">Trang quản lý</a>
                      <a href="#" @click="logout()">Đăng xuất</a>
                  </div>
              </div>
            </div>
          </div>
        </div>

<div class="small-container">
        <div>
            <h1>Lịch sử mua hàng</h1>
            <h2>Danh sách đơn hàng</h2>
        </div>
        <div class="small-container cart-page">
		<table>
			<tr>
				<th>Sản phẩm</th>
				<th>Số lượng</th>
				<th>Tình trạng đơn hàng</th>
				<th>Cập nhật</th>
			</tr>
            <tr v-for="(order, index) in orders" :key="index">
                <td>
					<div class="cart-info">
						<img :src="'/uploads/imagesProduct/' + order.thumbnail">
						<div>
							<p>{{ order.product_name }}</p>
							<small>Giá: {{ formatPrice(order.price) }}</small>
							<br>
							<a href="" @click="orderDetail($event, order.id)">Xem chi tiết</a>
						</div>
					</div>
				</td>
				<td><span>{{ order.quantity }}</span></td>
				<td v-if="order.status_name == 'Chờ xác nhận'">{{ order.status_name }}</td>
                <td v-else-if="order.status_name == 'Đang vận chuyển'" class="ship">{{ order.status_name }}</td>
                <td v-else class="complete">{{ order.status_name }}</td>
				<td>{{ order.updated_at }}</td>
            </tr>
            <a v-if="amount.total >0" class="amount">Tổng số tiền: {{formatPrice(amount.total)}}</a>
        </table>
        </div>
    </div>

    <div class="footer">
          <div class="container">
            <div class="row">
              <div class="footer-col-1">
                <h3>Web shop</h3>
              </div>
              <div class="footer-col-2">
                <h3>Sản phẩm của: Mạnh</h3>
              </div>
            </div>
          </div>
        </div>
</div>    
</template>
<script>
export default {
    mounted() {
        axios.get('/api/profile')
              .then(response => {
                  this.user = response.data;
                  this.isAdmin = response.data[0].role_id;
                   //console.log(this.user);
                   //console.log(this.user.length);
              })
              .catch(function(){
                console.log('Loi tai user');
        });
        axios.get('/api/listorder')
        .then(respond => 
        {
            this.orders = respond.data.listOrders;
            this.amount = respond.data.totalAmount[0];
        })
        .catch(function(err)
        {
            console.log(err);
        }
        );
    },
    data() {
        return {
            user:[],
            orders:[],
            keyword: '',
            isuser: false,
            show_profile: false,
            amount:0,
            isAdmin:1,
        }
    },
    
    methods: {
        orderDetail($event, id){
            event.preventDefault();
            this.$route.push('/order/'+id);
            return;
        },
        formatPrice(value){
        let val = (value/1).toFixed(0).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+'đ'
        },
        logout() {
                axios.post('api/logout')
                    .catch(error => {
                       window.location.href = '/login';
                });
        },
        search(event) {
            event.preventDefault();
            if (this.keyword == '') {
              return;
            }
            this.$router.push('/product/search/' + this.keyword);
            this.keyword = '';
          },
    },
    watch:{
            user() {
                if(this.user.length > 0) {
                    this.isuser = true;
                }
                else {
                    this.isuser = false;
                }
            }
        }

}
</script>
<style src="../css/css_listOrders.css" scoped>