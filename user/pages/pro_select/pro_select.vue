<template>
	<view>
		<view class="tex-ms" v-if="sys[2]">{{sys[2].value}}</view>
		<u-table>
				<view v-for="(item,index) in data" :key="index">
					<button size="default" value="index" type="info" v-if="item.xname!=''" @click="go_pro(item.id)">{{item.xname}}</button>
				</view>
		</u-table>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				data:[],
				sys:[]
			}
		},
		mounted() {
			this.onload1();
			this.sys=uni.getStorageSync("sys")
		},
		methods: {
			onload1(){
				this.http.get(this.$api.Excel.get).then(res => {
						
							this.data=res.data;
						});
			},
			go_pro(id){
			
				uni.setStorageSync('pid',id)
				uni.navigateTo({
					url: '../pro/pro'
				})
			
			}
			
		}
	}
</script>

<style>
.tex-ms{
		margin: 20px 10px 0 10px; 
		font-size: 16px;
	}
</style>
