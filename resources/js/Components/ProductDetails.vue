<template>
    <div>   
        <div class="small-container product-details-page">
            <h1>Thông tin sản phẩm</h1>
            <div class="row">
                <div class="col2">
                    <img v-if="changeAvt == false" :src="'../uploads/imagesProduct/' + images[0]" width="100%" id="ProductImg">
                    <img v-else :src="Avt_src" width="100%" height="500px" id="ProductImg">
				    <div class="small-img-row">
                         <div class="small-img-col" v-for="(image, index) in images" :key="index">
                            <img :src="'/uploads/imagesProduct/' + image" width="100%" class="small-img" @click="gotoAvatar(image)">
                        </div>
				    </div>             
                </div>
                <div class="col2" v-if="product[0] != null">
                    <h2>{{ product[0].name }}</h2>
                    <p><b>{{ formatPrice(product[0].price)+"đ"}}</b></p>
                    <h3>Tình trạng : {{product[1].name}}</h3>
                    <button  v-if="isuser" class="btn" @click="buy($event, product[0].id)">Mua ngay</button>
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
                <tr v-for="(features, index) in product[3]" :key="index">
                    <td>{{ features.property }}</td>
				    <td>{{ features.feature }}</td>
                </tr>
            </table>
            <h2>Bình luận</h2> 
            <div class="comment" v-for="(comment, index) in comments" :key="index">
                <h4 class="you" v-if="user[0] != null && comment.user_id == user[0].id"><strong>{{ comment.name }}</strong></h4>
                <h4 v-else><strong>{{ comment.name }}</strong></h4>
                <p>{{ comment.content }}</p>
            </div>
            <div class="comment" v-if="isComment">
                <h4><strong>{{ user[0].name }}</strong></h4>
                <p>{{ tempComment }}</p>
            </div>
            <div class="input-comment">
                <textarea name="comments" cols="50" rows="5" v-model="comment.content" placeholder="nhập bình luận của bạn tại đây..."></textarea>
                <br>
                <button class="btn" @click="postcomment($event,comment.content)">Gửi</button>
            </div>
        </div>

	<!--title-->
        <div class="small-container" v-if="recommend_products[0] != null">
                <h1>Sản phẩm liên quan</h1>
                <div class="row">
                    
                </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['id',],

    data() {
        return {
            product:[],
            recommend_products:[],
            images:[],
            isuser: false,
            user:[],
            comment:{},
            comments:[],
            isComment:false,
            tempComment:'',
            Avt_src: "",
            changeAvt: false,
        }
    },
    mounted() {
        axios.get('/api/product/' + this.id)
        .then(respond => {
            this.product = respond.data;
            if(this.product[0].image !== "") {
                this.images = JSON.parse(this.product[0].image);
                console.log(this.images);
            }
            })          
        .catch(function(err){
            console.log(err);
        });

        axios.get('/api/profile')
		.then(respond => {
			this.user = respond.data;
		})
		 .catch(function(){
                    console.log('Loi tai user');
        });

        axios.get('/api/product/comments/'+this.id)
      .then(response => {
        this.comments = response.data;
      })
      .catch(function(error){
        console.log(error);
      });
	},
    methods: {
        formatPrice(value) {
        let val = (value/1).toFixed(0).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    },
    buy(event, product_id) {
                event.preventDefault();
                if (!this.isuser) {
                    window.location.href = '/login';
                    return;
                } else {
                    this.$router.push('/order/' + product_id);
                    return;
                };
            },
    postcomment(event, content)
    {
        this.tempComment = content;
        //event.preventDefault();
        if(content == null || content =='') {alert('Xin nhập nội dung');}
        else{
        this.comment.user_id = this.user[0].id;
        this.comment.product_id = this.id;
        axios.post('/api/comment',this.comment)
        .then(response => {
            this.isComment=true;
            this.comment.content='';
        })
        .catch(function(err){
            console.log(err);
        });
        }
    },
    gotoAvatar(image){
        this.Avt_src = '../uploads/imagesProduct/' + image;
        this.changeAvt = true;
    },
    },
    watch: {
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
<style scoped>
    @import "../css/css_product_details.css";
</style>