<li><a href="javascript:"><?php echo $key;?></a>
    <div class="datas">
        <h3><?php echo $key;?>具体数据</h3>
        <?php
        //如果没有接收到数据，则显示2016年每个月份的数据
        if(!isset($_POST['date_day']) && !isset($_POST['date_month']) && !isset($_POST['somedays1']) && !isset($_POST['somedays2'])){
            for($i=1;$i<=12;$i++) {
                echo '<div class="default">'.$i.'月：&nbsp;';
                if ($i < 10) {
                    $i='0'.$i;
                }
                if (!_month_average_data("2016-$i",$key)) {
                    $_data = '——';
                } else {
                    $_data = _month_average_data("2016-$i",$key);
                }
                echo $_data . '<br/></div>';
            }
        }
        //统计一天24小时的数据
        elseif(isset($_POST['date_day'])){
            for($i=0;$i<24;$i++){
                echo '<div class="date_day">'.$i.'时:&nbsp;';
                if ($i < 10) {
                    $i='0'.$i;
                }
                if ($_data[$i][$key]) {
                    echo $_data[$i][$key].'<br/></div>';
                }else{
                    echo '——<br/></div>';
                }
            }
        }
        //统计一个月31天的数据
        elseif(isset($_POST['date_month'])){
            for($i=1;$i<32;$i++){
                echo '<div class="date_month">'.$i.'日:&nbsp;';
                if ($i < 10) {
                    $i='0'.$i;
                }
                if ($_data[$i][$key]) {
                    echo $_data[$i][$key].'<br/></div>';
                }else{
                    echo '——<br/></div>';
                }
            }
        }
        //统计一段日期内每一天的数据
        elseif(isset($_POST['somedays1']) && isset($_POST['somedays2'])){
            foreach ($_data as $date=>$value){
                echo '<div class="somedays">'.$date.':&nbsp;&nbsp;';
                echo $_data[$date][$key].'<br/></div>';
            }
        }
        ?>
    </div>
</li>