<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>A</title>
</head>
<body>
    <h id="a">AQQQQ</h>
</body>
</html>
<script src="/js/jquery.min.js"></script>
<script>
    $(function(){
       $('#a').click(function(){
           $.ajax({
               url:'http://lumen_1809a.com/b',
               dataType:'jsonp',
               method:'get',
               success:function(msg){
                   console.log(msg)
               }
           })
       })
    })
</script>