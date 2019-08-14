(function($) {
	$(document).ready(function() {
		//$.ajax({dataType: 'json',url: "//"+window.location.host+"/index.php/personalization/index/getversion/"}).success(function(data){
			//alert("<br>---------"+data);
			//if(data == '') {
				var productId = 1;
				$.ajax("http://he11.printscience.net/pdf_admin/rpc_api_v_4_0_0/get_version/product/" + productId + "/").success(function(data) {
					var loc = window.location.href;
					var dir = loc.substring(0, loc.lastIndexOf('/'));
					$.ajax(dir+"/index.php/personalization/index/setversion/version/" + data.app_type + "/").success(function(data){
						//alert("version set");
					});
				});
			//}
		//});
	});
})(jQuery);