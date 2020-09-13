<html>
<head>
<style>
    table tr td{border: 1px solid #000000;}
</style>
</head>
<body>
    <div>
        <div><button>导出excel</button></div>
        <table>
            <tr>
                <th>日期</th>
                <th>产品型号</th>
                <th>单价</th>
                <th>购买数量</th>
                <th>收货人姓名</th>
                <th>联系电话</th>
                <th>联系地址</th>
                <th>买家留言</th>
                <th>操作</th>
            </tr>
            <?php foreach ($list as $v):?>
            <tr>
                <td><?= date('Y-m-d H:i:s', $v['created_at'])?></td>
                <td><?= $v['goods_type']?></td>
                <td><?= $v['price']?></td>
                <td><?= $v['account']?></td>
                <td><?= $v['name']?></td>
                <td><?= $v['mobile']?></td>
                <td><?= $v['address']?></td>
                <td><?= $v['remark']?></td>
                <td><button>删除</button></td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
</body>
</html>