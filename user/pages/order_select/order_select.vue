<template>
	<view>
		<u-table>
			<u-tr>
				<u-th>日期 </u-th>

				<u-th>{{time[0]}}-{{time[1]}}</u-th>
				<u-th v-if="data[0].t2time">{{time[2]}}-{{time[3]}}</u-th>
				<u-th v-if="data[0].t3time">{{time[4]}}-{{time[5]}}</u-th>
			</u-tr>
			<u-tr v-for="(item,index) in data" :key="index">
				<u-td style="height: 49px;">
					<view>{{item.nj}}<br>{{item.week}}<br></view>
				</u-td>
				<u-td style="height: 49px;">
					<view class="tab">
						<view v-if="item.t1_num!=0" @click="go_order(item)"><br>{{item.t1_num}}</view>
						<view v-if="item.t1_num<=0" style="color: red;"><br>已满</view>
					</view>
				</u-td >
				<u-td style="height: 49px;" v-if="data[0].t2time">
					<view class="tab">
						<view v-if="item.t2_num!=0" @click="go_order2(item)"><br>{{item.t2_num}}</view>
						<view v-if="item.t2_num<=0" style="color: red;"><br>已满</view>
					</view>
				</u-td>
				<u-td class="utd" v-if="data[0].t3time">
					<view class="tab">
						<view v-if="item.t3_num!=0" @click="go_order3(item)"><br>{{item.t3_num}}</view>
						<view v-if="item.t3_num<=0" style="color: red;"><br>已满</view>
					</view>
				</u-td>
			</u-tr>
		</u-table>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				data: [{
					nj: "",
					week: "",
					unix: "",
					date: "",
					t1_start: "",
					t1_end: "",
					t1_num: "",
					t1_start: "",
					t1time: "",
					t2time: "",
					t3time: "",
					unix: "",
					week: "",
				}, ],

				sys: {
					3: ""
				},
				time: {
					0: '',
					1: '',
					2: '',
					3: '',
					4: '',
					5: '',
				}
			}
		},
		mounted() {
			this.sys = uni.getStorageSync('sys');
			this.onload1();
			this.onload();

		},

		methods: {
			go_order(item) {

				let time = item.unix + ' ' + item.t1_end;
				uni.setStorageSync('time', time)
				let time2 = item.unix + '的' + item.t1time;
				uni.setStorageSync('time2', time2)
				uni.navigateTo({
					url: '../order/order'
				})
			},
			onload() {
				this.http.get(this.$api.key.get).then(res => {
					uni.setStorageSync('key', res.data);
				});
			},
			go_order2(item) {
				console.log(item)
				let time = item.unix + ' ' + item.t2_end;
				uni.setStorageSync('time', time)
				let time2 = item.unix + '的' + item.t2time;
				uni.setStorageSync('time2', time2)
				uni.navigateTo({
					url: '../order/order'
				})
			},
			go_order3(item) {
				console.log(item)
				let time = item.unix + ' ' + item.t3_end;
				uni.setStorageSync('time', time)
				let time2 = item.unix + '的' + item.t3time;
				uni.setStorageSync('time2', time2)
				uni.navigateTo({
					url: '../order/order'
				})
			},
			onload1() {

				this.http.get(this.$api.Order.dateget).then(res => {

					this.data = res.data;
				});
				this.http.get(this.$api.sys.get).then(res => {

					this.time = res.data[6].value.split('@');

				});
			},
		},
	}
</script>

<style lang="scss" scoped>
	.tab{
		
		line-height: 8px;
		text-align: 0 auto;
	}
	.utd{
		height: 49px;
	}

</style>
