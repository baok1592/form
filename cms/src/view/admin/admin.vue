<template>
	<div>


		<el-tabs type="border-card">
			<el-button style="margin-bottom: 10px;" type="primary" size="medium" @click="add_level">新增管理员
			</el-button>
			<el-table :data="list" border style="width: 100%">
				<el-table-column prop="id" label="id" width="50px"></el-table-column>
				<el-table-column prop="name" label="账号"></el-table-column>
				<el-table-column prop="create_time" label="创建时间"></el-table-column>
				<el-table-column prop="operation" label="操作" width="300px">
					<template slot-scope="scope">
						<el-button type="danger" size="mini" @click="qclose(scope.row.id)">删除</el-button>
						<el-button type="success" size="mini" @click="open(scope.row.id)">修改密码</el-button>
					</template>
				</el-table-column>
				<strong></strong>
			</el-table>
		</el-tabs>
		<el-dialog style="text-align: left;" title="新增管理员" :visible.sync="dialogVisible" width="30%">
			<el-form ref="form" :model="form" label-width="80px">
				<el-form-item label="用户名">
					<el-input placeholder="请输入用户名..." v-model="form.name"></el-input>
				</el-form-item>
				<el-form-item label="密码">
					<el-input placeholder="请输入密码..." show-password v-model="form.pwd"></el-input>
				</el-form-item>
			</el-form>
			<span slot="footer" class="dialog-footer">
				<el-button @click="dialogVisible = false">取 消</el-button>
				<el-button type="primary" @click="admin_add">确 定</el-button>
			</span>
		</el-dialog>
		<el-dialog style="text-align: left;" title="修改密码" :visible.sync="dialog2" width="30%">
			<el-form ref="pwd_from" :model="pwd_from" label-width="80px">
				<el-form-item label="旧密码">
					<el-input placeholder="请输入旧密码..." show-password v-model="pwd_from.oldpwd"></el-input>
				</el-form-item>
				<el-form-item label="密码">
					<el-input placeholder="请输入密码..." show-password v-model="pwd_from.pwd"></el-input>
				</el-form-item>
				<el-form-item label="确认密码">
					<el-input placeholder="请输入密码..." show-password v-model="pwd_from.qpwd"></el-input>
				</el-form-item>
			</el-form>
			<span slot="footer" class="dialog-footer">
				<el-button @click="dialog2 = false">取 消</el-button>
				<el-button type="primary" @click="admin_ed()">确 定</el-button>
			</span>
		</el-dialog>
	</div>
</template>

<script>
	import Nodelapi from "../../api/api.js"
	export default {
		data() {
			var validatePass = (rule, value, callback) => {
				if (value === '') {
					callback(new Error('请输入密码'));
				} else {
					if (this.ruleForm.checkPass !== '') {
						this.$refs.ruleForm.validateField('checkPass');
					}
					callback();
				}
			};
			var validatePass2 = (rule, value, callback) => {
				if (value === '') {
					callback(new Error('请再次输入密码'));
				} else if (value !== this.ruleForm.pass) {
					callback(new Error('两次输入密码不一致!'));
				} else {
					callback();
				}
			};
			return {
				form: {
					name: '',
					pwd: ''
				},
				list: [

				],
				pwd_from:{
					id:'',
					oldpwd:'',
					pwd:'',
					qpwd:''
				},
				rules: {
					pass: [{
						validator: validatePass,
						trigger: 'blur'
					}],
					checkPass: [{
						validator: validatePass2,
						trigger: 'blur'
					}],
				},
				operation: '4',
				dialogVisible: false,
				dialog2: false,
				keys:{
					key1:"",
					key2:"",
					key3:""
				}
			}

		},
		mounted() {
			this.onload();
			let token = localStorage.getItem("token");
			if (token == '' || !token) {
			this.$message.error('token过期或者无效！');
				this.$router.push({
					
					path: "/login"
				});
			}
		},
		methods: {
			open(id){
				this.dialog2=true;
				this.pwd_from.id=id;
			},
			onSubmit() {
				console.log('submit!');
			},
			add_level() {
				this.dialogVisible = true;
			},
			admin_add() {
				this.http.post(this.$api.Admin.add, this.form).then(res => {
					this.dialogVisible = false;
					this.$message({
						showClose: true,
						message: '添加成功',
						type: 'success',
					});
					this.onload();
				})
			},
			admin_del(id) {
				let data = {
					"id": id
				};
				this.http.post(this.$api.Admin.del, data).then(res => {
				
					this.onload();
				})
			},
			admin_ed() {
				this.http.post(this.$api.Admin.pwd,this.pwd_from).then(res => {
					this.$message({
						type: 'success',
						message: '修改完成!'
					});
					this.dialog2=false;
					
				})
			},
			qclose(id) {
				this.$confirm('此操作将删除该管理, 是否继续?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					this.admin_del(id);
					this.$message({
						type: 'success',
						message: '删除成功!'
					});
					this.onload()
				})
			},
			onload() {
				this.http.get(this.$api.Admin.get, this.form).then(res => {
					this.list = res.data;
				})
			}
		}
	}
</script>

<style>
	.input {

		height: 40px;
		width: 300px;
		margin: 20px;
	}


	.die {
		margin-left: 12%;
	}

	.son {
		/* position: absolute; */
		margin-left: 2%;
	}
</style>
