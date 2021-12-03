module.exports={
	Admin:{  
		login:"admin/login",
		edit:"admin/editpwd",
		add:"admin/add_admin",
		get:"admin/get_admin",
		del:"admin/del",
		pwd:"admin/ed_pwd",
		check:"admin/check",
	},
	Order:{
		getinfo:"order/get_order",//获取预约情况
		dateget:"order/getdate",   //获取预约日渐
		switch:"order/off_order",			//开关
		close:"order/close",                 //取消单次预约	
		closeall:"order/closeall"    ,//清除预约数据
		F5:"order/update"
	},
	ProExcel:{
		dc:"excel/out",
		dr:"excel/put",
		edits:"excel/search",  //修改查询关键词
		get:"excel/excel_get",
		getse:"excel/excel_getse",  //获取表头关键词
		select:"excel/select",
		move:"excel/move",
		del:"excel/del_excel"
	},
	key:{
		addall:"fromkey/addall",
		get:"fromkey/get_key"
	},
	sys:{
		get:"sys/get_sys?type=",
		edit:"sys/edit",
		getkey:"sys/getkey",
		
	}
	
}