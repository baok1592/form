<template>
	<div>

		
			<el-tabs>
				<el-tab-pane label="预约信息">
					<el-card>
						<div class="head">
							<el-row :gutter="20">
								<el-col :span="2">
									<el-button type="primary" @click="dialogVisible=true">导出</el-button>
								</el-col>
								<el-dialog style="text-align: left;" title="导出当前项目" :visible.sync="dialogVisible"
									width="30%">
									<el-form ref="form" :model="form" label-width="80px">
										<el-form-item label="项目名称">
											<el-input placeholder="请输入项目名..." v-model="form.name"></el-input>
										</el-form-item>
									</el-form>
									<span slot="footer" class="dialog-footer">
										<el-button @click="dialogVisible = false">取 消</el-button>
										<el-button type="primary" @click="dc">确 定</el-button>
									</span>
								</el-dialog>

								<el-dialog style="text-align: left;" title="预约详情" :visible.sync="seev" width="40%">

									<div class="seev">预约时间:{{view.time}}</div>
									<div v-for="(item,i) in view.info">
										<template v-if="view.info" style="">
											<div class="seev">
												<div style="color: #0080FF;">{{i}}:</div>
												<div>{{item}}</div>
											</div>

										</template>
									</div>
									<span slot="footer" class="dialog-footer">
										<el-button type="primary" @click="seev = false">确 定</el-button>
									</span>


								</el-dialog>



								<el-col :span="6">
									<div class="block">
										<el-date-picker v-model="sefrom.time" type="daterange" value-format="yyyy-M-d"
											align="right" unlink-panels range-separator="至" start-placeholder="开始日期"
											end-placeholder="结束日期">
										</el-date-picker>
									</div>
								</el-col>
								<el-col :span="4">
									<el-input placeholder="输入关键词或编号进行搜索" v-model="sefrom.keys"></el-input>
								</el-col>
								<el-col :span="4">
									<el-button @click="search">查询</el-button>
								</el-col>
								<el-col :span="4">
									<el-button @click="qqcloseall">清除全部预约数据</el-button>
								</el-col>


							</el-row>
						</div>
					</el-card>

					<el-table
						:data="tableData.slice((currentPage-1)*pageSize,currentPage*pageSize)||	tableData.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))"
						style="margin-top: 40px;">
						<el-table-column label="编号" prop="id">
						</el-table-column>
						<el-table-column label="预约时间" prop="time">
						</el-table-column>
						<el-table-column label="创建时间" prop="create_time">
						</el-table-column>
						<el-table-column label="查询关键词1" prop="key1">
						</el-table-column>

						<el-table-column label="查询关键词2" prop="key2">
						</el-table-column>

						<el-table-column label="查询关键词3" prop="key3">
						</el-table-column>




						<el-table-column fixed="right" label="操作" width="400">
							<template slot-scope="scope">
								<el-button type="primary" size="small" @click="see(scope.row)">查看</el-button>
								<el-button type="danger" size="small" @click="qclose(scope.row)">取消</el-button>
							</template>
						</el-table-column>

					</el-table>
					<el-pagination background layout="prev, pager, next" :total="total1"
						style="margin-top:20px;margin-left: 500px;" @current-change="currentChangeHandle"
						@size-change="sizeChangeHandle"></el-pagination>
				</el-tab-pane>
<el-tab-pane label="表单设置">



					<el-form :model="dynamicValidateForm" ref="dynamicValidateForm" label-width="100px"
						class="demo-dynamic" style="margin-top: 40px;">

						<el-form-item v-for="(domain, index) in dynamicValidateForm.domains" :label="domain.keyname"
							:key="domain.key" :prop="'domains.' + index + '.value'">



							</el-select>
							<span style="margin-left: 15px;">字段名</span>
							<el-input v-model="domain.name" style="width: 200px;margin-left: 20px;">
							</el-input>

							<span style="margin-left: 15px;">类型</span>
							<el-select style="width: 100px;margin-left: 20px;" v-model="domain.type">
								<el-option v-for="item in options" :key="item.value" :label="item.label"
									:value="item.value"></el-option>
							</el-select>

							<span class="head_demo">是否必填:</span>
							<template>
								<el-radio v-model="domain.is_ok" :label="0">否</el-radio>
								<el-radio v-model="domain.is_ok" :label="1" class="left">是</el-radio>
							</template>
							<span class="head_demo">是否查询:</span>
							<template>
								<el-radio v-model="domain.is_se" :label="0">否</el-radio>
								<el-radio v-model="domain.is_se" :label="1" class="left">是</el-radio>
							</template>
							<span class="head_demo">是否显示:</span>
							<template>
								<el-radio v-model="domain.is_view" :label="0">否</el-radio>
								<el-radio v-model="domain.is_view" :label="1" class="left">是</el-radio>
							</template>
							<span class="head_demo">备注</span>
							<el-input v-model="domain.msg" style="width: 200px;margin-left: 20px;"></el-input>
							<el-button style="margin-left: 20px;" type="danger" @click.prevent="removeDomain(domain)"
								icon="el-icon-delete" circle></el-button>

							</el-button>
						</el-form-item>
						<el-form-item>
							<el-button type="primary" @click="submitForm('dynamicValidateForm')">提交</el-button>
							<el-button @click="addDomain">新增字段</el-button>

						</el-form-item>
					</el-form>

				</el-tab-pane>


				

			</el-tabs>

	
	</div>
</template>

