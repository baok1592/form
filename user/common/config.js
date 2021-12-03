const CONFIG = {
    // 开发环境配置
    development: {
        
		Api_url:"http://192.168.124.36:8099/",
		
    },
    // 生产环境配置
    production: {
        Api_url:"/../",
	
		
    }
	

};
export default CONFIG[process.env.NODE_ENV];
