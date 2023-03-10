<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    //  ð¼ $this->category : categories ãã¼ãã«ã¨ã®ããã¨ãããéã«å¿è¦ãª code
    }

    public function generateCategories(){

        //ããcategories table ã«ãã¼ã¿ãç¡ããªãï¼ã¾ã  category ãçæããã¦ããªããªã)
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

        // æ¢ã«çæããã¦ãããªãï¼category ãå¨åé¤ãã¦åçæãã¦ create ãã¼ã¸ã«è¡ãï¼
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