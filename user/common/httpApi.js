module.exports={
	Order:{
		dateget:"order/getdate",   //获取预约日期
		close:"order/order_close",         //取消单次预约	
		se:"order/select_order",
		F5:"order/update",  //刷新
		add:"order/add_order"//预约
		
	},
	Excel:{
		getse:"excel/excel_getse", //获取项目查询关键词
		get:"excel/excel_get", //获取项目
		ex:"excel/select_pro" 	//项目查询

	},
	key:{

		get:"fromkey/get_key" //获取表单关键词
	},
	sys:{
		get:"sys/get_sys",	//获取系统配置
		getstr:"sys/get_sys?type=1", //获取系统字符串配置
		getkey:"sys/getkey",

	}
	
}