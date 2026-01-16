<?php

namespace App\Controllers;

use App\Models\Hry;
use App\Models\ZanreHry;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class SearchController extends BaseController
{
    public function index(Request $request): Response
    {
        if ($request->isAjax()) {
            $jsonData = $request->json();
            if(is_object($jsonData) && property_exists($jsonData, 'filters') && property_exists($jsonData, 'names')){
                $decode = array_unique($jsonData->filters,SORT_NUMERIC);
                $name = $jsonData->names;
                $where = "";
                foreach ($decode as $key => $value) {
                    if ($key != array_key_last($decode)){
                        $where .= "ID_zaner = " . $value . " OR ";
                    } else {
                        $where .= "ID_zaner = " . $value;
                    }
                }
                $games = ZanreHry::getAll($where);
                $gameNames = Hry::getAll("nazov LIKE ?",['%'.$name.'%']);
                if ($where == ""){
                    return $this->json(json_encode($gameNames));
                }
                $ids = [];
                $result = [];
                foreach ($games as $game) {
                    $ids[] = $game->getIDHra();
                }
                $counted = array_count_values($ids);
                $ids = array_unique($ids);

                $idsname = [];
                foreach ($gameNames as $gameName){
                    $idsname[] = $gameName->getIDHra();
                }
                $ids = array_intersect($idsname, $ids);
                foreach ($ids as $id) {
                    if ($counted[$id] === sizeof($decode)) {
                        $result[] = Hry::getOne($id);
                    }
                }
                return $this->json(json_encode($result));
            }

        }

        $games = Hry::getAll();
        if ($request->hasValue('submit')){
            $games = Hry::getAll("nazov LIKE ?",['%'.$request->value('search').'%']);
        }
        return $this->html(compact('games'));
    }
}