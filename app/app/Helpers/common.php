<?php

/**
 * Format time -> Time interval from created-at to now
 */
if(!function_exists('caculateDatetime')){
    function caculateDatetime($time){
        $currentTime = \Carbon\Carbon::now();
        $timeCal = date_create($time);
        $dateNow = date_create($currentTime);

        $dateDiff = date_diff($dateNow,$timeCal);
        $result = '';

        if($dateDiff->y){
            $m = $dateDiff->m ? $dateDiff->m.'m':'';
            $result = $dateDiff->y .'y '.$m;
        }else if($dateDiff->m){
            $d = $dateDiff->d ? $dateDiff->d.'d':'';
            $result = $dateDiff->m .'m '.$d;
        }
        else if($dateDiff->d){
            $h = $dateDiff->h ? $dateDiff->h.'h':'';
            $result = $dateDiff->d .'d '.$h;
        }
        else if($dateDiff->h){
            $i = $dateDiff->i ? $dateDiff->i.'i':'';
            $result = $dateDiff->h .'h '.$i;
        }
        else if($dateDiff->i){
            $s = $dateDiff->s ? $dateDiff->s.'s':'';
            $result = $dateDiff->i .'i '.$s;
        }else{
            $result = $dateDiff->s .'s';
        }

        return $result.' ago';
    }
};

if(!function_exists('checkIsAvailable24h')){
    function checkIsAvailable24h($time){
        $currentTime = \Carbon\Carbon::now();
        $timeCal = date_create($time);
        $dateNow = date_create($currentTime);

        $dateDiff = date_diff($dateNow,$timeCal);

        return $dateDiff->days >= 1 ? false : true;
    }
}