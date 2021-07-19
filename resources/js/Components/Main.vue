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
                  <li>
                    <div class="dropdown">
                      <button class="dropbtn">Hãng</button>
                      <div class="dropdown-content">
                        <a v-for="(category, index) in categories" :key="index" :value="category.id" @click="direct($event,category.id)">{{ category.name }}</a>
                      </div>
                    </div>
                  </li>
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
                        <img v-if="isuser == true && user[0].avatar != null" class="avatar" :src="'/uploads/avatar/' + user[0].avatar" width="30px" height="30px" @click="show_profile = !show_profile">
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
        <div>
        </div>
          <router-view></router-view>
          <button class="open-button" @click="dialogChat=!dialogChat">Chat</button>
          <div class="chat-popup" >
            <form action="" class="form-container" v-if="dialogChat">
              <h1>Chat</h1>

              <label for="msg"><b>Message</b></label>
              <textarea placeholder="Type message.." name="msg" required></textarea>

              <button type="submit" class="btn">Send</button>
              <button type="button" class="btn cancel" @click="dialogChat=false">Close</button>
            </form>
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
import Index from './Index.vue'
import Search from './Search.vue'
    export default {
        data() {
            return {
                user: [],
                categories: [],
                keyword: '',
                isuser: false,
                show_profile: false,
                dialogChat: false,
            }
        },

        mounted() {
          axios.get('/api/profile')
              .then(response => {
                  this.user = response.data;
                   //console.log(this.user);
                   //console.log(this.user.length);
              })
              .catch(function(){
                console.log('Loi tai user');
              });
          axios.get('/api/category')
              .then(response => {
                  this.categories= response.data;
                  // console.log(this.categories);
              })
              .catch(function(){
                console.log('Loi tai danh muc san pham');
              });
        },

        methods: {
          search(event) {
            event.preventDefault();
            if (this.keyword == '') {
              return;
            }
            this.$router.push('/product/search/' + this.keyword);
            this.keyword = '';
          },

          logout() {
                axios.post('api/logout')
                    .catch(error => {
                       window.location.href = '/login';
                });
        },
          direct(event,id) {
            //event.preventDefault();
            this.$router.push('/category/' + id).catch(()=>{});;
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

<style src="../css/css_products.css" scoped>