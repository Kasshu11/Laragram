<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    //  🔼 $this->category : categories テーブルとのやりとりする際に必要な code
    }

    public function generateCategories(){

        //もしcategories table にデータが無いなら（まだ category が生成されていないなら)
        if(!$this->category){
            $catArray = [
                'travel',
                'food',
                'lifestyle',
                'music',
                'career',
                'movie',
                'fashion'
            ];

            for($x = 0; $x < count($catArray); $x++):
                Category::create([
                    'name'=>$catArray[$x]
                ]);
            endfor;

            return redirect()->route('post.create');

        // 既に生成されているなら（category を全削除して再生成して create ページに行く）
        }else{
            $category = Category::query()->delete();

            $catArray = [
                'travel',
                'food',
                'lifestyle',
                'music',
                'career',
                'movie',
                'fashion'
            ];

            for($x = 0; $x < count($catArray); $x++):
                Category::create([
                    'name'=>$catArray[$x]
                ]);
            endfor;

            return redirect()->route('post.create');
        }
    }
}