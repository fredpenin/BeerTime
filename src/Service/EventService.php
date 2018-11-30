<?php

namespace App\Service;

class EventService
{
    private $events = [
        [
        'id' => 1, 
        'name' => "Bearsbeer", 
        'startTime' => "2018/12/20 22:00:00", 
        'endTime' => "2018/12/20 01:00:00",
        'creationTime' => "2018/11/10 01:00:00",
        'Description' => "la bière c'est la fête",
        'price' => 2,
        'poster' => "https://s3.envato.com/files/100302003/14oktoberfest_design002.jpg",
        'spotName' => "Mac Ewan's",
        'adress' => "123 rue des Pepitos",
        'zip' => 62300,
        'city' => "Lens",
        'country' => "France",
        'cat_name' => "beer"
        ],
        [
        'id' => 2, 
        'name' => "Mise en bière", 
        'startTime' => "2019/01/01 01:00:00", 
        'endTime' => "2019/01/01 12:00:00",
        'creationTime' => "2018/11/10 01:00:00",
        'Description' => "Youhou",
        'price' => 5,
        'poster' => "",
        'spotName' => "Mac Ewan's",
        'adress' => "123 rue des Pepitos",
        'zip' => 62300,
        'city' => "Lens",
        'country' => "France",
        'cat_name' => "beer"
        ]        
    ];

    public function getAll(){
        $events = $this->events;
        return $events;
    }

    public function getOne($id){
        foreach ($this->events as $key => $value) {
            if($value['id'] == $id)
                return $value;
        }
        return null;
    }



}