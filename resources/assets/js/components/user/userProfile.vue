<template>
    <div>
        <el-form-item v-for="item in this.structure" :key="item.key"
        :label="trans(item.label)"
                :prop="item.name"
                :rules="[
                {message: trans(item.errorMsg)}
                ]">
            <el-input v-if="item.item=='el-input' " v-model="user[item.name]" :name="item.name" type="text"></el-input>
            <el-select @focus="loadList(item.apiUrl)" v-if="item.item=='el-select' " v-model="form[item.name]" :name="item.name" >
            <el-option
                v-for="option in lists"
                :key="option.id"
                :label="option.description"
                :value="option.id">
            </el-option>
            </el-select>              
            <el-upload
            v-if="item.item=='el-upload'"
            class="avatar-uploader"
            :headers="headerInfo"
            ref="upload"
            action=""
            name="avatar"
            :limit=1
            :on-success="handleAvatarSuccess"
            :before-upload="onBeforeUpload"
            :auto-upload="false">               
            <el-button slot="trigger" size="small" type="primary">انتخاب تصویر</el-button> 
                <img v-if="user.avatar" :src="user.avatar" class="img-fluid img-circle" alt="User profile picture">               
            </el-upload>                            
        </el-form-item>
    </div>
</template>
<style>

</style>
<script>
export default {
    props:['user'],
    data(){
        return{
            structure:{},
            form: 
            {
                id:'',             
                profile_id:'',
                data:'',           
            },
            headerInfo: {
                'Accept': 'application/json'
            },
            formData:'',            
            }
    },
    methods:{
      /*
      |--------------------------------------------------------------------------
      | Load Profile Structure
      | Added By e.bagherzadegan        
      |--------------------------------------------------------------------------
      |
      | This method load Profile Structure for edit
      |
      */      
      loadProfileSructure(){
        this.form.profile_id=this.$route.params.profileId;
        if(!this.form.profile_id)
        this.form.profile_id = this.user.profile_id;
        axios.get("../api/profile/profiles/"+this.form.profile_id).then(({data})=>(this.structure =JSON.parse(data.data.structure))).catch((error)=>{
            this.$message({                      
              message:error.response.data.errors,
              center: true,
              type: 'error'
            }); 
        });
      },
      /*
      |--------------------------------------------------------------------------
      | handleAvatarSuccess
      |--------------------------------------------------------------------------
      |
      | This method handleAvatarSuccess
      |
      */        
      handleAvatarSuccess(res, file) {
        this.user.avatar = URL.createObjectURL(file.raw);
      },
      /*
      |--------------------------------------------------------------------------
      | Validate Avatar Befor Upload
      |--------------------------------------------------------------------------
      |
      | This method Validate Avatar Befor Upload
      |
      */     
      onBeforeUpload(file) {
          const isJPG = file.type === 'image/jpeg';
          const isLt2M = file.size / 1024 / 1024 < 2;
          if (!isJPG) {
              this.$message.error('Avatar picture must be JPG format!');
          }
          if (!isLt2M) {
              this.$message.error('Avatar picture size can not exceed 2MB!');
          }
          return (isJPG & isLt2M);
      },       
    },
    created() {
      this.loadProfileSructure();
            
    },
}
</script>
