<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2016/8/25
 * Time: 16:39
 */
namespace Boss;

/**
 * 数据分页类
 * 参数: 关联数组类型
 * 返回值: 索引数组类型
 */
class Page {

    private $pages = array();
    private $setPages = array();

    public function __construct() {
    }

    public function _set($pages) {
        $this->size = $pages['size']; //总页数, 最后页
        $this->current = $pages['current']; //当前页
        $this->first = $pages['first']; //第一页
        $this->paging = $pages['paging']; //每页条数
        $this->offset = $pages['offset']; //偏移值

        $this->section = (floor($this->size / $this->paging) * $this->paging); //计算区间值

        if ($this->current < $this->paging)
            return $this->preSectionSet();

        if ($this->current < $this->section)
            return $this->centerSectionSet();

        if ($this->current >= $this->section)
            return $this->backSectionSet();
    }

    /**
     * 分页的前区间
     * @return array
     */
    public function preSectionSet() {
        for ($i=$this->first; $i<($this->first + $this->paging + $this->offset + 1); $i++) {
            if ($this->borderDump($i)) {
                $setPages[] = $this->borderDump($i);
            }
        }
        return $this->setPages = $setPages;
    }

    /**
     * 分页的中间区间
     * @return array
     */
    public function centerSectionSet() {
        for ($i=($this->current - $this->offset); $i<=($this->current + $this->paging); $i++) {
            if ($this->borderDump($i)) {
                $setPages[] = $this->borderDump($i);
            }
        }
        return $this->setPages = $setPages;
    }

    /**
     * 分页的后区间
     * @return array
     */
    public function backSectionSet() {
        for ($i=($this->current - $this->offset - $this->paging); $i<=($this->current + $this->paging); $i++) {
            if ($this->borderDump($i)) {
                $setPages[] = $this->borderDump($i);
            }
        }
        return $this->setPages = $setPages;
    }

    /**
     * 判断边界
     * @param $border
     * @return bool
     */
    public function borderDump($border) {
        if ($border > $this->size || $border <= 0 ) return false;
        return $border;
    }

    /**
     * @param array $data 数据库的所有数据
     * @param array $limit 分页的参数
     * @return array 分页后的数据
     */
    public function getPageData($data=array(),$limit=array()){
        if(empty($data) || empty($limit))
            return array();

        $start_index = $limit['start'];//开始下标
        $end_index = empty($start_index) ? $limit['count'] : $start_index + $limit['count'];//结束下标
        $ret_data = array();//需要返回的数组
        foreach($data as $k=>$v){
            if($k>=$start_index && $k<$end_index){
                $ret_data[] = $v;
            }
        }
        return $ret_data;
    }

    /**
     * __destruct析构函数，当类不再使用的时候调用，该函数用来释放资源。
     */
    public function __destruct() {
        unset($pages);
        unset($setPages);
        unset($data);
        unset($ret_data);
    }
}