import http from "../common/axios.js"

//配置信息获取
function get_sys(data){
	let url = 'sys/get?type='
	return http.get(url,data).then(res=>{
		return res
	})
}

//配置修改
function edit_sys(data){
	let url = 'sys/edit'
	return http.post(url,data).then(res=>{
		return res
	})
}

//表单
//获取表单关键词
function get_formkey(){
	let url = 'fromkey/get'
	return http.get(url).then(res=>{
		return res
	})
}

//添加表单关键词 覆盖
function add_formkey(data){
	let url = 'fromkey/addall'
	return http.post(url,data).then(res=>{
		return res
	})
}

//excel项目
//获取项目信息
function get_excel(){
	let url = 'excel/get'
	return http.get(url).then(res=>{
		return res
	})
}
//项目查询
function select_excel(data){
	let url = 'excel/select'
	return http.post(url,data).then(res=>{
		return res
	})
}
//项目导出
function out_excel(data){
	let url = 'excel/out'
	return http.post(url,data).then(res=>{
		return res
	})
}
//项目导入
function put_excel(data){     //文件地址
	let url = 'excel/put'
	return http.post(url,data).then(res=>{
		return res
	})
}
//项目修改查询关键词
function edit_excel_search(data){
	let url = 'excel/search'
	return http.post(url,data).then(res=>{
		return res
	})
}

//预约
//获取预约日期数据
function get_orderdate(){
	let url = 'order/getdate'
	return http.get(url).then(res=>{
		return res
	})
}
//获取预约数据
function get_order(){
	let url = 'order/get'
	return http.get(url).then(res=>{
		return res
	})
}
//关闭/开启预约
function off_order(){
	let url = 'order/off'
	return http.get(url).then(res=>{
		return res
	})
}
//清除当前预约数据，并保存一份当前预约数据备份
function closeall_order(){
	let url = 'order/closedata'
	return http.put(url).then(res=>{
		return res
	})
}

//管理员登录
function login(data){
	let url = 'admin/login'
	return http.post(url,data).then(res=>{
		return res
	})
}
//修改密码
function editpwd(data){
	let url = 'admin/editpwd'
	return http.post(url,data).then(res=>{
		return res
	})
}
//添加管理员
function add(data){
	let url = 'admin/add'
	return http.post(url,data).then(res=>{
		return res
	})
}


export default{
	add,       //管理员 添加 修改密码 登录
	editpwd,
	login,
	
	closeall_order,  //预约 预约数据清除 预约开关
	off_order,
	get_order,		//获取预约信息  获取预约日期信息
	get_orderdate,
	
	get_excel,         //获取项目
	edit_excel_search, //修改项目查询字段
	select_excel,		//项目查询
	out_excel,		//导出excel
	
	put_excel,		//导入excel
	add_formkey,	//表单关键词增删改查
	 
	get_sys,
	edit_sys    //配置信息
}