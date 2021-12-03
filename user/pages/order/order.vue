<template>
	<view>
		<u-top-tips ref="uTips"></u-top-tips>
		<view class="index_top">
			<span>您预约的时间段为：</span><br>{{time2}}
		</view>
		<view class="tab">
			<u-form :model="form" ref="uForm">
				<view v-for="(item,index) in key">
					<u-form-item>
						<template solt>
							<view v-if="item.is_ok==1" style="color: red;">
								*
							</view>
							{{item.name}}:
							<u-input v-if="item.type==0" v-model="form[item.keyname]" />
							<u-radio-group v-if="item.type==1" v-model="form[item.keyname]">
								<u-radio v-for="(item2, index2) in item.msg" :key="index2" :name="item2.name"
									:disabled="item2.disabled">
									{{item2.name}}
								</u-radio>
							</u-radio-group>
							<u-checkbox-group v-if="item.type==2" v-model="form[item.keyname]">
								<u-checkbox v-model="item2.checked" v-for="(item2, index2) in item.msg" :key="index2"
									:name="item2.name">{{item2.name}}</u-checkbox>
							</u-checkbox-group>
							<view v-if="item.type==3">
								<view class="" @click="dian(index)">
									请选择：{{form[item.keyname]}}
								</view>
								<u-select v-if="item.type==3" v-model="lv[index]" :list="item.msg" @confirm="confirm">
									zhesh</u-select>
							</view>
						</template>
					</u-form-item>
				</view>
				<u-button type="primary" size="medium" @click="sub">预约</u-button>
			</u-form>
		</view>
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
				vl: false,

				key: {

				},

				lists: {

				},
				id: '',
				time: '',
				time2: '',
				form: {

				},
				lv: [],
				oid: ''
			}
		},
		onShow() {
			this.$forceUpdate();
		},
		mounted() {
			this.onload();
			this.oid = uni.getStorageSync('oid')
			this.$forceUpdate();
		},

		methods: {

			dian(index) {
				this.lv[index] = true
				uni.setStorageSync('index', index)
				this.$forceUpdate();


			},
			confirm(e) {


				let index = uni.getStorageSync('index')
				this.form[this.lets[index]] = e[0].label

			},
			sub() {
				let key = this.key;
				let l = key.length
				for (let i = 0; i < l; i++) {
					if (this.key[i].is_ok == 1) {
						if (!this.form[key[i].keyname]) {
							
							this.$refs.uTips.show({
								title: '第' + (i + 1) + '项为必填',
								type: 'error',
								duration: '2300'
							})
							return;
						} else {
							//多选框获取对应选取值转化为字符串
							this.susub()
							break;
						}
					}
				}
			},
			susub() {
				let key = this.key;
				let l = key.length
				for (let i = 0; i < l; i++) {

					if (key[i].type == 2) {
						let str = ''
						let ll = key[i].msg.length
						let k = 0;
						for (let j = 0; j < ll; j++) {
							if (key[i].msg[j].checked == true) {
								if (k == 0) {
									str = key[i].msg[j].name
									k++
								}
								str = str + '/' + key[i].msg[j].name
							}
						}
						this.form[key[i].keyname] = str
					}

				}
				this.form.time = this.time
				this.http.post(this.$api.Order.add, this.form).then(res => {
					this.form.oid = res.data.id
					uni.setStorageSync('form', this.form)
					console.log('res', res)
					uni.navigateTo({
						url: './order_res'
					})

				});
			},
			onload() {
				this.time = uni.getStorageSync("time")
				this.time2 = uni.getStorageSync("time2")
				let key = uni.getStorageSync("key")

				let l = key.length
				let list = []
				for (let i = 0; i < l; i++) {
					if (key[i].is_ok == 0) {
						this.form[key[i].keyname] = '';
					}
					if (key[i].type == 1) {
						this.lv[i] = false
						key[i].msg = key[i].msg.split('@');
						for (let j = 0; j < key[i].msg.length; j++) {
							let arr = {
								disabled: false,
								name: key[i].msg[j],
							}
							list.push(arr)
						}
						key[i].msg = list;
						list = []
					}

					if (key[i].type == 2) {
						this.lv[i] = false
						key[i].msg = key[i].msg.split('@');
						for (let j = 0; j < key[i].msg.length; j++) {
							let arr = {
								disabled: false,
								checked: false,
								name: key[i].msg[j],
							}
							list.push(arr)
						}
						key[i].msg = list;

						list = []
					}

					if (key[i].type == 3) {
						this.lv[i] = false
						key[i].msg = key[i].msg.split('@');
						for (let j = 0; j < key[i].msg.length; j++) {
							let arr = {
								value: j,
								label: key[i].msg[j],
							}
							list.push(arr)
						}
						key[i].msg = list;
						list = []
					}
				}

				this.key = key;
				
			}
		},
		qclose() {
			this.show = true;
		},
		close() {
			let post = {
				id: this.oid
			}

			console.log(post);
			this.show = false;
			this.http.post(this.$api.Order.close, post).then(res => {
				this.$refs.uTips.show({
					title: '取消本次预约成功',
					type: 'success',
					duration: '2300'
				})


				localStorage.removeItem('oid');
			})
		},
		checkboxGroupChange() {
			
		},



	}
</script>

<style lang="scss">
	.index_top{
		margin: 15px;
		font-size: 16px;
		line-height: 24px;
	}
	.tab{
		margin: 10px;
	}
	.u-btn{
		margin-left: 36.5%;
	}

</style>
