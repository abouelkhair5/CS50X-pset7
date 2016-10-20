<table class="table table-striped">

    <thead>
        <tr>
            <th>Transaction</th>
            <th>Date/Time</th>
            <th>Symbol</th>
            <th>Shares</th>
            <th>Price</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($user_data as $row) : ?>
            <tr>
                <td>
                    <?php if ($row["transaction"]):?>
                        SELL
                    <?php else: ?>
                        BUY
                    <?php endif ?>
                </td>
                <td><?=$row["date_time"]?></td>
                <td><?=$row["symbol"]?></td>
                <td><?=$row["shares"]?></td>
                <td><?=$row["price"]?></td>
            </tr>
        <?php endforeach?> 
    </tbody>

</table>