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
                  <li v-if="isAdmin==2"><router-link to="/message">Tin Nhắn</router-link></li>
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
        <div>
        </div>
          <router-view></router-view>
          <button class="open-button" v-if="!dialogChat" @click="openDialog()"><img src="https://play-lh.googleusercontent.com/ldcQMpP7OaVmglCF6kGas9cY_K0PsJzSSosx2saw9KF1m3RHaEXpH_9mwBWaYnkmctk" height="40px"></button>
          <div class="chatbox" v-if="dialogChat">
            <div class="item1"></div>
            <div class="item2"><button type="button" class="btn-close btn-close-white" aria-label="Close" @click="dialogChat=false">&#10006</button></div>
            <div class="chat-box-list-container" ref="chatbox">
              <ul class="chat-box" v-for="(message, index) in messages" :key="index">
                <li v-if="user[0].id == message.sender" class="client">
                  <p>
                    {{ message.content }}
                  </p>
                </li>
                <li v-else class="server">
                  <p>
                    {{ message.content }}
                  </p>
                </li>
              </ul>
            </div>
            <div class="inputmsg">
              <textarea  placeholder="type message" v-model="message" @keyup.enter="saveMessage($event,message)" >
              </textarea>
              <button>
                <img src="https://img1.pnghut.com/17/6/22/AfzgpxrSsa/blog-font-awesome-symbol-brand-logo.jpg" @click="saveMessage($event,message)" height="27px" width="30px">
              </button>
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
import Index from './Index.vue'
import Search from './Search.vue'
    export default {
      created() {
        this.getUser();
        this.getMessages();
      },
        data() {
            return {
                user: [],
                categories: [],
                keyword: '',
                isuser: false,
                show_profile: false,
                dialogChat: false,
                messages:[],
                message:'',
                isAdmin:1,
                currentChannel:0
            }
        },

        mounted() {
          //get message
          // axios.get('/api/messages')
          //     .then(response => {
          //         this.messages = response.data
          //     })
          //     .catch(function(err){
          //       console.log(err);
          //     });
              //get user
          // axios.get('/api/profile')
          //     .then(response => {
          //         this.user = response.data;
          //         this.isAdmin = response.data[0].role_id;
          //          //console.log(this.user);
          //          //console.log(this.user.length);
          //     })
          //     .catch(function(){
          //       console.log('Loi tai user');
          //     }); 
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
          openDialog(){
            if(this.isAdmin!=2){
            this.dialogChat = true;
            this.$nextTick(() => {
                  this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight
                  })
            Echo.private(`channel.${this.currentChannel}`)
            .listen('MessagePosted', (e) => {
              this.messages.push(e.message) 
          })}
          },
          //getmessage
          async getMessages(){
          try {
          const response = await axios.get('/api/messages')
          this.messages = response.data
        } catch (error) {
          console.log(error)
        }
        },
        //getuser
        async getUser(){
        try {
        const response = await axios.get(`/api/profile`)
        this.user = response.data;
        this.isAdmin = response.data[0].role_id;
        this.currentChannel = response.data[0].id;
      } catch (error) {
        console.log(error)
      }
    },
    /////////////////
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
          saveMessage(event,content){
            event.preventDefault();
            axios.post('/api/messages', {
              channel: this.user[0].id,
              content
            })
              .then(response => {
                  this.messages.push(response.data.message);
                  this.$nextTick(() => {
                  this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight
                  })
                  console.log(response.data);
                  this.message='';
              })
              .catch(function(err){
                console.log(err);
              });
          }
    //       sendMessage() {
    //         const message = this.message
    //         this.messages.push({
    //           text: message,
    //           author: 'client'
    //         })
    //         this.message='';
    //         if(message=="alo\n")
    //         {
    //           this.messages.push(
    //             {
    //               text:'what the hell?.',
    //               author:'server'
    //             }
    //           )
    //         }
    //         if(message=="help\n")
    //         {
    //           this.messages.push(
    //             {
    //               text:'What do you need?.',
    //               author:'server'
    //             }
    //           )
    //         }
    //         if(message=="an\n")
    //         {
    //           this.messages.push(
    //             {
    //               text:'anlab?.',
    //               author:'server'
    //             }
    //           )
    //         }
    //       this.$nextTick(() => {
    //       this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight
    //       })
    // },
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