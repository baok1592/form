<template>
	<div>
		<el-tabs type="border-card">

			<el-button type="success" @click="dialogVisible2=true">新增</el-button>

			<el-dialog style="text-align: left;" title="新增项目" :visible.sync="dialogVisible2" width="30%">
				<el-form ref="key" :model="key" label-width="100px">

					<el-upload class="upload-demo" ref="upload" action="http://192.168.124.36:8099/excel/upload"
						:show-file-list="true" :on-success="onSuccess" :auto-upload="true" v-model="info">
						<div>
							<el-button size="small" type="primary">点击上传</el-button>
							<div slot="tip" class="el-upload__tip">只能上传xlsx文件,仅导入最后上传的文件</div>
						</div>
					</el-upload>

				</el-form>
				<span slot="footer" class="dialog-footer">
					<el-button @click="dialogVisible2 = false">取 消</el-button>
					<el-button type="primary" @click="dr">确 定</el-button>
				</span>
			</el-dialog>
			<el-dialog style="text-align: left;" title="修改项目配置" :visible.sync="dialogVisible" width="30%">
				<el-form ref="form" :model="form" label-width="80px">
					<el-form-item label="项目id">
						<el-input placeholder="" v-model="edfrom.id" :disabled="true"></el-input>
					</el-form-item>
					<el-form-item label="项目名">
						<el-input placeholder="" v-model="edfrom.xname"></el-input>
					</el-form-item>
					<el-form-item label="关键词数">
						<template v-if="sekey">
							<el-select v-model="edfrom.n" placeholder="请选择">
								<el-option v-for="item in num" :label="item" :key="item" :value="item">
								</el-option>
							</el-select>
						</template>
					</el-form-item>

					<el-form-item label="优先级">
						<el-input placeholder="" v-model="edfrom.lv"></el-input>
					</el-form-item>



					<el-form-item label="关键词1">
						<template v-if="sekey">
							<el-select v-model="edfrom.key1" placeholder="请选择">
								<el-option v-for="item in sekey" :label="item" :key="item" :value="item">
								</el-option>
							</el-select>
						</template>

					</el-form-item>
					<el-form-item label="关键词2">
						<template v-if="sekey">
							<el-select v-model="edfrom.key2" placeholder="请选择">
								<el-option v-for="item in sekey" :label="item" :key="item" :value="item">
								</el-option>
							</el-select>
						</template>

					</el-form-item>
					<el-form-item label="关键词3">
						<template v-if="sekey">
							<el-select v-model="edfrom.key3" placeholder="请选择">
								<el-option v-for="item in sekey" :label="item" :key="item" :value="item">
								</el-option>
							</el-select>
						</template>

					</el-form-item>
				</el-form>
				<span slot="footer" class="dialog-footer">
					<el-button @click="dialogVisible = false">取 消</el-button>
					<el-button type="primary" @click="sub">确 定</el-button>
				</span>
			</el-dialog>
			<el-dialog style="text-align: left;" title="新项目配置" :visible.sync="dialogVisible3" width="30%">
				<el-form ref="form" :model="form" label-width="80px">
					<el-form-item label="项目id">
						<el-input placeholder="" v-model="edfrom.id" :disabled="true"></el-input>
					</el-form-item>
					<el-form-item label="项目名">
						<el-input placeholder="" v-model="edfrom.xname"></el-input>
					</el-form-item>
					<el-form-item label="关键词数">
						<template v-if="sekey">
							<el-select v-model="edfrom.n" placeholder="请选择">
								<el-option v-for="item in num" :label="item" :key="item" :value="item">
								</el-option>
							</el-select>
						</template>
					</el-form-item>

					<el-form-item label="优先级">
						<el-input placeholder="" v-model="edfrom.lv"></el-input>
					</el-form-item>



					<el-form-item label="关键词1">
						<template v-if="sekey">
							<el-select v-model="edfrom.key1" placeholder="请选择">
								<el-option v-for="item in sekey" :label="item" :key="item" :value="item">
								</el-option>
							</el-select>
						</template>

					</el-form-item>
					<el-form-item label="关键词2">
						<template v-if="sekey">
							<el-select v-model="edfrom.key2" placeholder="请选择">
								<el-option v-for="item in sekey" :label="item" :key="item" :value="item">
								</el-option>
							</el-select>
						</template>

					</el-form-item>
					<el-form-item label="关键词3">
						<template v-if="sekey">
							<el-select v-model="edfrom.key3" placeholder="请选择">
								<el-option v-for="item in sekey" :label="item" :key="item" :value="item">
								</el-option>
							</el-select>
						</template>

					</el-form-item>
				</el-form>
				<span slot="footer" class="dialog-footer">
					<el-button @click="dialogVisible3 = false">取 消</el-button>
					<el-button type="primary" @click="sub">确 定</el-button>
				</span>
			</el-dialog>


			<el-table
				:data="tableData.slice((currentPage-1)*pageSize,currentPage*pageSize)||tableData.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))"
				style="width: 100%">
				<el-table-column label="优先级" prop="lv" width="100">
				</el-table-column>
				<el-table-column label="项目编号" prop="id" width="100">
				</el-table-column>
				<el-table-column label="项目名" prop="xname" width="100">
				</el-table-column>

				<el-table-column label="项目关键词" prop="frist_name" width="700">
				</el-table-column>
				<el-table-column label="项目查询关键词" prop="search_key">
				</el-table-column>
				<el-table-column fixed="right" label="操作" width="400">
					<template slot-scope="scope">
						<el-button type="primary" size="small" @click="ed(scope.row)">编辑</el-button>
						<el-button type="danger" size="small" @click="qclose(scope.row)">删除</el-button>
					</template>
				</el-table-column>

			</el-table>
			<el-pagination background layout="prev, pager, next" :total="total1" style="margin:20px"
				@current-change="currentChangeHandle" @size-change="sizeChangeHandle"></el-pagination>
			</el-pagination>
			</el-tabs>


	</div>
