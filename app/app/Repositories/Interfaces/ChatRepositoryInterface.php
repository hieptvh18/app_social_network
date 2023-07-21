<?php
namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

Interface ChatRepositoryInterface{

    public function saveMessage(Request $request);

    public function fetchMessage($reciever);
}

?>
