<template>
	<view>
		<view v-if="data">
			{{data.id}}
			<view>预约时间:{{data.time}}</view>
			<view v-for="(item,i) in data2">
				<template v-if="data.json" style="">
					<view class="seev">
						<view style="color: #0080FF;">{{item.name}}:</view>
						<view>{{data.json[lets[i]]}}</view>
					</view>

				</template>
			</view>
			<u-top-tips ref="uTips"></u-top-tips>

		</view>
		<u-modal v-model="show" @confirm="close" content="确定取消预约？" show-cancel-button mask-close-able cancel-text="取消"
			ref="uModal" :async-close="true"></u-modal>

		<button size="default" type="warn" @click="qclose">取消预约</button>

	</view>

</template>

<script>
	export default {
		data() {
			return {
				show: false,
				lets: [
					'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
					'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK',
					'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ'
				],

				data: {

				},
				data2: {

				}
			}
		},
		mounted() {
			
			this.data = uni.getStorageSync('seres');
			console.log(this.data);
			this.onload();
			
		},
		
		methods: {
			onload() {
				console.log(this.data);
				this.http.get(this.$api.key.get).then(res => {

					this.data2 = res.data;
				})
			},
			qclose() {
				this.show = true;
			},
			close() {
				let post = {
					id: this.data.id,
				}
				
				console.log(post);
				this.show = false;
				this.http.post(this.$api.Order.close, post).then(res => {
					this.$refs.uTips.show({
						title: '取消成功,即将返回首页',
						type: 'success',
						duration: '2300'
					})
					
				
					localStorage.clear();
					
					
				setTimeout(() => {
					this.data='';
							uni.switchTab({
								url: '../index/index'
							})
							;
							}, 3000)
					


				})
			}


		}
	}
</script>

<style>

</style>