<script>
	export default {
		data() {
			return {
				lets: [
					'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
					'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK',
					'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ'
				],

				fileList: {

				},
				info: {
					url: ""
				},

				searchvalue: '',
				message: '',
				total1: 0,
				currentPage: 1,
				pageSize: 10,
				options: [{
					value: 0,
					label: '输入框'
				}, {
					value: 1,
					label: '单选框'
				}, {
					value: 2,
					label: '多选框'
				}, {
					value: 3,
					label: '下拉框'
				}, {
					value: 4,
					label: '时间选择器'
				}],
				options2: [{
					value: 0,
					label: '否'
				}, {
					value: 1,
					label: '是'
				}],
				form: {
					name: "",
					url: "../xl/"
				},
				key: {
					url: "",
				},
				dialogVisible: false,
				dialogVisible2: false,
				seev: false,
				dynamicValidateForm: {
					domains: [{
						name: '',
						type: '',
						is_ok: 0,
						is_se: 0,
						is_view:0,
						msg: '',
					}],
				},
				tableData: [

				],
				sefrom: {
					keys: '',
					time: ''
				},
				sefrom2: {
					keys: '',
					time: {
						0: '',
						1: ''
					}
				},
				keys: {
					key1: "",
					key2: "",
					key3: "",
					n: ""
				},
				view: {

				},
				viewkey: {

				}

			}
		},
		A_name: '姓名',
		mounted() {
			let token = localStorage.getItem("token");
			if (token == '' || !token) {
				this.$router.push({
					path: "/login"
				});
			}
			this.onload();
			this.onload2();


		},
		methods: {
			onSuccess(response, file, fileList) {
				this.key.url = response.data.url
			},
			// 切换页码同时切换内容
			currentChangeHandle(e) {
				console.log("当前页码", e);
				this.currentPage = e;
			},
			sizeChangeHandle(e) {
				console.log("当前页码", e);
			},
			submitForm(formName) {
				let dd = this.dynamicValidateForm.domains;
				let op = this.options;
				let op2 = this.options2;
				for (let i in dd) {
					for (let j in op) {
						if (dd[i].type == op[j].label) {
							console.log(op[j].label);
							dd[i].type = op[j].value;

						}
					}
					for (let j in op2) {
						if (dd[i].is_ok == op2[j].label) {
							dd[i].is_ok = op2[j].value;
						}
					}

				}

				this.http.post(this.$api.key.addall, dd).then(res => {

					this.$message({
						showClose: true,
						message: '修改成功',
						type: 'success',
					});

					this.timer = setTimeout(() => { //设置延迟执行

					}, 1000);
					this.onload2();
				})
			},

			resetForm(formName) {
				this.$refs[formName].resetFields();
			},
			removeDomain(item) {
				var index = this.dynamicValidateForm.domains.indexOf(item)
				if (index !== -1) {
					this.dynamicValidateForm.domains.splice(index, 1)
				}
			},
			addDomain() {
				this.dynamicValidateForm.domains.push({

					type: '',
					is_ok: 0,
					msg: '',
					is_se: 0,
					is_view: 0,
					key: Date.now()
				});
			},
			dc() {
				this.http.post(this.$api.ProExcel.dc, this.form).then(res => {
					alert("导出成功其项目id为" + res.data.id);
				});
				this.dialogVisible = false;
				this.onload();
			},
			dr() {
				this.http.post(this.$api.ProExcel.dr, this.key).then(res => {
					this.$message({
						showClose: true,
						message: '导入成功',
						type: 'success',
					});
					this.dialogVisible2 = false;
					this.onload2();
				});
			},
			onload() {

				this.http.post_show(this.$api.Order.getinfo, this.sefrom2).then(res => {
					this.tableData = res.data;
					this.total1 = this.tableData.length;
				});

			},
			onload2() {
				this.http.get(this.$api.key.get).then(res => {

					this.dynamicValidateForm.domains = res.data;
				})
			},

			search() {
				if (!this.sefrom.keys && !this.sefrom.time) {

					this.onload();
				} else {
					this.http.post_show(this.$api.Order.getinfo, this.sefrom).then(res => {
						console.log(res);
						this.tableData = res.data;
						this.total1 = this.tableData.length;
					});
				}



			},
			F5() {
				this.http.get(this.$api.Order.F5).then(res => {
					console.log(res);
				});
			},

			qclose(index, row) {
				this.$confirm('此操作将取消本次预约, 是否继续?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					this.close(index, row);
					this.$message({
						type: 'success',
						message: '删除成功!'
					});


				})
			},
			close(index, row) {
				console.log(index.id);

				let data = {
					"id": index.id
				};

				this.http.post(this.$api.Order.close, data).then(res => {
					this.onload()
				});
			},
			see(index, row) {
				this.seev = true;
				this.view = index;
				console.log(this.view);
			},
			qqcloseall() {
				this.$confirm('此操作将删除所有的预约数据,推荐您先导出后再删除，是否继续删除？', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					this.qcloseall();

				})
			},
			qcloseall() {
				this.$confirm('此操作将删除所有的预约数据, 是否继续?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					this.closeall();
					this.$message({
						type: 'success',
						message: '删除完毕!'
					});
				})
			},
			closeall() {
				this.http.Del(this.$api.Order.closeall).then(res => {
					this.onload()
				});
			}

		}
	}
</script>

<style>
	.box-card {
		margin-top: 20px;
	}

	.left {
		margin-left: -20px;
	}

	.head_demo {
		margin-left: 15px;
		margin-right: 15px;
	}

	.seev {
		display: flex;
		justify-content: flex-start;
		font-weight: 700;
		line-height: 30px;
		font-size: 18px;
	}
</style>
