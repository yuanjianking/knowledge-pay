<?php

namespace app\wap\model\live;

/**
 * 直播信息表
 */

use basic\ModelBasic;
use traits\ModelTrait;

class LiveStudio extends ModelBasic
{

    use ModelTrait;

    public static function getLiveList($limit = 10)
    {
        return self::where(['l.is_del' => 0, 's.is_show' => 1, 's.is_del' => 0])->alias('l')
            ->join('special s', 's.id = l.special_id')
            ->field(['s.title', 's.image', 's.browse_count', 'l.is_play', 's.id', 'l.playback_record_id', 'l.start_play_time'])
            ->limit($limit)->select()->each(function ($item) {
                if ($item['playback_record_id'] && !$item['is_play']) {
                    $item['status'] = 2;
                } else if ($item['is_play']) {
                    $item['status'] = 1;
                } else if (!$item['playback_record_id'] && !$item['is_play'] && strtotime($item['start_play_time']) > time()) {
                    $item['status'] = 3;
                }
                if ($item['start_play_time']) {
                    $item['start_play_time'] = date('m-d H:i', strtotime($item['start_play_time']));
                }
            })->toArray();
    }

    public function getStartPlayTimeAttr($time)
    {
        return $time;//返回create_time原始数据，不进行时间戳转换。
    }


}