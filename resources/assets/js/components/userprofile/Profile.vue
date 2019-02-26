<template>
   <div class="container-fluid mt-3">
	<div class="row">
	  <div class="col-md-3">

		<!-- Profile Image -->
		<div class="card card-primary card-outline">
		  <div class="card-body box-profile">
			<div class="text-center profile-image">
			<el-upload
			  class="avatar-uploader"
			  action="https://jsonplaceholder.typicode.com/posts/"
			  :show-file-list="false"
			  :on-success="handleAvatarSuccess"
			  :before-upload="beforeAvatarUpload">
			  <img v-if="imageUrl" :src="imageUrl" class="profile-user-img img-fluid img-circle el-icon-plus" alt="User profile picture">
			  <i v-else class="el-icon-plus avatar-uploader-icon"></i>		
				<div class="edit"><a href="#"><i class="fas fa-edit"></i></a></div>
			</el-upload>
			  <!--<img class="profile-user-img img-fluid img-circle" src="images/user4-128x128.jpg" alt="User profile picture">-->
			</div>
			<h3 class="profile-username text-center">{{user.fullname}}</h3>

			<p class="text-right text-center">{{user.roles}}</p>
	
		  </div>
		  <!-- /.card-body -->
		</div>
		<!-- /.card -->

		<!-- About Me Box -->
		<div class="card card-primary">
		  <div class="card-header">
			<h3 class="card-title">{{trans('userProfile.aboutUs')}}</h3>
		  </div>
		  <!-- /.card-header -->
		  <div class="card-body">
			<strong><i class="fa fa-book mr-1"></i> {{trans('userProfile.activities')}}</strong>
			<p class="text-right">
			  مجهز به پیشرفته ترین دستگاه سونوگرافی داپلر رنگی پروبهای ترانس واژینال-رادیولوژی ساده-رنگی و opg-و فتوگرافی
			</p>
			<hr>
			<strong><i class="fa fa-map-marker mr-1"></i> {{trans('userProfile.location')}}</strong>
			<p class="text-right">اصفهان – خیابان توحید میانی-نرسیده به چهارراه پلیس-ساختمان آریا-طبقه اول- مرکز تصویربرداری پزشکی بهار</p>
			<hr>
			<strong><i class="fa fa-pencil mr-1"></i> {{trans('userProfile.services')}}</strong>
			<p class="text-right">
			  <li class="tag tag-danger">UI Design</li>
			  <li class="tag tag-success">Coding</li>
			  <li class="tag tag-info">Javascript</li>
			  <li class="tag tag-warning">PHP</li>
			  <li class="tag tag-primary">Node.js</li>
			</p>
			<hr>
			<strong><i class="fa fa-file-text-o mr-1"></i> {{trans('userProfile.manager')}}</strong>
			<p class="text-right">جناب آقای دکتر محمدمهدی جعفری</p>			
			<hr>
			<strong><i class="fa fa-file-text-o mr-1"></i> {{trans('userProfile.technicalAssistant')}}</strong>
			<p class="text-right">سرکارخانم دکتر مریم گلشاهی</p>
		  </div>
		  <!-- /.card-body -->
		</div>
		<!-- /.card -->
	  </div>
	  <!-- /.col -->
	  <div class="col-md-9">
		<div class="card">
		  <div class="card-header p-2">
			<ul class="nav nav-pills">
			  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">{{trans('profile.activities')}}</a></li>
			  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">{{trans('profile.doctors')}}</a></li>
			  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">{{trans('profile.setting')}}</a></li>
			</ul>
		  </div><!-- /.card-header -->
		  <div class="card-body">
			<div class="tab-content">
			  <div class="active tab-pane" id="activity">
				<!-- Post -->
				<div class="post">
				  <div class="user-block">
					<img class="img-circle img-bordered-sm" src="images/user1-128x128.jpg" alt="user image">
					<span class="username">
					  <a href="#">Jonathan Burke Jr.</a>
					  <a href="#" class="float-right btn-tool"><i class="fa fa-times"></i></a>
					</span>
					<span class="description">Shared publicly - 7:30 PM today</span>
				  </div>
				  <!-- /.user-block -->
				  <p>
					Lorem ipsum represents a long-held tradition for designers,
					typographers and the like. Some people hate it and argue for
					its demise, but others ignore the hate as they create awesome
					tools to help create filler text for everyone from bacon lovers
					to Charlie Sheen fans.
				  </p>

				  <p>
					<a href="#" class="link-black text-sm mr-2"><i class="fa fa-share mr-1"></i> اشتراک </a>
					<a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up mr-1"></i> پسندیدن</a>
					<span class="float-right">
					  <a href="#" class="link-black text-sm">
						<i class="fa fa-comments-o mr-1"></i> دیدگاهها (5)
					  </a>
					</span>
				  </p>

				  <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
				</div>
				<!-- /.post -->

				<!-- Post -->
				<div class="post clearfix">
				  <div class="user-block">
					<img class="img-circle img-bordered-sm" src="images/user7-128x128.jpg" alt="User Image">
					<span class="username">
					  <a href="#">Sarah Ross</a>
					  <a href="#" class="float-right btn-tool"><i class="fa fa-times"></i></a>
					</span>
					<span class="description">Sent you a message - 3 days ago</span>
				  </div>
				  <!-- /.user-block -->
				  <p>
					Lorem ipsum represents a long-held tradition for designers,
					typographers and the like. Some people hate it and argue for
					its demise, but others ignore the hate as they create awesome
					tools to help create filler text for everyone from bacon lovers
					to Charlie Sheen fans.
				  </p>

				  <form class="form-horizontal">
					<div class="input-group input-group-sm mb-0">
					  <input class="form-control form-control-sm" placeholder="Response">
					  <div class="input-group-append">
						<button type="submit" class="btn btn-danger">Send</button>
					  </div>
					</div>
				  </form>
				</div>
				<!-- /.post -->

				<!-- Post -->
				<div class="post">
				  <div class="user-block">
					<img class="img-circle img-bordered-sm" src="images/user6-128x128.jpg" alt="User Image">
					<span class="username">
					  <a href="#">Adam Jones</a>
					  <a href="#" class="float-right btn-tool"><i class="fa fa-times"></i></a>
					</span>
					<span class="description">Posted 5 photos - 5 days ago</span>
				  </div>
				  <!-- /.user-block -->
				  <div class="row mb-3">
					<div class="col-sm-6">
					  <img class="img-fluid" src="images/photo1.png" alt="Photo">
					</div>
					<!-- /.col -->
					<div class="col-sm-6">
					  <div class="row">
						<div class="col-sm-6">
						  <img class="img-fluid mb-3" src="images/photo2.png" alt="Photo">
						  <img class="img-fluid" src="images/photo3.png" alt="Photo">
						</div>
						<!-- /.col -->
						<div class="col-sm-6">
						  <img class="img-fluid mb-3" src="images/photo4.png" alt="Photo">
						  <img class="img-fluid" src="images/photo1.png" alt="Photo">
						</div>
						<!-- /.col -->
					  </div>
					  <!-- /.row -->
					</div>
					<!-- /.col -->
				  </div>
				  <!-- /.row -->

				  <p>
					<a href="#" class="link-black text-sm mr-2"><i class="fa fa-share mr-1"></i> Share</a>
					<a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up mr-1"></i> Like</a>
					<span class="float-right">
					  <a href="#" class="link-black text-sm">
						<i class="fa fa-comments-o mr-1"></i> Comments (5)
					  </a>
					</span>
				  </p>

				  <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
				</div>
				<!-- /.post -->
			  </div>
			  <!-- /.tab-pane -->
			  <div class="tab-pane" id="timeline">
				<div class="row">
				  <div class="col-md-4">
					<!-- Widget: user widget style 1 -->
					<div class="card card-widget widget-user">
					  <!-- Add the bg color to the header using any of the bg-* classes -->
					  <div class="widget-user-header text-white" style="background: url('images/photo1.png') center center;">
						<h3 class="widget-user-username">Elizabeth Pierce</h3>
						<h5 class="widget-user-desc">Web Designer</h5>
					  </div>
					  <div class="widget-user-image">
						<img class="img-circle" src="images/user3-128x128.jpg" alt="User Avatar">
					  </div>
					  <div class="card-footer">
						<div class="row">
						  <div class="col-sm-4 border-right">
							<div class="description-block">
							  <h5 class="description-header">3,200</h5>
							  <span class="description-text">SALES</span>
							</div>
							<!-- /.description-block -->
						  </div>
						  <!-- /.col -->
						  <div class="col-sm-4 border-left">
							<div class="description-block">
							  <h5 class="description-header">13,000</h5>
							  <span class="description-text">FOLLOWERS</span>
							</div>
							<!-- /.description-block -->
						  </div>
						  <!-- /.col -->
						  <div class="col-sm-4">
							<div class="description-block">
							  <h5 class="description-header">35</h5>
							  <span class="description-text">PRODUCTS</span>
							</div>
							<!-- /.description-block -->
						  </div>
						  <!-- /.col -->
						</div>
						<!-- /.row -->
					  </div>
					</div>
					<!-- /.widget-user -->
				  </div>
				  <!-- /.col -->
				  <div class="col-md-4">
					<!-- Widget: user widget style 1 -->
					<div class="card card-widget widget-user">
					  <!-- Add the bg color to the header using any of the bg-* classes -->
					  <div class="widget-user-header text-white" style="background: url('images/photo1.png') center center;">
						<h3 class="widget-user-username">Elizabeth Pierce</h3>
						<h5 class="widget-user-desc">Web Designer</h5>
					  </div>
					  <div class="widget-user-image">
						<img class="img-circle" src="images/user3-128x128.jpg" alt="User Avatar">
					  </div>
					  <div class="card-footer">
						<div class="row">
						  <div class="col-sm-4 border-right">
							<div class="description-block">
							  <h5 class="description-header">3,200</h5>
							  <span class="description-text">SALES</span>
							</div>
							<!-- /.description-block -->
						  </div>
						  <!-- /.col -->
						  <div class="col-sm-4 border-left">
							<div class="description-block">
							  <h5 class="description-header">13,000</h5>
							  <span class="description-text">FOLLOWERS</span>
							</div>
							<!-- /.description-block -->
						  </div>
						  <!-- /.col -->
						  <div class="col-sm-4">
							<div class="description-block">
							  <h5 class="description-header">35</h5>
							  <span class="description-text">PRODUCTS</span>
							</div>
							<!-- /.description-block -->
						  </div>
						  <!-- /.col -->
						</div>
						<!-- /.row -->
					  </div>
					</div>
					<!-- /.widget-user -->
				  </div>
				  <!-- /.col -->
				  <div class="col-md-4">
					<!-- Widget: user widget style 1 -->
					<div class="card card-widget widget-user">
					  <!-- Add the bg color to the header using any of the bg-* classes -->
					  <div class="widget-user-header text-white" style="background: url('images/photo1.png') center center;">
						<h3 class="widget-user-username">Elizabeth Pierce</h3>
						<h5 class="widget-user-desc">Web Designer</h5>
					  </div>
					  <div class="widget-user-image">
						<img class="img-circle" src="images/user3-128x128.jpg" alt="User Avatar">
					  </div>
					  <div class="card-footer">
						<div class="row">
						  <div class="col-sm-4 border-right">
							<div class="description-block">
							  <h5 class="description-header">3,200</h5>
							  <span class="description-text">SALES</span>
							</div>
							<!-- /.description-block -->
						  </div>
						  <!-- /.col -->
						  <div class="col-sm-4 border-left">
							<div class="description-block">
							  <h5 class="description-header">13,000</h5>
							  <span class="description-text">تعداد پزشکان مجموعه</span>
							</div>
							<!-- /.description-block -->
						  </div>
						  <!-- /.col -->
						  <div class="col-sm-4">
							<div class="description-block">
							  <h5 class="description-header">35</h5>
							  <span class="description-text">PRODUCTS</span>
							</div>
							<!-- /.description-block -->
						  </div>
						  <!-- /.col -->
						</div>
						<!-- /.row -->
					  </div>
					</div>
					<!-- /.widget-user -->
				  </div>
				  <!-- /.col -->				  
				</div>
			  </div>
			  <!-- /.tab-pane -->

			  <div class="tab-pane" id="settings">
				 <user-profile :userInfo="user.profile_id"></user-profile>
			  </div>
			  <!-- /.tab-pane -->
			</div>
			<!-- /.tab-content -->
		  </div><!-- /.card-body -->
		</div>
		<!-- /.nav-tabs-custom -->
	  </div>
	  <!-- /.col -->
	</div>
	<!-- /.row -->
