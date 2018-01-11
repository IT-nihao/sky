<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>

<?php $this->assets->outputJs() ?>
<body>
	<center>
		<h1>用户信息列表</h1>
		<form action="/Index/list" method='get'>
        <input type="text" value="{{ search }}" name="search"><input type="submit" value="搜索">
        </form>
		<table border="1">
			<tr>
				<th>ID</th>
				<th>头像</th>
				<th>姓名</th>
				<th>电话</th>
				<th>出生年月</th>
				<th>性别</th>
				<th>家庭住址</th>
				<th>注册时间</th>
				<th>操作</th>
			</tr>
			{% for v in page.items %}
			<tr>
				<td>{{ v.id }}</td>
				<td><img src="/{{v.img}}" alt="" width="50px" height="50px"/></td>
				<td>{{ v.name }}</td>
				<td>{{ v.tel }}</td>
				<td>{{ v.birthday }}</td>
				<td>
					{% if v.sex == 1 %}
						男
						{% else %}
						女
					{% endif %}
				</td>
				<td>{{ v.address }}</td>
				<td>{{ v.time }}</td>
				<td>{{ link_to('/Index/del/?id='~ v.id,'删除')}}||{{ link_to('/Index/update/?id='~ v.id,'编辑')}}</td>
				<!-- <td><a href="/Index/del/?id={{ v.id }}">删除</a>||<a href="">修改</a></td> -->
			</tr>
			{% endfor %}
			<a href="/index/list?search={{ search }}">First</a>
                <a href="/index/list?page=<?= $page->before; ?>&search={{ search }}">Previous</a>
                <a href="/index/list?page=<?= $page->next; ?>&search={{ search }}">Next</a>
                <a href="/index/list?page=<?= $page->last; ?>&search={{ search }}">Last</a>
               <?php echo "You are in page ", $page->current, " of ", $page->total_pages; ?>
		</table>
	</center>

</body>
</html>
<script>


</script>