</template>

<script>
	export default {
		data() {
			return {
				total1: 0,
				currentPage: 1,
				pageSize: 10,
				form: {
					name: '',
					url: ''
				},
				info: {
					url: ""
				},
				tableData: [],
				key: {
					url: "",
				},
				num: [1, 2, 3],
				search: '',
				dialogVisible: false,
				dialogVisible2: false,
				dialogVisible3: false,
				edfrom: {
					id: '',
					xname: "",
					n: "",
					lv: '',
					key1: '',
					key2: '',
					key3: ''
				},
				sekey: {

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
			sub() {
				this.http.post(this.$api.ProExcel.edits, this.edfrom).then(res => {
					console.log(res);
					this.$message({
						showClose: true,
						message: '修改成功',
						type: 'success',

					});
					this.onload();
					this.dialogVisible = false;
					this.dialogVisible3 = false;
				})
			},
			dr() {
				console.log(this.key);
				this.http.post(this.$api.ProExcel.move, this.key).then(res => {
					console.log(res);

					this.onload();
					this.$message({
						showClose: true,
						message: '导入成功,',
						type: 'success',
					});
					this.dialogVisible2 = false;
					this.dialogVisible3 = true;
					this.dr2(res.data);

				});
			},
			dr2(index) {
				this.getse(index.id);

				this.edfrom.id = index.id;

				this.edfrom.lv = index.lv;
				this.edfrom.xname = index.xname;

			},
			onSuccess(response, file, fileList) {
				console.log(response.data.url)
				this.key.url = response.data.url
			},
			ed(index, row) {
				this.getse(index.id);

				this.edfrom.id = index.id;
				let se = index.search_key.split('/');
				this.edfrom.key1 = se[0];
				this.edfrom.key2 = se[1];
				if (se[2])
					this.edfrom.key3 = se[2];
				this.edfrom.lv = index.lv;
				this.edfrom.xname = index.xname;

				this.dialogVisible = true;
			},
			del(index, row) {
				let data = {
					"id": index.id
				};
				this.http.post(this.$api.ProExcel.del, data).then(res => {

					this.onload();
				})
			},
			// 切换页码同时切换内容
			currentChangeHandle(e) {
				console.log("当前页码", e);
				this.currentPage = e;
			},
			sizeChangeHandle(e) {
				console.log("当前页码", e);
			},
			qclose(index, row) {
				this.$confirm('此操作将删除该项目, 是否继续?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					this.del(index, row);
					this.$message({
						type: 'success',
						message: '删除成功!'
					});
					this.onload()
				})
			},
			onload() {
				this.http.get(this.$api.ProExcel.get).then(res => {
					console.log(res);
					this.tableData = res.data;
					this.total1 = this.tableData.length;
				});
			},
			getse(id) {
				let data = {
					"id": id
				};
				this.http.post(this.$api.ProExcel.getse, data).then(res => {
					this.sekey = res.data.se_key;
					this.edfrom.n = res.data.n;
					console.log(this.sekey)
				});
			},

		},

	}
</script>

<style>

</style>
