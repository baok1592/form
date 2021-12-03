<template>
	<div id="order">
		<el-card class="box-card">
			欢迎使用万能预约系统，系统正常运行中
		</el-card>
		<el-card class="box-card">
			<div slot="header" class="clearfix">
				<h1 style="text-align: center;">近日预约情况</h1>
			</div>
			<el-table
				:data="tableData.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))"
				style="width: 90%">
				<el-table-column label="日期" prop="date">
				</el-table-column>
				<el-table-column label="预约时间段1" prop="t1time">
				</el-table-column>
				<el-table-column label="可预约数" prop="t1_num">
				</el-table-column>

				<el-table-column label="预约时间段2" prop="t2time" v-if="tableData[0].t2time">
				</el-table-column>
				<el-table-column label="可预约数" prop="t2_num" v-if="tableData[0].t2time">
				</el-table-column>



				<el-table-column label="预约时间段3" prop="t3time" v-if="tableData[0].t3time">
				</el-table-column>
				<el-table-column label="可预约数" prop="t3_num" v-if="tableData[0].t3time">
				</el-table-column>





			</el-table>
		</el-card>

	</div>

</template>

<script>
	export default {

		data() {
			return {
				tableData: [{
						t2time: "",
						t3time: "",
					}

				],
				search: ''
			}
		},
		mounted() {
			let token = localStorage.getItem("token");
			let ok= localStorage.getItem("ok");
			if (token == '' || !token) {
				this.$message.error('token过期或者无效！');
				this.$router.push({
					path: "/login"
				});
			}
			
			if (location.href.indexOf("#reloaded") == -1&&ok!=1) {
							localStorage.setItem("ok", 1);
			                 location.href = location.href + "#reloaded";
			                 location.reload();
			             }
			this.http.get(this.$api.Order.dateget, []).then(res => {
				this.tableData = res.data;
			});
			

		},
		methods: {
			handleEdit(index, row) {
				console.log(index, row);
			},
			handleDelete(index, row) {
				console.log(index, row);
			}
		},
	}
</script>

<style>
	.el-main {
		padding: 20px;
	}
</style>
