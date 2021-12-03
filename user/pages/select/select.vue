<template>
	<view>
		<u-top-tips ref="uTips"></u-top-tips>
		<view class="tab">
			<u-form :model="form" ref="uForm">
				<view v-for="(item,index) in data" :key="index">

					<view v-if="item.is_se==1">

						<u-form-item label="">{{item.name}}:
							<u-input v-model="form.key[index]" />
						</u-form-item>

					</view>
				</view>



				<u-button type="primary" size="medium" @click="sub()">提交</u-button>
			</u-form>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				n: 0,
				data: {},
				form: {
					key: []
				},
				j: 0,
				key: {},
			}
		},
		mounted() {
			this.onload();
		},
		methods: {
			onload() {
				this.http.get(this.$api.key.get).then(res => {
					console.log(res);
					this.data = res.data;
					let l = res.data.length
					let j = 0;
					for (let i = 0; i < l; i++) {

						if (res.data[i].is_se == 1) {
							this.key[j] = res.data[i].keyname
							j++;

						}
					}
					this.j = j

				});
			},


			sub() {
				let post = {};
				let c = 0;
				let j = this.j;


				for (let i = 0; i < j; i++) {

					if (!this.form.key[i]) {
						j++;
						if (j > 40) {
							break;
						}
						continue;
					}

					post[this.key[c]] = this.form.key[i];
					c++;


				}

				if (this.j != c) {
					this.$refs.uTips.show({
						title: '有' + (this.j - c) + '项未填写',
						type: 'error',
						duration: '2300'
					})
					return;
				}


				this.http.post(this.$api.Order.se, post).then(res => {
					uni.setStorageSync('seres', res.data)
					uni.navigateTo({
						url: './select_res'
					})
				});

			}


		}

	}
</script>

<style>
.tab{
		margin: 10px;
	}
</style>
