<template>
	<div>
		
		<el-tabs>
			<el-tab-pane label="系统设置" style="margin-left:80px;">
				<el-row :gutter="20">
					<el-col :span="2">
						<label class="el-form-item__label">系统开关 </label>
					</el-col>
					<el-col :span="3" v-if="">
						<el-switch v-model="data[12].value" style="margin-top: 10px;" active-color="#13ce66"
							inactive-color="#ff4949" active-value=0 inactive-value=1>
						</el-switch>
					</el-col>
				</el-row>

				<el-form>
					<el-row :gutter="20">
						<el-col :span="2">
							<label class="el-form-item__label">预约日期 </label>
						</el-col>
						<el-col :span="15">
							<el-date-picker v-model="data[21].value" type="daterange" format="M-d" value-format="M-d"
								range-separator="至" start-placeholder="开放日期" end-placeholder="截至日期">
							</el-date-picker>
						</el-col>
					</el-row>

					<el-row :gutter="20">
						<el-col :span="2">
							<label class="el-form-item__label">欢迎字符串 </label>
						</el-col>
						<el-col :span="22">
							<el-input type="textarea" v-model="data[0].value" style="width: 70%;"></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="20">
						<el-col :span="2">
							<label class="el-form-item__label" >成功字符串 </label>
						</el-col>
						<el-col :span="22">
							<el-input type="textarea" v-model="data[1].value" style="width: 70%;"></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="20">
						<el-col :span="2">
							<label class="el-form-item__label">项目顶部字符串 </label>
						</el-col>
						<el-col :span="22">
							<el-input type="textarea" v-model="data[2].value" style="width: 70%;"></el-input>
						</el-col>
					</el-row>








					<el-row :gutter="20">
						<el-col :span="4" :offset="2">
							<el-button type="primary" @click="sub1">提交</el-button>
						</el-col>
					</el-row>
				</el-form>
			</el-tab-pane>
			<el-tab-pane label="预约设置" style="margin-left: 100px;padding-bottom: 100px;">
				<el-form>
					<el-row :gutter="20">
						<el-col :span="2.5">
							<label class="el-form-item__label">预约显示天数</label>
						</el-col>
						<el-col :span="3">
							<el-input v-model="data[4].value"></el-input>
						</el-col>
						<el-col :span="2.5">
							<label class="el-form-item__label">提前预约天数</label>
						</el-col>
						<el-col :span="3">
							<el-input v-model="data[3].value"></el-input>
						</el-col>
						<el-col :span="2.5">
							<label class="el-form-item__label">多次预约间隔天数</label>
						</el-col>
						<el-col :span="3">
							<el-input v-model="data[20].value"></el-input>
						</el-col>

					</el-row>
					<el-row :gutter="20">
						<el-col :span="2.5">
							<label class="el-form-item__label">预约跳过星期</label>
						</el-col>
						<el-col :span="20" style="margin-top: 10px;">
							<el-checkbox-group v-model="data[22].value" @change="weeksChange">
								<el-checkbox v-for="week in weeks" :label="week" :key="week">{{week}}</el-checkbox>
							</el-checkbox-group>
						</el-col>


					</el-row>
					<el-row :gutter="20">
						<el-col :span="2">
							<label class="el-form-item__label">使用时间段</label>
							
						</el-col>
						<el-col :span="3">
							<el-select v-model="data[5].value" placeholder="请选择">
								<el-option v-for="item in time5" :label="item" :key="item" :value="item">
								</el-option>
							</el-select>
						</el-col>
						
					</el-row>
					<div v-for="(item,i) in time">
						<div v-show="i<	data[5].value">
							<el-row :gutter="20">
								<el-col :span="2">
									<label class="el-form-item__label">预约时间段{{i+1}}</label>
								</el-col>
								<el-col :span="8">
									<el-time-picker is-range v-model="time[i]" format="H:mm" value-format="H:mm"
										range-separator="至" start-placeholder="开始时间" end-placeholder="结束时间"
										placeholder="选择时间范围">
									</el-time-picker>									
								</el-col>
								<el-col :span="3">
									<label class="el-form-item__label">时间段内可预约数</label>	
								</el-col>
								<el-col :span="2">
									<el-input v-model="data[7].value[i]"></el-input>
								</el-col>
							</el-row>
						</div>
							
					</div>


					<el-row :gutter="20">
						<el-col :span="4" :offset="2">
							<el-button type="primary" @click="sub2">提交</el-button>
						</el-col>
					</el-row>
				</el-form>
			</el-tab-pane>
		</el-tabs>
		
	</div>
</template>

