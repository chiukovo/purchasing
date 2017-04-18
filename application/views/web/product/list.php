<table>
	<tr>
		<th>名稱</th>
		<th>售價</th>
		<th>折扣</th>
		<th>重量</th>
		<th>商品狀態</th>
		<th>操作</th>
	</tr>

	<?php foreach ($product as $info) { ?>
	<tr>
		<td><?php echo $info['name']; ?></td>
		<td><?php echo $info['money']; ?></td>
		<td><?php echo $info['discount']; ?></td>
		<td><?php echo $info['weight']; ?></td>
		<td>
			<?php
			if ( $info['status'] == 1 ) {
				echo '上架';
			} else if ( $info['status'] == 2 ) {
				echo '下架';
			}
			?>
		</td>
		<td>
			<button type="button">刪除</button>
			<button type="button">修改</button>
		</td>
	</tr>
	<?php } ?>
</table>