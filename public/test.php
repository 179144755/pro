<!DOCTYPE html>  
<html lang="zh-CN">  
<head>  
<meta charset="UTF-8">  
<title>GetUserMedia实例</title>  
</head>  
<body>  

<!-- <input type="file" accept="image/*" capture="camera">  -->
<div>
<input type="file" onchange="a(this)" accept="image/*"> 
<img id="img"  src="https://www.baidu.com/img/bd_logo1.png?qua=high" style="width:400px;height:400px">
</div>
</body>  
<script type="text/javascript">  
function a(_this){
    document.getElementById('img').src = _this.value;
    alert(_this.value);
}

</script>  
<html>