<script>
	export default {
		data() {
			return {
				time5:[1,2,3],
				data: [{
						"id": 1,
						"key": "hello",
						"value": "你好哇",
						"desc": "欢迎字符串",
						"update_time": "2021-09-22 10:34:04",
						"create_time": null,
						"type": 1
					},
					{
						"id": 2,
						"key": "order_success",
						"value": "恭喜您预约成功",
						"desc": "成功字符串",
						"update_time": null,
						"create_time": null,
						"type": 1
					},
					{
						"id": 3,
						"key": "order_top",
						"value": "我是预约顶部字符串",
						"desc": "预约字符串",
						"update_time": null,
						"create_time": null,
						"type": 1
					},
					{
						"id": 4,
						"key": "order_early_day",
						"value": "5",
						"desc": "可提前预约天数 (防止太早预约）",
						"update_time": null,
						"create_time": null,
						"type": 2
					},
					{
						"id": 5,
						"key": "order_day",
						"value": "7",
						"desc": "预约显示天数",
						"update_time": null,
						"create_time": null,
						"type": 2
					},
					{
						"id": 6,
						"key": "order_time_num",
						"value": "2",
						"desc": "预约时段数量",
						"update_time": null,
						"create_time": null,
						"type": 2
					},
					{
						"id": 7,
						"key": "order_timef",
						"value": "8:00@12:00@13:00@17:00",
						"desc": "预约时间段第一个和第二个  第三个和第四个如此类推",
						"update_time": null,
						"create_time": null,
						"type": 2
					},
					{
						"id": 8,
						"key": "limit",
						"value": "40@50",
						"desc": "预约人数限制",
						"update_time": null,
						"create_time": null,
						"type": 2
					},
					{
						"id": 9,
						"key": "key1",
						"value": "B",
						"desc": "查询关键词1keyname下面同",
						"update_time": "2021-09-09 11:27:42",
						"create_time": null,
						"type": 1
					},
					{
						"id": 10,
						"key": "key2",
						"value": "H",
						"desc": "查询关键词2",
						"update_time": null,
						"create_time": null,
						"type": 1
					},
					{
						"id": 11,
						"key": "key3",
						"value": "G",
						"desc": "查询关键词3",
						"update_time": null,
						"create_time": null,
						"type": 1
					},
					{
						"id": 12,
						"key": "key",
						"value": "2",
						"desc": "预约数据库查询使用关键词数量",
						"update_time": null,
						"create_time": null,
						"type": 1
					},
					{
						"id": 13,
						"key": "order_ok",
						"value": "0",
						"desc": "预约是否开放 1为开放",
						"update_time": "2021-08-26 17:41:08",
						"create_time": null,
						"type": 1
					},
					{
						"id": 14,
						"key": "title",
						"value": "Sheet1",
						"desc": "生成文件sheet的标题",
						"update_time": null,
						"create_time": null,
						"type": 1
					},
					{
						"id": 15,
						"key": "type0",
						"value": "0",
						"desc": "代表输入框",
						"update_time": null,
						"create_time": null,
						"type": 0
					},
					{
						"id": 16,
						"key": "type1",
						"value": "1",
						"desc": "代表长文本输入框",
						"update_time": null,
						"create_time": null,
						"type": 0
					},
					{
						"id": 17,
						"key": "type2",
						"value": "2",
						"desc": "代表单选框",
						"update_time": null,
						"create_time": null,
						"type": 0
					},
					{
						"id": 18,
						"key": "type3",
						"value": "3",
						"desc": "代表多选框",
						"update_time": null,
						"create_time": null,
						"type": 0
					},
					{
						"id": 19,
						"key": "type4",
						"value": "4",
						"desc": "代表下拉框",
						"update_time": null,
						"create_time": null,
						"type": 0
					},
					{
						"id": 20,
						"key": "type5",
						"value": "5",
						"desc": "代表日期选择器",
						"update_time": null,
						"create_time": null,
						"type": 0
					},
					{
						"id": 21,
						"key": "order_long",
						"value": "7",
						"desc": "预约间隔 2次有效预约期间的间隔",
						"update_time": null,
						"create_time": null,
						"type": 2
					},
					{
						"id": 22,
						"key": "order_open",
						"value": "8-1@10-23",
						"desc": "预约开放日期",
						"update_time": null,
						"create_time": null,
						"type": 1
					},
					{
						"id": 23,
						"key": "order_skip",
						"value": "6,7",
						"desc": "预约忽略",
						"update_time": null,
						"create_time": null,
						"type": 2
					}
				],
				weeks: ['1', '2', '3', '4', '5', '6', '7'],
				limit: [],
				time: [],


			}
		},
		mounted() {
			this.load()
			
		},
		computed: {

		},
		methods: {
			load() {
				this.http.get(this.$api.sys.get).then(res => {

					this.data = res.data;

					
					this.data[6].value = this.data[6].value.split('@');
					let n = this.data[6].value.length;
					for (let i = 0; i < n / 2; i++) {
						this.time[i] = [this.data[6].value[i * 2], this.data[6].value[i * 2 + 1]];
					}

					this.data[7].value = this.data[7].value.split('@');
					this.data[21].value = this.data[21].value.split('@');
					this.data[22].value = this.data[22].value.split(',');

				});
			},
			sub1() {
				let data1 = this.data;
				let time1 = this.time;
				data1[22].value = data1[22].value.join(',');
				data1[21].value = data1[21].value.join('@');



				console.log(data1[12].value)
				let n = time1.length;
				data1[7].value = data1[7].value.join('@');
				data1[6].value = '';
				for (let i = 0; i < n; i++) {
					time1[i] = time1[i].join('@');
					if (i == 0)
						data1[6].value = time1[i];
					else {
						data1[6].value = data1[6].value + "@" + time1[i];
					}
				}
				console.log(data1);
				this.http.post(this.$api.sys.edit, data1).then(res => {
					console.log(res);
					this.$message({
						showClose: true,
						message: '设置更新成功',
						type: 'success',
					});
					this.timer = setTimeout(() => { //设置延迟执行

					}, 1000);
					this.load();
				});


			},
			sub2() {
				this.sub1();
			},
			weeksChange(val) {
				this.checkedCities = val ? this.weeks : [];
				this.isIndeterminate = false;
			}
		}
	};
</script>

<style>
	.el-row {
		margin-bottom: 20px;

		&:last-child {
			margin-bottom: 0;
		}
	}

	.el-col {
		border-radius: 4px;
	}

	.bg-purple-dark {
		background: #99a9bf;
	}

	.bg-purple {
		background: #d3dce6;
	}

	.bg-purple-light {
		background: #e5e9f2;
	}

	.grid-content {
		border-radius: 4px;
		min-height: 36px;
	}

	.row-bg {
		padding: 10px 0;
		background-color: #f9fafc;
	}
</style>
