<template>
	<view v-if="data">
		<view class="u-body-item   u-p-b-0">
			<view v-for="(item,i) in data2.se_key">
				<template v-if="data">
					<view class="seev">
						<view ><span style="color: #0080FF;">{{item}}</span>:{{data[lets[i]]}}</view>
					</view>
				</template>
			</view>
		</view>
			
		
		<u-modal v-model="show" @confirm="back" content="确定返回？" show-cancel-button mask-close-able cancel-text="取消"
			ref="uModal" :async-close="true"></u-modal>
		<u-top-tips ref="uTips"></u-top-tips>
		<button size="default" type="warn" @click="qback">返回主页</button>

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
				headdata: {

				},
				data: {

				},
				data2: {

				}
			}
		},
		mounted() {
			this.data2 = uni.getStorageSync('headdata');
			
			this.data = uni.getStorageSync('exdata');

		},
		methods: {
			back(){		
				
				
				
				localStorage.clear();
				uni.switchTab({
					url: '../pro_select/pro_select'
				})
	
			},
			qback(){
				this.show=true;
			}


		}
	}
</script>

<style>
	.seev{
		margin: 10px;
	}
</style>