</div><!-- /.container-fluid -->
</template>

<script>
import UserProfile from './UserProfile.vue';
  export default {
	data(){
					return{
								imageUrl:'images/user4-128x128.jpg',
								form: {

								},
								user:{},
								profile_id:''
					}
        },
			methods: {
				/**
				 * Load User Info
				 */
				loadUserInfo(){					
					axios.get("../api/profile/user").then(({data})=>{(this.user =data.data),(this.profile_id =data.data.profile_id) }).catch((error)=>{
							this.$message({                      
								message:error.response.data.errors,
								center: true,
								type: 'error'
							});

					});
				},
	      handleAvatarSuccess(res, file) {
	        this.imageUrl = URL.createObjectURL(file.raw);
	      },
	      beforeAvatarUpload(file) {
	        const isJPG = file.type === 'image/jpeg';
	        const isLt2M = file.size / 1024 / 1024 < 2;

	        if (!isJPG) {
	          this.$message.error('Avatar picture must be JPG format!');
	        }
	        if (!isLt2M) {
	          this.$message.error('Avatar picture size can not exceed 2MB!');
	        }
	        return isJPG && isLt2M;
				}
			},
			components: { 'user-profile' : UserProfile },
			mounted() {
				this.loadUserInfo();			
			}
    }
</script>
<style>
.el-form-item__label:lang(fa){
	float:right;
	text-align:left;
	padding:0 0 0 10px;
}
.el-form-item__content:lang(fa){
	margin-right:130px;
	margin-left:0px;
}
.el-form-item__content:lang(en){
	margin-right:100px;
	margin-left:100px;
}
.el-form-item__error:lang(fa){
	right:0;
	left:auto;
}
.el-table .cell:lang(fa){
    float: right;
    text-align: right;
    direction: rtl;
}
.el-table .cell:lang(en){
    float: left;
    text-align: left;
    direction: ltr;
}
.border-right:lang(en){
	border-right: 1px solid #dee2e6 !important;
}
.border-right:lang(fa){
	border-left: 1px solid #dee2e6 !important;
  border-right: 0px !important;
}
.form {
	text-align: left;
	width: 600px;
	margin: auto;
}

