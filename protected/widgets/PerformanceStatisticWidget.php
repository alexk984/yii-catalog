<?php

class PerformanceStatisticWidget extends CWidget
{

    /**
     * @var boolean show full execution time
     */
    public $all_time = true;
    /**
     * @var boolean show total memory usage
     */
    public $memory = true;
    /**
     * @var boolean show time executing sql queries
     */
    public $db_time = true;
    /**
     * @var boolean show database queries number
     */
    public $db_query = true;

    public function init()
    {

    }

    public function run()
    {
        echo '<div>';
        if ($this->all_time)
            echo 'Отработало за ' . sprintf('%0.5f', Yii::getLogger()->getExecutionTime()) . ' с. ';
        if ($this->memory)
            echo 'Скушано памяти: ' . round(memory_get_peak_usage() / (1024 * 1024), 2) . ' MB';
        echo '<br>';
        $sql_stats = YII::app()->db->getStats();
        if ($this->db_query)
            echo $sql_stats[0] . ' запросов к БД. ';
        if ($this->db_time)
            echo 'время выполнения запросов - ' . sprintf('%0.5f', $sql_stats[1]) . ' c.';
        echo '</div>';
    }

}

