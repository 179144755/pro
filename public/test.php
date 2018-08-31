<!DOCTYPE html>  
<html lang="zh-CN">  
<head>  
<meta charset="UTF-8">  
<title>GetUserMedia实例</title>  
</head>  
<body>  
<video id="video" autoplay><ideo>  
</body>  
<script type="text/javascript">  
navigator.mediaDevices.getUserMedia({ audio: true, video: true })
.then(function(stream) {
  /* 使用这个stream stream */
  console.log(stream);
})
.catch(function(err) {
    console.log(err);
  /* 处理error */
});
</script>  
<html>