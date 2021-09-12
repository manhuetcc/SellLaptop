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
                        <a v-for="(category, index) in categories" :key="index" :value="category.id" @click="directCategory($event,category.id)">{{ category.name }}</a>
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
                    {{ message.content }}
                </li>
                <li v-else class="server">
                    {{ message.content }}
                </li>
              </ul>
            </div>
            <div class="hint">
              <ul class="quick-reply">
                <li v-for="(hint, index) in tempSuggest" :key="index" @click="controlConversation(index)">{{hint.ask}}</li>
                <li v-if="this.temp.length!=0" @click="backthen()"> Quay lại</li>
              </ul>
            </div>
            <div class="inputmsg">
              <textarea  placeholder="type message" v-model="message" v-on:keydown.enter.prevent="saveMessage(message)" >
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
        this.getMessageRespond();
        this.latestProduct();
        this.getProducts();
        this.getMyorder();
        this.tempSuggest=this.defaultSuggest;
        this.prevMessage=this.defaultSuggest;
      },
        data() {
            return {
                user: [],
                categories: [],
                products:[],
                myorder:[],
                keyword: '',
                isuser: false,
                show_profile: false,
                dialogChat: false,
                messages:[],
                message:'',
                isAdmin:1,
                currentChannel:0,
                msgRespond:[],
                latestPoduct:[],
                countMsg:0,
                productByKeyWord:[],
                tempMsg:'',
                defaultSuggest:[
                  {
                    ask:'Tư vấn sản phẩm',
                    subask:[
                      {ask:'Dell',subask:[{ask:'Dell xps',subask:[]},{ask:'Dell Inspiron',subask:[]}]},
                      {ask:'Asus',subask:[{ask:'Asus TUF',subask:[]},{ask:'Asus Vivo',subask:[]}]},
                      {ask:'Macbook',subask:[{ask:'Macbook Pro',subask:[]},{ask:'Macbook Air',subask:[]}]},
                      {ask:'sản phẩm mới nhất',subask:[]},
                      {ask:'các sản phẩm',subask:[]}
                      ]
                  },
                  {ask:'Kiểm tra đơn hàng',subask:[{ask:'Đã nhận',subask:[]},{ask:'Đang vận chuyển',subask:[]},{ask:'Bị hủy',subask:[]}  ]},
                  {ask:'Tra cứu bảo hành',subask:[]},
                  {ask:'Chat với nhân viên',subask:[]},
                  ],
                  tempSuggest:[],
                  prevMessage:'',
                  temp:[],
                //listUser:[],
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
        computed:{
          
        },
        methods: {
          openDialog(){
            if(this.isAdmin!=2){
            this.dialogChat = true;
            this.saveMessage('Chào bạn mình có thể giúp gì cho bạn?')
            this.$nextTick(() => {
                  this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight
                  })
            Echo.private(`channel.${this.currentChannel}`)
            .listen('MessagePosted', (e) => {
              this.messages.push(e.message)
              this.$nextTick(() => {
              this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight
        });
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
        //get new product
        async latestProduct(){
          try {
          const response = await axios.get('/api/newproduct')
          this.latestPoduct = response.data
        } catch (error) {
          console.log(error)
        }
        },
        //api get product
        async getProducts(){
          try {
          const response = await axios.get('/api/products')
          this.products = response.data
          console.log(this.products.data[0].name);
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
    //get myorder
    async getMyorder(){
        try {
        const response = await axios.get(`/api/listorder`)
        this.myorder = response.data.listOrders;
      } catch (error) {
        console.log(error)
      }
      },
    async getMessageRespond(){
        try {
        const response = await axios.get(`/api/msgrespond`)
        this.msgRespond = response.data
      } catch (error) {
        console.log(error)
      }
    },
    async searchkeyword(keyword){
      axios.get('/api/products?key=' + keyword)
        .then(response => {
        this.productByKeyWord = response.data.data
          })          
        .catch(function(err){
            console.log(err);
        });
    },
    //dan dat cuoc hoi thoai
    controlConversation(index){
        this.temp.push(index)
        this.saveMessage(this.tempSuggest[index].ask)
        if(this.temp.length==1) this.tempSuggest=this.defaultSuggest[index].subask;
        else{
            this.tempSuggest=this.tempSuggest[this.temp[this.temp.length-1]].subask
        }
    },
        //back to main request
    backthen(){
      if(this.temp.length>0) this.temp.pop();
      this.prevMessage=this.defaultSuggest;
      for(let i=0;i<this.temp.length;i++)
      {
        this.prevMessage=this.prevMessage[this.temp[i]].subask;
      }
      this.tempSuggest=this.prevMessage;
    },
    //phan hoi noi dung da fix trong chatbot
     async checkMessage(content){
          axios.post('/api/messagerespond', {
            channel: this.user[0].id,
            content:content,
            sender:1,
          })
            .then(response => {
                this.messages.push(response.data.message);
                // this.countMsg++;
                this.$nextTick(() => {
                this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight
                })
                this.message='';
            })
            .catch(function(err){
              console.log(err);
            });
        },

          //smart bot
          upgradeBot(content)
          {
            const str = content;
            const words = str.split(' ');
            var categoryId = -1;
            var indexCategory =-1;
            if(words.includes('hi')) return "Chào "+this.user[0].name;
            if(str.includes('Tư vấn sản phẩm')){
              return 'Bạn hãy nhập tên nhà sản xuất hoặc tên máy theo mẫu'
            }
            if(str.includes('Kiểm tra đơn hàng')){
              return 'Bạn hãy nhập trạng thái của đơn hàng'
            }
            if(str.includes('Tra cứu bảo hành')){
              let tempList='';
              let countList=0;
              for(let i=0;i<this.myorder.length;i++)
              {
                if(this.myorder[i].status_name == 'Hoàn thành')
                {
                  countList++;
                  tempList+=this.myorder[i].product_name+' thời gian mua '+this.myorder[i].created_at
                }
              }
              if(countList==0) return 'Bạn chưa mua sản phẩm nào tại shop';
              return "Sản phẩm bạn đã mua tại shop "+countList+' sản phẩm gồm: '+tempList;
            }
            if(str.includes('Chat với nhân viên')){
              return 'Chúng tôi sẽ liên hệ với tư vấn viên để liên hệ sớm nhất lại với bạn'
            }
            //kiem tra don hang cua khach
            if(str.includes('Đã nhận'))
            {
              let tempList='';
              let countList=0;
              for(let i=0;i<this.myorder.length;i++)
              {
                if(this.myorder[i].status_name == 'Hoàn thành')
                {
                  countList++;
                  tempList+=this.myorder[i].product_name+' '
                }
              }
              if(countList==0) return 'Bạn không có đơn hàng được vận chuyển thành công';
              return "Đơn hàng đã vận chuyển thành công "+countList+' đơn hàng gồm: '+tempList;
            }
            //shipping
            if(str.includes('Đang vận chuyển'))
            {
              let tempList='';
              let countList=0;
              for(let i=0;i<this.myorder.length;i++)
              {
                if(this.myorder[i].status_name == 'Đang giao hàng')
                {
                  countList++;
                  tempList+=this.myorder[i].product_name+' '
                }
              }
              if(countList==0) return 'Bạn không có đơn hàng nào đang vận chuyển';
              return "Đơn hàng đang vận chuyển "+countList+' đơn hàng gồm: '+tempList;
            }
            //cancel
            if(str.includes('Bị hủy'))
            {
              let tempList='';
              let countList=0;
              for(let i=0;i<this.myorder.length;i++)
              {
                if(this.myorder[i].status_name == 'Bị hủy')
                {
                  countList++;
                  tempList+=this.myorder[i].product_name+' '
                }
              }
              if(countList==0) return 'Bạn không có đơn hàng nào bị hủy';
              return "Đơn hàng đang vận chuyển "+countList+' đơn hàng gồm: '+tempList;
            }
            //cac loai san pham
            if(str.includes('các sản phẩm')) 
            {
              let cate=" ";
              for(let i=0;i<this.categories.length;i++)
              {
                cate+=this.categories[i].name+' '
              }
              return 'shop có '+this.categories.length+' hãng là: '+cate+' và có tổng cộng '+this.products.data.length +' sản phẩm';
            }            
            //san pham moi nhat
            if(str.includes("sản phẩm mới nhất")) return 'Đây là sản phẩm mới nhất ' + this.latestPoduct[0].name
            for(let j=0; j<this.categories.length;j++)
            {
              if(words.includes(this.categories[j].name)) 
              {
                categoryId = this.categories[j].id             
              }            
            }
            //lay index cua san pham trong str
            if(categoryId!=-1) indexCategory = words.indexOf(this.categories[categoryId-1].name);
            console.log('index'+indexCategory);
            // Lay ra san pham cua khach hang
            if(indexCategory!=-1 && indexCategory != (words.length-1))
            {
              var result="";
              let keyWord = words.slice(indexCategory,indexCategory+2).join(" ");
              axios.get('/api/products?key=' + keyWord)
              .then(response => {
                  this.productByKeyWord= response.data.data;
              if(this.productByKeyWord.length != 0) 
              {
                result +='Danh sách '+keyWord+' có '+this.productByKeyWord.length+' sản phẩm: '
                for(let i=0;i<this.productByKeyWord.length;i++)
                {
                  result += this.productByKeyWord[i].name+',  \n';
                }
                this.tempMsg = result;
                console.log(result);
              }
              })
              .catch(function(err){
                console.log(err);
              });            
                //neu api co ket qua thi tra ve cho khach
            }
            else if(categoryId!=-1) return 'Đây là danh mục sản phẩm '+this.categories[categoryId-1].name+' 127.0.0.1:8000/category/' + this.categories[categoryId-1].id;
            // chuyen huong toi tu van vien
            if(this.countMsg >= 6) return "Tôi sẽ liên hệ tư vấn viên của shop để trả lời cho bạn"
            return 0;
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
          directCategory(event,id) {
            //event.preventDefault();
            this.$router.push('/category/' + id);
          },
          saveMessage(content){
            axios.post('/api/messages', {
              channel: this.user[0].id,
              content
            })
              .then(response => {
                  this.messages.push(response.data.message);
                  this.message='';
                  this.$nextTick(() => {
                  this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight
                  })
              let index = this.msgRespond.findIndex(function(post, index) {
                if(post.msg == content)
                return true;
                });
              //phan hoi theo nhung cau co san trong bang chatbots
              if(index != -1) this.checkMessage(this.msgRespond[index].respond);  
              //neu co nhung cau trong ham upgradebot thi phan hoi  
              if(this.upgradeBot(content)){
                  this.checkMessage(this.upgradeBot(content));       
              }
              })
              .catch(function(err){
                console.log(err);
              });
          }
  },
    watch:{
            user() {
                if(this.user.length > 0) {
                    this.isuser = true;
                }
                else {
                    this.isuser = false;
                }
            },
            tempMsg(){
              if(this.tempMsg!='')
              {
                this.checkMessage(this.tempMsg);
                  this.message='';
              }
            },
            temp(){
              
            }
        }
}
</script>

<style src="../css/css_products.css" scoped>