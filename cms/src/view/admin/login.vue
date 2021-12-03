<template >
	<div class="box">
		<div class="login_box">
			<el-form :model="loginForm" :rules="rules" ref="loginForm" class="login_form">
				<h3 class="title">系 统 登 录</h3>
				<el-form-item prop="name">
					<el-input v-model="loginForm.name" style="width: 300px;" autocomplete="off" placeholder="账号"
						prefix-icon="el-icon-user">
					</el-input>
				</el-form-item>
				<el-form-item prop="pwd">
					<el-input  v-model="loginForm.pwd" style="width: 300px;"
						@keyup.native.enter="login('loginForm')" autocomplete="off" placeholder="密码"
						show-password prefix-icon="el-icon-key">
						<i slot="suffix" class="el-input__icon el-icon-view btn-eye" @click=""></i>
					</el-input>
				</el-form-item>
				<el-form-item>
					<el-button type="primary" @click="login()" class="login-btn" :loading="loading">登 录</el-button>
				</el-form-item>
			</el-form>
		</div>


	</div>

</template>


<script>
	export default {
		data() {
			return {
				loginForm: {
					name: '',
					pwd: ''
				},
				rules: {
					name: [{
						required: true,
						message: '请输入账号',
						trigger: 'blur'
					}],
					pwd: [{
						required: true,
						message: '请输入密码',
						trigger: 'blur'
					}]
				},
				
				loading: false,
				textType: 'pwd'
			}
		},
		methods: {
			login() {
				this.http.post_show(this.$api.Admin.login, this.loginForm).then(res => {
					console.log(res)
					localStorage.setItem("token", res.data.token);
					this.$router.push({
						path: "/"
					});
				})
			}

		},

	}
</script>

<style >
	body {
		margin: 0;
	}
	#app {
		margin: 0px;
	}
	.box{
		width: 100%;
		height: 100%;
		background-image: url(../../assets/login.jpg);
	}
	.el-main{
		padding: 0px;
	}
	.login_box {
		width: 500px;
		height: 300px;
		background-image: url(../../assets/login2.jpg);
		opacity: 0.8;
		border-radius: 3px;
		position: absolute;
		left: 50%;
		top: 50%;

		transform: translate(-50%, -50%);
	}

	/* 居中往下 */
	.login_form {
		position: absolute;
		/*绝对定位 */


		bottom: 15px;
		left: 15%;
		/* 最底下*/
		width: 100%;
		padding: 0 20px;
		/*  上下内边距为0，左右内边距为20 */
		box-sizing: border-box;
		/* 宽高和盒子一样 */
	}

	/* 按钮在右侧 */
	.login-btn {
		display: flex;
		justify-content: flex-end;
	}
</style>
