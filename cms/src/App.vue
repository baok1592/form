<template>
	<div id="app">
		<el-container style="height: 937px ;width: 100%; border: 1px solid #eee; ">
			<el-aside width="200px" style="background-color: #545c64;padding-top: 60px;" v-if="!is_login">
				<el-menu :default-openeds="['4', '3', '2', '5']" background-color="#545c64" text-color="#fff"
					active-text-color="#ffd04b" router>
					<el-menu-item index="1" @click="go_home">
						<template slot="title">
							<i class="el-icon-s-home"></i>
							<span slot="title">首页</span>
						</template>
					</el-menu-item>

					<el-menu-item index="2" @click="go_order">
						<i class="el-icon-s-order"></i>
						<span slot="title">预约</span>
					</el-menu-item>

					<!-- 	<el-menu-item index="3" @click="go_from">
						<i class="el-icon-s-claim"></i>
						<span slot="title">表单</span>
					</el-menu-item> -->

					<el-menu-item index="4" @click="go_excel">
						<i class="el-icon-document"></i>
						<span slot="title">excel项目</span>
					</el-menu-item>

					<el-menu-item index="5" @click="go_sysinfo">
						<template slot="title">
							<i class="el-icon-menu"></i>
							<span>配置</span>
						</template>

					</el-menu-item>

					<el-menu-item index="6" @click="go_admin">
						<i class="el-icon-setting"></i>
						<span slot="title">管理员</span>
					</el-menu-item>

				</el-menu>
			</el-aside>



			<el-container>
				<el-header style="padding: 20px; background-color: #b3c0d1;text-align: right; font-size: 12px"
					v-if="!is_login">

					<el-dropdown @command="go_logins">
						<div>
							<span>个人中心 </span>
							<i class="el-icon-caret-bottom" style="margin-right: 15px"></i>
						</div>
						<el-dropdown-menu slot="dropdown">
							<el-dropdown-item command="xiu"><i class="el-icon-edit"></i>修改密码
							</el-dropdown-item>
							<el-dropdown-item command="tui"><i class="el-icon-switch-button"></i> <b></b>退出登录
							</el-dropdown-item>

						</el-dropdown-menu>
					</el-dropdown>
				</el-header>
				<el-main>
					<router-view></router-view>
				</el-main>
				<el-dialog style="text-align: left;" title="修改密码" :visible.sync="dialogVisible" width="30%">
					<el-form ref="formpwd" :model="formpwd" label-width="80px">
						<el-form-item label="旧密码">
							<el-input placeholder="请输入旧密码..." show-password v-model="formpwd.oldpwd"
								style="width: 300px;"></el-input>
						</el-form-item>
						<el-form-item label="密码">
							<el-input placeholder="请输入密码..." show-password v-model="formpwd.pwd" style="width: 300px;">
							</el-input>
						</el-form-item>
						<el-form-item label="确认密码">
							<el-input placeholder="请输入密码..." show-password v-model="formpwd.qpwd" style="width: 300px;">
							</el-input>
						</el-form-item>
					</el-form>
					<span slot="footer" class="dialog-footer">
						<el-button @click="dialogVisible = false">取 消</el-button>
						<el-button type="primary" @click="edit">确 定</el-button>
					</span>
				</el-dialog>
			</el-container>
		</el-container>
	</div>






	</div>

</template>

<script>
	export default {
		name: 'app',
		
		
		data() {
			return {
				is_login: false,
				inputValue:true,
				dialogVisible: false,
				isRouterAlive:true,
				formpwd: {
					oldpwd: '',
					pwd: '',
					qpwd: ''
				}
			}
		},

		watch: {
			$route(to, from) {
				//监听路由是否变化
				if (to.name == "login") {
					this.is_login = true;
				} else {
					this.is_login = false;
				}
			}

		},
		components: {

		},
		mounted() {
			this.http.get(this.$api.Admin.check).then(res => {
				
			});
			let token = localStorage.getItem("token");
			if (token == '' || !token) {
				this.$router.push({
					path: "/login"
				});
			}
			
		},
		methods: {
			
			handleOpen(key, keyPath) {
				console.log(key, keyPath);
			},
			handleClose(key, keyPath) {
				console.log(key, keyPath);
			},
			go_admin() {
				this.$router.push({
					name: "admin"
				});
			},
			go_home() {
				this.$router.push({
					name: "index"
				});
			},
			go_order() {
				this.$router.push({
					name: "order"
				});
			},
			go_sysinfo() {
				this.$router.push({
					name: "sysinfo"
				});
			},
			go_excel() {
				this.$router.push({
					name: "excel"
				});
			},
			go_logins(e) {
				if (e == "xiu")
					this.dialogVisible = true
				if (e == "tui") {
					localStorage.setItem("token", '');
					this.$router.push('/login');
					localStorage.clear();
				}
			},
			go_login() {
				localStorage.clear();
				this.$router.push('/login');
			},
			edit() {
				this.http.post(this.$api.Admin.edit, this.formpwd).then(res => {
					this.dialogVisible = false;
					alert("修改成功");
				});

			}
		}
	}
</script>

<style>
	#app {

		margin: -8px;


		.el-header {
			background-color: #b3c0d1;
			color: #333;
			line-height: 60px;
		}

		.el-aside {
			color: #333;
		}

		.el-main {
			/* background-color: #ffffff; */
		}
	}

	.mmk {
		width: 300px;
	}
</style>
