export default {
	data() {
		return {}
	},
	mounted() {
		// this.get_service()
	},

	methods: {
		get_service(){
			let arr = [1,2,3,4]
			for(let k  in arr){
				this.show_service()
			}
		},
		show_service() {
			this.$confirm('三号桌呼叫服务', '提示', {
				confirmButtonText: '确定',
				cancelButtonText: '取消',
				type: 'warning'
			}).then(() => {
				this.$message({
					type: 'success',
					message: '已收到'
				});
			})
		}
	}
}
