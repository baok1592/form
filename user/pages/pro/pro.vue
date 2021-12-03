<template>
	<view>
		<u-top-tips ref="uTips"></u-top-tips>
		<view class="tab">
			<view  v-if="sys[2]">{{sys[2].value}}</view>
			<u-form :model="form" ref="uForm">

				<view v-if="data.search_key[0]">
					<u-form-item label="">{{data.search_key[0]}}:
						<u-input required="required" v-model="form.key1" />
					</u-form-item>
				</view>

				<view v-if="data.search_key[1]">
					<u-form-item label="">{{data.search_key[1]}}:
						<u-input required="required" v-model="form.key2" />
					</u-form-item>
				</view>
				<view v-if="data.search_key[2]">
					<u-form-item label="">{{data.search_key[2]}}:
						<u-input required="required" v-model="form.key3" />
					</u-form-item>
				</view>

				<u-button type="primary" size="medium" @click="sub">提交</u-button>
			</u-form>

		</view>

	</view>
</template>

<script>
	export default {
		data() {
			return {
				id: '',
				formdata: {},
				form: {

				},
				sys:{},
				data: {
					search_key: {
						0: '',
						1: '',
						2: ''
					}
				}
			}
		},
		mounted() {
			
			this.onload();
			
			
		},

		methods: {
			onload() {
				this.sys=uni.getStorageSync("sys")
				this.id = uni.getStorageSync("pid")
				this.getse();
				console.log(1)
			},
			getse() {
				let post = {
					id: this.id
				}
				this.http.post(this.$api.Excel.getse, post).then(res => {
					uni.setStorageSync('headdata', res.data)
					this.data = res.data;
				});
			},
			sub() {
				let n = 0;
				this.form.id = this.id
				let sekey = this.data.search_key
				let ok = 0
				if (sekey[0]) {
					if (!this.form.key1) {

						ok = 1;
					}

				} else if (sekey[1]) {
					if (!this.form.key2) {
						ok = 2;

					}
				} else if (sekey[2]) {
					if (!this.form.key3) {
						ok = 3;


					}

				}

				if (ok) {
					this.$refs.uTips.show({
						title: '第' + ok + '项未填写',
						type: 'error',
						duration: '2300'
					})
					return;
				}


				this.http.post(this.$api.Excel.ex, this.form).then(res => {
					uni.setStorageSync('exdata', res.data)
					uni.navigateTo({
						url: './pro_res'
					})
				});
			}
		}
	}
</script>

<style>
	.tab {
		margin: 10px;
	}
</style>
