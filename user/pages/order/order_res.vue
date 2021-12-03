<template>

	<u-card v-if="sys[1]" :title="sys[1].value" :sub-title="msg" :thumb="thumb">
		<u-top-tips ref="uTips"></u-top-tips>
		<view class="" slot="body">
			<!-- <view class="u-body-item u-flex u-border-bottom u-col-between u-p-t-0">
						<view v-if="sys[1]">{{sys[1].value}}</view>
						
					</view> -->
			<view class="u-body-item u-flex u-row-between u-p-b-0">
				<view>您预约的时间为:{{data.time}}</view>
			</view>
			<view class="u-body-item u-flex u-row-between u-p-b-0">

				<view>请核对您的信息，如果出现了错误的情况请取消本次预约</view>
			</view>
			<view class="u-body-item   u-p-b-0">
				<view v-for="(item,i) in key">
					<template v-if="item.is_view==1" style="">
						<view class="seev">
							<view ><span style="color: #0080FF;">{{item.name}}</span>:{{data[lets[i]]}}</view>
						</view>
					</template>
				</view>
			</view>
			<view class="u-body-item  u-p-b-0 btn">
				<u-button size="medium" type="warn" @click="qclose" style="margin-left: 20px;">取消预约</u-button>
				
				<u-button type="primary" size="medium" @click="qgoback" style="margin-left: 20px;">返回首页</u-button>
				<u-modal v-model="show" @confirm="close" content="确定取消预约？" show-cancel-button mask-close-able
					cancel-text="取消" ref="uModal" :async-close="true"></u-modal>
				<u-modal v-model="show2" @confirm="goback" content="确定返回？" show-cancel-button mask-close-able
					cancel-text="取消" ref="uModal" :async-close="true"></u-modal>
			</view>
		</view>
		<view>


			<!-- <view>您预约的时间为:{{data.time}}</view>
			<view>请核对您的信息，如果出现了错误的情况请取消本次预约</view>
			<view v-for="(item,i) in key">
				<template v-if="item.is_view==1" style="">
					<view class="seev">
						<view style="color: #0080FF;">{{item.name}}:</view>
						<view>{{data[lets[i]]}}</view>
					</view>

				</template>
			</view>

			<view style="margin-top: 40px;">
				<u-button size="medium" type="warn" @click="qclose" style="margin-left: 20px;">取消预约</u-button>

				<u-button type="primary" size="medium" @click="qgoback" style="margin-left: 20px;">返回首页</u-button>
				<u-modal v-model="show" @confirm="close" content="确定取消预约？" show-cancel-button mask-close-able
					cancel-text="取消" ref="uModal" :async-close="true"></u-modal>
				<u-modal v-model="show2" @confirm="goback" content="确定返回？" show-cancel-button mask-close-able
					cancel-text="取消" ref="uModal" :async-close="true"></u-modal>
			</view>
 -->

		</view>
	</u-card>
</template>

<script>
	export default {
		data() {
			return {
				msg:"",
				title: '素胚勾勒出青花，笔锋浓转淡',
				subTitle: '2020-05-15',
				thumb: 'http://pic2.sc.chinaz.com/Files/pic/pic9/202002/hpic2119_s.jpg',

				lets: [
					'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
					'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK',
					'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ'
				],
				data: '',
				sys: '',
				key: '',
				show: false,
				show2: false

			}
		},
		mounted() {

			this.onload();
		},

		methods: {
			qgoback() {
				this.show2 = true;
			},
			goback() {
				uni.switchTab({
					url: '../index/index'
				})
			},
			onload() {

				this.data = uni.getStorageSync("form")
				this.key = uni.getStorageSync("key")
				this.sys = uni.getStorageSync("sys")
				console.log('data', this.data);
			},
			qclose() {
				this.show = true;
			},
			close() {
				let post = {
					id: this.data.oid,
				}
				this.show = false;
				this.http.post(this.$api.Order.close, post).then(res => {
					this.$refs.uTips.show({
						title: '取消成功',
						type: 'success',
						duration: '2300'
					})
					
					uni.navigateBack({
						
					})
					
				})
			}

		}
	}
</script>

<style lang="scss">
	.btn{
		margin-top: 30px;
	}
</style>