h2 {
	font-size: 1.7em;
	text-align: center;
	margin-top: 0;
	margin-bottom: .2em
}

h2 + small {
	display: block;
	text-align: center;
	margin-bottom: 1.2em
}

small {
	line-height: 20px;
	display: block;
}

.el-alert {
	margin-bottom: 15px
}
.card-body:lang(fa){
	direction: rtl;
	text-align: justify;
}
.card-body:lang(en){
	direction: ltr;
	text-align: justify;
}
.user-block .username:lang(fa), .user-block .description:lang(fa), .user-block .comment:lang(fa) {
    display: block;
    margin-right: 50px;
		margin-left: 0px !important;
		text-align: right;
		direction: rtl;
}
.user-block .username:lang(en), .user-block .description:lang(en), .user-block .comment:lang(en) {
    display: block;
    margin-left: 50px;
		margin-right: 0px !important;
		text-align: left;
		direction: ltr;
}
.user-block img:lang(fa){
	float: right;
}
.user-block img:lang(en){
	float: left;
}
.btn-tool:lang(fa){
	float: left !important;
}
.btn-tool:lang(en){
	float: right !important;
}
.profile-image:hover .edit {
	display: block;
}

.edit {
	padding-top: 25%;
  padding-right: 45%;
	position: absolute;
	right: 0;
	top: 0;
	display: none;
}
</style>
