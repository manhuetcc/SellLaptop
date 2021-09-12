<template>
<div class="main-section">
    <div class="head-section">
    <div class="headLeft-section">
        <div class="headLeft-sub">
            <input type="text" name="search" placeholder="Search...">
            <button> <i class="fa fa-search"></i> </button>
        </div>
    </div>
    <div class="headRight-section">
        <div class="headRight-sub">
            <h3 v-if="currentChannel">{{listUser[currentChannel-1].name}}</h3>
            <small></small>
        </div>
    </div>
</div>
<div class="body-section">
<div class="left-section mCustomScrollbar" data-mcs-theme="minimal-dark">
<ul>
    <li v-if="listUser[0]!=null">
        <div class="chatList" v-for="(listmsg, index) in listMessage[0]" :key="index" @click="currentChannel=listmsg.channel ">
            <div class="img">
                <img :src="'/uploads/avatar/' + listmsg.sender+'/'+listUser[listmsg.sender-1].avatar">
            </div>
            <div  class="desc" >
                 <small class="time">05:30 am</small> 
                <h5>{{listUser[listmsg.channel-1].name}}</h5>
                  <small>Message</small>
            </div>
        </div>
    </li>
    <!--<li class="active">
        <div class="chatList">
            <div class="img">
                <img src="/demo/man03.png">
            </div>
            <div class="desc">
                <small class="time">4 day</small>
                    <h5>Lajy Ion</h5>
                <small>Lorem ipsum dolor sit amet...</small>
            </div>
        </div>
    </li>!-->

</ul>
</div>
<div class="right-section" >
<div class="message mCustomScrollbar" data-mcs-theme="minimal-dark" ref="chatbox">
<ul v-for="(message,index) in messages" :key="index" >

    <li v-if="user[0].id != message.sender" class="msg-left">
        <div class="msg-left-sub">
            
                <div class="msg-desc">
                    {{message.content}}
                </div>
            <small>{{message.created_at}}</small>
        </div>
    </li>
    <li v-else class="msg-right">
        <div class="msg-left-sub">
            <img :src="'/uploads/avatar/' + user[0].id+'/'+user[0].avatar">
                <div class="msg-desc">
                    {{message.content}}
                </div>
            <small>{{message.created_at}}</small>
        </div>
    </li>

</ul>

</div>
    <div class="right-section-bottom">
        <form>
            <div class="upload-btn">
                <button class="btn"><i class="fa fa-photo"></i></button>
            </div>
            <div class="inputMsg">
                <input  v-model="inputMessage" type="text" name="" placeholder="type here..." v-on:keydown.enter.prevent="saveMessage($event,inputMessage)">
                <button class="btn-send" @click="saveMessage($event,inputMessage)"> Send</button>
            </div>
        </form>
    </div>
    </div>
    </div>
</div>
</div>
</template>
<script>
import $ from 'jquery'
export default {
    data() {
        return {
            user:[],
            messages:{},
            currentChannel:0,
            listMessage:[],
            inputMessage:'',
            showChat:false,
            listUser:[],
            msgRespond:[],
        }
    },
    created () {
        this.getUser();
        this.getList();
        this.getListUser();
        this.getMessageRespond();
        // this.currentChannel = this.$route.params.channel
        // if(this.$route.params.channel!=null){
        // Echo.private(`room.${this.currentChannel}`)
        // .listen('MessagePosted', (e) => {
        //   this.messages.push(e.message) 
        // })   
    // }
    },
    beforeDestroy () {
    // huỷ lắng nghe tin nhắn ở chatroom hiện tại
    // nếu như user chuyển qua route/chatroom khác
    Echo.leave(`channel.${this.currentChannel}`)
},
  methods: {
      //get tin nhan
      async getMessages(){
        try {
        const response = await axios.get(`/api/messages/${this.currentChannel}`)
        this.messages = response.data
        //this.scrollToBottom(document.getElementById('shared_room'), false)
      } catch (error) {
        console.log(error)
      }
      },
      //luu tin nhan
      async saveMessage (event,content) {
        event.preventDefault();
        this.inputMessage=''
      try {
        const response = await axios.post('/api/messages', {
          channel: this.currentChannel,
          content
        })
        this.messages.push(response.data.message)
        // this.$nextTick(() => {
        this.$nextTick(() => {
          this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight
        });
        // })
      } catch (error) {
        console.log(error)
      }
    },
    //
    async respondMessage (content) {
      try {
        const response = await axios.post('/api/messages', {
          channel: this.currentChannel,
          content
        })
        this.messages.push(response.data.message)
        this.$nextTick(() => {
          this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight
        });
      } catch (error) {
        console.log(error)
      }
    },
    //
    async getList(){
        try {
        const response = await axios.get(`/api/listmessages`)
        this.listMessage = response.data
      } catch (error) {
        console.log(error)
      }
    },
    //
    async getUser(){
        try {
        const response = await axios.get(`/api/profile`)
        this.user = response.data
      } catch (error) {
        console.log(error)
      }
    },
    //
    async getListUser(){
        try {
        const response = await axios.get(`/api/listuser`)
        this.listUser = response.data
      } catch (error) {
        console.log(error)
      }
    },
    //
    async getMessageRespond(){
        try {
        const response = await axios.get(`/api/msgrespond`)
        this.msgRespond = response.data
        console.log(this.msgRespond)
      } catch (error) {
        console.log(error)
      }
    },
    //
    scrollToBottom (){
      var messageDisplay = vueContent.$refs.chatbox;
      messageDisplay.scrollTop = messageDisplay.scrollHeight;
    },
  //
    
  },
  watch:{
      currentChannel(){
        this.getMessages();
         Echo.private(`channel.${this.currentChannel}`)
        .listen('MessagePosted', (e) => {
          this.messages.push(e.message)
          // if(e.message.content)    
        })
        this.$nextTick(() => {
          this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight
        });
      }
  }
}
</script>
<style src="../css/css_message.css" scoped>