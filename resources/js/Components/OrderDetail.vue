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
                      <a href="#" @click="logout()">Đăng xuất</a>
                  </div>
              </div>
            </div>
          </div>
        </div>

<div v-if="product[0] && isuser">
            <h1>Tiến hành đặt sản phẩm:</h1>
            
            <div>
                <div class="row">
                    <div class="col70">
                         <div class="small-row">
                    <label class="infor" for="">Tên khách hàng:</label>
                    <input class="infor-input" type="text" v-model="user[0].name" disabled>
                </div>
                <div class="small-row">
                    <label class="infor" for="">Số điện thoại đặt hàng:</label>
                    <input class="infor-input" type="text" v-model="order.phone_order" >
                </div>
                <div class="small-row">
                    <label class="infor" for="">Địa chỉ đặt hàng:</label>
                    <input class="infor-input" type="text" v-model="order.address_order" >
                </div>
                <div class="small-row">
                    <label class="infor1" for="">Đơn giá:</label>
                    <p>{{ formatPrice(this.product[0].price)}}</p>
                </div>
                <div class="small-row">
                    <label class="infor2" for="" margin-top="2.5px">Số lượng đặt hàng:</label>
                    <div>
                        <button @click="number-=1" v-if="number > 1">-</button>
                        <button @click="number=1" v-else>-</button>
                        <span>{{ number }}</span>
                        <button @click="number+=1">+</button>
                    </div>
                </div>
                    </div>
                    <div class="col20">
                        <h3>{{ product[0].name }}</h3>
                        <img :src="'/uploads/imagesProduct/' + product[0].thumbnail">
                    </div>
                </div>
               
                <hr>
            <div class="total-price">
			    <table>
				<tr>
					<td>Tổng tiền</td>
					<td>{{ formatPrice(this.temp)}}</td>
				</tr>
				<tr>
					<td>Giảm giá</td>
					<td>{{ formatPrice(this.discount)}}</td>
				</tr>
				<tr>
					<td>Thanh toán</td>
					<td>{{ formatPrice(this.total)}}</td>
				</tr>
			</table>
		</div>
                <button class="btn" @click="completeOrder()" v-show="completed == false">Hoàn tất</button>
                <button class="btn-cancel" @click="cancelOrder()" v-show="completed == false">Hủy</button>
                <div v-show="completed == true">
                    <h3>Bạn đã đặt hàng thành công</h3>
                    <router-link :to="{name: 'Products'}" class="btn">Tiếp tục mua hàng</router-link>
                    <router-link :to="{name: 'Listorder'}" class="btn">Lịch sử đặt hàng</router-link>
                </div>
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
    props: [
            'id',
        ],
    data() { 
        return {
            user:[],
            product:[],
            order:{},
            isuser:false,
            number: 1,
            temp:0,
            discount:0,
            total: 0,
            completed: false,
            show_profile: false,
        }
    },
    mounted() {
        axios.get('/api/product/'+this.id)
        .then(respond=>{
            this.product = respond.data;
            this.temp=this.product[0].price;
        }).
        catch(function(err)
        {
            console.log(err);
        });

        axios.get('/api/profile')
        .then(respond=>{
            this.user = respond.data;
        }).
        catch(function(err)
        {
            console.log(err);
        });
    },
    methods:{
        formatPrice(value){
        let val = (value/1).toFixed(0).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+'đ'
    },
    completeOrder(){
        if(this.order.phone_order == '' || this.order.address_order == null) {alert('Xin nhập đủ thông tin ');}
        else{
        this.order.user_id = this.user[0].id
        this.order.product_id = this.product[0].id;
        this.order.quantity = this.number;
        this.order.price = this.product[0].price;
        this.order.status_order_id = 1;
        axios.post('/api/order', this.order)
                .then(response => {
                    // console.log(response.data);
                    this.completed = true;
                })
                .catch(function(err){
                  console.log(err);
                });
        }
    },
    cancelOrder() {
                this.$router.push('/index');
            },
    logout() {
        axios.post('api/logout')
            .catch(error => {
                window.location.href = '/login';
        });
    },
    },
    watch: {
        number() {
            this.temp=this.number * this.product[0].price;
        },
        temp() {
            this.total=this.temp - this.discount;
        },
        user() {
            if(this.user.length > 0)
            {
                this.isuser = true;
            }
            else 
            {
                this.isuser = false;
            }
        },
    }
}
</script>>
<style src="../css/css_order.css" scoped>