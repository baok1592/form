<template>

	<view>
		<view class="tex-ms" v-if="data[0]">{{data[0].value}}</view>
		<view class="index">
			<u-button @click="go_order" type="primary" class="btn">预约</u-button>
			<u-button @click="go_select" type="success" class="btn">查询</u-button>
		</view>
	</view>

</template>

<script>
	import config from "@/common/config.js"
	export default {
		data() {
			return {
				data:{}
			}
		},
		mounted() {
			this.onload();
			
		},

		methods: {
			go_order() {
				
				uni.navigateTo({
					url: '../order_select/order_select'
				})
			},
			onload(){
				this.http.get(this.$api.sys.getstr).then(res => {
					this.data = res.data;
					
					uni.setStorageSync('sys',res.data);
				});
			},
			go_select() {

				uni.navigateTo({
					url: '../select/select'
				})
			}


		}

	}
</script>

<style lang="scss" scoped>
	.tex-ms{
		margin: 20px 10px 0 10px; 
		font-size: 16px;
	}
	.index{
		position: absolute;
		display: flex;
		bottom: 20px;
		left: 15%;
		.btn{
			margin: 30px;
		}
		// justify-content: flex-start;
	}
</style>
